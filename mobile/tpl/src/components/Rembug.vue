<template>
  <div>
    <v-select solo label="Rembug" class="mb-4" hide-details :items="rembug" v-model="list.rembug" @change="$emit('refreshAnggota',list.rembug)"/>
    <v-btn small block class="orange lighten-1 white--text rounded-lg mb-4" type="submit">
      Infaq
    </v-btn>
    <v-container class="pa-0" v-if="list.anggota && list.anggota.length > 0">
      <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3">
        <div class="d-flex justify-space-between">
          <span>Total Setoran</span>
          <h5>Rp 1.000.000</h5>
        </div>
        <div class="d-flex justify-space-between">
          <span>Total Penarikan</span>
          <h5>Rp 1.000.000</h5>
        </div>
        <div class="d-flex justify-space-between">
          <span>Total Infaq</span>
          <h5>Rp 1.000.000</h5>
        </div>
      </v-card>
      <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3" v-for="(agt,agtIndex) in list.anggota" :key="agtIndex">
        <v-container class="d-flex justify-space-between pa-0">
          <div class="d-flex flex-column">
            <h5 class="text-h5 font-weight-bold">{{agt.nama}}</h5>
            <span class="text-caption grey--text">{{agt.cif_no}}</span>
            <span class="orange--text lighten-1 font-weight-black">{{agt.cm_name}}</span>
            <div class="d-flex block flex-row justify-space-between align-items-center">
              <span>Total Setoran: </span>
              <h5 class="text-end">Rp 1.000.000</h5>
            </div>
            <div class="d-flex block flex-row justify-space-between align-items-center">
              <span>Total Penarikan: </span>
              <h5 class="text-end">Rp 1.000.000</h5>
            </div>
          </div>
          <div>
            <!-- <v-btn
              class="orange lighten-1"
              fab
              x-small
              dark
              depressed
            >
              <v-icon>mdi-refresh</v-icon>
            </v-btn> -->
          </div>
        </v-container>
        <v-divider class="my-2"/>
        <v-container class="pa-0 d-flex justify-space-between">
          <v-row>
            <v-col cols="4">
              <router-link :to="`/transaksi/setoran-form/${list.rembug}/${agt.cif_no}`">
                <v-btn small block class="orange lighten-1 white--text rounded-lg" type="submit">
                  Setoran
                </v-btn>
              </router-link>
            </v-col>
            <v-col cols="4">
              <router-link :to="`/transaksi/pembiayaan/${agt.cif_no}`">
                <v-btn small block class="orange lighten-1 white--text rounded-lg px-0" type="submit">
                  Pembiayaan
                </v-btn>
              </router-link>
            </v-col>
            <v-col cols="4">
              <router-link :to="`/transaksi/rekening/${agt.cif_no}`">
                <v-btn small block class="orange lighten-1 white--text rounded-lg" type="submit">
                  Rekening
                </v-btn>
              </router-link>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-container>
    <v-container class="pa-0" v-else>
      <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3">
        <v-container class="d-flex justify-space-between pa-0">
          <div class="d-flex flex-column">
            <h5 class="text-h5 font-weight-bold">
              {{(list.loading) ? 'Memproses data...' : 'Tidak ada anggota'}}
            </h5>
          </div>
        </v-container>
      </v-card>
    </v-container>
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
  props: ['list','target'],
  components: {
    Toast
  },
  data(){
    return {
      alert: {
        show: false,
        msg: ''
      },
      rembug: [],
      loading: false
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    async getRembug() {
      let day = new Date().getDay();
      day = 3
      let payload = new FormData()
      payload.append('fa_code', this.user.fa_code)
      payload.append('day', day)
      this.rembug = []
      this.loading = true
      try {
        let req = await services.infoRembug(payload, this.user.token)
        if(req.status === 200) {
          req.data.data.map((item) => {
            this.rembug.push({
              text: item.cm_name,
              value: item.cm_code
            })
          })
        } else {
          this.alert = {
            show: true,
            msg: data.message
          }
        }
        this.loading = false
      } catch (error) {
        this.alert = {
          show: true,
          msg: error
        }
        this.loading = false
      }
    }
  },
  mounted() {
    this.getRembug()
  }
}
</script>