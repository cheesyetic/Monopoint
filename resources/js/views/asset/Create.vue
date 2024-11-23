<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-alt"></i> Buat Asset Baru</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'asset' }">Asset</router-link></li>
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
                                    <input class="form-control" type="text" v-model="assetCreate.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Kuantitas</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" v-model="assetCreate.quantity">
                                    <div v-if="theErrors.quantity" class="mt-1 text-danger">{{ theErrors.quantity[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Harga Satuan</label>
                                <div class="col-md-10">
                                    <div class="d-flex align-items-center">
                                        <p style="margin:0;margin-right: 1rem">IDR</p>
                                        <input class="form-control flex-grow" type="number" v-model="assetCreate.price">
                                    </div>
                                    <div v-if="theErrors.price" class="mt-1 text-danger">{{ theErrors.price[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Tanggal Pembelian</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="datetime-local" v-model="assetCreate.buy_time">
                                    <div v-if="theErrors.buy_time" class="mt-1 text-danger">{{ theErrors.buy_time[0] }}</div>
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
            assetCreate: {},
            // successMessage: [],
            theErrors: []
        }
    },
    methods: {
        async store() {
            try {
                // console.log(this.assetCreate)
                let responseCreate = await axios.post('/api/asset', this.assetCreate, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (responseCreate.status == 201) {
                    this.$router.push({ name: 'asset' })

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
                    // console.log(e)
                this.theErrors = e.response.data;
            }
        }
    }
}
</script>

<style>
</style>
