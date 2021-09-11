import Vue from "vue";
import Router from "vue-router";
import AuthRequired from "./core/auth/AuthRequired";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      redirect: "/dashboard",
      beforeEnter : AuthRequired,
      component: () => import("@/layout/Layout"),
      children: [
        {
          path: "/dashboard",
          name: "Dashboard",
          component: () => import("@/pages/Dashboard.vue"),
        },
        {
          path: "/keuangan",
          name: "Keuangan",
          component: () => import("@/pages/Keuangan"),
          children: [
            {
              path: "pengaturan-ledger",
              name: "Pengaturan Ledger",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "pengaturan-laporan-keuangan",
              name: "Pengaturan Laporan Keuangan",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "jurnal-transaksi",
              name: "Jurnal Transaksi",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "laporan",
              name: "Laporan",
              component: () => import("@/pages/Keuangan"),
              children: [
                {
                  path: "jurnal",
                  name: "Jurnal",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "arus-kas",
                  name: "Arus Kas",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "buku-besar",
                  name: "Buku Besar",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "neraca-saldo",
                  name: "Neraca Saldo",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "neraca",
                  name: "Neraca",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "laba-rugi",
                  name: "Laba Rugi",
                  component: () => import("@/pages/Dummy.vue"),
                },
              ]
            },
          ]
        },
        {
          path: "/pengaturan",
          name: "Pengaturan",
          component: () => import("@/pages/Pengaturan"),
          children: [
            {
              path: "pengguna",
              name: "Pengguna",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "grup-pengguna",
              name: "Grup Pengguna",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "menu",
              name: "Menu",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "lembaga",
              name: "Lembaga",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "cabang",
              name: "Cabang",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "wilayah",
              name: "Wilayah",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "karyawan-petugas",
              name: "Karyawan / Petugas",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "parameter",
              name: "Parameter",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "tutup-periode",
              name: "Tutup Periode",
              component: () => import("@/pages/Dummy.vue"),
            },
          ]
        },
      ]
    },
    {
      path: "/",
      component: () => import("@/pages/Login"),
      children: [
        {
          name: "login",
          path: "/login",
          component: () => import("@/pages/Login")
        },
        {
          name: "register",
          path: "/register",
          component: () => import("@/pages/Login")
        }
      ]
    },
    {
      path: "*",
      redirect: "/404"
    },
    {
      path: "/404",
      name: "404",
      component: () => import("@/pages/error/Error-6.vue")
    }
  ]
});
