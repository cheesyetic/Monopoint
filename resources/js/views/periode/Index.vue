<template>
  <div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Periode</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item m-auto"><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
                                <li class="breadcrumb-item m-auto active">Periode</li>
                                <router-link exact :to="{ name: 'periode.create'}" class="btn btn-primary mx-2">Buat Periode Baru</router-link>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div v-if="!periods.length" class="row card p-4">
                <h4 class="m-0">No data available</h4>
            </div>

            <div v-if="periods.length" class="row">
                <div class="col-md-6 col-xl-3" v-for="period in periods" :key="period.id">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ period.name }}</h4>
                            <p class="card-text mb-0">Start : {{ format_date(period.start) }}</p>
                            <p class="card-text">End : {{ format_date(period.end) }}</p>
                            <router-link :to="{ name: 'periode.edit', params: { id: period.id }}" class="btn btn-primary">Edit</router-link>
                            <delete-period :endpoint="period.id"/>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>
  </div>
</template>

<script>
import DeletePeriod from './Delete'
export default {
    components: {
        DeletePeriod
    },
    data() {
        return  {
            periods: {}
        };
    },

    mounted() {
        this.getPeriod()
    },

    methods: {
        async getPeriod() {
            let response = await axios.get('/api/accountingperiod')
            if (response.status === 200) {
                this.periods = response.data.data
            }
            console.log(response.data.data)
        },
        format_date(value){
         if (value) {
           return moment(String(value)).format('Do MMMM YYYY')
          }
      },
    }
}
</script>

<style>

</style>
