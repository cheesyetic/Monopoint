<template>
    <form class="main-content" @submit.prevent="store">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"><i class="uil-users-alt"></i> Remuneration</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item m-auto"><router-link
                                            :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                    <li class="breadcrumb-item m-auto active">Remuneration</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-6 col-xl-2">
                        <div class="card">
                            <div class="card-body">
                                <!-- <div class="float-end mt-2" style="position: relative;">
                                <h3 class="bx bx-log-out-circle mt-3 mb-0"></h3>
                            </div> -->
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR {{ new
        Intl.NumberFormat(['ban', 'id']).format(remuneration.nilai_asli)
}}</span>
                                    </h4>
                                    <p class="text-muted mb-0">Nilai Asli</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-2">
                        <div class="card">
                            <div class="card-body">
                                <!-- <div class="float-end mt-2" style="position: relative;">
                                <h3 class="bx bx-log-out-circle mt-3 mb-0"></h3>
                            </div> -->
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR {{ new
        Intl.NumberFormat(['ban', 'id']).format(remuneration.pph)
}}</span></h4>
                                    <p class="text-muted mb-0">PPH 23 (2%)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-2">
                        <div class="card">
                            <div class="card-body">
                                <!-- <div class="float-end mt-2" style="position: relative;">
                                <h3 class="bx bx-log-in-circle mt-3 mb-0"></h3>
                            </div> -->
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">IDR {{ new
        Intl.NumberFormat(['ban', 'id']).format(remuneration.ppn)
}}</span></h4>
                                    <p class="text-muted mb-0">PPN (11%)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-footer text-end">
                                <h5>
                                    <strong>Nilai Bersih Selain Pajak : </strong>
                                    IDR {{ new
        Intl.NumberFormat(['ban', 'id']).format(remuneration.nilai_bersih)
}}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">HPP</h4>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Nilai</th>
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

                                            <tr v-if="!remuneration.journals_keluar.length" class="row">
                                                <td class="m-0" colspan="5">No data available</td>
                                            </tr>

                                            <transition-group v-else tag="tbody" :key="key">
                                                <tr v-for="journal in remuneration.journals_keluar" :key="journal.id"
                                                    class="">
                                                    <td>{{ journal.title }}</td>
                                                    <td>IDR {{ new Intl.NumberFormat(['ban',
        'id']).format(journal.balance)
}}</td>
                                                </tr>
                                            </transition-group>
                                        </transition>
                                    </table>

                                </div>
                                <!-- end table-responsive -->
                            </div>
                            <div class="card-footer text-end">
                                <h5>
                                    <strong>TOTAL HPP : </strong>
                                    IDR {{ new
        Intl.NumberFormat(['ban', 'id']).format(remuneration.hpp)
}}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Kas Dll</h4>
                                <div class="mb-3 row">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Kas & Operasional
                                        Kantor:</label>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <input class="form-control" type="number" v-model="operationalRemuneration">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>IDR {{ new Intl.NumberFormat(['ban',
        'id']).format(calcRemuneration(operationalRemuneration))
}}</p>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Pemilik: </label>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <input class="form-control" type="number" v-model="ownerRemuneration">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>IDR {{ new Intl.NumberFormat(['ban',
        'id']).format(calcRemuneration(ownerRemuneration))
}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <h5>
                                    <strong>TOTAL Kas Dll : </strong>
                                    IDR {{ new Intl.NumberFormat(['ban',
        'id']).format(calcRemuneration(kasRemuneration))
}}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-footer text-end">
                                <h5>
                                    <strong>Total HPP + Total Kas Dll : </strong>
                                    IDR {{ new Intl.NumberFormat(['ban',
        'id']).format(calcRemuneration(kasRemuneration) + remuneration.hpp)
}}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-footer text-end">
                                <h5>
                                    <strong>Sisa Bersih : </strong>
                                    IDR {{ new Intl.NumberFormat(['ban',
        'id']).format(cleanRemuneration)
}}
                                </h5>
                                <p class="mb-0">Total HPP & Total Kas Dll - Nilai Project</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Pembagian</h4>
                                <v-select :options="users" v-model="selectedUser" :disabled="userLoading" multiple
                                    class="mb-3">
                                </v-select>
                                <div v-for="(user, index) in selectedUser" :key="index">
                                    <div class="mb-3 row">
                                        <label for="example-date-input" class="col-md-4 col-form-label">{{ user.label
}}:
                                        </label>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <input class="form-control" type="number"
                                                    v-model="selectedUser[index].value">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p>IDR {{ new Intl.NumberFormat(['ban',
        'id']).format(selectedUser[index].value / 100 * cleanRemuneration)
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
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
            remuneration: {},
            operationalRemuneration: 0,
            ownerRemuneration: 0,
            users: [],
            selectedUser: [],
            loading: true,
            userLoading: true,
            key: 0,
        };
    },
    computed: {
        kasRemuneration: {
            get: function () {
                return parseFloat(this.ownerRemuneration) + parseFloat(this.operationalRemuneration);
            },
            set: function (newValue) {
                this.ownerRemuneration = newValue;
                this.operationalRemuneration = newValue;
            }
        },
        cleanRemuneration: {
            get: function () {
                return this.remuneration.nilai_bersih - this.calcRemuneration(this.kasRemuneration) + this.remuneration.hpp;
            },
        }
    },

    mounted() {
        if (!this.auth.loggedIn) {
            return this.$router.push({ name: 'login' })
        }
        this.getProject()
        this.getUser()
    },

    methods: {
        async getProject() {
            let response = await axios.get('/api/pembagian/' + this.$route.params.token, {
                headers: {
                    'Authorization': 'Bearer ' + this.auth.token
                }
            })
            if (response.status === 200) {
                this.remuneration = response.data
                this.operationalRemuneration = this.remuneration.kas
                this.ownerRemuneration = this.remuneration.pemilik
            }
            // console.log(response.data.data)
            // console.log("sukses get user")
            this.loading = false
        },
        async getUser() {
            let response = await axios.get('/api/account', {
                headers: {
                    'Authorization': 'Bearer ' + this.auth.token
                }
            })
            let type = ""
            if (response.status === 200) {
                // this.users = response.data.data
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    let value = ''
                    this.users.push({
                        label,
                        id,
                        value
                    })
                }
                this.selectedUser = [];
                for (var i = 0; i < this.remuneration.arrayusers.length; i++) {
                    for (var j = 0; j < this.users.length; j++) {
                        if (this.users[j].id == this.remuneration.arrayusers[i]) {
                            let label = this.users[i].label
                            let id = this.users[i].id
                            let value = this.remuneration.percents[i]
                            this.selectedUser.push({
                                label,
                                id,
                                value
                            })
                            break
                        }
                    }
                }
                console.log("this.selectedUser")
                console.log(this.selectedUser)
            }
            // console.log(response.data.data)
            // console.log("sukses get user")
            this.userLoading = false
        },
        calcRemuneration(value) {
            return value / 100 * this.remuneration.nilai_asli
        },
        async store() {
            try {
                // console.log(this.projectCreate)
                let formdata = new FormData()
                formdata.append('project_id', this.$route.params.token)
                formdata.append('kas', this.operationalRemuneration)
                formdata.append('pemilik', this.ownerRemuneration)
                for (var i = 0; i < this.selectedUser.length; i++) {
                    formdata.append('user_id[]', this.selectedUser[i].id)
                    formdata.append('percent[]', this.selectedUser[i].value)
                }
                console.log(formdata)
                await axios.post('/api/pembagian', formdata, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                }).then(
                    response => {
                        this.theErrors = []

                        // this.$router.go()

                        this.$toasted.show("Sukses menyimpan", {
                            type: 'success',
                            duration: 3000,
                            position: 'top-center',
                        })
                    }
                )
            } catch (e) {
                this.$toasted.show("Something went wrong : " + e, {
                    type: 'error',
                    duration: 3000,
                    position: 'top-center',
                })
                // console.log(e)
                this.theErrors = e.response.data;
            }
        }
    }
}
</script>

<style>

</style>
