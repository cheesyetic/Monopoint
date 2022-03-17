<template>
<div class="authentication-bg" style="height:100vh">
        <div class="account-pages pt-sm-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <div class="my-5 d-block auth-logo">
                                <img src="assets/images/logo-dark.png" alt="" height="22" class="logo logo-dark">
                                <img src="assets/images/logo-light.png" alt="" height="22" class="logo logo-light">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Masuk untuk mulai menggunakan Monopoint</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form @submit.prevent="login">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">EMAIL</label>
                                            <input type="email" class="form-control" v-model="user.email"
                                                placeholder="Masukkan Email">
                                            <div v-if="theErrors.email" class="mt-2 alert alert-danger">
                                                {{ theErrors.email[0] }}
                                            </div>
                                        </div>

                                        <div class="mb-3 form-group">
                                            <label class="form-label">PASSWORD</label>
                                            <input type="password" class="form-control" v-model="user.password"
                                                placeholder="Masukkan Password">
                                            <div v-if="theErrors.password" class="mt-2 alert alert-danger">
                                                {{ theErrors.password[0] }}
                                            </div>
                                        </div>

                                        <!-- <button type="submit" class="btn btn-primary">LOGIN</button> -->
                                         <div class="mt-3 text-end">
                                            <loading v-if="loading"/>
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <p>© Kodig.id</p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>

    </div>
</template>

<script>
    import Loading from '../../components/loading'
    import axios from 'axios'

    export default {
        components: {
            Loading
        },

        data() {
            return {
                loading: false,
                //state loggedIn with localStorage
                loggedIn: localStorage.getItem('loggedIn'),
                //state token
                token: localStorage.getItem('token'),
                //state user
                user: [],
                theErrors: [],
            }
        },
        methods: {

            login() {
                // if (this.user.email && this.user.password) {
                    this.loading = true
                    axios.get('/sanctum/csrf-cookie')
                        .then(response => {
                            //debug cookie
                            let formdata = new FormData();
                            formdata.append('email', this.user.email)
                            formdata.append('password', this.user.password)
                            axios.post('/api/login', formdata).then(res => {
                                //debug user login
                                // console.log(res)
                                if (res.data.success) {
                                    localStorage.setItem("loggedIn", "true")
                                    localStorage.setItem("token", res.data.token)
                                    this.loggedIn = true
                                    this.loading = false
                                    return this.$router.push({ name: 'dashboard' })
                                }
                            }).catch(e => {
                                this.$toasted.show("Something went wrong : " + e.response.data.message, {
                                        type: 'error',
                                        duration: 3000,
                                        position: 'top-center',
                                    })
                                    // console.log(e)
                                this.theErrors = e.response.data.errors;
                                this.loading = false
                                // console.log(this.theErrors)
                            })
                            this.loading = false
                        })
                // }
                // this.loading = false
                // this.theErrors = []

                // if (!this.user.email) {
                //     this.theErrors.email = true
                // }

                // if (!this.user.password) {
                //     this.theErrors.password = true
                // }

            }
        },

        //check user already logged in
        mounted() {
            if (this.loggedIn) {
                return this.$router.push({ name: 'dashboard' })
            }
        }
    }
</script>
