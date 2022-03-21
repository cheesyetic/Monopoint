<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-landscape"></i> Jurnal Draft</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Jurnal Draft</li>
                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light mx-2" data-bs-toggle="modal" data-bs-target="#createModal">Buat Jurnal Baru</button> -->
                                <div class="btn-group" style="margin-left:8px">
                                    <button type="button" class="btn btn-success dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="uil-table"></i> Excel <i class="uil-angle-down"></i></button>
                                    <div class="dropdown-menu" style="">
                                        <a href="/api/journal/export" @click.prevent="exportExcel" class="dropdown-item"><i class="bx bx-export"></i> Export Excel <loading v-if="loadingExcel" size="18"/></a>
                                        <router-link :to="{ name: 'jurnal.import' }" class="dropdown-item"><i class="bx bx-import"></i> Import Excel <loading v-if="loadingExcel" size="18"/></router-link>
                                    </div>
                                </div>
                                <router-link exact :to="{ name: 'jurnal.create'}" class="btn btn-primary mx-2"><i class="uil-plus"></i> Buat Jurnal Baru</router-link>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Start Table -->
                            <div class="table-responsive-sm">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text border-bottom"><i class="uil-search"></i></span>
                                    </div>
                                    <input type="text" v-model="filter_keyword" @change="getJurnal" class="form-control" placeholder="Search">
                                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-sm"><i class="uil-filter"></i> Filter</button>
                                </div>
                                <table class="table table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Waktu</th>
                                            <th>Reimburse</th>
                                            <th>Remark</th>
                                            <th>User</th>
                                            <th>Project</th>
                                            <th>Chart Account</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                        <transition
                                            tag="tbody"
                                            mode="out-in"
                                            enter-active-class="animate__animated animate__fadeIn animate__faster"
                                            leave-active-class="animate__animated animate__fadeOut animate__faster"
                                            v-if="loading" class="row ">
                                        <loading/>
                                        </transition>
                                        <transition
                                            v-else
                                            tag="tbody"
                                            mode="out-in"
                                            enter-active-class="animate__animated animate__fadeIn"
                                            leave-active-class="animate__animated animate__fadeOut"
                                            >

                                            <tr v-if="!journals.length">
                                                <td colspan="7">No data available</td>
                                            </tr>

                                            <transition-group
                                                v-else
                                                tag="tbody"
                                                >
                                                <tr
                                                    v-for="journal in journals"
                                                    :key="journal.token"
                                                    >
                                                    <td>{{ journal.title }}</td>
                                                    <td>{{ format_date(journal.date) }}</td>
                                                    <td><span :class=" journal.is_reimburse ? 'bg-soft-success' : 'bg-soft-danger'" class="badge rounded-pill font-size-12" >
                                                        {{ journal.is_reimburse ? 'Ya' : 'Tidak'}}</span>
                                                    </td>
                                                    <td>
                                                        {{ journal.remark }}
                                                    </td>
                                                    <td>
                                                        {{ journal.user_id }}
                                                    </td>
                                                    <td>{{ journal.project_id }}</td>
                                                    <td>
                                                        {{ journal.chart_account.name }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu <i class="uil-angle-down"></i></button>
                                                            <div class="dropdown-menu" style="">
                                                                <router-link :to="{ name: 'jurnal.detail', params: { token: journal.token }}" class="dropdown-item"><i class="uil-document-layout-left"></i> Detail</router-link>
                                                                <button @click="ajukanDialog(journal.token)" class="dropdown-item"><i class="uil-message"></i> Ajukan</button>
                                                                <div class="dropdown-divider"></div>
                                                                <router-link :to="{ name: 'jurnal.edit', params: { token: journal.token }}" class="dropdown-item"><i class="uil-edit-alt"></i> Edit</router-link>
                                                                <delete-journal :endpoint="journal.token" :auth="auth" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </transition-group>
                                        </transition>
                                </table>
                                <filter-journal @filterjournal="filtering" :auth="auth"></filter-journal>
                            </div>
                            <!-- End table -->
                            <pagination :page="page" :last_page="last_page"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import DeleteJournal from './Delete'
import FilterJournal from './Filter'
import Loading from '../../components/loading'
import Pagination from './Pagination'
export default {
    props: ['auth'],
    components: {
        DeleteJournal,
        FilterJournal,
        Loading,
        Pagination,
    },
    data() {
        return  {
            journals: {},
            loading: true,
            chartOptions: [],
            chartLoading: true,
            filter_keyword: '',
            loadingExcel: false,
            params: '',
            page: '',
            last_page: '',
        };
    },

    mounted() {
        this.getJurnal()
        this.getChart()
    },

    methods: {
        filtering(event) {
            this.params = event
        },
        selectId(e) {
            this.filter_chartaccount = e.id
        },
        async getChart() {
            let response = await axios.get('/api/chartaccount', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    this.chartOptions.push({ label, id })
                }
                this.chartLoading = false
            } else {
                this.$toasted.show("Failed to load Chart Account", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
        },
        async exportExcel() {
            try {
                this.loadingExcel = true

                let response = await axios({
                    url: '/api/journal/export', //your url
                    method: 'GET',
                    responseType: 'blob', // important
                    headers: {'Authorization': 'Bearer '+ this.auth.token}
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'Journal.xlsx'); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                });
                this.loadingExcel = false
            } catch (e) {
                this.loadingExcel = false
                this.$toasted.show("Failed to export excel", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
        },
        async getJurnal() {
            // this.params.category = 1
            let response = await axios.get('/api/journal', {
                    params: {
                        category: 1,
                        keyword: this.filter_keyword,
                        chart: this.params.chart,
                        reimburse: this.params.reimburse,
                        sortname: this.params.sortname,
                        sortdate: this.params.sortdate,
                        date: this.params.month,
                        page: this.$route.query.page,
                    },
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.journals = response.data.data
                this.page = response.data.page
                this.last_page = response.data.last_page
            }
            this.loading = false
        },
        format_date(value){
            if (value) {
                return moment(String(value)).format('hh:mm - Do MMM YYYY')
            }
        },
        ajukanDialog(token) {
            this.$swal.fire({
                title: 'Yakin ingin mengajukan jurnal?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.ajukan(token)
                    }
            })
        },
        async ajukan(token) {
            try {
                this.loading = true
                let formdata = new FormData()
                let response = await axios.post('/api/validjournal/' + token, formdata, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (response.status == 200) {
                    this.$toasted.show(response.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })
                    this.getJurnal()
                }
                else {
                    this.loading = false
                    this.$toasted.show("Error mengajukan jurnal", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                }
            } catch (e) {
                this.loading = false
                this.$toasted.show("Something went wrong : " + e.message, {
                    type: 'error',
                    duration: 3000,
                    position: 'top-center',
                })
            }
        }
    }
}
</script>
