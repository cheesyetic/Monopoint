<template>
 <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-landscape"></i> Verifikasi Jurnal</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'jurnal' }">Jurnal</router-link></li>
                                <li class="breadcrumb-item m-auto active">Verifikasi</li>
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
                <div class="row">
                    <div class="card col-sm-4">
                        <form class="card-body" method="pos" @submit.prevent="store">
                            <h3>Verifikasi</h3>
                            <div class="col md-10 wrapper btn-group">
                                <button class="btn btn-outline-primary" :class="verif ? 'active' : ''" @click.prevent="verif = 1">Terima</button>
                                <button class="btn btn-outline-primary" :class="!verif ? 'active' : ''" @click.prevent="verif = 0">Tolak</button>
                            </div>
                            <div class="my-3" v-if="!verif">
                                <label for="example-date-input" class="">Alasan Penolakan</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" type="text" v-model="note_decline"></textarea>
                                    <div v-if="theErrors.ref" class="mt-1 text-danger">{{ theErrors.ref[0] }}</div>
                                </div>
                            </div>
                            <div class="my-3" v-if="journal.is_reimburse == 1 && verif">
                                <label for="example-date-input" class="">File Bukti Verifikasi</label>
                                <div class="">
                                    <input type="file" class="form-control-file" v-on:change="pictureUpload" accept="image/*">
                                    <div v-if="theErrors.ref" class="mt-1 text-danger">{{ theErrors.ref[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="uil-message"></i> Kirim <loading size="22" fill="#fff" v-if="loadingAcc"/></button>.
                        </form>
                    </div>
                    <div class="col-sm-8">
                        <div class="card p-4">
                            <h4>{{ journal.title }}</h4>
                            <p class="mb-0">{{ journal.date }}</p>
                            <hr>
                            <p>Remark : {{ journal.remark }}</p>
                            <p>Ref : {{ journal.ref }}</p>
                            <p>Reimburse : {{ journal.is_reimburse }}</p>
                            <p>Chart_account : {{ journal.chart_account_id }}</p>
                            <p>Period : {{ journal.accounting_period_id }}</p>
                            <p>Bank : {{ journal.bank_account_id }}</p>
                            <p>Project : {{ journal.project_id }}</p>
                            <p>User : {{ journal.user_id }}</p>
                            <p>File : {{ journal.filebukti }}</p>
                        </div>
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
            journal: {},
            // successMessage: [],
            theErrors: [],
            verif: 1,
            filebukti: '',
            note_decline: '',
            loading: true,
            loadingAcc: false,
        }
    },

    mounted() {
        this.findJurnal()
    },

    methods: {
        selectId(e, target) {
            this.journal[target] = e.id
        },
        pictureUpload: function() {
            console.log("ganti gambar")
            // this.journal.filebukti = this.$refs.filebukti.files[0]
            this.filebukti = event.target.files[0]
        },

        async findJurnal() {
            let response = await axios.get('/api/journal/' + this.$route.params.token, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.journal = response.data.data
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
            if(this.verif) {
                try {
                    this.loadingAcc = true
                    let formdata = new FormData()
                    if(this.filebukti != '') {
                        formdata.append('filebukti', this.filebukti)
                    }
                    await axios.post('/api/verifjournal/' + this.$route.params.token, formdata, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'Authorization': 'Bearer ' + this.auth.token
                            }
                    }).then(
                        response => {
                            this.filebukti = ''
                            this.theErrors = []
                            this.$router.push({ name: 'jurnal' })

                            this.$toasted.show("Sukses verifikasi jurnal", {
                                type: 'success',
                                duration: 3000,
                                position: 'top-center',
                            })
                        }
                    ).catch((e) => {
                        this.$toasted.show("Something went wrong : " + e, {
                            type: 'error',
                            duration: 3000,
                            position: 'top-center',
                        })
                        console.log(e)
                        console.log("Gagal verifikasi jurnal")
                        console.log("ERRR:: ", e.response.data)
                    })

                } catch (e) {
                    this.loadingAcc = false
                    this.$toasted.show("Something went wrong : " + e, {
                            type: 'error',
                            duration: 3000,
                            position: 'top-center',
                        })
                        console.log(e)
                        console.log("Gagal verifikasi jurnal")
                        console.log("ERRR:: ", e.response.data)
                    // this.theErrors = e.responseCreate.data;
                }
            } else {
                try {
                    this.loadingAcc = true
                    let formdata = new FormData()
                    formdata.append('note_decline', this.note_decline)
                    await axios.post('/api/declinejournal/' + this.$route.params.token, formdata, {
                            headers: {
                                'Authorization': 'Bearer ' + this.auth.token
                            }
                        }).then(
                        response => {
                            this.theErrors = []
                            this.$router.push({ name: 'jurnal' })

                            this.$toasted.show("Sukses menolak verifikasi jurnal", {
                                type: 'success',
                                duration: 3000,
                                position: 'top-center',
                            })
                        }
                    ).catch((error) => {
                        this.$toasted.show("Something went wrong : " + e, {
                            type: 'error',
                            duration: 3000,
                            position: 'top-center',
                        })
                        console.log(e)
                        console.log("Gagal verifikasi jurnal")
                        console.log("ERRR:: ", e.response.data)
                    })

                } catch (e) {
                    this.loadingAcc = false
                    this.$toasted.show("Something went wrong : " + e, {
                            type: 'error',
                            duration: 3000,
                            position: 'top-center',
                        })
                        console.log(e)
                        console.log("Gagal verifikasi jurnal")
                        console.log("ERRR:: ", e.response.data)
                    // this.theErrors = e.responseCreate.data;
                }
            }
        }
    }
}
</script>

<style>

</style>
