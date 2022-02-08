import Dashboard from '../views/home'
import Register from '../views/register'

export default {
    mode : 'history',
    linkActiveClass : 'active',

    routes: [
        {
            path: 'vue/',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: 'vue/register',
            name: 'dashboard.one',
            component: Register
        }
    ]
}
