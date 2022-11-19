
<template>
  <div class="bt-transaksi-setoran pa-5">
    <h6 class="text-h5 font-weight-bold orange--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill orange lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-bell</v-icon>
      </div>
      Setoran Form
    </h6>
    <Camera class="mt-5"/>
    <v-select solo label="Rembug" class="mb-4 mt-5" hide-details :items="opt.rembug" v-model="rembug" @change="getAnggota(rembug)"/>
    <v-select solo label="Anggota" class="mb-4" hide-details :items="opt.anggota" v-model="anggota" @change="getDataSetoran(anggota)"/>
    <v-container class="pa-0" v-show="anggota">
      <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3">
        <v-container class="d-flex justify-space-between pa-0">
          <div class="d-flex flex-column">
            <h5 class="text-h5 font-weight-bold">{{aAnggota.nama}}</h5>
            <span class="text-caption grey--text">{{aAnggota.cif_no}}</span>
            <span class="orange--text lighten-1 font-weight-black">{{aAnggota.cm_name}}</span>
            <hr class="my-3">
            <v-row>
              <v-col cols="12" class="text-center pt-1 pb-0 mb-0 d-flex justify-space-between">
                <span>Tasya</span>
                <span>10/50</span>
                <h4>Rp 1.000.000</h4>
              </v-col>
              <v-col cols="12" class="text-center pt-1 pb-0 mb-0 d-flex justify-space-between">
                <span>Takur</span> 
                <span>10/50</span>
                <h4>Rp 1.000.000</h4>
              </v-col>
              <v-col cols="12" class="text-center pt-1 pb-0 mb-0 d-flex justify-space-between">
                <span>Trendis</span> 
                <span>10/50</span>
                <h4>Rp 1.000.000</h4>
              </v-col>
              <v-col cols="12">
                <hr>
              </v-col>
              <v-col cols="12" class="text-center pt-1 pb-0 mb-0 d-flex justify-space-between">
                <span>Mba</span>
                <span>10/50</span>
                <h4>Rp 1.000.000</h4>
              </v-col>
              <v-col cols="12" class="text-center pt-1 pb-0 mb-0 d-flex justify-space-between">
                <span>Qh</span>
                <span>10/50</span>
                <h4>Rp 1.000.000</h4>
              </v-col>
              <v-col cols="12" class="text-center pt-1 pb-0 mb-0 d-flex justify-space-between">
                <span>Hwl</span>
                <span>10/50</span>
                <h4>Rp 1.000.000</h4>
              </v-col>
              <v-col cols="12">
                <hr>
              </v-col>
              <v-col cols="12" class="text-center pt-1 d-flex justify-space-between">
                <span>Saldo Sukarela</span>
                <h4>Rp 1.000.000</h4>
              </v-col>
            </v-row>
          </div>
        </v-container>
      </v-card>
      <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
        <h6 class="text-h6 font-weight-bold mb-4">Setoran</h6>
        <v-row>
          <v-col cols="8" class="pb-0">
            <label class="black--text">Angsuran</label>
          </v-col>
          <v-col cols="4" class="pb-0 d-flex justify-end">
            Tidak <v-switch hide-details class="pa-0 ma-0" v-model="form.angsuranState"/> Bayar
          </v-col>
          <v-col cols="8">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              :value="thousand(form.angsuran)"
              disabled
            />
          </v-col>
          <v-col cols="4">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="form.frekuensi"
              :disabled="!form.angsuranState"
              append-outer-icon="mdi-plus"
              prepend-icon="mdi-minus"
              @click:append-outer="form.frekuensi += 1"
              @click:prepend="(form.frekuensi > 1) ? form.frekuensi -= 1 : 1"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="8" class="pb-0">
            <label class="black--text">Simpanan Wajib</label>
          </v-col>
          <v-col cols="4" class="pb-0 d-flex justify-end">
            Tidak <v-switch hide-details class="pa-0 ma-0" v-model="form.simwaState"/> Bayar
          </v-col>
          <v-col cols="12">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              :value="thousand(form.simwa)"
              disabled
            />
          </v-col>
          <!-- <v-col cols="4">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="form.simwaFreq"
              :disabled="!form.simwaState"
              append-outer-icon="mdi-plus"
              prepend-icon="mdi-minus"
              @click:append-outer="form.simwaFreq += 1"
              @click:prepend="(form.simwaFreq > 1) ? form.simwaFreq -= 1 : 1"
            />
          </v-col> -->
        </v-row>
        <v-row v-for="(taber,taberIndex) in form.berencana" :key="taberIndex">
          <v-col cols="8" class="pb-0">
            <label class="black--text">Tabungan Berencana ({{ taber.product_name }})</label>
          </v-col>
          <v-col cols="4" class="pb-0 d-flex justify-end">
            Tidak <v-switch hide-details class="pa-0 ma-0" v-model="taber.taberState"/> Bayar
          </v-col>
          <v-col cols="8">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              :value="thousand(taber.rencana_setoran)"
              disabled
            />
          </v-col>
          <v-col cols="4">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="taber.freq_saving"
              :disabled="!taber.taberState"
              append-outer-icon="mdi-plus"
              prepend-icon="mdi-minus"
              @click:append-outer="taber.freq_saving += 1"
              @click:prepend="(taber.freq_saving > 1) ? taber.freq_saving -= 1 : 1"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" class="pb-0">
            <label class="black--text">Sukarela</label>
          </v-col>
          <v-col cols="12">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="form.sukarelaInVal"
              v-mask="thousandMask"
            />
          </v-col>
        </v-row>
      </v-card>
      <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
        <h6 class="text-h6 font-weight-bold mb-4">Penarikan</h6>
        <v-row>
          <v-col cols="12" class="pb-0">
            <label class="black--text">Penarikan Sukarela</label>
          </v-col>
          <v-col cols="12">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="form.sukarelaOutVal"
              v-mask="thousandMask"
            />
          </v-col>
        </v-row>
      </v-card>
      <v-btn block class="orange lighten-1 white--text mb-5">
        Proses
      </v-btn>
    </v-container>
    <Toast :show="alert.show" :msg="alert.msg"/>
  </div>
