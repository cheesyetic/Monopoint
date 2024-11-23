<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-bag"></i> Buat Project Baru</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'project' }">Project</router-link></li>
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
                                <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="projectCreate.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Status</label>
                                <div class="col md-10">
                                    <div class="col wrapper">
                                        <input value="In Progress" type="radio" name="select" id="option-1" v-model="projectCreate.status">
                                        <label for="option-1" class="option option-1" style="margin-left:0">
                                            <div class="dot"></div>
                                            <span>In Progress</span>
                                        </label>

                                        <input value="Pending" type="radio" name="select" id="option-2" v-model="projectCreate.status">
                                        <label for="option-2" class="option option-2">
                                            <div class="dot"></div>
                                            <span>Pending</span>
                                        </label>

                                        <input value="Done" type="radio" name="select" id="option-3" v-model="projectCreate.status">
                                        <label for="option-3" class="option option-3">
                                            <div class="dot"></div>
                                            <span>Done</span>
                                        </label>
                                    </div>
                                    <div v-if="theErrors.status" class="mt-1 text-danger">{{ theErrors.status[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="uil-plus"></i> Buat</button>
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
import Radio from '../../components/Radio'

export default {
    props: ['auth'],
    components: {
        Loading,
        Radio
    },
    data() {
        return {
            projectCreate: {
                name: '',
                status: '',
            },
            // successMessage: [],
            theErrors: []
        }
    },
    methods: {
        selectId(e, target) {
            this.projectCreate[target] = e.value
        },
        async store() {
            try {
                // console.log(this.projectCreate)
                let responseCreate = await axios.post('/api/project', this.projectCreate, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (responseCreate.status == 201) {
                    this.projectCreate.name = ''
                    this.projectCreate.status = ''
                    this.theErrors = []

                    this.$router.push({ name: 'project' })

                    this.$toasted.show(responseCreate.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong : " + e.response.statusText, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                    // console.log(e)
                this.theErrors = e.response.data;
            }
        }
    }
}
</script>

<style>
</style>
