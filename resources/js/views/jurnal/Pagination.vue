<template>
    <div class="row mt-4">
        <div class="col-sm-6">
            <div>
                <p class="mb-sm-0">Page {{ page }} of {{ last_page }}</p>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-sm-end">
                <ul class="pagination pagination-rounded mb-sm-0">
                    <li class="page-item" @click="$parent.getJurnal" :class="page == 1 ? 'disabled' : ''">
                        <router-link :to="{ name: routeName, query: { page: (page > 0) ? parseInt(page)-1 : 1 } }" class="page-link"><i class="mdi mdi-chevron-left"></i></router-link>
                    </li>
                    <li class="page-item" v-for="i in last_page" :key="i" :class=" i == page ? 'active' : ''" @click="$parent.getJurnal">
                        <router-link :to="{ name: routeName, query: { page: i } }" class="page-link">{{ i }}</router-link>
                    </li>
                    <li class="page-item" @click="$parent.getJurnal" :class="page == last_page ? 'disabled' : ''">
                        <router-link :to="{ name: routeName, query: { page: (page < last_page) ? parseInt(page)+1 : last_page } }" class="page-link"><i class="mdi mdi-chevron-right"></i></router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['page', 'last_page'],
    data() {
        return {
            routeName : this.$route.name,
        }
    }
}
</script>

<style>

</style>
