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
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2" style="position: relative;">
                                <div id="orders-chart" style="min-height: 46px;"> <div id="apexcharts3a6zad0c" class="apexcharts-canvas apexcharts3a6zad0c apexcharts-theme-light" style="width: 45px; height: 46px;"><svg id="SvgjsSvg1048" width="45" height="46" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1050" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1049"><clipPath id="gridRectMask3a6zad0c"><rect id="SvgjsRect1052" width="51" height="47" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask3a6zad0c"><rect id="SvgjsRect1053" width="49" height="49" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1054" class="apexcharts-radialbar"><g id="SvgjsG1055"><g id="SvgjsG1056" class="apexcharts-tracks"><g id="SvgjsG1057" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 22.497318152626402 7.134146575498747" fill="none" fill-opacity="1" stroke="rgba(242,242,242,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="4.258536585365854" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 22.497318152626402 7.134146575498747"></path></g></g><g id="SvgjsG1059"><g id="SvgjsG1061" class="apexcharts-series apexcharts-radial-series" seriesName="seriesx1" rel="1" data:realIndex="0"><path id="SvgjsPath1062" d="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 7.886204749611055 27.248309913566267" fill="none" fill-opacity="0.85" stroke="rgba(52,195,143,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="4.390243902439025" stroke-dasharray="0" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="252" data:value="70" index="0" j="0" data:pathOrig="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 7.886204749611055 27.248309913566267"></path></g><circle id="SvgjsCircle1060" r="13.23658536585366" cx="22.5" cy="22.5" class="apexcharts-radialbar-hollow" fill="transparent"></circle></g></g></g><line id="SvgjsLine1063" x1="0" y1="0" x2="45" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1064" x1="0" y1="0" x2="45" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG1051" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div></div></div>
                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 46px; height: 47px;"></div></div><div class="contract-trigger"></div></div></div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">Rp {{ dashboard.totaluang }}</span></h4>
                                <p class="text-muted mb-0">Total Uang</p>
                            </div>
                            <!-- <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                            </p> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2" style="position: relative;">
                                <div id="orders-chart" style="min-height: 46px;"> <div id="apexcharts3a6zad0c" class="apexcharts-canvas apexcharts3a6zad0c apexcharts-theme-light" style="width: 45px; height: 46px;"><svg id="SvgjsSvg1048" width="45" height="46" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1050" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1049"><clipPath id="gridRectMask3a6zad0c"><rect id="SvgjsRect1052" width="51" height="47" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask3a6zad0c"><rect id="SvgjsRect1053" width="49" height="49" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1054" class="apexcharts-radialbar"><g id="SvgjsG1055"><g id="SvgjsG1056" class="apexcharts-tracks"><g id="SvgjsG1057" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 22.497318152626402 7.134146575498747" fill="none" fill-opacity="1" stroke="rgba(242,242,242,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="4.258536585365854" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 22.497318152626402 7.134146575498747"></path></g></g><g id="SvgjsG1059"><g id="SvgjsG1061" class="apexcharts-series apexcharts-radial-series" seriesName="seriesx1" rel="1" data:realIndex="0"><path id="SvgjsPath1062" d="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 7.886204749611055 27.248309913566267" fill="none" fill-opacity="0.85" stroke="rgba(52,195,143,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="4.390243902439025" stroke-dasharray="0" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="252" data:value="70" index="0" j="0" data:pathOrig="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 7.886204749611055 27.248309913566267"></path></g><circle id="SvgjsCircle1060" r="13.23658536585366" cx="22.5" cy="22.5" class="apexcharts-radialbar-hollow" fill="transparent"></circle></g></g></g><line id="SvgjsLine1063" x1="0" y1="0" x2="45" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1064" x1="0" y1="0" x2="45" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG1051" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div></div></div>
                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 46px; height: 47px;"></div></div><div class="contract-trigger"></div></div></div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ dashboard.jumlahjurnal }}</span></h4>
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
                                <!-- <div id="orders-chart" style="min-height: 46px;"> <div id="apexcharts3a6zad0c" class="apexcharts-canvas apexcharts3a6zad0c apexcharts-theme-light" style="width: 45px; height: 46px;"><svg id="SvgjsSvg1048" width="45" height="46" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1050" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs1049"><clipPath id="gridRectMask3a6zad0c"><rect id="SvgjsRect1052" width="51" height="47" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask3a6zad0c"><rect id="SvgjsRect1053" width="49" height="49" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><g id="SvgjsG1054" class="apexcharts-radialbar"><g id="SvgjsG1055"><g id="SvgjsG1056" class="apexcharts-tracks"><g id="SvgjsG1057" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 22.497318152626402 7.134146575498747" fill="none" fill-opacity="1" stroke="rgba(242,242,242,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="4.258536585365854" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 22.497318152626402 7.134146575498747"></path></g></g><g id="SvgjsG1059"><g id="SvgjsG1061" class="apexcharts-series apexcharts-radial-series" seriesName="seriesx1" rel="1" data:realIndex="0"><path id="SvgjsPath1062" d="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 7.886204749611055 27.248309913566267" fill="none" fill-opacity="0.85" stroke="rgba(52,195,143,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="4.390243902439025" stroke-dasharray="0" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="252" data:value="70" index="0" j="0" data:pathOrig="M 22.5 7.134146341463413 A 15.365853658536587 15.365853658536587 0 1 1 7.886204749611055 27.248309913566267"></path></g><circle id="SvgjsCircle1060" r="13.23658536585366" cx="22.5" cy="22.5" class="apexcharts-radialbar-hollow" fill="transparent"></circle></g></g></g><line id="SvgjsLine1063" x1="0" y1="0" x2="45" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1064" x1="0" y1="0" x2="45" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG1051" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div></div></div> -->
                                <h4 class="mt-3 mb-0">{{ bank.name }}</h4>
                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 46px; height: 47px;"></div></div><div class="contract-trigger"></div></div></div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">Rp {{ bank.balance }}</span></h4>
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
                            <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
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
                     © Minible.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://themesbrand.com/" target="_blank" class="text-reset">Themesbrand</a>
                    </div>
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
            series: [
                {
                name: "High - 2013",
                data: [28, 29, 33, 36, 32, 32, 33]
                },
                {
                name: "Low - 2013",
                data: [12, 11, 14, 18, 17, 13, 13]
                }
            ],
            chartOptions: {
                chart: {
                height: 350,
                type: 'line',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                toolbar: {
                    show: false
                }
                },
                colors: ['#77B6EA', '#545454'],
                dataLabels: {
                enabled: true,
                },
                stroke: {
                curve: 'smooth'
                },
                title: {
                text: 'Average High & Low Temperature',
                align: 'left'
                },
                grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
                },
                markers: {
                size: 1
                },
                xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                title: {
                    text: 'Month'
                }
                },
                yaxis: {
                title: {
                    text: 'Temperature'
                },
                min: 5,
                max: 40
                },
                legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
                }
            },
            dashboard: {},
            loading: true,
            key: 0
        };
    },

    mounted() {
        this.getDashboard()
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
            console.log("this.dashboard")
            console.log(response.data)
            this.loading = false
        },
        format_date(value){
            if (value) {
                return moment(String(value)).format('Do MMMM YYYY')
            }
        },
    }
}

</script>

<style>

</style>
