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
            path: 'dashboard/:cif_no?',
            name: 'Dashboard',
            component: () => import(/* webpackChunkName: "dashboard" */ '../views/Transaksi/Dashboard.vue')
          },
          {
            path: 'pembiayaan/:cif_no?',
            name: 'Pembiayaan',
            component: () => import(/* webpackChunkName: "pembiayaan" */ '../views/Transaksi/Pembiayaan.vue')
          },
          {
            path: 'pembiayaan-pengajuan/:cif_no?',
            name: 'PembiayaanPengajuan',
            component: () => import(/* webpackChunkName: "pembiayaan-pengajuan" */ '../views/Transaksi/PembiayaanPengajuan.vue')
          },
          {
            path: 'pembiayaan-rab/:cif_no?',
            name: 'PembiayaanRab',
            component: () => import(/* webpackChunkName: "pembiayaan-rab" */ '../views/Transaksi/PembiayaanRab.vue')
          },
          {
            path: 'pembiayaan-wakalah/:cif_no?',
            name: 'PembiayaanWakalah',
            component: () => import(/* webpackChunkName: "pembiayaan-wakalah" */ '../views/Transaksi/PembiayaanWakalah.vue')
          },
          {
            path: 'pembiayaan-akad/:cif_no?',
            name: 'PembiayaanAkad',
            component: () => import(/* webpackChunkName: "pembiayaan-akad" */ '../views/Transaksi/PembiayaanAkad.vue')
          },
          {
            path: 'registrasi-anggota/:cif_no?',
            name: 'RegistrasiAnggota',
            component: () => import(/* webpackChunkName: "registrasi-anggota" */ '../views/Transaksi/RegistrasiAnggota.vue')
          },
          {
            path: 'rekening',
            name: 'Rekening',
            component: () => import(/* webpackChunkName: "rekening" */ '../views/Transaksi/Rekening.vue')
          },
          {
            path: 'setoran',
            name: 'Setoran',
            component: () => import(/* webpackChunkName: "setoran" */ '../views/Transaksi/Setoran.vue')
          },
          {
            path: 'setoran-form/:cm_code?/:cif_no?',
            name: 'SetoranForm',
            component: () => import(/* webpackChunkName: "setoran-form" */ '../views/Transaksi/SetoranForm.vue')
          },
        ]
      },
      {
        path: 'anggota/:cm_code?',
        name: 'Anggota',
        component: () => import(/* webpackChunkName: "anggota" */ '../views/Anggota.vue')
      },
      {
        path: 'pengumuman',
        name: 'Pengumuman',
        component: () => import(/* webpackChunkName: "pengumuman" */ '../views/Pengumuman.vue')
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
