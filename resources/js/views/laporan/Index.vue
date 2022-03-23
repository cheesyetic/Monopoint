<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-book"></i> Laporan</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Laporan</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2" style="position: relative;">
                                <h3 class="bx bx-wallet mt-3 mb-0"></h3>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR {{ new Intl.NumberFormat(['ban', 'id']).format(debit) }}</span></h4>
                                <p class="text-muted mb-0">Total Balance</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2" style="position: relative;">
                                <h3 class="bx bx-log-out-circle mt-3 mb-0"></h3>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR {{ new Intl.NumberFormat(['ban', 'id']).format(debit) }}</span></h4>
                                <p class="text-muted mb-0">Total Debit</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2" style="position: relative;">
                                <h3 class="bx bx-log-in-circle mt-3 mb-0"></h3>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR {{ new Intl.NumberFormat(['ban', 'id']).format(kredit) }}</span></h4>
                                <p class="text-muted mb-0">Total Kredit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                    <input type="text" v-model="filter_keyword" @change="getLaporan" class="form-control" placeholder="Search">
                                    <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-sm"><i class="uil-filter"></i> Filter</button>
                                </div>
                                <table class="table table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tgl</th>
                                            <th>Bank</th>
                                            <th>Transaksi</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>
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

                                            <tr v-if="!laporans.length">
                                                <td colspan="7">No data available</td>
                                            </tr>

                                            <transition-group
                                                v-else
                                                tag="tbody"
                                                >
                                                <tr
                                                    v-for="laporan in laporans"
                                                    :key="laporan.id"
                                                    >
                                                    <td>{{ format_date(laporan.date) }}</td>
                                                    <td>{{ laporan.bank }}</td>
                                                    <td>{{ laporan.title }}</td>
                                                    <td>{{ laporan.chart_account.type == 2 ? laporan.balance : '-' }}</td>
                                                    <td>{{ laporan.chart_account.type == 1 ? laporan.balance : '-' }}</td>

                                                </tr>
                                            </transition-group>
                                        </transition>
                                </table>
                                <filter-laporan @filterlaporan="filtering" :auth="auth"></filter-laporan>
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
import FilterLaporan from './Filter'
import Loading from '../../components/loading'
import Pagination from './Pagination'
export default {
    props: ['auth'],
    components: {
        FilterLaporan,
        Loading,
        Pagination,
    },
    data() {
        return  {
            laporans: {},
            loading: true,
            filter_keyword: '',
            params: '',
            debit: '',
            kredit: '',
            page: '',
            last_page: '',
        };
    },

    mounted() {
        this.getLaporan()
    },

    methods: {
        filtering(event) {
            this.params = event
        },
        async getLaporan() {
            // this.params.category = 1
            let response = await axios.get('/api/laporan', {
                    params: {
                        keyword: this.filter_keyword,
                        bank: this.params.bank,
                        reimburse: this.params.reimburse,
                        sortbank: this.params.sortbank,
                        sortdate: this.params.sortdate,
                        start_date: this.params.start_date,
                        end_date: this.params.end_date,
                        page: this.$route.query.page,
                    },
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                // console.log("response.data")
                // console.log(response.data)
                this.laporans = response.data.data
                this.debit = response.data.pemasukan
                this.kredit = response.data.pengeluaran
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
    }
}
</script>
