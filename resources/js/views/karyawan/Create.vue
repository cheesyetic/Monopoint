<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-users-alt"></i> Tambah Karyawan Baru</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'karyawan' }">Karyawan</router-link></li>
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
                                    <input class="form-control" type="text" v-model="accountCreate.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Email</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="email" v-model="accountCreate.email">
                                    <div v-if="theErrors.email" class="mt-1 text-danger">{{ theErrors.email[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Password</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="password" v-model="accountCreate.password">
                                    <div v-if="theErrors.password" class="mt-1 text-danger">{{ theErrors.password[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Nomor telepon</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="accountCreate.phone_number">
                                    <div v-if="theErrors.phone_number" class="mt-1 text-danger">{{ theErrors.phone_number[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Tipe Akun</label>
                                <div class="col md-10 wrapper">
                                    <input value="0" type="radio" name="select" id="option-1" v-model="accountCreate.type">
                                    <label for="option-1" class="option option-1" style="margin-left:0">
                                        <div class="dot"></div>
                                        <span>Admin</span>
                                    </label>

                                    <input value="1" type="radio" name="select" id="option-2" v-model="accountCreate.type">
                                    <label for="option-2" class="option option-2">
                                        <div class="dot"></div>
                                        <span>Keuangan</span>
                                    </label>

                                    <input value="2" type="radio" name="select" id="option-3" v-model="accountCreate.type">
                                    <label for="option-3" class="option option-3">
                                        <div class="dot"></div>
                                        <span>Staff</span>
                                    </label>
                                    <div v-if="theErrors.type" class="mt-1 text-danger">{{ theErrors.type[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="uil-plus"></i> Buat</button>
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
    data() {
        return {
            accountCreate: {
                name: '',
                email: '',
                phone_number: '',
                type: '',
                password: '',
            },
            typeOptions: [
                {
                    value: 0,
                    label: 'Admin'
                },
                {
                    value: 1,
                    label: 'Keuangan'
                },
                {
                    value: 2,
                    label: 'Staff'
                },
            ],
            // successMessage: [],
            theErrors: []
        }
    },
    methods: {
        // selectId(e, target) {
        //     this.accountCreate[target] = e.id
        // },
        async store() {
            try {
                console.log(this.accountCreate)
                let responseCreate = await axios.post('/api/account', this.accountCreate, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (responseCreate.status == 201) {
                    this.accountCreate.name = ''
                    this.accountCreate.email = ''
                    this.accountCreate.phone_number = ''
                    this.accountCreate.type = ''
                    this.accountCreate.password = ''
                    this.theErrors = []

                    this.$router.push({ name: 'karyawan' })

                    this.$toasted.show(responseCreate.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong : " + e, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                console.log(e)
                // this.theErrors = e.responseCreate.data;
            }
        }
    }
}
</script>

<style>
</style>
