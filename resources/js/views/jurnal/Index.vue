<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-landscape"></i> Jurnal</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Jurnal</li>
                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light mx-2" data-bs-toggle="modal" data-bs-target="#createModal">Buat Jurnal Baru</button> -->
                                <router-link exact :to="{ name: 'jurnal.create'}" class="btn btn-primary mx-2"><i class="uil-plus"></i> Buat Jurnal Baru</router-link>
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
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Remark</th>
                                            <th>Ref</th>
                                            <th>Project ID</th>
                                            <th>User ID</th>
                                            <th>View Details</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody> -->
                                        <!-- end page title -->
                                        <transition
                                            tag="tbody"
                                            mode="out-in"
                                            enter-active-class="animate__animated animate__fadeIn animate__faster"
                                            leave-active-class="animate__animated animate__fadeOut animate__faster"
                                            v-if="loading" class="row ">
                                        <loading/>
                                        </transition>
                                        <transition
                                            v-else
                                            tag="tbody"
                                            mode="out-in"
                                            enter-active-class="animate__animated animate__fadeIn"
                                            leave-active-class="animate__animated animate__fadeOut"
                                            >

                                        <!-- <div v-else> -->
                                            <tr v-if="!journals.length">
                                                <td colspan="7">No data available</td>
                                            </tr>

                                            <transition-group
                                                v-else
                                                tag="tbody"
                                                >
                                                <tr
                                                    v-for="journal in journals"
                                                    :key="journal.token"
                                                    >
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">{{ journal.title }}</a> </td>
                                                    <td>{{ format_date(journal.date) }}</td>
                                                    <td>
                                                        {{ journal.remark }}
                                                    </td>
                                                    <td>
                                                        {{ journal.ref }}
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill bg-soft-success font-size-12">{{ journal.project_id }}</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-mastercard me-1"></i> {{ journal.user_id }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu <i class="uil-angle-down"></i></button>
                                                            <div class="dropdown-menu" style="">
                                                                <router-link :to="{ name: 'jurnal.edit', params: { token: journal.token }}" class="dropdown-item"><i class="uil-history-alt"></i> Histori</router-link>
                                                                <router-link :to="{ name: 'jurnal.verif', params: { token: journal.token }}" class="dropdown-item" v-if="auth.user.type != 2"><i class="uil-file-check"></i> Verifikasi</router-link>
                                                                <div class="dropdown-divider"></div>
                                                                <router-link :to="{ name: 'jurnal.edit', params: { token: journal.token }}" class="dropdown-item"><i class="uil-edit-alt"></i> Edit</router-link>
                                                                <delete-journal :endpoint="journal.token"/>
                                                            </div>
                                                        </div>
                                                        <!-- <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            View Details
                                                        </button> -->
                                                    </td>
                                                </tr>
                                            </transition-group>
                                        </transition>
                                    <!-- </tbody> -->
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

import DeleteJournal from './Delete'
// import CreateJurnal from './Create'
import Loading from '../../components/loading'
export default {
    props: ['auth'],
    components: {
        DeleteJournal,
        // CreateJurnal,
        Loading
    },
    data() {
        return  {
            journals: {},
            loading: true,
            key: 0,
        };
    },

    mounted() {
        this.getJurnal()
    },

    created: function () {
        this.getJurnal()
    },

    methods: {
        async getJurnal() {
            let response = await axios.get('/api/journal')
            if (response.status === 200) {
                this.journals = response.data.data
            }
            console.log(this.journals)
            this.loading = false
        },
        format_date(value){
         if (value) {
           return moment(String(value)).format('hh:mm - Do MMM YYYY')
          }
      },
    }
}
</script>

<style>

</style>
