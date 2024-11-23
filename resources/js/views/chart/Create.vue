<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-puzzle-piece"></i> Buat Chart Account Baru</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'chart' }">Chart Account</router-link></li>
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
                                    <input class="form-control" type="text" v-model="chartCreate.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Kode</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" v-model="chartCreate.code">
                                    <div v-if="theErrors.code" class="mt-1 text-danger">{{ theErrors.code[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Tipe</label>
                                 <div class="col md-10">
                                    <div class="col wrapper">
                                        <input value="1" type="radio" name="select" id="option-1" v-model="chartCreate.type">
                                        <label for="option-1" class="option option-1" style="margin-left:0">
                                            <div class="dot"></div>
                                            <span>Pemasukan</span>
                                        </label>

                                        <input value="2" type="radio" name="select" id="option-2" v-model="chartCreate.type">
                                        <label for="option-2" class="option option-2">
                                            <div class="dot"></div>
                                            <span>Pengeluaran</span>
                                        </label>
                                    </div>
                                    <div v-if="theErrors.type" class="mt-1 text-danger">{{ theErrors.type[0] }}</div>
                                </div>
                            </div>
                            <!-- <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Tipe</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="chartCreate.type" name="number">
                                    <div v-if="theErrors.type" class="mt-1 text-danger">{{ theErrors.type[0] }}</div>
                                </div>
                            </div> -->
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
import Radio from '../../components/Radio'

export default {
    props: ['auth'],
    components: {
        Loading,
        Radio
    },
    data() {
        return {
            chartCreate: {
                name: '',
                code: '',
                type: '',
            },
            // successMessage: [],
            theErrors: []
        }
    },
    methods: {
        async store() {
            try {
                // console.log(this.chartCreate)
                let responseCreate = await axios.post('/api/chartaccount', this.chartCreate, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (responseCreate.status == 201) {
                    this.chartCreate.name = ''
                    this.chartCreate.code = ''
                    this.chartCreate.type = ''
                    this.theErrors = []

                    this.$router.push({ name: 'chart' })

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
