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
                                <label for="example-text-input" class="col-md-2 col-form-label">Reimburse</label>
                                <div class="col md-10">
                                    <div class="col wrapper">
                                        <input value="1" type="radio" name="select" id="option-1" v-model="journal.is_reimburse">
                                        <label for="option-1" class="option option-1" style="margin-left:0">
                                            <div class="dot"></div>
                                            <span>Ya</span>
                                        </label>
                                        <input value="0" type="radio" name="select" id="option-3" v-model="journal.is_reimburse">
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
                                    <div v-if="theErrors.ref" class="mt-1 text-danger">{{ theErrors.ref[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Chart Account</label>
                                <div class="col-md-10">
                                    <v-select v-model="chartSelected" :options="chartOptions" :disabled="chartLoading"></v-select>
                                    <div v-if="theErrors.chart_account_id" class="mt-1 text-danger">{{ theErrors.chart_account_id[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Balance</label>
                                <div class="col-md-10">
                                    <div class="d-flex align-items-center">
                                        <p style="margin:0;margin-right: 1rem">IDR</p>
                                        <input class="form-control flex-grow" type="number" v-model="journal.balance" :class="theErrors.balance ? 'is-invalid' : ''">
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
                                    <v-select v-model="bankSelected" :options="bankOptions" :disabled="bankLoading"></v-select>
                                    <div v-if="theErrors.bank_account_id" class="mt-1 text-danger">{{ theErrors.bank_account_id[0] }}</div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Project</label>
                                <div class="col-md-10">
                                    <v-select v-model="projectSelected" :options="projectOptions" :disabled="projectLoading"></v-select>
                                    <div v-if="theErrors.project_id" class="mt-1 text-danger">{{ theErrors.project_id[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit" :disabled="loadingEdit"><i class="bx bx-save"></i> Save</button>
                            <loading v-if="loadingEdit"/>
                        </form>
                    </div>
                </div>
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
            chartOptions: [],
            chartSelected: '',
            chartLoading: true,

            bankOptions: [],
            bankSelected: '',
            bankLoading: true,

            projectOptions: [],
            projectSelected: '',
            projectLoading: true,

            periodOptions: [],
            periodSelected: '',
            periodLoading: true,

            journal: {},
            // successMessage: [],
            theErrors: [],
            loading: true,
            loadingEdit: false,
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
            let response = await axios.get('/api/chartaccount', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name + ' (' + response.data.data[i].code + ', ' + response.data.data[i].type + ')'
                    let id = String(response.data.data[i].id)
                    this.chartOptions.push({ label, id })
                    if(id == this.journal.chart_account_id) {
                        this.chartSelected = { label, id }
                    }
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
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name + ' (' + response.data.data[i].start + ' - ' + response.data.data[i].end + ')'
                    let id = String(response.data.data[i].id)
                    this.periodOptions.push({ label, id })
                    if(id == this.journal.accounting_period_id) {
                        this.periodSelected = { label, id }
                    }
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
            let response = await axios.get('/api/project', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    this.projectOptions.push({ label, id })
                    if(id == this.journal.project_id) {
                        this.projectSelected = { label, id }
                    }
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
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    this.bankOptions.push({ label, id })
                    if(id == this.journal.bank_account_id) {
                        this.bankSelected = { label, id }
                    }
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
            let response = await axios.get('/api/journal/' + this.$route.params.token, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.journal = response.data.data
                this.journal.date = moment(String(this.journal.date)).format('yyyy-MM-DD') + 'T' + moment(String(this.journal.date)).format('hh:mm:ss')
                this.journal.filebukti = ''
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
                console.log(this.journal.filebukti)
                formdata.append('title', this.journal.title)
                formdata.append('date', this.journal.date)
                formdata.append('remark', this.journal.remark)
                formdata.append('ref', this.journal.ref)
                if (this.journal.filebukti) {
                    formdata.append('filebukti', this.journal.filebukti)
                }
                formdata.append('is_reimburse', this.journal.is_reimburse)
                formdata.append('chart_account_id', this.chartSelected.id)
                formdata.append('accounting_period_id', this.periodSelected.id)
                formdata.append('balance', this.journal.balance)
                formdata.append('bank_account_id', this.bankSelected.id)
                formdata.append('project_id', this.projectSelected.id)
                // formdata.append('project_id', this.journal.project_id)
                formdata.append('user_id', this.auth.user.id)
                this.loadingEdit = true
                await axios.post('/api/journal/' + this.$route.params.token,  formdata, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'Authorization': 'Bearer ' + this.auth.token
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

                        this.$toasted.show("Sukses mengedit jurnal", {
                            type: 'success',
                            duration: 3000,
                            position: 'top-center',
                        })
                    }
                )
                // .catch((e) => {
                //     this.$toasted.show("Something went wrong : " + e, {
                //         type: 'error',
                //         duration: 3000,
                //         position: 'top-center',
                //     })
                //     console.log(e)
                //     console.log("ERRR:: ", e.response.data)
                // })

            } catch (e) {
                this.loadingEdit = false
                this.$toasted.show("Something went wrong : " + e, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                console.log(e)
                console.log("responseCreate gagal")
                console.log("ERRR:: ", e.response.data)
                this.theErrors = e.response.data;
                // this.theErrors = e.responseCreate.data;
            }
        }
    }
}
</script>

<style>

</style>
