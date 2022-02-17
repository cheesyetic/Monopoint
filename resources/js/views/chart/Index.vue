<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-puzzle-piece"></i> Chart Account</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Chart Account</li>
                                <router-link exact :to="{ name: 'chart.create'}" class="btn btn-primary mx-2"><i class="uil-plus"></i> Buat Chart Baru</router-link>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="main-content">

                <div class="row">
                    <div class="col-sm-12">
                        <transition
                        tag="div"
                        mode="out-in"
                        enter-active-class="animate__animated animate__fadeIn animate__faster"
                        leave-active-class="animate__animated animate__fadeOut animate__faster"
                        v-if="loading" class="row card p-4 col-md-6 col-xl-3">
                        <loading/>
                        </transition>
                        <transition
                            v-else
                            tag="div"
                            mode="out-in"
                            enter-active-class="animate__animated animate__fadeIn"
                            leave-active-class="animate__animated animate__fadeOut"
                            >

                            <div v-if="!charts.length" class="row card p-4">
                                <h4 class="m-0">No data available</h4>
                            </div>

                            <transition-group
                                v-else
                                tag="div"
                                class="row"
                                :key="key"
                                >
                                <div
                                    v-for="chart in charts"
                                    :key="chart.token"
                                    class="col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body row">
                                            <div class="col-9">
                                                <h5 class="card-title">{{ chart.name }}</h5>
                                                <p class="card-text">{{ chart.code }}</p>
                                                <p class="card-text">{{ chart.type }}</p>
                                            </div>
                                            <div class="col-3 row">
                                                <router-link :to="{ name: 'chart.edit', params: { token: chart.token }}" class="btn btn-primary mb-2"><i class="uil-edit-alt"></i> Edit</router-link>
                                                <delete-chart :endpoint="chart.token"/>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end col -->
                            </transition-group>
                        </transition>
                            <!-- end col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

import DeleteChart from './Delete'
import Loading from '../../components/loading'
export default {
    components: {
        DeleteChart,
        Loading
    },
    data() {
        return  {
            charts: {},
            loading: true,
            key: 0
        };
    },

    mounted() {
        this.getChart()
    },

    created: function () {
        this.getChart()
    },

    methods: {
        async getChart() {
            let response = await axios.get('/api/chartaccount')
            if (response.status === 200) {
                this.charts = response.data.data
            }
            console.log(response.data.data)
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
