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
                                    <p class="text-muted">Sign in to continue to Minible.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form @submit.prevent="login">
                                        <div class="mb-3 form-group">
                                            <label class="form-label">EMAIL</label>
                                            <input type="email" class="form-control" v-model="user.email"
                                                placeholder="Masukkan Email">
                                            <div v-if="validation.email" class="mt-2 alert alert-danger">
                                                Masukkan Email
                                            </div>
                                        </div>

                                        <div class="mb-3 form-group">
                                            <label class="form-label">PASSWORD</label>
                                            <input type="password" class="form-control" v-model="user.password"
                                                placeholder="Masukkan Password">
                                            <div v-if="validation.password" class="mt-2 alert alert-danger">
                                                Masukkan Password
                                            </div>
                                        </div>

                                        <!-- <button type="submit" class="btn btn-primary">LOGIN</button> -->
                                         <div class="mt-3 text-end">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <p>© Minible. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
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
    import axios from 'axios'

    export default {
        // name: 'Login',

        data() {
            return {
                //state loggedIn with localStorage
                loggedIn: localStorage.getItem('loggedIn'),
                //state token
                token: localStorage.getItem('token'),
                //state user
                user: [],
                //state validation
                validation: [],
                //state login failed
                loginFailed: null
            }
        },
        methods: {

            login() {
                if (this.user.email && this.user.password) {
                    axios.get('/sanctum/csrf-cookie')
                        .then(response => {
                            //debug cookie
                            axios.post('/api/login', {
                                email: this.user.email,
                                password: this.user.password
                            }).then(res => {
                                //debug user login
                                console.log(res)
                                if (res.data.success) {
                                    //set localStorage
                                    localStorage.setItem("loggedIn", "true")
                                    //set localStorage Token
                                    localStorage.setItem("token", res.data.token)
                                    //change state
                                    this.loggedIn = true
                                    //redirect dashboard
                                    return this.$router.push({ name: 'dashboard' })
                                } else {
                                    //set state login failed
                                    this.loginFailed = true
                                }
                            }).catch(error => {
                                console.log(error)
                            })
                        })
                }

                this.validation = []

                if (!this.user.email) {
                    this.validation.email = true
                }

                if (!this.user.password) {
                    this.validation.password = true
                }

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
