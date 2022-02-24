<template>
  <div>
      <!-- <h1 class="mt-4">Anjay</h1>
    <router-view :user="user"></router-view> -->
  </div>
</template>

<script>

export default {
    data() {
        return {
            //state loggedIn with localStorage
            loggedIn: localStorage.getItem('loggedIn'),
            //state token
            token: localStorage.getItem('token'),
            //state user logged In
            user: []
        }
    },

    created() {
        axios.get('http://localhost:8000/api/user', {headers: {'Authorization': 'Bearer '+this.token}})
        .then(response => {
            console.log(response)
            this.user = response.data // assign response to state user
            this.$emit('user', this.user)
        })
    },

    methods: {
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

    //check user logged in or not
    mounted() {
        if(!this.loggedIn) {
            return this.$router.push({ name: 'login' })
        }
    }
}
</script>

<style>

</style>
