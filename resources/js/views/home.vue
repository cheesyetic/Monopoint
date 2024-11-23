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
                                <h3 class="uil-wallet mt-3 mb-0"></h3>
                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 46px; height: 47px;"></div></div><div class="contract-trigger"></div></div></div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR {{ new Intl.NumberFormat(['ban', 'id']).format(dashboard.totaluang) }}</span></h4>
                                <p class="text-muted mb-0">Total Uang</p>
                            </div>
<<<<<<< HEAD
                            <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>2.65%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="orders-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">5,643</span></h4>
                                <p class="text-muted mb-0">Orders</p>
                            </div>
                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>0.82%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="customers-chart"> </div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">45,254</span></h4>
                                <p class="text-muted mb-0">Customers</p>
                            </div>
                            <p class="text-muted mt-3 mb-0"><span class="text-danger me-1"><i class="mdi mdi-arrow-down-bold me-1"></i>6.24%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">

                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2">
                                <div id="growth-chart"></div>
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">+ <span data-plugin="counterup">12.58</span>%</h4>
                                <p class="text-muted mb-0">Growth</p>
                            </div>
                            <p class="text-muted mt-3 mb-0"><span class="text-success me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>10.51%</span> since last week
                            </p>
                        </div>
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->

            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                        <a class="dropdown-item" href="#">Weekly</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Sales Analytics</h4>

                            <div class="mt-1">
                                <ul class="list-inline main-chart mb-0">
                                    <li class="list-inline-item chart-border-left me-0 border-0">
                                        <h3 class="text-primary">$<span data-plugin="counterup">2,371</span><span class="text-muted d-inline-block font-size-15 ms-3">Income</span></h3>
                                    </li>
                                    <li class="list-inline-item chart-border-left me-0">
                                        <h3><span data-plugin="counterup">258</span><span class="text-muted d-inline-block font-size-15 ms-3">Sales</span>
                                        </h3>
                                    </li>
                                    <li class="list-inline-item chart-border-left me-0">
                                        <h3><span data-plugin="counterup">3.6</span>%<span class="text-muted d-inline-block font-size-15 ms-3">Conversation Ratio</span></h3>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-3">
                                <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-xl-4">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-8">
                                    <p class="text-white font-size-18">Enhance your <b>Campaign</b> for better outreach <i class="mdi mdi-arrow-right"></i></p>
                                    <div class="mt-4">
                                        <a href="javascript: void(0);" class="btn btn-success waves-effect waves-light">Upgrade Account!</a>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mt-4 mt-sm-0">
                                        <img src="/assets/images/setup-analytics-amico.svg" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->

                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <div class="dropdown">
                                    <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="#">Monthly</a>
                                        <a class="dropdown-item" href="#">Yearly</a>
                                        <a class="dropdown-item" href="#">Weekly</a>
                                    </div>
                                </div>
                            </div>

                            <h4 class="card-title mb-4">Top Selling Products</h4>


                            <div class="row align-items-center g-0 mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-primary me-2"></i> Desktops </p>
                                </div>

                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-primary" role="progressbar"
                                            style="width: 52%" aria-valuenow="52" aria-valuemin="0"
                                            aria-valuemax="52">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center g-0 mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-info me-2"></i> iPhones </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-info" role="progressbar"
                                            style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                            aria-valuemax="45">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center g-0 mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-success me-2"></i> Android </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-success" role="progressbar"
                                            style="width: 48%" aria-valuenow="48" aria-valuemin="0"
                                            aria-valuemax="48">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center g-0 mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-warning me-2"></i> Tablets </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-warning" role="progressbar"
                                            style="width: 78%" aria-valuenow="78" aria-valuemin="0"
                                            aria-valuemax="78">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                            <div class="row align-items-center g-0 mt-3">
                                <div class="col-sm-3">
                                    <p class="text-truncate mt-1 mb-0"><i class="mdi mdi-circle-medium text-purple me-2"></i> Cables </p>
                                </div>
                                <div class="col-sm-9">
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar progress-bar bg-purple" role="progressbar"
                                            style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                                            aria-valuemax="63">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end Col -->
            </div> <!-- end row-->

            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <div class="dropdown">
                                    <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted">All Members<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                        <a class="dropdown-item" href="#">Locations</a>
                                        <a class="dropdown-item" href="#">Revenue</a>
                                        <a class="dropdown-item" href="#">Join Date</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Top Users</h4>

                            <div data-simplebar style="max-height: 336px;">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-centered table-nowrap">
                                        <tbody>
                                            <tr>
                                                <td style="width: 20px;"><img src="/assets/images/users/avatar-4.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 fw-normal">Glenn Holden</h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Nevada</p>
                                                </td>
                                                <td><span class="badge bg-soft-danger font-size-12">Cancel</span></td>
                                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>$250.00</td>
                                            </tr>
                                            <tr>
                                                <td><img src="/assets/images/users/avatar-5.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 fw-normal">Lolita Hamill</h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Texas</p>
                                                </td>
                                                <td><span class="badge bg-soft-success font-size-12">Success</span></td>
                                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-danger" data-feather="trending-down"></i>$110.00</td>
                                            </tr>
                                            <tr>
                                                <td><img src="/assets/images/users/avatar-6.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 fw-normal">Robert Mercer</h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> California</p>
                                                </td>
                                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>$420.00</td>
                                            </tr>
                                            <tr>
                                                <td><img src="/assets/images/users/avatar-7.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 fw-normal">Marie Kim</h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Montana</p>
                                                </td>
                                                <td><span class="badge bg-soft-warning font-size-12">Pending</span></td>
                                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                                            </tr>
                                            <tr>
                                                <td><img src="/assets/images/users/avatar-8.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 fw-normal">Sonya Henshaw</h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Colorado</p>
                                                </td>
                                                <td><span class="badge bg-soft-info font-size-12">Active</span></td>
                                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>$112.00</td>
                                            </tr>
                                            <tr>
                                                <td><img src="/assets/images/users/avatar-2.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 fw-normal">Marie Kim</h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> Australia</p>
                                                </td>
                                                <td><span class="badge bg-soft-success font-size-12">Success</span></td>
                                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-danger" data-feather="trending-down"></i>$120.00</td>
                                            </tr>
                                            <tr>
                                                <td><img src="/assets/images/users/avatar-1.jpg" class="avatar-xs rounded-circle " alt="..."></td>
                                                <td>
                                                    <h6 class="font-size-15 mb-1 fw-normal">Sonya Henshaw</h6>
                                                    <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-map-marker"></i> India</p>
                                                </td>
                                                <td><span class="badge bg-soft-danger font-size-12">Cancel</span></td>
                                                <td class="text-muted fw-semibold text-end"><i class="icon-xs icon me-2 text-success" data-feather="trending-up"></i>$112.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- enbd table-responsive-->
                            </div> <!-- data-sidebar-->
                        </div><!-- end card-body-->
                    </div> <!-- end card-->
                </div><!-- end col -->

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" id="dropdownMenuButton3"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted">Recent<i class="mdi mdi-chevron-down ms-1"></i></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item" href="#">Recent</a>
                                        <a class="dropdown-item" href="#">By Users</a>
                                    </div>
                                </div>
                            </div>

                            <h4 class="card-title mb-4">Recent Activity</h4>

                            <ol class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 336px;">
                                <li class="feed-item">
                                    <div class="feed-item-list">
                                        <p class="text-muted mb-1 font-size-13">Today<small class="d-inline-block ms-1">12:20 pm</small></p>
                                        <p class="mb-0">Andrei Coman magna sed porta finibus, risus
                                            posted a new article: <span class="text-primary">Forget UX
                                                Rowland</span></p>
                                    </div>
                                </li>
                                <li class="feed-item">
                                    <p class="text-muted mb-1 font-size-13">22 Jul, 2020 <small class="d-inline-block ms-1">12:36 pm</small></p>
                                    <p class="mb-0">Andrei Coman posted a new article: <span
                                            class="text-primary">Designer Alex</span></p>
                                </li>
                                <li class="feed-item">
                                    <p class="text-muted mb-1 font-size-13">18 Jul, 2020 <small class="d-inline-block ms-1">07:56 am</small></p>
                                    <p class="mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                        Commented <span class="text-primary"> Developer Moreno</span></p>
                                </li>
                                <li class="feed-item">
                                    <p class="text-muted mb-1 font-size-13">10 Jul, 2020 <small class="d-inline-block ms-1">08:42 pm</small></p>
                                    <p class="mb-0">Zack Wetass, Chris combined Commented <span
                                            class="text-primary">UX Murphy</span></p>
                                </li>

                                <li class="feed-item">
                                    <p class="text-muted mb-1 font-size-13">23 Jun, 2020 <small class="d-inline-block ms-1">12:22 am</small></p>
                                    <p class="mb-0">Zack Wetass, sed porta finibus, risus Chris Wallace
                                        Commented <span class="text-primary"> Developer Moreno</span></p>
                                </li>
                                <li class="feed-item pb-1">
                                    <p class="text-muted mb-1 font-size-13">20 Jun, 2020 <small class="d-inline-block ms-1">09:48 pm</small></p>
                                    <p class="mb-0">Zack Wetass, Chris combined Commented <span
                                            class="text-primary">UX Murphy</span></p>
                                </li>

                            </ol>

=======
>>>>>>> origin/Back-End
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-end mt-2" style="position: relative;">
                                <h3 class="uil-file-landscape mt-3 mb-0"></h3>
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
                                <h4 class="mt-3 mb-0">{{ bank.name }}</h4>
                            <div class="resize-triggers"><div class="expand-trigger"><div style="width: 46px; height: 47px;"></div></div><div class="contract-trigger"></div></div></div>
                            <div>
                                <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR {{ new Intl.NumberFormat(['ban', 'id']).format(bank.balance) }}</span></h4>
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
                            <apexchart v-if="journalSeries.length != 0" type="bar" height="400" :options="journalChartOptions" :series="journalSeries"></apexchart>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <apexchart v-if="balanceSeries.length != 0" type="line" height="400" :options="balanceChartOptions" :series="balanceSeries"></apexchart>
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
                this.journalSeries.push({ data, name })
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
                this.balanceSeries.push({ data, name })
                data = Object.values(response.data.pengeluaran)
                name = "Pengeluaran"
                this.balanceSeries.push({ data, name })
            }
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
