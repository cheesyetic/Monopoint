<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-users-alt"></i> Tambah Karyawan Baru</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'karyawan' }">Karyawan</router-link></li>
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
                                <label for="example-date-input" class="col-md-2 col-form-label">File Excel</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control-file" v-on:change="fileUpload" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    <div v-if="theErrors.ref" class="mt-1 text-danger">{{ theErrors.ref[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="bx bx-import"></i> Import</button>
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

export default {
    props: ['auth'],
    components: {
        Loading
    },
    data() {
        return {
            accountCreate: {},
            // successMessage: [],
            theErrors: []
        }
    },
    methods: {
        fileUpload: function() {
            this.file = event.target.files[0]
        },
        // selectId(e, target) {
        //     this.accountCreate[target] = e.id
        // },
        async store() {
            try {
                console.log(this.accountCreate)
                let formdata = new FormData()
                formdata.append('file', this.file)

                let responseCreate = await axios.post('/api/journal/import',  formdata, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (responseCreate.status == 200) {
                    this.file = ''
                    this.theErrors = []

                    this.$router.push({ name: 'jurnal' })

                    this.$toasted.show(responseCreate.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong : " + e, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                console.log(e)
                // this.theErrors = e.responseCreate.data;
            }
        }
    }
}
</script>

<style>
</style>
