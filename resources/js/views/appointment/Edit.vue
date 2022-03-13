<template>
 <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-bag"></i> Edit Appointment</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'appointment' }">Appointment</router-link></li>
                                <li class="breadcrumb-item m-auto active">Edit</li>
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
                class="row"
                tag="div"
                mode="out-in"
                enter-active-class="animate__animated animate__fadeIn"
                leave-active-class="animate__animated animate__fadeOut"
                >
                <div class="col-12">
                    <div class="card">
                        <form class="card-body" method="post" @submit.prevent="store">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="appointment.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Tanggal</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="datetime-local" v-model="appointment.date">
                                    <div v-if="theErrors.date" class="mt-1 text-danger">{{ theErrors.date[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Remark</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="appointment.remark">
                                    <div v-if="theErrors.remark" class="mt-1 text-danger">{{ theErrors.remark[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Partner</label>
                                <div class="col-md-10">
                                    <v-select :options="partnerOptions" @input="selectId($event, 'user_id')" v-model="appointmentCreate.user_id" multiple :disabled="partnerLoading"></v-select>
                                    <div v-if="theErrors.user_id" class="mt-1 text-danger">{{ theErrors.user_id[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="uil-edit-alt"></i> Edit</button>
                        </form>
                    </div>
                </div> <!-- end col -->
            </transition>
        </div>
    </div>
</div>
</template>

<script>
import Loading from '../../components/loading'
export default {
    props: ['auth'],
    components: {
        Loading
    },
    data() {
        return {
            appointment: {
                name: '',
                account_number: '',
            },
            // successMessage: [],
            theErrors: [],
            loading: true,
        }
    },

    mounted() {
        this.findAppointment()
    },

    methods: {
        async findAppointment() {
            let response = await axios.get('/api/appointment/' + this.$route.params.token, {
                headers: {
                    Authorization: 'Bearer ' + this.auth.token
                }
            })
            if (response.status === 200) {
                this.appointment = response.data.data
                this.appointment.date = moment(String(this.appointment.date)).format('yyyy-MM-DD') + 'T' + moment(String(this.appointment.date)).format('hh:mm:ss')
                this.loading = false
            } else {
                this.$toasted.show("Something went wrong, please try again later", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
            // console.log(response.data.data)
        },
        async store() {
            try {
                let response = await axios.post('/api/appointment/' + this.$route.params.token, this.appointment)
                // console.log(response.status)
                if (response.status == 200) {
                    this.theErrors = []

                    this.$toasted.show(response.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })

                    this.$router.push({ name: 'appointment' })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                this.theErrors = e.response.data;
            }
        }
    }
}
</script>

<style>

</style>
