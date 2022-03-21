<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"><i class="uil-user"></i> Edit Akun</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                    <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'akun' }">Akun</router-link></li>
                                    <li class="breadcrumb-item m-auto active">Edit</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="row" @submit.prevent="store">
                                    <fieldset class="col-md-12" :disabled="loading">
                                        <div class="col-md-6 my-2">
                                            <div class="form-group">
                                                <label for="">Nama</label>
                                                <input type="text" class="form-control" v-model="account.name">
                                                <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" class="form-control" v-model="account.email">
                                                <div v-if="theErrors.email" class="mt-1 text-danger">{{ theErrors.email[0] }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <div class="form-group">
                                                <label for="">Phone Number</label>
                                                <input type="number" class="form-control" v-model="account.phone_number">
                                                <div v-if="theErrors.phone_number" class="mt-1 text-danger">{{ theErrors.phone_number[0] }}</div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary" type="submit"><i class="bx bx-save"></i> Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
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
    data() {
        return {
            account: [],
            // successMessage: [],
            theErrors: [],
            loading: true,
        }
    },
    mounted() {
        this.get()
    },
    methods: {
        async get() {
            axios.get('/api/user', {headers: {'Authorization': 'Bearer '+this.auth.token}})
            .then(response => {
                this.account = response.data
                this.loading = false
            })
        },
        async store() {
            try {
                let response = await axios.post('/api/account/' + this.auth.user_token, this.account, {
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

                    this.$router.push({ name: 'akun' })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong : " + e.response.statusText, {
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
