import Vue from 'vue'
import VueRouter from 'vue-router'
import App from '../views'
import AuthRequired from '../utils/AuthRequired'
Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'App',
    component: App,
    beforeEnter: AuthRequired,
    redirect: '/home',
    children: [    
      {
        path: 'home',
        name: 'Home',
        component: () => import(/* webpackChunkName: "home" */ '../views/Home.vue')
      },
      {
        path: 'profile',
        name: 'Profile',
        component: () => import(/* webpackChunkName: "profile" */ '../views/Profile.vue')
      },
      {
        path: 'transaksi',
        name: 'Transaksi',
        component: () => import(/* webpackChunkName: "transaksi" */ '../views/Transaksi'),
        redirect: '/transaksi/dashboard',
        children: [    
          {
            path: 'dashboard/:no_anggota?',
            name: 'Dashboard',
            component: () => import(/* webpackChunkName: "dashboard" */ '../views/Transaksi/Dashboard.vue')
          },
          {
            path: 'setoran',
            name: 'Setoran',
            component: () => import(/* webpackChunkName: "setoran" */ '../views/Transaksi/Setoran.vue')
          },
          {
            path: 'setoran-form/:kode_rembug?/:no_anggota?/:date?',
            name: 'SetoranForm',
            component: () => import(/* webpackChunkName: "setoran-form" */ '../views/Transaksi/SetoranForm.vue')
          },
        ]
      },
      {
        path: 'anggota/:kode_rembug?/:date?',
        name: 'Anggota',
        component: () => import(/* webpackChunkName: "anggota" */ '../views/Anggota.vue')
      },
      {
        path: 'keanggotaan',
        name: 'Keanggotaan',
        component: () => import(/* webpackChunkName: "keanggotaan" */ '../views/Keanggotaan'),
        redirect: '/keanggotaan/dashboard',
        children: [    
          {
            path: 'dashboard',
            name: 'KeanggotaanDashboard',
            component: () => import(/* webpackChunkName: "keanggotaandashboard" */ '../views/Keanggotaan/Dashboard.vue')
          },
          {
            path: 'registrasiMasuk',
            name: 'KeanggotaanRegistrasiMasuk',
            component: () => import(/* webpackChunkName: "keanggotaanregistrasiMasuk" */ '../views/Keanggotaan/RegistrasiMasuk.vue')
          },
          {
            path: 'registrasiKeluar',
            name: 'KeanggotaanRegistrasiKeluar',
            component: () => import(/* webpackChunkName: "keanggotaanregistrasiKeluar" */ '../views/Keanggotaan/RegistrasiKeluar.vue')
          },
        ]
      },
      {
        path: 'pembiayaan',
        name: 'Pembiayaan',
        component: () => import(/* webpackChunkName: "pembiayaan" */ '../views/Pembiayaan'),
        redirect: '/pembiayaan/dashboard',
        children: [    
          {
            path: 'dashboard',
            name: 'PembiayaanDashboard',
            component: () => import(/* webpackChunkName: "pembiayaandashboard" */ '../views/Pembiayaan/Dashboard.vue')
          },
          {
            path: 'pencairan',
            name: 'PembiayaanPencairan',
            component: () => import(/* webpackChunkName: "pembiayaanpencairan" */ '../views/Pembiayaan/Pencairan.vue')
          },
          {
            path: 'pengajuan',
            name: 'PembiayaanPengajuan',
            component: () => import(/* webpackChunkName: "pembiayaanpengajuan" */ '../views/Pembiayaan/Pengajuan.vue')
          },
        ]
      },
      {
        path: 'tabungan',
        name: 'Tabungan',
        component: () => import(/* webpackChunkName: "tabungan" */ '../views/Tabungan'),
        redirect: '/tabungan/dashboard',
        children: [    
          {
            path: 'dashboard',
            name: 'TabunganDashboard',
            component: () => import(/* webpackChunkName: "tabungandashboard" */ '../views/Tabungan/Dashboard.vue')
          },
          {
            path: 'pencairan',
            name: 'TabunganPencairan',
            component: () => import(/* webpackChunkName: "tabunganpencairan" */ '../views/Tabungan/Pencairan.vue')
          },
          {
            path: 'registrasi',
            name: 'TabunganRegistrasi',
            component: () => import(/* webpackChunkName: "tabunganregistrasi" */ '../views/Tabungan/Registrasi.vue')
          },
        ]
      },
    ]
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import(/* webpackChunkName: "login" */ '../views/Login.vue')
  },
  {
    path: '/forgot',
    name: 'Forgot',
    component: () => import(/* webpackChunkName: "forgot" */ '../views/Forgot.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
