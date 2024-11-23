<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="uil-document-layout-left"></i> Detail Jurnal</h4>
                </div>
                <div class="card p-4">
                    <h4>{{ journal.title }}
                        <span
                            class="badge rounded-pill"
                            :class=" journal.status == 3 ? 'bg-soft-success' : 'bg-soft-danger'"
                            v-if="journal.status == 3 || journal.status == 4">
                            {{ journal.status == 3 ? 'Diterima' : 'Ditolak'}}
                        </span>
                    </h4>
                    <p>{{ format_date(journal.date) }}</p>
                    <div class="">
                        <a :href="journal.filebukti" class="btn btn-primary" role="button" target="__blank"><i class="uil-image"></i> Lihat Bukti Pengajuan</a>
                        <a :href="journal.buktireimburse" v-if="journal.buktireimburse" class="btn btn-primary" role="button" target="__blank"><i class="uil-image"></i> Lihat Bukti Reimburse</a>
                        <p v-if="journal.note_decline" class="mt-2 mb-0">Alasan penolakan : {{ journal.note_decline }}</p>
                    </div>
                    <hr>
                    <p class="my-1">Remark : {{ journal.remark }}</p>
                    <p class="my-1">Ref : {{ journal.ref }}</p>
                    <p class="my-1">Reimburse : {{ journal.is_reimburse ? "Ya" : "Tidak" }}</p>
                    <p class="my-1">Chart Account : {{ journal.chart_account_name }}</p>
                    <p class="my-1">Period : {{ journal.accounting_period_name }}</p>
                    <p class="my-1">Bank : {{ journal.bank_account_name }}</p>
                    <p class="my-1">Project : {{ journal.project_name }}</p>
                    <p class="my-1">User : {{ journal.user_name }}</p>
                    <!-- <img :src="journal.filebukti" alt="" srcset=""> -->
                </div>
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><i class="uil-document-layout-left"></i> Histori Perubahan Jurnal</h4>
                </div>
                <div class="card table-responsive-sm">
                    <table class="table table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Remark</th>
                                <th>Project</th>
                                <th>Chart Akun</th>
                                <th>Nominal</th>
                                <th>Reimburse</th>
                            </tr>
                        </thead>
                            <transition
                                tag="tbody"
                                mode="out-in"
                                enter-active-class="animate__animated animate__fadeIn animate__faster"
                                leave-active-class="animate__animated animate__fadeOut animate__faster"
                                v-if="loading" class="row ">
                            <loading/>
                            </transition>
                            <transition
                                v-else
                                tag="tbody"
                                mode="out-in"
                                enter-active-class="animate__animated animate__fadeIn"
                                leave-active-class="animate__animated animate__fadeOut"
                                >

                                <tr v-if="!journalHistories.length">
                                    <td colspan="7">No data available</td>
                                </tr>

                                <transition-group
                                    v-else
                                    tag="tbody"
                                    >
                                    <tr
                                        v-for="journalHistory in journalHistories"
                                        :key="journalHistory.id"
                                        >
                                        <td :class="journalHistory.title == 'Pembuatan Jurnal' ? 'uil-plus bg-soft-success' :
                                                    journalHistory.title == 'Pengajuan Jurnal' ? 'uil-message bg-soft-primary' :
                                                    journalHistory.title == 'Verifikasi Jurnal' ? 'uil-check bg-soft-info' :
                                                    journalHistory.title == 'Perubahan Jurnal' ? 'uil-edit-alt' : 'uil-book bg-soft-warning'">
                                            {{ journalHistory.title }}</td>
                                        <td>{{ journalHistory.remark }}</td>
                                        <td>{{ journalHistory.project_name }}</td>
                                        <td>{{ journalHistory.chart_account_name }}</td>
                                        <td>IDR {{ new Intl.NumberFormat(['ban', 'id']).format(journalHistory.balance) }} </td>
                                        <td><span :class=" journalHistory.is_reimburse ? 'bg-soft-success' : 'bg-soft-danger'" class="badge rounded-pill font-size-12" >
                                            {{ journalHistory.is_reimburse ? 'Ya' : 'Tidak'}}</span>
                                        </td>
                                    </tr>
                                </transition-group>
                            </transition>
                    </table>
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
            loading: true,
            journal: {},
            journalHistories: {},
        }
    },
    mounted() {
        this.getJournal()
        this.getJournalHistories()
    },
    methods: {
        format_date(value){
            if (value) {
                return moment(String(value)).format('hh:mm - Do MMM YYYY')
            }
        },
        async getJournal() {
            let response = await axios.get('/api/journal/' + this.$route.params.token, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
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
        async getJournalHistories() {
            let response = await axios.get('/api/journalhistories/' + this.$route.params.token, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                // console.log(response)
                this.journalHistories = response.data.data
                this.journalHistories.date = moment(String(this.journalHistories.date)).format('yyyy-MM-DD') + 'T' + moment(String(this.journalHistories.date)).format('hh:mm:ss')
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
    }
}
</script>

<style>

</style>
