<template>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-users-alt"></i> Import Excel</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'jurnal' }">Jurnal</router-link></li>
                                <li class="breadcrumb-item m-auto active">Import Excel</li>
                                <!-- <form method="get" action="/storage/files/JournalSample.xlsx">
                                    <button type="submit" class="btn btn-primary mx-2"><i class="bx bx-import"></i> Unduh file contoh</button>
                                </form>
                                <button type="submit" onclick="window.open('/storage/files/JournalSample.xlsx')">Download!</button> -->
                                <a href="/storage/files/JournalSample.xlsx" download="JournalSample.xlsx" target="__blank" class="btn btn-primary mx-2" type="submit"><i class="bx bx-import"></i> Unduh file contoh</a>
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
                                    <div v-if="theErrors.file" class="mt-1 text-danger">{{ theErrors.file[0] }}</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><i class="bx bx-import"></i> Import</button>
                        </form>
                    </div>
                </div> <!-- end col -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Format Excel untuk di-import</h5>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-centered mb-0">
                                <thead class="">
                                    <tr>
                                        <th> Title* </th>
                                        <td>Nama Jurnal</td>
                                    </tr>
                                    <tr>
                                        <th> Date & Time* </th>
                                        <td>Tanggal dan waktu jurnal</td>
                                    </tr>
                                    <tr>
                                        <th> Remark </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Ref </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Catatan Penolakan </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Balance* </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Reimburse* </th>
                                        <td>Berisi 1 jika diterima dan 2 jika ditolak</td>
                                    </tr>
                                    <tr>
                                        <th> Filebukti </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Status* </th>
                                        <td>Berisi 1 jika draft; 2 jika proses; 3 jika diterima; 4 jika ditolak</td>
                                    </tr>
                                    <tr>
                                        <th> Bukti Reimburse </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Created at </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Updated at </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Chart Account ID* </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Accounting Period ID* </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Bank Account ID* </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> Project ID* </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th> User ID* </th>
                                        <td></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
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
                // console.log(this.accountCreate)
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
                // console.log(e)
                this.theErrors = e.response.data;
            }
        }
    }
}
</script>

<style>
</style>
