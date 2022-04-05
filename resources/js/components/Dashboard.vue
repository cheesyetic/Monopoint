<template>
<div>
   <div id="layout-wrapper">
        <navigation :auth="auth"></navigation>
        <transition
            mode="out-in"
            enter-active-class="animate__animated animate__fadeIn animate__faster"
            leave-active-class="animate__animated animate__fadeOut animate__faster"
            >
            <router-view :auth="auth"></router-view>
        </transition>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            auth: {
                loggedIn: localStorage.getItem('loggedIn'),
                token: localStorage.getItem('token'),
                user_token: '',
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
                    this.auth.user = response.data // assign response to state user
                    this.token()
                })
            }
            catch (e) {
                localStorage.removeItem("loggedIn")
                this.$router.push({ name: 'login' })
            }
        },
        token() {
            // console.log("request acc token")
            axios.get('/api/token/' + this.auth.user.id )
            .then(response => {
                // console.log(response)
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
