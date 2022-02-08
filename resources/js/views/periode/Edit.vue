<template>
 <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Edit Periode</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'periode' }">Periode</router-link></li>
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
                        <form class="card-body" method="post" @submit.prevent="store">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="periode.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">Start Date</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="date" v-model="periode.start" value="2019-02-19">
                                    <div v-if="theErrors.start" class="mt-1 text-danger">{{ theErrors.start[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-date-input" class="col-md-2 col-form-label">End Date</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="date" v-model="periode.end" value="2019-08-19">
                                    <div v-if="theErrors.end" class="mt-1 text-danger">{{ theErrors.end[0] }}</div>
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
export default {
    data() {
        return {
            periode: {
                name: '',
                start: '',
                end: '',
            },
            // successMessage: [],
            theErrors: []
        }
    },

    mounted() {
        this.findPeriod()
    },

    methods: {
        async findPeriod() {
            let response = await axios.get('/api/accountingperiod/' + this.$route.params.id)
            if (response.status === 200) {
                this.periode = response.data.data
            }
            console.log(response.data.data)
        },
        async store() {
            try {
                let response = await axios.patch('/api/accountingperiod/' + this.$route.params.id, this.periode)
                console.log(response.status)
                if (response.status == 200) {
                    this.theErrors = []

                    this.$toasted.show(response.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })

                    this.$router.push({ name: 'periode' })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong", {
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
