<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><i class="uil-file-landscape"></i> Jurnal</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Jurnal</li>
                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light mx-2" data-bs-toggle="modal" data-bs-target="#createModal">Buat Jurnal Baru</button> -->
                                <button @click="exportExcel()" class="btn btn-success" style="margin-left:8px"><i class="uil-table"></i> Export Excel <loading v-if="loadingExcel" size="18"/></button>
                                <router-link exact :to="{ name: 'jurnal.create'}" class="btn btn-primary mx-2"><i class="uil-plus"></i> Buat Jurnal Baru</router-link>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <ul class="nav nav-tabs nav-tabs nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab" aria-selected="true">
                        <span class="d-block"><i class="uil-clipboard"></i></span>
                        <span class="d-none d-sm-block">Draft</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab" aria-selected="false">
                        <span class="d-block"><i class="uil-process"></i></span>
                        <span class="d-none d-sm-block">Diproses</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab" aria-selected="false">
                        <span class="d-block"><i class="uil-file-check"></i></span>
                        <span class="d-none d-sm-block">Terverif</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3 text-muted card border-top-0">
                <div class="tab-pane active" id="home1" role="tabpanel">
                    <tab-draft :auth="auth"></tab-draft>
                </div>
                <div class="tab-pane" id="profile1" role="tabpanel">
                    <tab-proses :auth="auth"></tab-proses>
                </div>
                <div class="tab-pane" id="messages1" role="tabpanel">
                    <tab-verif :auth="auth"></tab-verif>
                </div>
            </div>

        </div>
    </div>
  </div>
</template>

<script>

import TabDraft from './TabDraft'
import TabProses from './TabProses'
import TabVerif from './TabVerif'
import DeleteJournal from './Delete'
import Loading from '../../components/loading'
export default {
    props: ['auth'],
    components: {
        DeleteJournal,
        TabDraft,
        TabProses,
        TabVerif,
        Loading
    },
    data() {
        return {
            loadingExcel: false,
        }
    },
    methods: {
        async exportExcel() {
            try {
                this.loadingExcel = true
                let response = await axios.get(`/api/journal/export`, {
                    headers: {
                        'Authorization': 'Bearer ' + this.auth.token
                    }
                })
                if (response.status == 200) {
                    this.$toasted.show(response.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })
                }
                this.loadingExcel = false
            } catch (e) {
                // console.log(e)
                this.$toasted.show("Something went wrong : " + e, {
                    type: 'error',
                    duration: 3000,
                    position: 'top-center',
                })
            }
        }
    }

}
</script>

<style>

</style>
