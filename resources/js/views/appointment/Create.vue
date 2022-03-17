<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-meeting-board"></i> Buat Appointment Baru</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'appointment' }">Appointment</router-link></li>
                                <li class="breadcrumb-item m-auto active">Create</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form class="card-body" method="pos" @submit.prevent="store">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="appointmentCreate.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Tanggal</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="datetime-local" v-model="appointmentCreate.date">
                                    <div v-if="theErrors.date" class="mt-1 text-danger">{{ theErrors.date[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Remark</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="appointmentCreate.remark">
                                    <div v-if="theErrors.remark" class="mt-1 text-danger">{{ theErrors.remark[0] }}</div>
                                </div>
                            </div>
                            <!-- <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Partner</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text">
                                    <div v-if="theErrors.remark" class="mt-1 text-danger">{{ theErrors.remark[0] }}</div>
                                </div>
                            </div> -->
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Partner</label>
                                <div class="col-md-10">
                                    <v-select :options="partnerOptions" @input="selectId($event, 'user_id')" v-model="appointmentCreate.user_id" multiple :disabled="partnerLoading"></v-select>
                                    <div v-if="theErrors.user_id" class="mt-1 text-danger">{{ theErrors.user_id[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit" :disabled="requestLoading"><i class="uil-plus"></i> Buat</button>
                            <loading v-if="requestLoading"/>
                        </form>
                    </div>
                </div> <!-- end col -->
            </div>
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
    mounted() {
        this.getPartner()
    },
    data() {
        return {
            appointmentCreate: {
                name: '',
                date: '',
                remark: '',
                user_id: [],
            },
            partnerLoading: false,
            partnerOptions: [],
            requestLoading: false,
            // successMessage: [],
            theErrors: [],
        }
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
                    let id = String(response.data.data[i].id)
                    this.partnerOptions.push({ label, id })
                }
            }
            console.log(response.data.data)
            console.log("sukses get user")
            this.partnerLoading = false
        },
        async store() {
            this.requestLoading = true
            for (var i = 0; i < this.appointmentCreate.user_id.length; i++) {
                this.appointmentCreate.user_id[i] = this.appointmentCreate.user_id[i].id
            }
            try {
                console.log(this.appointmentCreate)
                let responseCreate = await axios.post('/api/appointment', this.appointmentCreate, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (responseCreate.status == 201) {
                    this.appointmentCreate.name = ''
                    this.appointmentCreate.date = ''
                    this.appointmentCreate.remark = ''
                    this.theErrors = []

                    this.$router.push({ name: 'appointment' })

                    this.$toasted.show(responseCreate.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong : " + e.response.statusText, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                this.requestLoading = false
                this.theErrors = e.response.data;
            }
        }
    }
}
</script>

<style>
</style>
