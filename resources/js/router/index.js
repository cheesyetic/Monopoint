import Dashboard from '../views/home'
import Register from '../views/register'
import Appoinment from '../views/Appoinment'
import Jurnal from '../views/Jurnal'
import Karyawan from '../views/Karyawan'
import Rekening from '../views/Rekening'
import Periode from '../views/periode/Index'
import PeriodeCreate from '../views/periode/Create'
import PeriodeEdit from '../views/periode/Edit'
import Project from '../views/Project'

export default {
    mode : 'history',
    linkActiveClass : 'active',

    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/appoinment',
            name: 'appoinment',
            component: Appoinment
        },
        {
            path: '/jurnal',
            name: 'jurnal',
            component: Jurnal
        },
        {
            path: '/admin/karyawan',
            name: 'karyawan',
            component: Karyawan
        },
        {
            path: '/admin/rekening',
            name: 'rekening',
            component: Rekening
        },
        {
            path: '/admin/periode',
            name: 'periode',
            component: Periode
        },
        {
            path: '/admin/periode/create',
            name: 'periode.create',
            component: PeriodeCreate
        },
        {
            path: '/admin/periode/:id',
            name: 'periode.edit',
            component: PeriodeEdit
        },
        {
            path: '/admin/project',
            name: 'project',
            component: Project
        }
    ]
}
