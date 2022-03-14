<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-alt"></i> Asset</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Asset</li>
                                <router-link exact :to="{ name: 'asset.create'}" class="btn btn-primary mx-2"><i class="uil-plus"></i> Buat Asset Baru</router-link>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="main-content">

                <div class="row">
                    <div class="col-sm-12">
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

                            <div v-if="!assets.length" class="row card p-4">
                                <h4 class="m-0">No data available</h4>
                            </div>

                            <transition-group
                                v-else
                                tag="div"
                                class="row"
                                :key="key"
                                >
                                <div
                                    v-for="asset in assets"
                                    :key="asset.token"
                                    class="col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body row">
                                            <div class="col-9">
                                                <h5 class="card-title">{{ asset.name }}</h5>
                                                <p class="card-text">Jumlah :{{ asset.value }}</p>
                                                <p class="card-text">Tgl Pembelian : {{ format_date(asset.buy_time) }}</p>
                                            </div>
                                            <div class="col-3 row">
                                                <router-link :to="{ name: 'asset.edit', params: { token: asset.token }}" class="btn btn-primary mb-2"><i class="uil-edit-alt"></i> Edit</router-link>
                                                <delete-asset :endpoint="asset.token"/>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end col -->
                            </transition-group>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

import DeleteAsset from './Delete'
import Loading from '../../components/loading'
export default {
    props: ['auth'],
    components: {
        DeleteAsset,
        Loading
    },
    data() {
        return  {
            assets: {},
            loading: true,
            key: 0
        };
    },

    mounted() {
        this.getAsset()
    },

    methods: {
        async getAsset() {
            let response = await axios.get('/api/asset', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.assets = response.data.data
            }
            console.log(response.data.data)
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
