<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <!-- <h1>Selamat Datang, <strong>{{ user.name }}</strong></h1> -->
                <!-- <button class="btn-primary" @click="logout">Logout</button> -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"> Selamat Datang di Aplikasi Monopoint!</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                            <h4>{{ dashboard.jurnaldraft }}</h4>
                            <p class="m-0">Jurnal Draft</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                            <h4>{{ dashboard.jurnalprocess }}</h4>
                            <p class="m-0">Jurnal Process</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                            <h4>{{ dashboard.jurnaldone }}</h4>
                            <p class="m-0">Jurnal Done</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2" style="position: relative;">
                                    <h3 class="uil-wallet mt-3 mb-0"></h3>
                                    <div class="resize-triggers">
                                        <div class="expand-trigger">
                                            <div style="width: 46px; height: 47px;"></div>
                                        </div>
                                        <div class="contract-trigger"></div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR
                                            {{ new Intl.NumberFormat(['ban', 'id']).format(dashboard.totaluang) }}</span>
                                    </h4>
                                    <p class="text-muted mb-0">Total Uang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2" style="position: relative;">
                                    <h3 class="uil-file-landscape mt-3 mb-0"></h3>
                                    <div class="resize-triggers">
                                        <div class="expand-trigger">
                                            <div style="width: 46px; height: 47px;"></div>
                                        </div>
                                        <div class="contract-trigger"></div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span
                                            data-plugin="counterup">{{ dashboard.jumlahjurnal }}</span></h4>
                                    <p class="text-muted mb-0">Total Jurnal</p>
                                </div>
                                <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                            </p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3" v-for="bank in dashboard.bank" :key="bank.id">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2" style="position: relative;">
                                    <h4 class="mt-3 mb-0">{{ bank.name }}</h4>
                                    <div class="resize-triggers">
                                        <div class="expand-trigger">
                                            <div style="width: 46px; height: 47px;"></div>
                                        </div>
                                        <div class="contract-trigger"></div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR
                                            {{ new Intl.NumberFormat(['ban', 'id']).format(bank.balance) }}</span></h4>
                                    <p class="text-muted mb-0">Balance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chart" class="row">
                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <apexchart v-if="journalSeries.length != 0" type="bar" height="400"
                                    :options="journalChartOptions" :series="journalSeries"></apexchart>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <apexchart v-if="balanceSeries.length != 0" type="line" height="400"
                                    :options="balanceChartOptions" :series="balanceSeries"></apexchart>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <footer class="footer" v-if="0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        © Kodig.id.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>


<script>
    import Loading from '../components/loading'
    export default {
        props: ['auth'],
        components: {
            Loading
        },
        data() {
            return {
                journalSeries: [],
                journalChartOptions: {
                    chart: {
                        height: 400,
                        type: 'bar',
                    },
                    colors: ['#5B73E8', '#545454'],
                    dataLabels: {
                        enabled: true,
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            dataLabels: {
                                position: 'bottom', // top, center, bottom
                            },
                        }
                    },
                    title: {
                        text: 'Jumlah Jurnal Dibuat Per-bulan',
                        align: 'left'
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        labels: {
                            show: true,
                        },
                        // convertedCatToNumeric: false,
                        title: {
                            text: 'Month'
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah'
                        },
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                    }
                },
                balanceSeries: [],
                balanceChartOptions: {
                    chart: {
                        height: 400,
                        type: 'line',
                    },
                    colors: ['#5B73E8', '#545454'],
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: 'Jumlah Balance Per-bulan',
                        align: 'left'
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        convertedCatToNumeric: false,
                        title: {
                            text: 'Month'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah (IDR)'
                        },
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                    }
                },
                dashboard: {},
                loading: true,
                key: 0
            };
        },

        mounted() {
            this.getDashboard()
            this.getJournalChart()
            this.getBalanceChart()
        },

        methods: {
            async getDashboard() {
                let response = await axios.get('/api/dashboard', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (response.status === 200) {
                    this.dashboard = response.data
                }
                // console.log("this.dashboard")
                // console.log(response.data)
                this.loading = false
            },
            async getJournalChart() {
                let response = await axios.get('/api/journalchart', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (response.status === 200) {
                    this.journalChartOptions.xaxis.categories = Object.values(response.data.title)
                    this.journalChartOptions.xaxis.convertedCatToNumeric = false
                    let data = Object.values(response.data.total)
                    let name = "Journal"
                    this.journalSeries.push({
                        data,
                        name
                    })
                }
                this.loading = false
            },
            async getBalanceChart() {
                let response = await axios.get('/api/balancechart', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (response.status === 200) {
                    this.balanceChartOptions.xaxis.categories = Object.values(response.data.title)
                    let data = Object.values(response.data.pemasukan)
                    let name = "Pemasukan"
                    this.balanceSeries.push({
                        data,
                        name
                    })
                    data = Object.values(response.data.pengeluaran)
                    name = "Pengeluaran"
                    this.balanceSeries.push({
                        data,
                        name
                    })
                }
                this.loading = false
            },
            format_date(value) {
                if (value) {
                    return moment(String(value)).format('Do MMMM YYYY')
                }
            },
        }
    }

</script>

<style>

</style>
