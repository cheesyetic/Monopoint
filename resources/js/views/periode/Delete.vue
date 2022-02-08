<template>
  <button class="btn btn-danger" @click="destroyPeriod">Delete</button>
</template>

<script>
export default {
    props: ['endpoint'],
    mounted() {
        console.log(this.endpoint)
    },

    methods: {
        destroyPeriod() {
            console.log(this.endpoint)
            try {
                let response = axios.delete('/api/accountingperiod/' + this.endpoint)
                console.log(response.status)
                if (response.status == 200) {
                    this.theErrors = []

                    this.$toasted.show(response.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })

                    this.$router.push({ name: 'periode' })
                }
            } catch (e) {
                this.$toasted.show("Something went wrong", {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                this.theErrors = e.response.data;
            }
        }
    }
}
</script>

<style>

</style>
