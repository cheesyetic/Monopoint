<template>
    <button class="btn btn-danger" ref="deleteProject" @click="destroyProject"><i class="uil-trash"></i> Delete</button>
</template>

<script>
export default {
    props: ['endpoint', 'auth'],

    methods: {
        async destroyProject() {
            // console.log(this.endpoint)
            try {
                let q = window.confirm("Are you sure you want to delete this project?")
                if (q) {
                    let responseDelete = await axios.delete(`/api/project/${this.endpoint}`, {
                        headers: {
                            'Authorization': 'Bearer ' + this.auth.token
                        }
                    })
                    if (responseDelete.status == 200) {
                        this.$toasted.show(responseDelete.data.message, {
                            type: 'success',
                            duration: 3000,
                            position: 'top-center',
                        })

                        this.$refs.deleteProject.parentElement.parentElement.parentElement.parentElement.remove()
                    }
                    // else {
                    //     this.$toasted.show("Error deleting project", {
                    //         type: 'error',
                    //         duration: 3000,
                    //         position: 'top-center',
                    //     })
                    // }
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
