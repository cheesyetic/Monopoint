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
                                    <v-select :options="partnerOptions" v-model="partnerSelected" multiple :disabled="partnerLoading"></v-select>
                                    <div v-if="theErrors.user_id" class="mt-1 text-danger">{{ theErrors.user_id[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit" :disabled="loadingCRUD"><i class="bx bx-save"></i> Save</button>
                            <loading v-if="loadingCRUD"/>
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
            partnerSelected: [],
            partnerOptions: [],
            partnerLoading: true,
            theErrors: [],
            loading: true,
            loadingCRUD: false,
        }
    },

    mounted() {
        this.getPartner()

    },

    methods: {
        async getPartner() {
            let response = await axios.get('/api/account', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            let type = ""
            if (response.status === 200) {
                // this.partnerOptions = response.data.data
                for (var i = 0; i < response.data.data.length; i++) {
                    if(response.data.data[i].type == 0) {
                        type = "(Admin)"
                    } else if(response.data.data[i].type == 1) {
                        type = "(Keuangan)"
                    } else {
                        type = "(Staff)"
                    }
                    let label = response.data.data[i].name + " " + type
                    let id = (response.data.data[i].id)
                    this.partnerOptions.push({ label, id })
                }
            }
            // console.log(">> sukses get partner options")
            // console.log(this.partnerOptions)
            this.partnerLoading = false
            this.findAppointment()
        },
        async findAppointment() {
            let response = await axios.get('/api/appointment/' + this.$route.params.token, {
                headers: {
                    Authorization: 'Bearer ' + this.auth.token
                }
            })
            if (response.status === 200) {
                this.appointment = response.data.data
                this.appointment.date = moment(String(this.appointment.date)).format('yyyy-MM-DD') + 'T' + moment(String(this.appointment.date)).format('hh:mm:ss')
                // console.log(">> Panjang Appointment user id")
                // console.log(this.appointment.user_id.length)
                // console.log(">> Panjang partnerOptions")
                // console.log(this.partnerOptions.length)
                for (var i = 0; i < this.appointment.user_id.length; i++) {
                    for (var j = 0; j < this.partnerOptions.length; j++) {
                        if(this.partnerOptions[j].id == this.appointment.user_id[i]) {
                            let label = this.partnerOptions[j].label
                            let id = (this.partnerOptions[j].id)
                            this.partnerSelected.push({ label, id })
                            break
                        }
                    }
                }
                console.log(">> Selected Partner")
                console.log(this.partnerSelected)
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
            this.loadingCRUD = true

            this.appointment.user_id = []
            this.appointment.length = 0
            console.log(this.appointment.user_id)
            for (var i = 0; i < this.partnerSelected.length; i++) {
                this.appointment.user_id[i] = this.partnerSelected[i].id
            }
            try {
                let response = await axios.post('/api/appointment/' + this.$route.params.token, this.appointment, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
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
                this.loadingCRUD = false
            }
        }
    }
}
</script>

<style>

</style>
