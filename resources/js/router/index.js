<<<<<<< HEAD
import Dashboard from '../views/home'
import Register from '../views/register'
=======
import Dashboard from '../components/Dashboard'
import Home from '../views/home'
import Login from '../views/auth/Index'

import Appointment from '../views/appointment/Index'
import AppointmentEdit from '../views/appointment/Edit'
import AppointmentCreate from '../views/appointment/Create'

import Account from '../views/account/Index'
import AccountEdit from '../views/account/Edit'
import AccountPassword from '../views/account/Password'

import JurnalEdit from '../views/jurnal/Edit'
import JurnalCreate from '../views/jurnal/Create'
import JurnalVerif from '../views/jurnal/Verif'
import JurnalDetail from '../views/jurnal/Detail'
import JurnalImport from '../views/jurnal/Import'
import TabDraft from '../views/jurnal/TabDraft'
import TabProses from '../views/jurnal/TabProses'
import TabVerif from '../views/jurnal/TabVerif'

import Laporan from '../views/laporan/Index'

import Karyawan from '../views/karyawan/Index'
import KaryawanEdit from '../views/karyawan/Edit'
import KaryawanCreate from '../views/karyawan/Create'

import Rekening from '../views/rekening/Index'
import RekeningEdit from '../views/rekening/Edit'
import RekeningCreate from '../views/rekening/Create'

import Periode from '../views/periode/Index'
import PeriodeEdit from '../views/periode/Edit'

import Project from '../views/project/Index'
import ProjectEdit from '../views/project/Edit'
import ProjectCreate from '../views/project/Create'

import Asset from '../views/asset/Index'
import AssetEdit from '../views/asset/Edit'
import AssetCreate from '../views/asset/Create'

import Chart from '../views/chart/Index'
import ChartEdit from '../views/chart/Edit'
import ChartCreate from '../views/chart/Create'
>>>>>>> origin/Back-End

export default {
    mode : 'history',
    linkActiveClass : 'active',

    routes: [
        // {
        //     path: '/',
        //     name: 'dashboard',
        //     component: Home
        // },
        {
<<<<<<< HEAD
            path: 'vue/',
            name: 'dashboard',
            component: Dashboard
=======
            path: '/login',
            name: 'login',
            component: Login
>>>>>>> origin/Back-End
        },

        {
<<<<<<< HEAD
            path: 'vue/register',
            name: 'dashboard.one',
            component: Register
        }
=======
            path:"/",
            component:Dashboard,
            children:[
                {
                    name:"dashboard",
                    path: '/',
                    component: Home,
                    meta:{
                        title:`Dashboard`
                    }
                },
                {
                    path: '/akun',
                    name: 'akun',
                    component: Account
                },
                {
                    path: '/akun/edit',
                    name: 'akun.edit',
                    component: AccountEdit
                },
                {
                    path: '/akun/password',
                    name: 'akun.password',
                    component: AccountPassword
                },
                // APPOINTMENT
                {
                    path: '/appointment',
                    name: 'appointment',
                    component: Appointment
                },
                {
                    path: '/appointment/edit/:token',
                    name: 'appointment.edit',
                    component: AppointmentEdit
                },
                {
                    path: '/appointment/create',
                    name: 'appointment.create',
                    component: AppointmentCreate
                },

                // LAPORAN
                {
                    path: '/laporan',
                    name: 'laporan',
                    component: Laporan,
                },

                // JURNAL
                {
                    path: '/jurnal-draft',
                    name: 'jurnal',
                    component: TabDraft,
                },
                {
                    path: '/jurnal-proses',
                    name: 'jurnalproses',
                    component: TabProses,
                },
                {
                    path: '/jurnal-verif',
                    name: 'jurnalverif',
                    component: TabVerif,
                },
                {
                    path: '/jurnal/edit/:token',
                    name: 'jurnal.edit',
                    component: JurnalEdit
                },
                {
                    path: '/jurnal/create',
                    name: 'jurnal.create',
                    component: JurnalCreate
                },
                {
                    path: '/jurnal/import',
                    name: 'jurnal.import',
                    component: JurnalImport
                },
                {
                    path: '/jurnal/detail/:token',
                    name: 'jurnal.detail',
                    component: JurnalDetail
                },
                {
                    path: '/jurnal/verification/:token',
                    name: 'jurnal.verif',
                    component: JurnalVerif
                },
                {
                    path: '/admin/karyawan',
                    name: 'karyawan',
                    component: Karyawan
                },
                {
                    path: '/admin/karyawan/edit/:token',
                    name: 'karyawan.edit',
                    component: KaryawanEdit
                },
                {
                    path: '/admin/karyawan/create',
                    name: 'karyawan.create',
                    component: KaryawanCreate
                },

                // REKENING BANK
                {
                    path: '/admin/rekening',
                    name: 'rekening',
                    component: Rekening
                },
                {
                    path: '/admin/rekening/edit/:token',
                    name: 'rekening.edit',
                    component: RekeningEdit
                },
                {
                    path: '/admin/rekening/create',
                    name: 'rekening.create',
                    component: RekeningCreate
                },

                // PERIODE
                {
                    path: '/admin/periode',
                    name: 'periode',
                    component: Periode
                },
                {
                    path: '/admin/periode/:token',
                    name: 'periode.edit',
                    component: PeriodeEdit
                },

                // PROJECT
                {
                    path: '/admin/project',
                    name: 'project',
                    component: Project
                },
                {
                    path: '/admin/project/edit/:token',
                    name: 'project.edit',
                    component: ProjectEdit
                },
                {
                    path: '/admin/project/create',
                    name: 'project.create',
                    component: ProjectCreate
                },

                // ASSET
                {
                    path: '/admin/asset',
                    name: 'asset',
                    component: Asset
                },
                {
                    path: '/admin/asset/edit/:token',
                    name: 'asset.edit',
                    component: AssetEdit
                },
                {
                    path: '/admin/asset/create',
                    name: 'asset.create',
                    component: AssetCreate
                },

                // CHART ACCOUNT
                {
                    path: '/admin/chart',
                    name: 'chart',
                    component: Chart
                },
                {
                    path: '/admin/chart/edit/:token',
                    name: 'chart.edit',
                    component: ChartEdit
                },
                {
                    path: '/admin/chart/create',
                    name: 'chart.create',
                    component: ChartCreate
                },
            ]
        },

>>>>>>> origin/Back-End
    ]
}
