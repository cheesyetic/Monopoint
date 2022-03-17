<template>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true" role="dialog">
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
                        <input @change="updateFilter(filter_reimburse, 'reimburse')" value="1" type="radio" name="reimburse" v-model="filter_reimburse" id="option-1">
                        <label for="option-1" class="option option-1 m-0">
                            <div class="dot"></div>
                            <span>Ya</span>
                        </label>
                        <input @change="updateFilter(filter_reimburse, 'reimburse')" value="0" type="radio" name="reimburse" v-model="filter_reimburse" id="option-2">
                        <label for="option-2" class="option option-2 m-0 my-1">
                            <div class="dot"></div>
                            <span>Tidak</span>
                        </label>
                        <input @change="updateFilter(filter_reimburse, 'reimburse')" value="" type="radio" name="reimburse" v-model="filter_reimburse" id="option-3" selected>
                        <label for="option-3" class="option option-3 m-0">
                            <div class="dot"></div>
                            <span>Semua</span>
                        </label>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Bulan</label>
                    <v-select @input="updateFilter($event, 'month')" :options="monthOptions" :reduce="month => month.id" label="month" v-model="filter_month"></v-select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Chart Account</label>
                    <v-select  :options="chartOptions" @input="updateFilter($event.id, 'chart')" :disabled="chartLoading"></v-select>
                </div>
                <div class="mb-2">
                    <label for="example-text-input" class="col col-form-label">Name Sorting</label>
                    <div class="">
                        <input @change="updateFilter(filter_name, 'sortname')" value="ASC" type="radio" name="name" v-model="filter_name" id="name-option-1">
                        <label for="name-option-1" class="option option-1 m-0 mb-1">
                            <div class="dot"></div>
                            <span>A-Z</span>
                        </label>
                        <input @change="updateFilter(filter_name, 'sortname')" value="DESC" type="radio" name="name" v-model="filter_name" id="name-option-3" selected>
                        <label for="name-option-3" class="option option-3 m-0">
                            <div class="dot"></div>
                            <span>Z-A</span>
                        </label>
                    </div>
                </div>
                <div class="mb-2">
                    <label for="example-text-input" class="col col-form-label">Date Sorting</label>
                    <div class="">
                        <input @change="updateFilter(filter_date, 'sortdate')" value="ASC" type="radio" name="date" v-model="filter_date" id="date-option-1">
                        <label for="date-option-1" class="option option-1 m-0 mb-1">
                            <div class="dot"></div>
                            <span>Jan-Des</span>
                        </label>
                        <input @change="updateFilter(filter_date, 'sortdate')" value="DESC" type="radio" name="date" v-model="filter_date" id="date-option-3" selected>
                        <label for="date-option-3" class="option option-3 m-0">
                            <div class="dot"></div>
                            <span>Des-Jan</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect" @click="$parent.getJurnal" data-bs-dismiss="modal">Terapkan</button>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    props: ['auth'],
    data() {
        return {
            chartOptions: [],
            chartLoading: true,
            filter_keyword: '',
            filter_reimburse: '',
            filter_name: '',
            filter_date: '',
            filter_month: '',
            filter_chartaccount: '',
            monthOptions: [
                {month: 'Semua', id: ''},
                {month: 'Januari', id: '01'},
                {month: 'Februari', id: '02'},
                {month: 'Maret', id: '03'},
                {month: 'April', id: '04'},
                {month: 'Mei', id: '05'},
                {month: 'Juni', id: '06'},
                {month: 'Juli', id: '07'},
                {month: 'Agustus', id: '08'},
                {month: 'September', id: '09'},
                {month: 'Oktober', id: '10'},
                {month: 'November', id: '11'},
                {month: 'Desember', id: '12'}
            ],
            params: {
                category: 1,
                keyword: this.filter_keyword,
                chart: this.filter_chartaccount,
                reimburse: this.filter_reimburse,
                date: this.filter_month,
            }
        }
    },
    mounted() {
        this.getChart();
    },
    methods: {
        async getChart() {
            let response = await axios.get('/api/chartaccount', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                let label = "Semua"
                let id = ""
                this.chartOptions.push({ label, id })
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    this.chartOptions.push({ label, id })
                }
                this.chartLoading = false
            } else {
                this.$toasted.show("Failed to load Chart Account", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
        },
        // selectId(e) {
        //     this.filter_chartaccount = e.id
        // },
        updateFilter(event, target) {
            console.log("ngupdate bosq")
            // console.log(event)
            this.params[target] = event
            this.$emit('filterjournal', this.params)
        }
    }
}
</script>

<style>

</style>
