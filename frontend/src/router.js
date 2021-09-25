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
        // Keanggotaan
        {
          path: "/keanggotaan",
          name: "Keanggotaan",
          component: () => import("@/pages/Keanggotaan"),
          children: [
            {
              path: "registrasi-anggota",
              name: "Registrasi Anggota",
              component: () => import("@/pages/Keanggotaan/RegistrasiAnggota.vue"),
            },
            {
              path: "approval-registrasi",
              name: "Approval Registrasi",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "registrasi-anggota-keluar",
              name: "Registrasi Anggota Keluar",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "approval-registrasi-keluar",
              name: "Approval Anggota Keluar",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "transaksi-anggota",
              name: "Transaksi Anggota",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "laporan",
              name: "Laporan Keanggotaan",
              component: () => import("@/pages/Keanggotaan"),
              children: [
                {
                  path: "registrasi-anggota",
                  name: "Laporan Registrasi Anggota",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "profil-anggota",
                  name: "Laporan Profil Anggota",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "saldo-anggota",
                  name: "Laporan Saldo Anggota",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "anggota-keluar",
                  name: "Laporan Anggota Keluar",
                  component: () => import("@/pages/Dummy.vue"),
                },
              ]
            },
          ]
        },
        // Tabungan
        {
          path: "/tabungan",
          name: "Tabungan",
          component: () => import("@/pages/Pembiayaan"),
          children: [
            {
              path: "pembukaan-rekening-tabungan",
              name: "Pembukaan Rekening Tabungan",
              component: () => import("@/pages/Tabungan/PembukaanRekeningTabungan.vue"),
            },
            {
              path: "transaksi-tabungan",
              name: "Transaksi Tabungan",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "penutupan-rekening-tabungan",
              name: "Penutupan Rekening Tabungan",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "laporan",
              name: "Laporan Tabungan",
              component: () => import("@/pages/Tabungan"),
              children: [
                {
                  path: "pembukaan-rekening-tabungan",
                  name: "Laporan Pembukaan Rekening Tabungan",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "transaksi-tabungan",
                  name: "Laporan Transaksi Tabungan",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "saldo-tabungan",
                  name: "Laporan Saldo Tabungan",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "statement-tabungan",
                  name: "Laporan Statement Tabungan",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "penutupan-rekening-tabungan",
                  name: "Laporan Pencairan Tabungan / Penutupan Rekening Tabungan",
                  component: () => import("@/pages/Dummy.vue"),
                },
              ]
            },
          ]
        },
        // Pembiayaan
        {
          path: "/pembiayaan",
          name: "Pembiayaan",
          component: () => import("@/pages/Pembiayaan"),
          children: [
            {
              path: "pengajuan-pembiayaan",
              name: "Pengajuan Pembiayaan",
              component: () => import("@/pages/Pembiayaan/PengajuanPembiayaan.vue"),
            },
            {
              path: "registrasi-akad",
              name: "Registrasi Akad",
              component: () => import("@/pages/Pembiayaan/RegistrasiAkad.vue"),
            },
            {
              path: "pencairan",
              name: "Pencairan",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "transaksi-pembiayaan",
              name: "Transaksi Pembiayaan",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "angsuran-pembiayaan",
              name: "Angsuran Pembiayaan",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "pelunasan-pembiayaan",
              name: "Pelunasan Pembiayaan",
              component: () => import("@/pages/Dummy.vue"),
            },
            {
              path: "laporan",
              name: "Laporan Pembiayaan",
              component: () => import("@/pages/Pembiayaan"),
              children: [
                {
                  path: "pengajuan-pembiayaan",
                  name: "Laporan Pengajuan Pembiayaan",
                  component: () => import("@/pages/Pembiayaan/Laporan/PengajuanPembiayaan.vue"),
                },
                {
                  path: "pencairan",
                  name: "Laporan Pencairan",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "outstanding",
                  name: "Laporan Outstanding",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "penerimaan-angsuran",
                  name: "Laporan Penerimaan Angsuran",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "kartu-angsuran",
                  name: "Laporan Kartu Angsuran",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "pelunasan",
                  name: "Laporan Pelunasan",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "kolektibilitas",
                  name: "Laporan Kolektibilitas",
                  component: () => import("@/pages/Dummy.vue"),
                },
              ]
            },
          ]
        },
        // Keuangan
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
              name: "Laporan Keuangan",
              component: () => import("@/pages/Keuangan"),
              children: [
                {
                  path: "jurnal",
                  name: "Laporan Jurnal",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "arus-kas",
                  name: "Laporan Arus Kas",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "buku-besar",
                  name: "Laporan Buku Besar",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "neraca-saldo",
                  name: "Laporan Neraca Saldo",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "neraca",
                  name: "Laporan Neraca",
                  component: () => import("@/pages/Dummy.vue"),
                },
                {
                  path: "laba-rugi",
                  name: "Laporan Laba Rugi",
                  component: () => import("@/pages/Dummy.vue"),
                },
              ]
            },
          ]
        },
        // Pengaturan
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
