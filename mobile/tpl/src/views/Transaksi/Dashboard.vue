<template>
  <div class="bt-transaksi pa-5">
    <h6 class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-gesture-double-tap</v-icon>
      </div>
      Transaksi
    </h6>
    <div class="d-flex flex-wrap justify-space-between mt-5">
      <router-link to="/transaksi/setoran-form" class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
        <v-icon color="indigo darken-3">
          mdi-cash-multiple
        </v-icon>
        <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Setoran</span>
      </router-link>
      <router-link to="/transaksi/pembiayaan" class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
        <v-icon color="indigo darken-3">
          mdi-hand-coin
        </v-icon>
        <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Pembiayaan</span>
      </router-link>
      <router-link to="/transaksi/rekening" class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
        <v-icon color="indigo darken-3">
          mdi-book-check
        </v-icon>
        <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Rekening</span>
      </router-link>
      <router-link to="/transaksi/registrasi-anggota" class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
        <v-icon color="indigo darken-3">
          mdi-account-multiple-plus
        </v-icon>
        <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Registrasi Anggota</span>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Transaksi'
}
</script>
