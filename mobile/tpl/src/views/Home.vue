<template>
  <div class="bt-home pb-5">
    <div class="pa-5">
      <v-card class="pa-3 pb-10 rounded-xl d-flex flex-column align-center">
        <v-container class="d-flex justify-end">
          <v-icon color="indigo lighten-1" @click="doLogout()">
            mdi-logout
          </v-icon>
        </v-container>
        <div class="bth-profile-pic">
          <img src="data:image/png;base64,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">
        </div>
        <h3 class="indigo--text text--lighten-1 text-h5 font-weight-black">{{ user.nama_user }}</h3>
        <span class="black--text text-caption d-block">{{ user.kode_pgw }}</span>
        <v-row class="mt-3">
          <v-col cols="6" class="d-flex justify-end align-center">
            <div class="blue lighten-3 d-flex justify-center flex-column align-center pa-3 rounded-lg elevation-3">
            <span class="text-caption font-weight-bold blue--text text--darken-1">Saldo Awal</span>
            <span class="text-body-2 font-weight-bold white--text text--darken-1">Rp {{kasPetugas.saldoAwal}}</span>
            </div>
          </v-col>
          <v-col cols="6" class="d-flex justify-start align-center">
            <div class="green lighten-3 d-flex justify-center flex-column align-center pa-3 rounded-lg elevation-3">
            <span class="text-caption font-weight-bold green--text text--darken-1">Saldo Akhir</span>
            <span class="text-body-2 font-weight-bold white--text text--darken-1">Rp {{kasPetugas.saldoAkhir}}</span>
            </div>
          </v-col>
          <v-col cols="6" class="d-flex justify-end align-center">
            <div class="light-green lighten-3 d-flex justify-center flex-column align-center pa-3 rounded-lg elevation-3">
            <span class="text-caption font-weight-bold light-green--text text--darken-1">Kas Masuk</span>
            <span class="text-body-2 font-weight-bold white--text text--darken-1">Rp {{kasPetugas.kasMasuk}}</span>
            </div>
          </v-col>
          <v-col cols="6" class="d-flex justify-start align-center">
            <div class="indigo lighten-3 d-flex justify-center flex-column align-center pa-3 rounded-lg elevation-3">
            <span class="text-caption font-weight-bold indigo--text text--darken-1">Kas Keluar</span>
            <span class="text-body-2 font-weight-bold white--text text--darken-1">Rp {{kasPetugas.kasKeluar}}</span>
            </div>
          </v-col>
        </v-row>
      </v-card>
    </div>
    <!-- <h6 class="text-h5 font-weight-bold mt-3 indigo--text text--lighten-1 px-5 d-flex align-center">
      <div class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-bell</v-icon>
      </div>
      Pengumuman
    </h6>
    <div class="d-flex overflow-x-auto py-3 bth-pengumuman-box">
      <v-card v-for="x in 10" :key="x" class="ms-5 pa-5 rounded-xl bth-pengumuman" :class="(x==10) ? 'me-5': null">
        <h6 class="text-h6 mb-1 font-weight-bold">Lorem ipsum dolor sit amet</h6>
        <p class="text-body-2 mb-4">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Omnis repellendus labore rerum alias accusamus culpa reprehenderit? Voluptate hic et error sequi assumenda, enim nulla aliquid est magni ratione, ipsam quae?</p>
        <span class="text-caption grey--text">10 Desember 2022</span>
      </v-card>
    </div> -->
    <h6 class="text-h5 font-weight-bold mt-3 white--text text--lighten-1 px-5 d-flex align-center">
      <div class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-account-group</v-icon>
      </div>
      Rembug
    </h6>
    <div class="py-3 px-5 bth-rembug-box">
      <v-btn block class="blue lighten-3 white--text rounded-lg mb-5" type="submit">
        Ambil Data
      </v-btn>
      <v-card v-for="(rbg,rbgIndex) in rembug" :key="rbgIndex" class="pa-5 mb-3">
        <h6 class="text-h6 mb-1 font-weight-bold text-center">Rembug {{rbg.nama_rembug}}</h6>
        <h1 class="text-h4 font-weight-black indigo--text text--lighten-1 d-flex justify-space-between align-center">
          <span class="text-body-2 font-weight-black grey--text">Jumlah Anggota</span>
          {{rbg.jumlah}}
        </h1>
        <p class="text-caption mb-4">
          {{rbg.nama_desa}}
        </p>
        <v-row>
          <v-col cols="12">
            <v-btn block class="green lighten-3 white--text rounded-lg" type="button">
              Kirim Data
            </v-btn>
          </v-col>
          <v-col cols="12">
            <router-link :to="`/anggota/${rbg.kode_rembug}`">
              <v-btn block class="indigo lighten-1 white--text rounded-lg" type="button">
                Lihat Rembug
              </v-btn>
            </router-link>
          </v-col>
        </v-row>
      </v-card>
    </div>
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
export default {
  name: 'Home',
  components: {
    Toast
  },
  data() {
    return {
      rembug: [],
      alert: {
        show: false,
        msg: ''
      }
    }
  },
  computed: {
    ...mapGetters(['user','kasPetugas'])
  },
  methods: {
    ...mapActions(['logout','setKasPetugas']),
    doLogout() {
      this.logout();
      this.$router.push('/login').catch(()=>{});
    },
    async getRembug() {
      let hari_transaksi = new Date().getDay();
      hari_transaksi = 1
      let payload = new FormData()
      payload.append('kode_petugas', this.user.kode_petugas)
      payload.append('hari_transaksi', hari_transaksi)
      try {
        let req = await services.infoRembug(payload, this.user.token)
        if(req.status === 200) {
          this.rembug = req.data.data
        } else {
          this.alert = {
            show: true,
            msg: data.message
          }
        }
      } catch (error) {
        this.alert = {
          show: true,
          msg: error
        }
      }
    },
    setupKasPetugas(){
      if(!this.kasPetugas || this.kasPetugas.length < 1){
        let kasPetugas = {
          saldoAwal: Number(this.user.saldo_awal),
          saldoAkhir: Number(this.user.saldo_awal),
          kasMasuk: 0,
          kasKeluar: 0
        }
        this.setKasPetugas(kasPetugas)
      }
    }
  },
  mounted() {
    this.getRembug()
    this.setupKasPetugas()
  }
}
</script>
