<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-users-alt"></i> Karyawan</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Karyawan</li>
                                <router-link exact :to="{ name: 'karyawan.create'}" class="btn btn-primary mx-2"><i class="uil-plus"></i> Tambah Karyawan Baru</router-link>
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
                            <h4 class="card-title mb-4">Latest Transaction</h4>
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Tipe</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <transition
                                        tag="tbody"
                                        mode="out-in"
                                        enter-active-class="animate__animated animate__fadeIn animate__faster"
                                        leave-active-class="animate__animated animate__fadeOut animate__faster"
                                        v-if="loading" class="row card p-4 col-md-6 col-xl-3">
                                    <loading/>
                                    </transition>
                                    <transition
                                        v-else
                                        tag="tbody"
                                        mode="out-in"
                                        enter-active-class="animate__animated animate__fadeIn"
                                        leave-active-class="animate__animated animate__fadeOut"
                                        >

                                        <tr v-if="!users.length" class="row">
                                            <td class="m-0" colspan="5">No data available</td>
                                        </tr>

                                        <transition-group
                                            v-else
                                            tag="tbody"
                                            :key="key"
                                            >
                                            <tr
                                                v-for="user in users"
                                                :key="user.token"
                                                class="">
                                                    <td>{{ user.name }}</td>
                                                    <td>{{ user.email }}</td>
                                                    <td>{{ user.phone_number }}</td>
                                                    <td>
                                                        <span v-if="user.type == 0" class="badge rounded-pill bg-soft-danger font-size-13">Admin</span>
                                                        <span v-if="user.type == 1" class="badge rounded-pill bg-soft-warning font-size-13">Keuangan</span>
                                                        <span v-if="user.type == 2" class="badge rounded-pill bg-soft-success font-size-13">Staff</span>
                                                    </td>
                                                    <td>
                                                        <router-link :to="{ name: 'karyawan.edit', params: { token: user.token }}" class="btn btn-primary"><i class="uil-edit-alt"></i> Edit</router-link>
                                                        <delete-user :endpoint="user.token"/>
                                                        <!-- <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            Edit
                                                        </button> -->
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

import DeleteUser from './Delete'
import Loading from '../../components/loading'
export default {
    props: ['auth'],
    components: {
        DeleteUser,
        Loading
    },
    data() {
        return  {
            users: {},
            loading: true,
            key: 0
        };
    },

    mounted() {
        if(!this.auth.loggedIn) {
            return this.$router.push({ name: 'login' })
        }
        this.getUser()
    },

    created: function () {
        this.getUser()
    },

    methods: {
        async getUser() {
            let response = await axios.get('/api/account')
            if (response.status === 200) {
                this.users = response.data.data
            }
            console.log(response.data.data)
            console.log("sukses get user")
            this.loading = false
        },
        format_date(value){
            if (value) {
                return moment(String(value)).format('hh:mm, Do MMMM YYYY')
            }
        },
    }
}
</script>

<style>

</style>
