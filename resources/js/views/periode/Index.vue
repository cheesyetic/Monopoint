<template>
<div>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-calendar-alt"></i> Periode</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Periode</li>
                                <button type="button" class="btn btn-primary waves-effect waves-light mx-2" data-bs-toggle="modal" data-bs-target="#createModal"><i class="uil-plus"></i> Buat Periode Baru</button>
                                <!-- <router-link exact :to="{ name: 'periode.create'}" class="btn btn-primary mx-2">Buat Periode Baru</router-link> -->
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
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

                <div v-if="!periods.length" class="row card p-4">
                    <h4 class="m-0">No data available</h4>
                </div>

                <transition-group
                    v-else
                    tag="div"
                    class="row"
                    :key="key"
                    >
                        <div class="col-md-6 col-xl-3"
                        v-for="period in periods"
                        :key="period.token" ref="list"
                        >
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">{{ period.name }} <span class="badge rounded-pill bg-soft-success" v-if="period.status"><i class="uil-label"></i> Aktif</span></h4>
                                    <p class="card-text mb-0">Start : {{ format_date(period.start) }}</p>
                                    <p class="card-text">End : {{ format_date(period.end) }}</p>
                                    <button @click="enable(period.token)" class="btn btn-secondary mb-1" :class="period.status ? 'disabled' : ''"><i class="uil-message"></i> Aktifkan</button>
                                    <router-link :to="{ name: 'periode.edit', params: { token: period.token }}" class="btn btn-primary mb-1"><i class="uil-edit-alt"></i> Edit</router-link>
                                    <delete-period :endpoint="period.token" :auth="auth"/>
                                </div>
                            </div>
                        </div> <!-- end col -->
                </transition-group>
            </transition>

        </div>
    </div>
  </div>
  <create-period :auth="auth"/>
</div>
</template>

<script>
import DeletePeriod from './Delete'
import CreatePeriod from './Create'
import Loading from '../../components/loading'
export default {
    props: ['auth'],
    components: {
        DeletePeriod,
        CreatePeriod,
        Loading
    },
    data() {
        return  {
            periods: {},
            loading: true,
            key: 0,
        };
    },

    mounted() {
        this.getPeriod()
    },

    created: function () {
        this.getPeriod()
    },

    methods: {
        enable(token) {
            this.$swal.fire({
                title: 'Yakin ingin mengaktifkan periode?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.enablePeriod(token)
                    }
            })
        },
        async enablePeriod(token) {
            let formdata = new FormData();
            let response = await axios.post('/api/periodstatus/ ' + token, formdata, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.getPeriod()
            }
            else {
                this.loading = false
                this.$toasted.show("Error mengaktifkan periode", {
                    type: 'error',
                    duration: 3000,
                    position: 'top-center',
                })
            }
        },
        async getPeriod() {
            let response = await axios.get('/api/accountingperiod', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.periods = response.data.data
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
:root {
  /* --animate-duration: 800ms; */
  transition-delay: 0.9s;
}
</style>
