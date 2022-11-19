
<template>
  <div class="bt-transaksi-setoran pa-5">
    <h6 class="text-h5 font-weight-bold orange--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill orange lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-account-check</v-icon>
      </div>
      Akad Pembiayaan
    </h6>
    <PengajuanHeader/>
    <v-container class="pa-0">
      <v-row>
        <v-col cols="6" class="pb-0">
          <router-link to="/transaksi/pembiayaan-wakalah">
          <v-btn block class="orange lighten-1 white--text d-flex justify-content-start">
            Wakalah
          </v-btn>
          </router-link>
        </v-col>
        <v-col cols="6" class="pb-0">
          <router-link to="/transaksi/pembiayaan">
          <v-btn block class="orange lighten-1 white--text">
            Simpan
          </v-btn>
          </router-link> 
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import Camera from '../../components/Camera.vue'
import PengajuanHeader from '../../components/PengajuanHeader.vue'
export default {
  name: 'PembiayaanAkad',
  components: {
    Camera,
    PengajuanHeader
  },
  data() {
    return {
      opt: {
        noPengajuan: [
          { text: 'Baru', value: '0' },
          { text: 'No. Pengajuan 1', value: '1' },
          { text: 'No. Pengajuan 2', value: '2' },
          { text: 'No. Pengajuan 3', value: '3' },
          { text: 'No. Pengajuan 4', value: '4' },
          { text: 'No. Pengajuan 5', value: '5' },
          { text: 'No. Pengajuan 6', value: '6' },
          { text: 'No. Pengajuan 7', value: '7' },
          { text: 'No. Pengajuan 8', value: '8' },
          { text: 'No. Pengajuan 9', value: '9' },
          { text: 'No. Pengajuan 10', value: '10' },
        ]
      }
    }
  }
}
</script>