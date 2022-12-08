<template>
  <div class="bt-anggota pa-5">
    <h6 class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-bell</v-icon>
      </div>
      Anggota
    </h6>
    <Rembug class="mt-5" target="transaksi/dashboard" :list="list" @refreshAnggota="getAnggota" :total="total"/>
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
      },
      total: {
        setoran: 0,
        penarikan: 0
      }
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    async getAnggota(kode_rembug) {
      if(!kode_rembug) {
        kode_rembug = this.$route.params.kode_rembug
      } else {
        this.$router.push(`/anggota/${kode_rembug}`)
      }
      let payload = new FormData()
      payload.append('kode_rembug', kode_rembug)
      this.list.anggota = []
      this.list.loading = true
      try {
        let req = await services.infoMember(payload, this.user.token)
        if(req.status === 200) {
          this.list.anggota = req.data.data
          let setoran = 0
          let penarikan = 0
          this.list.anggota.map((item) => {
            setoran = setoran + Number(item.total_penerimaan)
            penarikan = penarikan + Number(item.total_penarikan)
          })
          this.total = {
            penarikan: penarikan,
            setoran: setoran
          }
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
    this.list.rembug = this.$route.params.kode_rembug
  }
}
</script>
