<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Buat Jurnal Baru</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'jurnal' }">Jurnal</router-link></li>
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
                                <label for="example-text-input" class="col-md-2 col-form-label">Title</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="journalCreate.title">
                                    <div v-if="theErrors.title" class="mt-1 text-danger">{{ theErrors.title[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Date</label>
                                <div class="col-md-10">
                                    <!-- <Datepicker></Datepicker> -->
                                    <input class="form-control" type="date" v-model="journalCreate.date" value="2019-02-19">
                                    <div v-if="theErrors.date" class="mt-1 text-danger">{{ theErrors.date[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-md-2 col-form-label" for="remark">Remark</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" v-model="journalCreate.remark"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Ref</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="journalCreate.ref" value="2019-08-19">
                                    <div v-if="theErrors.ref" class="mt-1 text-danger">{{ theErrors.ref[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Reimburse</label>
                                <div class="col-md-10">
                                    <div class="vstack gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="1" v-model="journalCreate.is_reimburse">
                                            <label class="form-check-label" for="formRadios1">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="0" v-model="journalCreate.is_reimburse">
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
                                    <v-select :options="chartOptions" @input="selectId($event, 'chart_account_id')" :disabled="chartLoading"></v-select>
                                    <div v-if="theErrors.chart_account_id" class="mt-1 text-danger">{{ theErrors.chart_account_id[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Periode</label>
                                <div class="col-md-10">
                                    <v-select :options="periodOptions" @input="selectId($event, 'accounting_period_id')" :disabled="periodLoading"></v-select>
                                    <div v-if="theErrors.accounting_period_id" class="mt-1 text-danger">{{ theErrors.accounting_period_id[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Akun Bank</label>
                                <div class="col-md-10">
                                    <v-select :options="bankOptions" @input="selectId($event, 'bank_account_id')" :disabled="bankLoading"></v-select>
                                    <div v-if="theErrors.bank_account_id" class="mt-1 text-danger">{{ theErrors.bank_account_id[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Project</label>
                                <div class="col-md-10">
                                    <v-select :options="projectOptions" @input="selectId($event, 'project_id')" :disabled="projectLoading"></v-select>
                                    <div v-if="theErrors.project_id" class="mt-1 text-danger">{{ theErrors.project_id[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Create</button>
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
            journalCreate: {
                title: '',
                date: '',
                remark: '',
                ref: '',
                filebukti: '',
                is_reimburse: '',
                chart_account_id: '',
                accounting_period_id: '',
                bank_account_id: '',
                project_id: '',
                user_id: '1',
            },
            // successMessage: [],
            theErrors: []
        }
    },
    mounted() {
        this.getChart()
        this.getPeriod()
        this.getProject()
        this.getBank()
    },
    computed: {
        id: function () {
            return (this.selectedId && this.selectedId.id)?this.selectedId.id:'';
        }
    },
    methods: {
        selectId(e, target) {
            this.journalCreate[target] = e.id
        },
        pictureUpload: function() {
            console.log("ganti gambar")
            // this.journalCreate.filebukti = this.$refs.filebukti.files[0]
            this.journalCreate.filebukti = event.target.files[0]
        },

        async getChart() {
            let response = await axios.get('/api/chartaccount')
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                console.log(response.data.data.length)
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name + ' (' + response.data.data[i].code + ', ' + response.data.data[i].type + ')'
                    let id = String(response.data.data[i].id)
                    this.chartOptions.push({ label, id })
                }
                this.chartLoading = false
            } else {
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
                    let label = response.data.data[i].name + ' (' + response.data.data[i].start + ' - ' + response.data.data[i].end + ')'
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
                    let label = response.data.data[i].name
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
                    let label = response.data.data[i].name
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

        async store() {
            try {
                console.log(this.journalCreate)
                // journalCreateStore = this.journalCreate
                // journalCreateStore.accounting_period_id = this.journalCreate.accounting_period_id.id
                let responseCreate = await axios.post('/api/journal', this.journalCreate, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                })
                // console.log(responseCreate.status)
                if (responseCreate.status == 201) {
                    this.journalCreate.title = ''
                    this.journalCreate.date = ''
                    this.journalCreate.remark = ''
                    this.journalCreate.ref = ''
                    this.journalCreate.filebukti = ''
                    this.journalCreate.is_reimburse = ''
                    this.journalCreate.chart_account_id = ''
                    this.journalCreate.accounting_period_id = ''
                    this.journalCreate.bank_account_id = ''
                    this.journalCreate.project_id = ''
                    this.journalCreate.user_id = ''
                    this.theErrors = []

                    this.$router.push({ name: 'jurnal' })

                    this.$toasted.show(responseCreate.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong : " + e, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                    console.log(e)
                // this.theErrors = e.responseCreate.data;
            }
        }
    }
}
</script>

<style>
</style>
