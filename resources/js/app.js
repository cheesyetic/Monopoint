/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

<<<<<<< HEAD
require('./bootstrap');
=======
// require('./bootstrap');


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true
>>>>>>> origin/Back-End

window.Vue = require('vue').default;
import Vue from 'vue'
import VueRouter from 'vue-router'
<<<<<<< HEAD

=======
import Toasted from 'vue-toasted'
import moment from 'moment'
import 'animate.css'
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueApexCharts from 'vue-apexcharts'
>>>>>>> origin/Back-End
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(VueRouter)
<<<<<<< HEAD
=======
Vue.use(moment)
Vue.use(VueSweetalert2)
Vue.use(VueApexCharts)

window.moment = require('moment');
window.moment.locale('id');
>>>>>>> origin/Back-End

import routes from './router/index'
// import router from './router'
// import store from './store'

Vue.component('navigation', require('./components/navigation.vue').default);
Vue.component('sidebar', require('./components/RightSidebar.vue').default);
Vue.component('v-select', vSelect)
Vue.component('apexchart', VueApexCharts)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    // router:router,
    // store:store,
});
