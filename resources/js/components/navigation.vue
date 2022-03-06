<template>
    <header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <router-link :to="{name: 'dashboard'}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="/assets/images/logo-dark.png" alt="" height="20">
                    </span>
                </router-link>

                <router-link :to="{name: 'dashboard'}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="/assets/images/logo-light.png" alt="" height="20">
                    </span>
                </router-link>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-search"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-user"></i>
                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">{{ auth.user.name }}</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="uil uil-user-circle font-size-18 align-middle text-muted me-1"></i> <span class="align-middle">Akun</span></a>
                    <a class="dropdown-item" href="#" @click="logout"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Sign out</span></a>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="topnav">

            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <router-link class="nav-link" exact :to="{name: 'dashboard'}">
                                <i class="uil-home-alt me-2"></i> Dashboard
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link class="nav-link" :to="{name: 'appointment'}">
                                <i class="uil-meeting-board me-2"></i> Appointment
                            </router-link>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-jurnal" role="button">
                                <i class="uil-file-landscape me-2"></i>Jurnal <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-jurnal">

                                <router-link :to="{name: 'jurnal'}" class="dropdown-item">Draft</router-link>
                                <router-link :to="{name: 'jurnalproses'}" class="dropdown-item">Proses</router-link>
                                <router-link :to="{name: 'jurnalverif'}" class="dropdown-item">Verif</router-link>

                            </div>
                        </li>

                        <li class="nav-item dropdown" v-if="auth.user.type == 0">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-admin" role="button">
                                <i class="uil-apps me-2"></i>Master Data <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-admin">

                                <router-link :to="{name: 'karyawan'}" class="dropdown-item">Karyawan</router-link>
                                <router-link :to="{name: 'periode'}" class="dropdown-item">Periode</router-link>
                                <router-link :to="{name: 'rekening'}" class="dropdown-item">Rekening</router-link>
                                <router-link :to="{name: 'project'}" class="dropdown-item">Project</router-link>
                                <router-link :to="{name: 'asset'}" class="dropdown-item">Asset</router-link>
                                <router-link :to="{name: 'chart'}" class="dropdown-item">Chart Account</router-link>

                            </div>
                        </li>




                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
</template>

<script>
export default {
    props: ['auth'],
    // data() {
    //   return {
    //     loggedIn: localStorage.getItem('loggedIn'),
    //     token: localStorage.getItem('token'),
    //     user: []
    //   }
    // },

    // created() {
    //     axios.get('http://localhost:8000/api/user', {headers: {'Authorization': 'Bearer '+this.token}})
    //     .then(response => {
    //         console.log(response)
    //         this.user = response.data // assign response to state user
    //     })
    // },

    methods: {
    //   getLoggedIn() {
    //     this.loggedIn = localStorage.getItem("loggedIn")
    //   },
      logout() {
            axios.get('http://localhost:8000/api/logout')
            .then(() => {
                //remove localStorage
                localStorage.removeItem("loggedIn")


                //redirect
                return this.$router.push({ name: 'login' })
            })
        }
    },

    // watch: {
    //   $route: {
    //     immediate: true,
    //     handler() {
    //       this.getLoggedIn()
    //     }
    //   }
    // },
}
</script>

<style>

</style>
