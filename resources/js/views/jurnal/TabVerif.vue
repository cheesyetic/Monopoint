<template>
<div class="table-responsive-sm">
    <div class="input-group mb-2">
        <div class="input-group-prepend">
        <span class="input-group-text border-bottom"><i class="uil-search"></i></span>
        </div>
        <input type="text" v-model="filter_keyword" @change="getJurnal" class="form-control" placeholder="Search">
        <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".modal-verif"><i class="uil-filter"></i> Filter</button>
    </div>
    <table class="table table-centered mb-0">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Remark</th>
                <th>User</th>
                <th>Project</th>
                <th></th>
            </tr>
        </thead>
        <!-- <tbody> -->
            <!-- end page title -->
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

                <tr v-if="!journals.length">
                    <td colspan="7">No data available</td>
                </tr>

                <transition-group
                    v-else
                    tag="tbody"
                    >
                    <tr
                        v-for="journal in journals"
                        :key="journal.token"
                        >
                        <td>{{ journal.title }}</td>
                        <td>{{ format_date(journal.date) }}</td>
                        <td><span :class=" journal.status == 3 ? 'bg-soft-success' : 'bg-soft-danger'" class="badge rounded-pill font-size-12" >
                            {{ journal.status == 3 ? 'Diterima' : 'Ditolak'}}</span>
                        </td>
                        <td>
                            {{ journal.remark }}
                        </td>
                        <td>
                            {{ journal.user_id }}
                        </td>
                        <td><span class="badge rounded-pill bg-soft-success font-size-12">{{ journal.project_id }}</span></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu <i class="uil-angle-down"></i></button>
                                <div class="dropdown-menu" style="">
                                    <router-link :to="{ name: 'jurnal.edit', params: { token: journal.token }}" class="dropdown-item"><i class="uil-document-layout-left"></i> Detail</router-link>
                                </div>
                            </div>
                        </td>
                    </tr>
                </transition-group>
            </transition>
    </table>
    <div class="modal fade modal-verif" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                   <div class="mb-2">
                        <label for="example-text-input" class="col col-form-label">Reimburse</label>
                        <div class="">
                            <input value="1" type="radio" name="reimburse3" v-model="filter_reimburse_verif" id="verif-option-1">
                            <label for="verif-option-1" class="option option-1 m-0">
                                <div class="dot"></div>
                                <span>Ya</span>
                            </label>
                            <input value="0" type="radio" name="reimburse3" v-model="filter_reimburse_verif" id="verif-option-2">
                            <label for="verif-option-2" class="option option-2 m-0 my-1">
                                <div class="dot"></div>
                                <span>Tidak</span>
                            </label>
                            <input value="" type="radio" name="reimburse3" v-model="filter_reimburse_verif" id="verif-option-3" selected>
                            <label for="verif-option-3" class="option option-3 m-0">
                                <div class="dot"></div>
                                <span>Semua</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="exampleDropdownFormPassword">Bulan</label>
                        <v-select :options="monthOptions" @change="getJurnal" :reduce="month => month.code" label="month" v-model="filter_month"></v-select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect" @click="getJurnal" data-bs-dismiss="modal">Terapkan</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import DeleteJournal from './Delete'
import Loading from '../../components/loading'
export default {
props: ['auth'],
    components: {
        DeleteJournal,
        Loading,
    },
    data() {
        return  {
            journals: {},
            loading: true,
            filter_keyword: '',
            filter_reimburse_verif: '',
            filter_month: '',
            monthOptions: [
                {month: 'Semua', code: ''},
                {month: 'Januari', code: '01'},
                {month: 'Februari', code: '02'},
                {month: 'Maret', code: '03'},
                {month: 'April', code: '04'},
                {month: 'Mei', code: '05'},
                {month: 'Juni', code: '06'},
                {month: 'Juli', code: '07'},
                {month: 'Agustus', code: '08'},
                {month: 'September', code: '09'},
                {month: 'Oktober', code: '10'},
                {month: 'November', code: '11'},
                {month: 'Desember', code: '12'}
            ],
        };
    },

    mounted() {
        this.getJurnal()
    },

    methods: {
        async getJurnal() {
            let filter = "&keyword=" + this.filter_keyword + "&reimburse=" + this.filter_reimburse_verif + "&date=" + this.filter_month
            console.log('/api/journal?category=3&keyword=' + filter)
            let response = await axios.get('/api/journal?category=3&keyword=' + filter)
            if (response.status === 200) {
                this.journals = response.data.data
            }
            console.log(this.journals)
            this.loading = false
        },
        format_date(value){
            if (value) {
                return moment(String(value)).format('hh:mm - Do MMM YYYY')
            }
        },
    }
}
</script>
