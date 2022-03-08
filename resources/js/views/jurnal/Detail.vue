<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="card p-4">
                    <h4>{{ journal.title }}</h4>
                    <p>{{ journal.date }}</p>
                    <br>
                    <p>{{ journal.remark }}</p>
                    <p>{{ journal.ref }}</p>
                    <p>{{ journal.is_reimburse }}</p>
                    <p>{{ journal.chart_account }}</p>
                    <p>{{ journal.accounting_period_id }}</p>
                    <p>{{ journal.bank_account_id }}</p>
                    <p>{{ journal.project_id }}</p>
                    <p>{{ journal.user_id }}</p>
                    <p>{{ journal.filebukti }}</p>
                </div>
                <div class="card table-responsive-sm">
                    <table class="table table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Remark</th>
                                <th>Ref</th>
                                <th>Diupdate</th>
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
                                        <td>{{ journalHistory.title }}</td>
                                        <td>{{ format_date(journalHistory.date) }}</td>
                                        <td>
                                            {{ journalHistory.remark }}
                                        </td>
                                        <td>
                                            {{ journalHistory.ref }}
                                        </td>
                                        <td>{{ format_date(journalHistory.updated_at) }}</td>
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
        async getJournalHistories() {
            let response = await axios.get('/api/journalhistories/' + this.$route.params.token)
            if (response.status === 200) {
                console.log(response)
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
