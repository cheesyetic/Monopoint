<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Jurnal</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Jurnal</li>
                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light mx-2" data-bs-toggle="modal" data-bs-target="#createModal">Buat Jurnal Baru</button> -->
                                <router-link exact :to="{ name: 'jurnal.create'}" class="btn btn-primary mx-2">Buat Jurnal Baru</router-link>
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
                                    <tbody>
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

                                        <!-- <div v-else> -->
                                            <tr v-if="!journals.length">
                                                <td colspan="7">No data available</td>
                                            </tr>

                                            <transition-group
                                                v-else
                                                tag="tr"
                                                class="row"
                                                v-for="journal in journals"
                                                :key="journal.token"
                                                >
                                                <td><a href="javascript: void(0);" class="text-body fw-bold">{{ journal.title }}</a> </td>
                                                <td>{{ journal.date }}</td>
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
                                                    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                        View Details
                                                    </button>
                                                </td>
                                            </transition-group>
                                        </transition>
                                    </tbody>
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

import DeleteJurnal from './Delete'
// import CreateJurnal from './Create'
import Loading from '../../components/loading'
export default {
    components: {
        DeleteJurnal,
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

</style>
