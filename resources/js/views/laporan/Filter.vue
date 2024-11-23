<template>
    <div class="modal fade bs-example-modal-sm" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Bank</label>
                    <v-select v-model="bankSelected" :options="bankOptions" @input="updateFilter($event.id, 'bank')" :disabled="bankLoading"></v-select>
                </div>
                <div class="mb-2">
                    <label class="col-form-label">Periode</label>
                    <v-select v-model="periodSelected" :options="periodOptions" @input="updateFilter($event.id, 'date')" :disabled="periodLoading"></v-select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Project</label>
                    <v-select v-model="projectSelected" :options="projectOptions" @input="updateFilter($event.id, 'project')" :disabled="projectLoading"></v-select>
                </div>
                <div class="mb-2">
                    <label class="col-form-label">Chart Account</label>
                    <v-select v-model="akunSelected" :options="akunOptions" @input="updateFilter($event.id, 'chart')" :disabled="akunLoading"></v-select>
                </div>
                <div class="mb-2">
                    <label class="col-form-label">Date Range (Start - End)</label>
                    <div class="input-daterange input-group">
                        <input @change="updateFilter(filter_start_date, 'start_date')" type="date" class="form-control" name="start" v-model="filter_start_date" placeholder="Start Date">
                        <input @change="updateFilter(filter_end_date, 'end_date')" type="date" class="form-control" name="end" v-model="filter_end_date" placeholder="End Date">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="example-text-input" class="col col-form-label">Bank Sorting</label>
                    <div class="">
                        <input @change="updateFilter(filter_bank, 'sortbank')" value="asc" type="radio" name="name" v-model="filter_bank" id="name-option-1">
                        <label for="name-option-1" class="option option-1 m-0 mb-1">
                            <div class="dot"></div>
                            <span>A-Z</span>
                        </label>
                        <input @change="updateFilter(filter_bank, 'sortbank')" value="desc" type="radio" name="name" v-model="filter_bank" id="name-option-3" selected>
                        <label for="name-option-3" class="option option-3 m-0">
                            <div class="dot"></div>
                            <span>Z-A</span>
                        </label>
                    </div>
                </div>
                <div class="mb-2">
                    <label for="example-text-input" class="col col-form-label">Date Sorting</label>
                    <div class="">
                        <input @change="updateFilter(filter_date, 'sortdate')" value="asc" type="radio" name="date" v-model="filter_date" id="date-option-1" selected>
                        <label for="date-option-1" class="option option-1 m-0 mb-1">
                            <div class="dot"></div>
                            <span>Jan-Des</span>
                        </label>
                        <input @change="updateFilter(filter_date, 'sortdate')" value="desc" type="radio" name="date" v-model="filter_date" id="date-option-3">
                        <label for="date-option-3" class="option option-3 m-0">
                            <div class="dot"></div>
                            <span>Des-Jan</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect" @click="$parent.getLaporan" data-bs-dismiss="modal">Terapkan</button>
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
            filter_keyword: '',
            filter_bank: '',
            filter_start_date: '',
            filter_end_date: '',
            filter_date: '',
            filter_month: '',
            filter_date: '',

            bankSelected: {
                label: 'Semua',
                id: '',
            },
            periodSelected: {
                label: 'Semua',
                id: '',
            },
            projectSelected: {
                label: 'Semua',
                id: '',
            },
            akunSelected: {
                label: 'Semua',
                id: '',
            },

            bankOptions: [{
                label: 'Semua',
                id: '',
            }],
            periodOptions: [{
                label: 'Semua',
                id: '',
            }],
            projectOptions: [{
                label: 'Semua',
                id: '',
            }],
            akunOptions: [{
                label: 'Semua',
                id: '',
            }],

            bankLoading: true,
            periodLoading: true,
            projectLoading: true,
            akunLoading: true,
            params: {
                bank: '',
                start_date: '',
                end_date: '',
                sortbank: '',
                sortdate: '',
                date: '',
            },
        }
    },
    mounted() {
        this.getPeriod();
        this.getBank();
        this.getProject();
        this.getAkun();
    },
    methods: {
        async getPeriod() {
            let response = await axios.get('/api/accountingperiod', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    this.periodOptions.push({ label, id })
                }
                this.periodLoading = false
            } else {
                this.$toasted.show("Failed to load Period", {
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
                }
                this.bankLoading = false
            } else {
                this.$toasted.show("Failed to load Bank", {
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
        async getAkun() {
            let response = await axios.get('/api/chartaccount', {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                for (var i = 0; i < response.data.data.length; i++) {
                    let label = response.data.data[i].name
                    let id = String(response.data.data[i].id)
                    this.akunOptions.push({ label, id })
                }
                this.akunLoading = false
            } else {
                this.$toasted.show("Failed to load akun", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
            }
        },
        updateFilter(event, target) {
            // console.log("ngupdate bosq")
            // console.log(event)
            this.params[target] = event
            this.$emit('filterlaporan', this.params)
        }
    }
}
</script>

<style>

</style>
