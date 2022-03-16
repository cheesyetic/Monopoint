<template>
 <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-bag"></i> Edit Chart Account</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'chart' }">Chart Account</router-link></li>
                                <li class="breadcrumb-item m-auto active">Edit</li>
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
                class="row"
                tag="div"
                mode="out-in"
                enter-active-class="animate__animated animate__fadeIn"
                leave-active-class="animate__animated animate__fadeOut"
                >
                <div class="col-12">
                    <div class="card">
                        <form class="card-body" method="post" @submit.prevent="store">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="chart.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Kode</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="number" v-model="chart.code">
                                    <div v-if="theErrors.code" class="mt-1 text-danger">{{ theErrors.code[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Tipe</label>
                                <div class="col md-10 wrapper">
                                    <input value="1" type="radio" name="select" id="option-1" v-model="chart.type">
                                    <label for="option-1" class="option option-1" style="margin-left:0">
                                        <div class="dot"></div>
                                        <span>Pemasukan</span>
                                    </label>

                                    <input value="2" type="radio" name="select" id="option-2" v-model="chart.type">
                                    <label for="option-2" class="option option-2">
                                        <div class="dot"></div>
                                        <span>Pengeluaran</span>
                                    </label>
                                    <div v-if="theErrors.type" class="mt-1 text-danger">{{ theErrors.type[0] }}</div>
                                </div>
                            </div>
                            <!-- <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Tipe</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="chart.type">
                                    <div v-if="theErrors.type" class="mt-1 text-danger">{{ theErrors.type[0] }}</div>
                                </div>
                            </div> -->
                            <button class="btn btn-primary" type="submit"><i class="bx bx-save"></i> Save</button>
                        </form>
                    </div>
                </div> <!-- end col -->
            </transition>
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
            chart: {
                name: '',
                account_number: '',
            },
            // successMessage: [],
            theErrors: [],
            loading: true,
        }
    },

    mounted() {
        this.findChart()
    },

    methods: {
        async findChart() {
            let response = await axios.get('/api/chartaccount/' + this.$route.params.token, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.chart = response.data.data
                this.loading = false
            } else {
                this.$toasted.show("Something went wrong, please try again later", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
            // console.log(response.data.data)
        },
        async store() {
            try {
                let response = await axios.post('/api/chartaccount/' + this.$route.params.token, this.chart, {
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

                    this.$router.push({ name: 'chart' })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong", {
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
