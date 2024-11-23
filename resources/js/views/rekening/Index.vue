<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-wallet"></i> Rekening</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Rekening</li>
                                <router-link exact :to="{ name: 'rekening.create'}" class="btn btn-primary mx-2"><i class="uil-plus"></i> Buat Rekening Baru</router-link>
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
                tag="div"
                mode="out-in"
                enter-active-class="animate__animated animate__fadeIn"
                leave-active-class="animate__animated animate__fadeOut"
                >

                <div v-if="!banks.length" class="row card p-4">
                    <h4 class="m-0">No data available</h4>
                </div>

                <transition-group
                    v-else
                    tag="div"
                    class="row"
                    :key="key"
                    >
                    <div class="col-md-6 col-xl-3"
                        v-for="bank in banks"
                        :key="bank.token" ref="list">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end mt-2">
                                    <div id="total-revenue-chart"></div>
                                </div>
                                <div>
                                    <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ bank.name }}</span></h4>
                                    <p class="text-muted mb-0">No Rekening : {{ bank.account_number }}</p>
                                    <p class="text-muted">Balance : IDR {{ new Intl.NumberFormat(['ban', 'id']).format(bank.balance) }}</p>
                                    <router-link :to="{ name: 'rekening.edit', params: { token: bank.token }}" class="btn btn-primary"><i class="uil-edit-alt"></i> Edit</router-link>
                                    <delete-rekening :endpoint="bank.token" :auth="auth"/>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </transition-group> <!-- end row-->
            </transition>
        </div>
    </div>
  </div>
</template>

<script>

import DeleteRekening from './Delete'
import Loading from '../../components/loading'
export default {
    props: ['auth'],
    components: {
        DeleteRekening,
        Loading
    },
    data() {
        return  {
            banks: {},
            loading: true,
            key: 0,
        };
    },

    mounted() {
        this.getRekening()
    },

    created: function () {
        this.getRekening()
    },

    methods: {
        async getRekening() {
            let response = await axios.get('/api/bankaccount', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.banks = response.data.data
            }
            this.loading = false
            // console.log(this.banks)
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
