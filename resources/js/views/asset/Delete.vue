<template>
    <button class="btn btn-danger" ref="deleteProject" @click="destroyAsset"><i class="uil-trash"></i> Delete</button>
</template>

<script>
export default {
    props: ['endpoint', 'auth'],

    methods: {
        async destroyAsset() {
            // console.log(this.endpoint)
            try {
                let q = window.confirm("Are you sure you want to delete this asset?")
                if (q) {
                    let responseDelete = await axios.delete(`/api/asset/${this.endpoint}`)
                    if (responseDelete.status == 200) {
                        this.$toasted.show(responseDelete.data.message, {
                            type: 'success',
                            duration: 3000,
                            position: 'top-center',
                        })

                        this.$refs.deleteProject.parentElement.parentElement.parentElement.remove()
                    }
                    else {
                        this.$toasted.show("Error deleting period", {
                            type: 'error',
                            duration: 3000,
                            position: 'top-center',
                        })
                    }
                }

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
