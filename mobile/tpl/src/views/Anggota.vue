<template>
  <div class="bt-anggota pa-5">
    <h6 class="text-h5 font-weight-bold orange--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill orange lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-bell</v-icon>
      </div>
      Anggota
    </h6>
    <Rembug class="mt-5" target="transaksi/dashboard" :list="list" @refreshAnggota="getAnggota"/>
    <Toast :show="alert.show" :msg="alert.msg"/>
  </div>
</template>
<script>
import Toast from '@/components/Toast'
import {
  mapGetters,
  mapActions
} from "vuex";
import services from "@/services";
import Rembug from '../components/Rembug.vue'
export default {
  name: 'Anggota',
  components: {
    Rembug,
    Toast
  },
  data() {
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
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    async getAnggota(cm_code) {
      if(!cm_code) {
        cm_code = this.$route.params.cm_code
      } else {
        this.$router.push(`/anggota/${cm_code}`)
      }
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
  },
  mounted() {
    this.getAnggota(false)
    this.list.rembug = this.$route.params.cm_code
  }
}
</script>
