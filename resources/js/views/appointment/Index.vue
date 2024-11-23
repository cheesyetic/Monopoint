<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"><i class="uil-meeting-board"></i> Appointment</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item m-auto">
                                        <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
                                    </li>
                                    <li class="breadcrumb-item m-auto active">Appointment</li>
                                    <router-link exact :to="{ name: 'appointment.create'}" class="btn btn-primary mx-2">
                                        <i class="uil-plus"></i> Buat Appointment Baru</router-link>
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
                                <h4 class="card-title mb-4">Latest Appointment</h4>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Tanggal</th>
                                                <th>Remark</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <transition tag="tbody" mode="out-in"
                                            enter-active-class="animate__animated animate__fadeIn animate__faster"
                                            leave-active-class="animate__animated animate__fadeOut animate__faster"
                                            v-if="loading" class="row card p-4 col-md-6 col-xl-3">
                                            <loading />
                                        </transition>
                                        <transition v-else tag="tbody" mode="out-in"
                                            enter-active-class="animate__animated animate__fadeIn"
                                            leave-active-class="animate__animated animate__fadeOut">
                                            <tr v-if="!appointments.length" class="row">
                                                <td class="m-0" colspan="5">No data available</td>
                                            </tr>
                                            <transition-group v-else tag="tbody" :key="key">
                                                <tr v-for="appointment in appointments" :key="appointment.token"
                                                    class="">
                                                    <td>{{ appointment.name }}</td>
                                                    <td>{{ format_date(appointment.date) }}</td>
                                                    <td>
                                                        {{ appointment.remark }}
                                                    </td>
                                                    <td>
                                                        <router-link
                                                            :to="{ name: 'appointment.edit', params: { token: appointment.token }}"
                                                            class="btn btn-primary"><i class="uil-edit-alt"></i> Edit
                                                        </router-link>
                                                        <delete-appointment :endpoint="appointment.token"
                                                            :auth="auth" />
                                                    </td>
                                                </tr>
                                            </transition-group>
                                        </transition>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import DeleteAppointment from './Delete'
    import Loading from '../../components/loading'
    export default {
        props: ['auth'],
        components: {
            DeleteAppointment,
            Loading
        },
        data() {
            return {
                appointments: {},
                loading: true,
                key: 0
            };
        },

        mounted() {
            if (!this.auth.loggedIn) {
                return this.$router.push({
                    name: 'login'
                })
            }
            this.getChart()
        },

        created: function () {
            this.getChart()
        },

        methods: {
            async getChart() {
                let response = await axios.get('/api/appointment', {
                    headers: {
                        Authorization: 'Bearer ' + this.auth.token
                    }
                })
                if (response.status === 200) {
                    this.appointments = response.data.data
                }
                this.loading = false
            },
            format_date(value) {
                if (value) {
                    return moment(String(value)).format('hh:mm, Do MMMM YYYY')
                }
            },
        }
    }

</script>

<style>

</style>
