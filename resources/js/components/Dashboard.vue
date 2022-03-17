<template>
<div>
   <div id="layout-wrapper">

        <navigation :auth="auth"></navigation>
        <!-- Start right Content here -->
        <transition
            mode="out-in"
            enter-active-class="animate__animated animate__fadeIn animate__faster"
            leave-active-class="animate__animated animate__fadeOut animate__faster"
            >
            <router-view :auth="auth"></router-view>
        </transition>
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <sidebar></sidebar>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
</div>
</template>

<script>
export default {
    data() {
        return {
            auth: {
                //state loggedIn with localStorage
                loggedIn: localStorage.getItem('loggedIn'),
                //state token
                token: localStorage.getItem('token'),
                user_token: '',
                //state user logged In
                user: []
            }
        }
    },

    created() {
        this.getUser()
    },

    methods: {
        async getUser() {
            try {
                let responseUser = await axios.get('/api/user', {
                        headers: {
                            'Authorization': 'Bearer ' + this.auth.token
                        }
                    })
                .then(response => {
                    // console.log("response")
                    // console.log(response.message)
                    this.auth.user = response.data // assign response to state user
                    this.token()
                })
            }
            catch (e) {
                // console.log("logout")
                localStorage.removeItem("loggedIn")
                this.$router.push({ name: 'login' })
            }
        },
        token() {
            console.log("request acc token")
            axios.get('/api/token/' + this.auth.user.id )
            .then(response => {
                console.log(response)
                this.auth.user_token = response.data.data
            })
        },
    },

    //check user logged in or not
    mounted() {
        if(!this.auth.loggedIn) {
            return this.$router.push({ name: 'login' })
        }
    }
}
</script>

<style>

</style>