</template>
<script>
import Camera from '@/components/Camera.vue'
import helper from '@/utils/helper'
import Toast from '@/components/Toast'
import {
  mapGetters,
  mapActions
} from "vuex";
import services from "@/services";
export default {
  name: 'SetoranForm',
  components: {
    Toast,
    Camera
  },
  data() {
    return {
      form: Object,
      alert: {
        show: false,
        msg: ''
      },
      deposit: null,
      opt: {
        rembug: [],
        anggota: []
      },
      rembug: null,
      anggota: null,
      aAnggota: {
        nama: null,
        cif_no: null,
        cm_name: null
      }
    }
  },
  computed: {
    ...mapGetters(['user'])
  },
  methods: {
    ...helper,
    async getDataSetoran(cif_no) {
      let cm_code = this.$route.params.cm_code
      if(!cif_no) {
        cif_no = this.$route.params.cif_no
      } else {
        this.$router.push(`/transaksi/setoran-form/${cm_code}/${cif_no}`)
      }
      if(cif_no) {
        let payload = new FormData()
        payload.append('cif_no', cif_no)
        try {
          let req = await services.transSetoranDeposit(payload, this.user.token)
          if(req.status === 200) {
            let dataDeposit = {...req.data.data}
            dataDeposit.simwaState = true
            dataDeposit.angsuranState = true
            dataDeposit.berencana.forEach((taber, index) => {
              taber.taberState = true
            })
            this.form = dataDeposit
          } else {
            this.alert = {
              show: true,
              msg: data.message
            }
          }
          this.opt.anggota.map((anggota, index) => {
            if(anggota.value === this.$route.params.cif_no) {
              this.aAnggota = anggota.data
            }
          })
        } catch (error) {
          this.alert = {
            show: true,
            msg: `Error on get setoran ${error}`
          }
        }
      }
    },
    async getRembug() {
      let day = new Date().getDay();
      day = 3
      let payload = new FormData()
      payload.append('fa_code', this.user.fa_code)
      payload.append('day', day)
      try {
        let req = await services.infoRembug(payload, this.user.token)
        if(req.status === 200) {
          let { data } = req.data
          this.opt.rembug = []
          data.map((rembug, index) => {
            this.opt.rembug.push({
              text: rembug.cm_name,
              value: rembug.cm_code
            })
          })
        } else {
          this.alert = {
            show: true,
            msg: data.message
          }
        }
      } catch (error) {
        this.alert = {
          show: true,
          msg: `Error on get rembug ${error}`
        }
      }
    },
    async getAnggota(cm_code) {
      if(!cm_code) {
        cm_code = this.$route.params.cm_code
      } else {
        this.$router.push(`/transaksi/setoran-form/${cm_code}`)
        this.aAnggota = {
          nama: null,
          cif_no: null,
          cm_name: null
        }
        this.anggota = null
      }
      if(cm_code) {
        let payload = new FormData()
        payload.append('cm_code', cm_code)
        try {
          let req = await services.infoMember(payload, this.user.token)
          if(req.status === 200) {
            this.opt.anggota = []
            let { data } = req.data
            data.map((anggota, index) => {
              this.opt.anggota.push({
                text: anggota.nama,
                value: anggota.cif_no,
                data: anggota
              })
              if(anggota.cif_no === this.$route.params.cif_no) {
                this.aAnggota = anggota
              }
            })
          } else {
            this.alert = {
              show: true,
              msg: data.message
            }
          }
        } catch (error) {
          this.alert = {
            show: true,
            msg: `Error on get anggota ${error}`
          }
        }
      }
    },
    setForm(){
      let cm_code = this.$route.params.cm_code
      let cif_no = this.$route.params.cif_no
      this.rembug = cm_code
      this.anggota = (cif_no) ? cif_no : null
    }
  },
  mounted() {
    this.getDataSetoran()
    this.getRembug()
    this.getAnggota()
    this.setForm()
  }
}
</script>