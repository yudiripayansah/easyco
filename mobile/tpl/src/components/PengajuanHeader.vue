<template>
  <div>
    <Camera class="mt-5"/>
    <v-select solo label="Rembug" class="mb-3 mt-3" hide-details/>
    <v-select solo label="Pilih Anggota" class="mb-3" hide-details/>
    <v-select solo label="No Pengajuan" class="mb-3" hide-details :items="opt.noPengajuan" v-model="form.noPengajuan"/>
    <v-container class="pa-0 mb-3">
      <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3">
        <v-container class="d-flex justify-space-between pa-0">
          <div class="d-flex flex-column">
            <h5 class="text-h5 font-weight-bold">John Doe</h5>
            <span class="text-caption grey--text">11228877665453</span>
            <span class="indigo--text lighten-1 font-weight-black">Rembug Mawar</span>
          </div>
        </v-container>
      </v-card>
    </v-container>
  </div>
</template>
<script>
import Camera from './Camera.vue'
export default {
  name: 'PembiayaanPengajuan',
  components: {
    Camera
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
      },
      form: {
        noPengajuan: '0'
      }
    }
  }
}
</script>