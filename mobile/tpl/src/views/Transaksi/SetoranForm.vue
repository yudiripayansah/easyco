
<template>
  <div class="bt-transaksi-setoran pa-5">
    <h6 class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-bell</v-icon>
      </div>
      Setoran Form
    </h6>
    <Camera class="mt-5"/>
    <v-select solo label="Rembug" class="mb-4 mt-5" hide-details :items="opt.rembug" v-model="rembug" @change="getAnggota(rembug)"/>
    <v-select solo label="Anggota" class="mb-4" hide-details :items="opt.anggota" v-model="anggota" @change="getDataSetoran(anggota)"/>
    <v-container class="pa-0" v-show="anggota">
      <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3">
        <h6 class="text-h6 font-weight-bold mb-4">Saldo</h6>
        <v-container class="d-flex justify-space-between pa-0">
          <div class="d-flex flex-column">
            <h5 class="text-h5 font-weight-bold">{{aAnggota.nama}}</h5>
            <span class="text-caption grey--text">{{aAnggota.cif_no}}</span>
            <span class="indigo--text lighten-1 font-weight-black">{{aAnggota.cm_name}}</span>
            <hr class="my-3">
            <v-row>
              <v-col cols="12" class="text-left pt-1 pb-0 mb-0 d-flex justify-space-between" v-for="(tbr, tbrIndex) in form.data.taber" :key="`trx-${tbrIndex}`">
                <v-row no-gutters>
                  <v-col cols="4">{{tbr.nama_produk}}</v-col>
                  <v-col cols="4">{{(tbr.counter_angsuran) ? tbr.counter_angsuran : 0}}/{{tbr.jangka_waktu}}</v-col>
                  <v-col cols="4" class="text-right"><b>Rp {{thousand(tbr.setoran)}}</b></v-col>
                </v-row>
              </v-col>
              <v-col cols="12">
                <hr>
              </v-col>
              <v-col cols="12" class="text-left pt-1 pb-0 mb-0 d-flex justify-space-between" v-for="(pmb, pmbIndex) in form.data.pembiayaan" :key="`pmb-${pmbIndex}`">
                <v-row no-gutters>
                  <v-col cols="4">{{pmb.nama_produk}}</v-col>
                  <v-col cols="4">{{pmb.counter_angsuran}}/{{pmb.jangka_waktu}}</v-col>
                  <v-col cols="4" class="text-right"><b>Rp {{thousand(pmb.pokok)}}</b></v-col>
                </v-row>
              </v-col>
              <v-col cols="12">
                <hr>
              </v-col>
              <v-col cols="12" class="text-left pt-1 d-flex justify-space-between">
                <v-row no-gutters>
                  <v-col cols="6">Saldo Sukarela</v-col>
                  <v-col cols="6" class="text-right"><b>Rp {{thousand(form.data.simsuk)}}</b></v-col>
                </v-row>
              </v-col>
            </v-row>
          </div>
        </v-container>
      </v-card>
      <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
        <h6 class="text-h6 font-weight-bold mb-4">Setoran</h6>
        <v-row>
          <v-col cols="3">
            <label class="black--text">Angsuran</label>
          </v-col>
          <!-- <v-col cols="4" class="pb-0 d-flex justify-end">
            Tidak <v-switch hide-details class="pa-0 ma-0" v-model="form.data.angsuranState"/> Bayar
          </v-col> -->
          <v-col cols="4">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="form.data.frekuensi"
              :disabled="!form.data.angsuranState"
              append-outer-icon="mdi-plus"
              prepend-icon="mdi-minus"
              @click:append-outer="form.data.frekuensi += 1;countTotalSetoran()"
              @click:prepend="(form.data.frekuensi > 0) ? form.data.frekuensi -= 1 : 1;countTotalSetoran()"
            />
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              :value="thousand(form.data.angsuran.amount * form.data.frekuensi)"
              disabled
              class="justify-end text-right"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="7" class="pb-0">
            <label class="black--text">Simpanan Wajib</label>
          </v-col>
          <!-- <v-col cols="4" class="pb-0 d-flex justify-end">
            Tidak <v-switch hide-details class="pa-0 ma-0" v-model="form.data.simwaState"/> Bayar
          </v-col> -->
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="form.data.setoran_simpanan_wajib"
              @change="countTotalSetoran()"
              class="justify-end text-right"
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
        <v-row>
          <v-col cols="12">
            <label class="black--text">Tabungan Berencana</label>
          </v-col>
        </v-row>
        <v-row v-for="(taber,taberIndex) in form.data.taber" :key="taberIndex">
          <v-col cols="3" class="pb-0">
            <label class="black--text">{{ taber.nama_produk }}</label>
          </v-col>
          <!-- <v-col cols="4" class="pb-0 d-flex justify-end">
            Tidak <v-switch hide-details class="pa-0 ma-0" v-model="taber.state"/> Bayar
          </v-col> -->
          <v-col cols="4">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="taber.freq_saving"
              :disabled="!taber.state"
              append-outer-icon="mdi-plus"
              prepend-icon="mdi-minus"
              @click:append-outer="taber.freq_saving += 1;countTotalSetoran()"
              @click:prepend="(taber.freq_saving > 0) ? taber.freq_saving -= 1 : 1;countTotalSetoran()"
            />
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              :value="thousand(taber.setoran * taber.freq_saving)"
              disabled
              class="justify-end text-right"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="7" class="pb-0">
            <label class="black--text">Sukarela</label>
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="form.data.setoran_sukarela"
              @change="countTotalSetoran()"
              class="justify-end text-right"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="7" class="pb-0">
            <label class="black--text"><b>Total</b></label>
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              disabled
              :value="thousand(Number(form.data.total_setoran) + Number(removeThousand(form.data.setoran_simpanan_wajib)) + Number(removeThousand(form.data.setoran_sukarela)))"
              class="justify-end text-right"
            />
          </v-col>
        </v-row>
      </v-card>
      <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
        <h6 class="text-h6 font-weight-bold mb-4">Penarikan</h6>
        <v-row>
          <v-col cols="7" class="pb-0">
            <label class="black--text">Sukarela</label>
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              v-model="form.data.penarikan_sukarela"
              v-mask="thousandMask"
              class="justify-end text-right"
            />
          </v-col>
        </v-row>
      </v-card>
      <v-card class="white elevation-3 rounded-lg pa-3 mb-3" v-if="(form.data.pokok != 0)">
        <h6 class="text-h6 font-weight-bold mb-4">Pencairan</h6>
        <v-row>
          <v-col cols="7" class="pb-0">
            <label class="black--text">Pokok</label>
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              disabled
              v-model="form.data.pokok"
              v-mask="thousandMask"
              class="justify-end text-right"
            />
          </v-col>
          <v-col cols="7" class="pb-0">
            <label class="black--text">Biaya Administrasi</label>
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              disabled
              v-model="form.data.biaya_administrasi"
              v-mask="thousandMask"
              class="justify-end text-right"
            />
          </v-col>
          <v-col cols="7" class="pb-0">
            <label class="black--text">Biaya Asuransi</label>
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              disabled
              v-model="form.data.biaya_asuransi_jiwa"
              v-mask="thousandMask"
              class="justify-end text-right"
            />
          </v-col>
          <v-col cols="7" class="pb-0">
            <label class="black--text">Tabungan 4%</label>
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              disabled
              v-model="form.data.tabungan_persen"
              v-mask="thousandMask"
              class="justify-end text-right"
            />
          </v-col>
          <v-col cols="7" class="pb-0">
            <label class="black--text">Dana Kebajikan</label>
          </v-col>
          <v-col cols="5">
            <v-text-field 
              color="black"
              autocomplete="off" 
              hide-details
              solo
              dense
              disabled
              v-model="form.data.dana_kebajikan"
              v-mask="thousandMask"
              class="justify-end text-right"
            />
          </v-col>
        </v-row>
      </v-card>
      <v-btn block class="indigo lighten-1 white--text mb-5" @click="prosesSetoran()">
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
      form: {
        data: {
          kode_cabang: null,
          kode_rembug: null,
          kode_petugas: null,
          kode_kas_petugas: null,
          trx_date: null,
          no_anggota: null,
          no_rekening: null,
          angsuran: {
            amount: 0,
            detail: []
          },
          frekuensi: 1,
          setoran_sukarela: 0,
          setoran_simpanan_wajib: 0,
          penarikan_sukarela: 0,
          no_rekening_tabungan: [],
          amount_tabungan: [],
          pokok: 0,
          biaya_administrasi: 0,
          biaya_asuransi_jiwa: 0,
          tabungan_persen: 0,
          dana_kebajikan: 0,
          pembiayaan: [],
          berencana: [],
          total_setoran: 0,
          taber: []
        }
      },
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
    async getDataSetoran(no_anggota) {
      let kode_rembug = this.$route.params.kode_rembug
      if(!no_anggota) {
        no_anggota = this.$route.params.no_anggota
      } else {
        this.$router.push(`/transaksi/setoran-form/${kode_rembug}/${no_anggota}`)
      }
      if(no_anggota) {
        let payload = new FormData()
        payload.append('no_anggota', no_anggota)
        try {
          let req = await services.transSetoranDeposit(payload, this.user.token)
          if(req.status === 200) {
            let dataDeposit = {...req.data.data}
            
            let formData = {
              kode_cabang: this.user.kode_cabang,
              kode_rembug: this.rembug,
              kode_petugas: this.user.kode_petugas,
              kode_kas_petugas: this.user.kode_kas_petugas,
              trx_date: this.getDate(),
              no_anggota: this.anggota,
              no_rekening: dataDeposit.no_rekening,
              angsuran: dataDeposit.angsuran,
              frekuensi: 1,
              setoran_sukarela: 0,
              setoran_simpanan_wajib: dataDeposit.simwa,
              penarikan_sukarela: 0,
              simwaState: true,
              angsuranState: true,
              taber: [],
              pokok: dataDeposit.pokok,
              biaya_administrasi: dataDeposit.biaya_administrasi,
              biaya_asuransi_jiwa: dataDeposit.biaya_asuransi_jiwa,
              tabungan_persen: dataDeposit.tabungan_persen,
              dana_kebajikan: dataDeposit.dana_kebajikan,
              pembiayaan: dataDeposit.pembiayaan,
              total_setoran: 0
            }
            dataDeposit.berencana.forEach((taber, index) => {
              let dataTaber = {...taber}
              dataTaber.state = true
              formData.taber.push(dataTaber)
            })
            this.form.data = {...formData}
            console.log(formData)
            this.countTotalSetoran()
          } else {
            this.alert = {
              show: true,
              msg: data.message
            }
          }
          this.opt.anggota.map((anggota, index) => {
            if(anggota.value === this.$route.params.no_anggota) {
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
      let hari_transaksi = new Date().getDay();
      hari_transaksi = this.user.hari_transaksi
      let payload = new FormData()
      payload.append('kode_petugas', this.user.kode_petugas)
      payload.append('hari_transaksi', hari_transaksi)
      try {
        let req = await services.infoRembug(payload, this.user.token)
        if(req.status === 200) {
          let { data } = req.data
          this.opt.rembug = []
          data.map((rembug, index) => {
            this.opt.rembug.push({
              text: rembug.nama_rembug,
              value: rembug.kode_rembug
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
    async getAnggota(kode_rembug) {
      if(!kode_rembug) {
        kode_rembug = this.$route.params.kode_rembug
      } else {
        this.$router.push(`/transaksi/setoran-form/${kode_rembug}`)
        this.aAnggota = {
          nama: null,
          cif_no: null,
          cm_name: null
        }
        this.anggota = null
      }
      if(kode_rembug) {
        let payload = new FormData()
        payload.append('kode_rembug', kode_rembug)
        try {
          let req = await services.infoMember(payload, this.user.token)
          if(req.status === 200) {
            this.opt.anggota = []
            let { data } = req.data
            data.map((anggota, index) => {
              this.opt.anggota.push({
                text: anggota.nama_anggota,
                value: anggota.no_anggota,
                data: anggota
              })
              if(anggota.no_anggota === this.$route.params.no_anggota) {
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
    async prosesSetoran(){
      let payload = new FormData()
      let formData = {...this.form.data}
      formData.total_angsuran = (formData.total_angsuran) ? Number(formData.total_angsuran.replace(/\./g,"")) : 0
      formData.setoran_sukarela = (formData.setoran_sukarela) ? Number(formData.setoran_sukarela.replace(/\./g,"")) : 0
      formData.setoran_simpanan_wajib = (formData.setoran_simpanan_wajib) ? Number(formData.setoran_simpanan_wajib.replace(/\./g,"")) : 0
      formData.penarikan_sukarela = (formData.penarikan_sukarela) ? Number(formData.penarikan_sukarela.replace(/\./g,"")) : 0
      formData.pokok = (formData.pokok) ? Number(this.removeThousand(formData.pokok)) : 0
      formData.biaya_administrasi = (formData.biaya_administrasi) ? Number(this.removeThousand(formData.biaya_administrasi)) : 0
      formData.biaya_asuransi_jiwa = (formData.biaya_asuransi_jiwa) ? Number(this.removeThousand(formData.biaya_asuransi_jiwa)) : 0
      formData.tabungan_persen = (formData.tabungan_persen) ? Number(this.removeThousand(formData.tabungan_persen)) : 0
      formData.dana_kebajikan = (formData.dana_kebajikan) ? Number(this.removeThousand(formData.dana_kebajikan)) : 0
      payload.append('kode_cabang',formData.kode_cabang)
      payload.append('kode_rembug',formData.kode_rembug)
      payload.append('kode_petugas',formData.kode_petugas)
      payload.append('kode_kas_petugas',formData.kode_kas_petugas)
      payload.append('trx_date',formData.trx_date)
      payload.append('no_anggota',formData.no_anggota)
      payload.append('no_rekening',formData.no_rekening)
      formData.angsuran.detail.map((item,i) => {
        payload.append(`angsuran[${i}][id]`,item.id)
        payload.append(`angsuran[${i}][nama]`,item.nama)
        payload.append(`angsuran[${i}][amount]`,item.amount*formData.frekuensi)
      })
      payload.append('setoran_sukarela',formData.setoran_sukarela)
      payload.append('setoran_simpanan_wajib',formData.setoran_simpanan_wajib)
      payload.append('penarikan_sukarela',formData.penarikan_sukarela)
      payload.append('kode_rembug',formData.kode_rembug)
      payload.append('kode_rembug',formData.kode_rembug)
      formData.taber.map((item) => {
        item.setoran = (item.setoran) ? Number(item.setoran.replace(/\./g,"")) : 0
        payload.append('no_rekening_tabungan[]',item.no_rekening)
        payload.append('amount_tabungan[]',item.setoran*item.freq_saving)
      })
      
      payload.append('pokok',Number(formData.pokok))
      payload.append('biaya_administrasi',Number(formData.biaya_administrasi))
      payload.append('biaya_asuransi_jiwa',Number(formData.biaya_asuransi_jiwa))
      payload.append('tabungan_persen',Number(formData.tabungan_persen))
      payload.append('dana_kebajikan',Number(formData.dana_kebajikan))
      try {
        let req = await services.transSetoranProses(payload, this.user.token)
        if(req.status === 200) {
          this.alert = {
            show: true,
            msg: req.data.msg
          }
          setTimeout(() => {
            this.$router.push('/anggota/'+this.rembug).catch(()=>{});
          },500)
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
    },
    countTotalSetoran(){
      let {angsuran, frekuensi, taber} = this.form.data
      let total_taber = 0
      taber.map((item) => {
        total_taber = total_taber + (Number(item.setoran) * Number(item.freq_saving))
      })
      let total_setoran = (Number(angsuran.amount) * Number(frekuensi)) + Number(total_taber)
      this.form.data.total_setoran = total_setoran
    },
    getDate(){
      let today = new Date()
      let day = today.getDate()
      let month = today.getMonth()
      let year = today.getFullYear()
      return `${day}/${month}/${year}`
    },
    setForm(){
      let kode_rembug = this.$route.params.kode_rembug
      let no_anggota = this.$route.params.no_anggota
      this.rembug = kode_rembug
      this.anggota = (no_anggota) ? no_anggota : null
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