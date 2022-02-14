import Dashboard from '../views/home'
import Register from '../views/register'
import Appoinment from '../views/Appoinment'

import Jurnal from '../views/jurnal/Index'
import JurnalEdit from '../views/jurnal/Edit'
import JurnalCreate from '../views/jurnal/Create'

import Karyawan from '../views/Karyawan'

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
            path: '/jurnal/edit/:token',
            name: 'jurnalEdit',
            component: JurnalEdit
        },
        {
            path: '/jurnal/create',
            name: 'jurnal.create',
            component: JurnalCreate
        },
        {
            path: '/admin/karyawan',
            name: 'karyawan',
            component: Karyawan
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
}
