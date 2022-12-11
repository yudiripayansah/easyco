
<template>
  <div class="bt-transaksi-setoran pa-5">
    <h6 class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-bell</v-icon>
      </div>
      Setoran
    </h6>
    <Camera class="mt-5"/>
    <Rembug class="mt-3" target="setoran-form" :list="list" @refreshAnggota="getAnggota"/>
  </div>
</template>
<script>
import Camera from '../../components/Camera.vue'
import Rembug from '../../components/Rembug.vue'
export default {
  name: 'Setoran',
  components: {
    Rembug,
    Camera
  },
  data(){
    return {
      list: {
        anggota: [],
        rembug: null,
        loading: false
      },
      alert: {
        show: false,
        msg: ''
      }
    }
  },
  methods: {
    async getAnggota(cm_code) {
      let payload = new FormData()
      payload.append('cm_code', cm_code)
      this.list.anggota = []
      this.list.loading = true
      try {
        let req = await services.infoMember(payload, this.user.token)
        if(req.status === 200) {
          this.list.anggota = req.data.data
        } else {
          this.alert = {
            show: true,
            msg: data.message
          }
        }
        this.list.loading = false
      } catch (error) {
        this.alert = {
          show: true,
          msg: error
        }
        this.list.loading = false
      }
    }
  }
}
</script>