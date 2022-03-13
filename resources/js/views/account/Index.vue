<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"><i class="uil-meeting-board"></i> Akun</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                    <li class="breadcrumb-item m-auto active">Akun</li>
                                    <!-- <router-link exact :to="{ name: 'appointment.create'}" class="btn btn-primary mx-2"><i class="uil-plus"></i> Buat Appointment Baru</router-link> -->
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="clearfix"></div>
                                    <h3 class="mt-3 mb-1">{{ auth.user.name }}</h3>
                                    <p class="text-muted">{{ auth.user.type == 2 ? "Staff" : (auth.user.type == 1 ? "Keuangan" : "Admin") }}</p>

                                    <div class="mt-4">
                                        <router-link :to="{name: 'akun.edit'}" class="btn btn-primary btn-sm"><i class="uil uil-user me-2"></i> Update Profil</router-link>
                                        <router-link :to="{name: 'akun.password'}" class="btn btn-secondary btn-sm"><i class="uil uil-lock-open-alt me-2"></i> Ganti Password</router-link>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="text-muted">
                                    <div class="table-responsive mt-4">
                                        <div class="mt-4">
                                            <p class="mb-1">Phone :</p>
                                            <h5 class="font-size-16">{{ auth.user.phone_number }}</h5>
                                        </div>
                                        <div class="mt-4">
                                            <p class="mb-1">Email :</p>
                                            <h5 class="font-size-16">{{ auth.user.email }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['auth'],
}
</script>

<style>

</style>
