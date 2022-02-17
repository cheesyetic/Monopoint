<template>
 <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-landscape"></i> Edit Jurnal</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'jurnal' }">Jurnal</router-link></li>
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
                        <form class="card-body" method="pos" @submit.prevent="store">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Title</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="journal.title">
                                    <div v-if="theErrors.title" class="mt-1 text-danger">{{ theErrors.title[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Date</label>
                                <div class="col-md-10">
                                    <!-- <Datepicker></Datepicker> -->
                                    <input class="form-control" type="datetime-local" v-model="journal.date">
                                    <div v-if="theErrors.date" class="mt-1 text-danger">{{ theErrors.date[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label" for="remark">Remark</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" v-model="journal.remark"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Ref</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="journal.ref" value="2019-08-19">
                                    <div v-if="theErrors.ref" class="mt-1 text-danger">{{ theErrors.ref[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Reimburse</label>
                                <div class="col-md-10">
                                    <div class="vstack gap-2">
                                        <div class="form-check">
                                            <input name="is_reimburse" class="form-check-input" type="radio" value="1" v-model="journal.is_reimburse">
                                            <label class="form-check-label" for="formRadios1">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input name="is_reimburse" class="form-check-input" type="radio" value="0" v-model="journal.is_reimburse">
                                            <label class="form-check-label" for="formRadios2">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="theErrors.remark" class="mt-1 text-danger">{{ theErrors.remark[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">File Bukti</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control-file" v-on:change="pictureUpload">
                                    <div v-if="theErrors.ref" class="mt-1 text-danger">{{ theErrors.ref[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Chart Account</label>
                                <div class="col-md-10">
                                    <v-select v-model="journal.chart_account_id" :options="chartOptions" @input="selectId($event, 'chart_account_id')" :disabled="chartLoading"></v-select>
                                    <div v-if="theErrors.chart_account_id" class="mt-1 text-danger">{{ theErrors.chart_account_id[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Periode</label>
                                <div class="col-md-10">
                                    <v-select v-model="journal.accounting_period_id" :options="periodOptions" @input="selectId($event, 'accounting_period_id')" :disabled="periodLoading"></v-select>
                                    <div v-if="theErrors.accounting_period_id" class="mt-1 text-danger">{{ theErrors.accounting_period_id[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Akun Bank</label>
                                <div class="col-md-10">
                                    <v-select v-model="journal.bank_account_id" :options="bankOptions" @input="selectId($event, 'bank_account_id')" :disabled="bankLoading"></v-select>
                                    <div v-if="theErrors.bank_account_id" class="mt-1 text-danger">{{ theErrors.bank_account_id[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Project</label>
                                <div class="col-md-10">
                                    <v-select v-model="journal.project_id" :options="projectOptions" @input="selectId($event, 'project_id')" :disabled="projectLoading"></v-select>
                                    <div v-if="theErrors.project_id" class="mt-1 text-danger">{{ theErrors.project_id[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Create</button>
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
    components: {
        Loading
    },
    data() {
        return {
            chartOptions: [],
            chartLoading: true,
            bankOptions: [],
            bankLoading: true,
            projectOptions: [],
            projectLoading: true,
            periodOptions: [],
            periodLoading: true,
            journal: {},
            // successMessage: [],
            theErrors: [],
            loading: true,
        }
    },

    mounted() {
        this.findJurnal()
        this.getChart()
        this.getPeriod()
        this.getProject()
        this.getBank()
    },

    methods: {
        selectId(e, target) {
            this.journal[target] = e.id
        },
        pictureUpload: function() {
            console.log("ganti gambar")
            // this.journal.filebukti = this.$refs.filebukti.files[0]
            this.journal.filebukti = event.target.files[0]
        },

        async getChart() {
            let response = await axios.get('/api/chartaccount')
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                console.log(response.data.data.length)
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].id + " - " + response.data.data[i].name + ' (' + response.data.data[i].code + ', ' + response.data.data[i].type + ')'
                    let id = String(response.data.data[i].id)
                    this.chartOptions.push({ label, id })
                }
                this.chartLoading = false
            } else {8
                this.$toasted.show("Failed to load period", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
        },

        async getPeriod() {
            let response = await axios.get('/api/accountingperiod')
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                console.log(response.data.data.length)
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].id + " - " + response.data.data[i].name + ' (' + response.data.data[i].start + ' - ' + response.data.data[i].end + ')'
                    let id = String(response.data.data[i].id)
                    this.periodOptions.push({ label, id })
                }
                this.periodLoading = false
            } else {
                this.$toasted.show("Failed to load period", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
        },

        async getProject() {
            let response = await axios.get('/api/project')
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                console.log(response.data.data.length)
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].id + " - " + response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    this.projectOptions.push({ label, id })
                }
                this.projectLoading = false
            } else {
                this.$toasted.show("Failed to load project", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
        },

        async getBank() {
            let response = await axios.get('/api/bankaccount')
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                console.log(response.data.data.length)
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].id + " - " + response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    this.bankOptions.push({ label, id })
                }
                this.bankLoading = false
            } else {
                this.$toasted.show("Failed to load project", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
        },
        async findJurnal() {
            let response = await axios.get('/api/journal/' + this.$route.params.token)
            if (response.status === 200) {
                this.journal = response.data.data
                this.journal.date = moment(String(this.journal.date)).format('yyyy-MM-DD') + 'T' + moment(String(this.journal.date)).format('hh:mm:ss')
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
                let formdata = new FormData()
                formdata.append('title', this.journal.title)
                formdata.append('date', this.journal.date)
                formdata.append('remark', this.journal.remark)
                formdata.append('ref', this.journal.ref)
                formdata.append('filebukti', this.journal.filebukti)
                formdata.append('is_reimburse', this.journal.is_reimburse)
                formdata.append('chart_account_id', this.journal.chart_account_id)
                formdata.append('accounting_period_id', this.journal.accounting_period_id)
                formdata.append('bank_account_id', this.journal.bank_account_id)
                formdata.append('project_id', this.journal.project_id)
                formdata.append('user_id', this.journal.user_id)
                await axios.post('/api/journal/' + this.$route.params.token,  formdata, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                }).then(
                    response => {
                        this.journal.title = ''
                        this.journal.date = ''
                        this.journal.remark = ''
                        this.journal.ref = ''
                        this.journal.filebukti = ''
                        this.journal.is_reimburse = ''
                        this.journal.chart_account_id = ''
                        this.journal.accounting_period_id = ''
                        this.journal.bank_account_id = ''
                        this.journal.project_id = ''
                        this.journal.user_id = ''
                        this.theErrors = []

                        this.$router.push({ name: 'jurnal' })

                        this.$toasted.show("Sukses menambah jurnal", {
                            type: 'success',
                            duration: 3000,
                            position: 'top-center',
                        })
                    }
                ).catch((error) => {
                    console.log("responseCreate gagal")
                    this.$toasted.show("Something went wrong : " + e, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                    console.log(e)
                    console.log("responseCreate gagal")
                    console.log("ERRR:: ", e.response.data)
                })

            } catch (e) {
                this.$toasted.show("Something went wrong : " + e, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                    console.log(e)
                    console.log("responseCreate gagal")
                    console.log("ERRR:: ", e.response.data)
                // this.theErrors = e.responseCreate.data;
            }
        }
    }
}
</script>

<style>

</style>
