<template>
 <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-bag"></i> Edit Project</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'project' }">Project</router-link></li>
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
                        <form class="card-body" method="post" @submit.prevent="store">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" v-model="project.name">
                                    <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Status</label>
                                <div class="col md-10 wrapper">
                                    <input value="In Progress" type="radio" name="select" id="option-1" v-model="project.status">
                                    <label for="option-1" class="option option-1" style="margin-left:0">
                                        <div class="dot"></div>
                                        <span>In Progress</span>
                                    </label>

                                    <input value="Pending" type="radio" name="select" id="option-2" v-model="project.status">
                                    <label for="option-2" class="option option-2">
                                        <div class="dot"></div>
                                        <span>Pending</span>
                                    </label>

                                    <input value="Done" type="radio" name="select" id="option-3" v-model="project.status">
                                    <label for="option-3" class="option option-3">
                                        <div class="dot"></div>
                                        <span>Done</span>
                                    </label>
                                    <div v-if="theErrors.type" class="mt-1 text-danger">{{ theErrors.status[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="bx bx-save"></i> Save</button>
                        </form>
                    </div>
                </div> <!-- end col -->
            </transition>
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
            project: {
                name: '',
                account_number: '',
            },
            // successMessage: [],
            theErrors: [],
            loading: true,
        }
    },

    mounted() {
        this.findProject()
    },

    methods: {
        async findProject() {
            let response = await axios.get('/api/project/' + this.$route.params.token, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
            if (response.status === 200) {
                this.project = response.data.data
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
                let response = await axios.post('/api/project/' + this.$route.params.token, this.project, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                // console.log(response.status)
                if (response.status == 200) {
                    this.theErrors = []

                    this.$toasted.show(response.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })

                    this.$router.push({ name: 'project' })
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
