
<template>
  <div class="bt-transaksi-setoran pa-5">
    <h6 class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-hand-coin</v-icon>
      </div>
      Pembiayaan
    </h6>
    <!-- <v-container class="pa-0 mt-5">
      <v-tabs fixed-tabs 
    background-color="indigo lighten-1" dark>
        <v-tab class="text-caption">Pengajuan</v-tab>
        <v-tab class="text-caption">RAB</v-tab>
        <v-tab class="text-caption">Wakalah</v-tab>
        <v-tab class="text-caption">Akad</v-tab>
      </v-tabs>
    </v-container> -->
    <div class="d-flex flex-wrap justify-space-between mt-5">
      <router-link to="/transaksi/pembiayaan-pengajuan" class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
        <v-icon color="indigo darken-3">
          mdi-note-plus-outline
        </v-icon>
        <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Pengajuan</span>
      </router-link>
      <router-link to="/transaksi/pembiayaan-rab" class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
        <v-icon color="indigo darken-3">
          mdi-format-list-checks
        </v-icon>
        <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">RAB</span>
      </router-link>
      <router-link to="/transaksi/pembiayaan-wakalah" class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
        <v-icon color="indigo darken-3">
          mdi-playlist-check
        </v-icon>
        <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Wakalah</span>
      </router-link>
      <router-link to="/transaksi/pembiayaan-akad" class="d-flex flex-column elevation-3 pa-3 indigo lighten-1 rounded-lg justify-center align-center mb-3 mx-1 bt-btn-transaksi">
        <v-icon color="indigo darken-3">
          mdi-account-check
        </v-icon>
        <span class="text-caption text-center indigo--text text--lighten-5 font-weight-bold mt-1">Akad</span>
      </router-link>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Pembiayaan'
}
</script>