<template>
<div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Buat Periode Baru</h5>
                <button ref="close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="" method="pos" @submit.prevent="store">
                <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" v-model="periodeCreate.name" name="name">
                                <div v-if="theErrors.name" class="mt-1 text-danger">{{ theErrors.name[0] }}</div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-date-input" class="col-md-2 col-form-label">Start Date</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" v-model="periodeCreate.start" value="2019-02-19">
                                <div v-if="theErrors.start" class="mt-1 text-danger">{{ theErrors.start[0] }}</div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-date-input" class="col-md-2 col-form-label">End Date</label>
                            <div class="col-md-10">
                                <input class="form-control" type="date" v-model="periodeCreate.end" value="2019-08-19">
                                <div v-if="theErrors.end" class="mt-1 text-danger">{{ theErrors.end[0] }}</div>
                            </div>
                        </div>
                        <!-- <button class="btn btn-primary" type="submit">Create</button> -->

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect waves-light" type="submit" ref="createModal"><i class="uil-plus"></i> Buat</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</template>

<script>
export default {
    data() {
        return {
            periodeCreate: {
                name: '',
                start: '',
                end: '',
            },
            // successMessage: [],
            theErrors: []
        }
    },

    methods: {
        async store() {
            try {
                let responseCreate = await axios.post('/api/accountingperiod', this.periodeCreate)
                // console.log(responseCreate.status)
                if (responseCreate.status == 201) {
                    this.periodeCreate.name = ""
                    this.periodeCreate.start = ""
                    this.periodeCreate.end = ""
                    this.theErrors = []

                    this.$toasted.show(responseCreate.data.message, {
                        type: 'success',
                        duration: 3000,
                        position: 'top-center',
                    })
                    // this.$parent.key++;
                    this.$parent.getPeriod();
                    this.$refs.close.click();
                }
            } catch (e) {
                this.$toasted.show("Something went wrong : " + e, {
                        type: 'error',
                        duration: 3000,
                        position: 'top-center',
                    })
                this.theErrors = e.responseCreate.data;
            }
        }
    }
}
</script>

<style>

</style>
