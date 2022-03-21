<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-landscape"></i> Buat Jurnal Baru</h4>

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
                                    <input class="form-control" type="datetime-local" v-model="journalCreate.date">
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
                                <label for="example-text-input" class="col-md-2 col-form-label">Reimburse</label>
                                <div class="col md-10">
                                    <div class="col wrapper">
                                        <input value="1" type="radio" name="select" id="option-1" v-model="journalCreate.is_reimburse">
                                        <label for="option-1" class="option option-1" style="margin-left:0">
                                            <div class="dot"></div>
                                            <span>Ya</span>
                                        </label>
                                        <input value="0" type="radio" name="select" id="option-3" v-model="journalCreate.is_reimburse">
                                        <label for="option-3" class="option option-3">
                                            <div class="dot"></div>
                                            <span>Tidak</span>
                                        </label>
                                    </div>
                                    <div v-if="theErrors.is_reimburse" class="mt-1 text-danger">{{ theErrors.is_reimburse[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">File Bukti</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control-file" v-on:change="pictureUpload" accept="image/*">
                                    <div v-if="theErrors.filebukti" class="mt-1 text-danger">{{ theErrors.filebukti[0] }}</div>
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
                                <label for="example-date-input" class="col-md-2 col-form-label">Balance</label>
                                <div class="col-md-10">
                                    <div class="d-flex align-items-center">
                                        <p style="margin:0;margin-right: 1rem">IDR</p>
                                        <input class="form-control flex-grow" type="number" v-model="journalCreate.balance">
                                    </div>
                                    <div v-if="theErrors.balance" class="mt-1 text-danger">{{ theErrors.balance[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Periode</label>
                                <div class="col-md-10">
                                    <v-select v-model="periodSelected" :options="periodOptions" :disabled="periodLoading"></v-select>
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
                                    <v-select :options="projectOptions"  @input="selectId($event, 'project_id')" :disabled="projectLoading"></v-select>
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
    props: ['auth'],
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
            periodSelected: '',
            journalCreate: {
                title: '',
                date: '',
                remark: '',
                ref: '',
                filebukti: '',
                is_reimburse: '',
                chart_account_id: '',
                accounting_period_id: '',
                balance: '',
                bank_account_id: '',
                project_id: '',
                user_id: '',
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
            // console.log("ganti gambar")
            // this.journalCreate.filebukti = this.$refs.filebukti.files[0]
            this.journalCreate.filebukti = event.target.files[0]
        },

        async getChart() {
            let response = await axios.get('/api/chartaccount', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                // console.log(response.data.data.length)
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
            let response = await axios.get('/api/accountingperiod', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                // console.log(response.data.data.length)
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name + ' (' + response.data.data[i].start + ' - ' + response.data.data[i].end + ')'
                    let id = String(response.data.data[i].id)
                    this.periodOptions.push({ label, id })
                    if(response.data.data[i].status == 1) {
                        // this.journalCreate.accounting_period_id = id
                        this.periodSelected = { label, id }
                    }
                }
                // console.log(this.journalCreate.accounting_period_id + "periodeny broe")
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
            let response = await axios.get('/api/project', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                // console.log(response.data.data.length)
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
            let response = await axios.get('/api/bankaccount', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                // this.periodOptions = response.data.data
                // console.log(response.data.data.length)
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

        async store(event) {
            try {
                let formdata = new FormData()
                formdata.append('title', this.journalCreate.title)
                formdata.append('date', this.journalCreate.date)
                formdata.append('remark', this.journalCreate.remark)
                formdata.append('ref', this.journalCreate.ref)
                formdata.append('filebukti', this.journalCreate.filebukti)
                formdata.append('is_reimburse', this.journalCreate.is_reimburse)
                formdata.append('chart_account_id', this.journalCreate.chart_account_id)
                formdata.append('accounting_period_id', this.periodSelected.id)
                formdata.append('balance', this.journalCreate.balance)
                formdata.append('bank_account_id', this.journalCreate.bank_account_id)
                formdata.append('project_id', this.journalCreate.project_id)
                formdata.append('user_id', this.auth.user.id)
                await axios.post('/api/journal',  formdata, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                }).then(
                    response => {
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

                        this.$toasted.show("Sukses menambah jurnal", {
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
                this.theErrors = e.response.data;
            }
        }
    }
}
</script>

<style>
</style>
