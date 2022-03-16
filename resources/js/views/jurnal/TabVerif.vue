<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-landscape"></i> Jurnal Verif</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Jurnal Verif</li>
                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light mx-2" data-bs-toggle="modal" data-bs-target="#createModal">Buat Jurnal Baru</button> -->
                                <div class="btn-group" style="margin-left:8px">
                                    <button type="button" class="btn btn-success dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="uil-table"></i> Excel <i class="uil-angle-down"></i></button>
                                    <div class="dropdown-menu" style="">
                                        <a href="/api/journal/export" class="dropdown-item"><i class="bx bx-export"></i> Export Excel <loading v-if="loadingExcel" size="18"/></a>
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
                                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal-verif"><i class="uil-filter"></i> Filter</button>
                                </div>
                                <table class="table table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Waktu</th>
                                            <th>Reimburse</th>
                                            <th>Status</th>
                                            <th>Remark</th>
                                            <th>User</th>
                                            <th>Project</th>
                                            <th>Chart Account</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody> -->
                                        <!-- end page title -->
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
                                                    <td><span :class=" journal.status == 3 ? 'bg-soft-success' : 'bg-soft-danger'" class="badge rounded-pill font-size-12" >
                                                        {{ journal.status == 3 ? 'Diterima' : 'Ditolak'}}</span>
                                                    </td>
                                                    <td>
                                                        {{ journal.remark }}
                                                    </td>
                                                    <td>
                                                        {{ journal.user_id }}
                                                    </td>
                                                    <td>
                                                        {{ journal.chart_account.name }}
                                                    </td>
                                                    <td><span class="badge rounded-pill bg-soft-success font-size-12">{{ journal.project_id }}</span></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu <i class="uil-angle-down"></i></button>
                                                            <div class="dropdown-menu" style="">
                                                                <router-link :to="{ name: 'jurnal.detail', params: { token: journal.token }, query: { page: 'verif'} }" class="dropdown-item"><i class="uil-document-layout-left"></i> Detail</router-link>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </transition-group>
                                        </transition>
                                </table>
                                <div class="modal fade modal-verif" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Filter</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <label for="example-text-input" class="col col-form-label">Reimburse</label>
                                                    <div class="">
                                                        <input value="1" type="radio" name="reimburse3" v-model="filter_reimburse" id="option-1">
                                                        <label for="option-1" class="option option-1 m-0">
                                                            <div class="dot"></div>
                                                            <span>Ya</span>
                                                        </label>
                                                        <input value="0" type="radio" name="reimburse3" v-model="filter_reimburse" id="option-2">
                                                        <label for="option-2" class="option option-2 m-0 my-1">
                                                            <div class="dot"></div>
                                                            <span>Tidak</span>
                                                        </label>
                                                        <input value="" type="radio" name="reimburse3" v-model="filter_reimburse" id="option-3" selected>
                                                        <label for="option-3" class="option option-3 m-0">
                                                            <div class="dot"></div>
                                                            <span>Semua</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Bulan</label>
                                                    <v-select :options="monthOptions" :reduce="month => month.code" label="month" v-model="filter_month"></v-select>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Chart Account</label>
                                                    <v-select :options="chartOptions" @input="selectId($event)" :disabled="chartLoading"></v-select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary waves-effect" @click="getJurnal" data-bs-dismiss="modal">Terapkan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Table -->
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
import Loading from '../../components/loading'
export default {
    props: ['auth'],
    components: {
        DeleteJournal,
        Loading,
    },
    data() {
        return  {
            journals: {},
            loading: true,
            chartOptions: [],
            chartLoading: true,
            filter_keyword: '',
            filter_reimburse: '',
            filter_month: '',
            filter_chartaccount: '',
            loadingExcel: false,
            monthOptions: [
                {month: 'Semua', code: ''},
                {month: 'Januari', code: '01'},
                {month: 'Februari', code: '02'},
                {month: 'Maret', code: '03'},
                {month: 'April', code: '04'},
                {month: 'Mei', code: '05'},
                {month: 'Juni', code: '06'},
                {month: 'Juli', code: '07'},
                {month: 'Agustus', code: '08'},
                {month: 'September', code: '09'},
                {month: 'Oktober', code: '10'},
                {month: 'November', code: '11'},
                {month: 'Desember', code: '12'}
            ],
        };
    },

    mounted() {
        this.getJurnal()
        this.getChart()
    },

    methods: {
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
                // console.log(e)
                this.$toasted.show("Something went wrong : " + e, {
                    type: 'error',
                    duration: 3000,
                    position: 'top-center',
                })
            }
        },
        async getJurnal() {
            let response = await axios.get('/api/journal', {
                    params: {
                        category: 3,
                        keyword: this.filter_keyword,
                        chart: this.filter_chartaccount,
                        reimburse: this.filter_reimburse,
                        date: this.filter_month,
                    },
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.journals = response.data.data
            }
            console.log(this.journals)
            this.loading = false
        },
        format_date(value){
            if (value) {
                return moment(String(value)).format('hh:mm - Do MMM YYYY')
            }
        },
    }
}
</script>
