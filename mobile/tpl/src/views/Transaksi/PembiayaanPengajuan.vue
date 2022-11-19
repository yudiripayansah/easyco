
<template>
  <div class="bt-pembiayaan-pengajuan pa-5">
    <h6 class="text-h5 font-weight-bold orange--text text--lighten-1 d-flex align-center">
      <div class="rounded-pill orange lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3">
        <v-icon small color="white">mdi-note-plus-outline</v-icon>
      </div>
      Pengajuan Pembiayaan
    </h6>
    <PengajuanHeader/>
    <v-container class="pa-0">
      <div class="bt-page-indicator d-flex justify-space-between pt-3">
        <span 
          class="d-flex align-center justify-center elevation-3 rounded-circle" 
          :class="(step==1) ? 'orange lighten-1 white--text text--darken-1' : 'orange lighten-5 orange--text text--darken-1'">
          1
        </span>
        <span 
          class="d-flex align-center justify-center elevation-3 rounded-circle" 
          :class="(step==2) ? 'orange lighten-1 white--text text--darken-1' : 'orange lighten-5 orange--text text--darken-1'">
          2
        </span>
        <span 
          class="d-flex align-center justify-center elevation-3 rounded-circle" 
          :class="(step==3) ? 'orange lighten-1 white--text text--darken-1' : 'orange lighten-5 orange--text text--darken-1'">
          3
        </span>
        <span 
          class="d-flex align-center justify-center elevation-3 rounded-circle" 
          :class="(step==4) ? 'orange lighten-1 white--text text--darken-1' : 'orange lighten-5 orange--text text--darken-1'">
          4
        </span>
        <span 
          class="d-flex align-center justify-center elevation-3 rounded-circle" 
          :class="(step==5) ? 'orange lighten-1 white--text text--darken-1' : 'orange lighten-5 orange--text text--darken-1'">
          5
        </span>
      </div>
      <div class="bt-page-steps d-flex pt-5 pb-3">
        <div class="bt-page-step-item" v-show="step==1">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Data Pengajuan</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="No. Pengajuan"
                />
              </v-col>
              <v-col cols="12">
                <v-select color="black" outlined label="Jenis Pembiayaan" hide-details :items="opt.financing_type" v-model="form.noPengajuan"/>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Pembiayaan Ke"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Jumlah Pengajuan"
                />
              </v-col>
              <v-col cols="12">
                <v-select color="black" outlined label="Periode" hide-details :items="opt.periode_jangka_waktu" v-model="form.noPengajuan"/>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Jangka Waktu"
                />
              </v-col>
              <v-col cols="12">
                <v-select color="black" outlined label="Peruntukan" hide-details :items="opt.peruntukan" v-model="form.noPengajuan"/>
              </v-col>
              <v-col cols="12">
                <v-textarea 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Keterangan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Tanggal Pengajuan"
                />
              </v-col>
              <v-col cols="12">
                <v-file-input 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Foto KTP"
                />
              </v-col>
              <v-col cols="12">
                <v-file-input 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Foto Kartu Keluarga"
                />
              </v-col>
              <v-col cols="12">
                <v-file-input 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Foto Dokumen Pendukung"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
        <div class="bt-page-step-item" v-show="step==2">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Jenis usaha</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Jenis Usaha"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Komoditi"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Lama Usaha (Dalam Tahun)"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Lokasi Usaha"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Surat Izin Usaha"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Aset Usaha"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Nilai Aset"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
        <div class="bt-page-step-item" v-show="step==3">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Modal Usaha</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Persediaan Awal"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Belanja/ Pembelian"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Persediaan Akhir"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="HPP"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Omset"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Laba Kotor"
                />
              </v-col>
            </v-row>
            <h6 class="text-h6 font-weight-bold mb-4 mt-5">Biaya Usaha</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Piutang"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Biaya Usaha"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Sewa Tempat"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Total Biaya Usaha"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Keuntungan Usaha"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
        <div class="bt-page-step-item" v-show="step==4">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Data Anggota</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="No Telp Anggota"
                />
              </v-col>
              <v-col cols="12">
                <v-select color="black" outlined label="Pekerjaan Anggota" hide-details :items="opt.financing_type" v-model="form.noPengajuan"/>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="No Telp Pasangan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Pekerjaan Pasangan"
                />
              </v-col>
            </v-row>
            <h6 class="text-h6 font-weight-bold mb-4 mt-5">Pendapatan/ Penghasilan</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Pendapatan Gaji"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Pendapatan Usaha"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Pendapatan Lainnya"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Total Pendapatan"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
        <div class="bt-page-step-item" v-show="step==5">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Tanggungan dan Saving Power</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Jumlah Tanggungan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Biaya Rumah Tangga"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Biaya Kontrakan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Biaya Pendidikan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Hutang Lainnya"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Total Biaya"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Saving Power"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="Repayment Capacity"
                />
              </v-col>
              <v-col cols="12">
                <v-textarea 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="TTD Nasabah"
                />
              </v-col>
              <v-col cols="12">
                <v-textarea 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.map_no"
                  label="TTD Pasangan"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
      </div>
      <v-row>
        <v-col cols="6" class="pb-0" v-show="step > 1">
          <v-btn block class="orange lighten-1 white--text" @click="move(step-1)">
            Sebelumnya
          </v-btn>
        </v-col>
        <v-col :cols="step > 1 ? 6 : 12" class="pb-0">
          <v-btn block class="orange lighten-1 white--text" @click="move(step+1)">
            {{step == 5 ? 'Simpan' : 'Selanjutnya'}}
          </v-btn>
        </v-col>
        <!-- <v-col cols="6" class="pb-0">
          <router-link to="/transaksi/pembiayaan">
          <v-btn block class="orange lighten-1 white--text d-flex justify-content-start">
            Kembali
          </v-btn>
          </router-link>
        </v-col>
        <v-col cols="6" class="pb-0">
          <router-link to="/transaksi/pembiayaan-rab">
          <v-btn block class="orange lighten-1 white--text">
            RAB
          </v-btn>
          </router-link> 
        </v-col> -->
      </v-row>
    </v-container>
  </div>
</template>
<script>
import helper from '@/utils/helper'
import Toast from '@/components/Toast'
import {
  mapGetters,
  mapActions
} from "vuex";
import services from "@/services";
import Camera from '../../components/Camera.vue'
import PengajuanHeader from '../../components/PengajuanHeader.vue'
export default {
  name: 'PembiayaanPengajuan',
  components: {
    Camera,
    PengajuanHeader
  },
  data() {
    return {
      form: {
        data : {
          cif_no : null,
          amount : 0,
          financing_type : null,
          peruntukan : null,
          rencana_droping : null,
          pembiayaan_ke : 1,
          periode_jangka_waktu: 1,
          jangka_waktu: 0,
          description : null,
          tanggal_pengajuan : null,
          created_by : null,
          pyd : 1,
          map_no : null,
          ttd_anggota : null,
          ttd_pasangan : null,
          sumber_pengembalian : null,
          jenis_usaha : '',
          komoditi : '',
          lama_usaha : '',
          lokasi_usaha : '',
          surat_ijin_usaha : '',
          aset_usaha : '',
          nilai_aset : 0,
          persediaan_awal : 0,
          belanja_pembelian : 0,
          persediaan_akhir : 0,
          hpp: 0,
          omset : 0,
          laba_kotor : 0,
          piutang : 0,
          biaya_usaha : 0,
          sewa_tempat : 0,
          total_biaya_usaha : 0,
          keuntungan_usaha : 0,
          telepon_anggota : null,
          pekerjaan_anggota : null,
          telepon_pasangan : null,
          pekerjaan_pasangan : null,
          pendapatan_gaji : 0,
          pendapatan_usaha : 0,
          pendapatan_lainnya : 0,
          total_pendapatan : 0,
          jumlah_tanggungan : null,
          biaya_rumah_tangga : 0,
          biaya_rekening : 0,
          biaya_kontrakan : 0,
          biaya_pendidikan : 0,
          hutang_lainnya : 0,
          total_biaya : 0,
          saving_power : 0,
          repayment_capacity : 0,
          doc_ktp: null,
          doc_kk: null,
          doc_pendukung: null,
          token : null
        },
      },
      opt : {
        financing_type : [
          {value: 0, text: 'Kelompok'},
          {value: 1, text: 'Individu'}
        ],
        peruntukan : [
          {value: 1 ,text : 'Modal kerja'},
          {value: 2 ,text : 'Investasi'},
          {value: 3 ,text : 'Pendidikan'},
          {value: 4 ,text : 'Perumahan'},
          {value: 5 ,text : 'Kesehatan'},
          {value: 6 ,text : 'Aset'},
          {value: 9 ,text : 'Lain-Lain'},
          {value: 7 ,text : 'Air bersih & Sanitasi'},
        ],
        sumber_pengembalian : ["sumber usaha","gaji"],
        pekerjaan : [
          {value:0,text: 'Ibu Rumah Tangga'},
          {value:1,text: 'Buruh'},
          {value:2,text: 'Petani'},
          {value:3,text: 'Pedagang'},
          {value:4,text: 'Wiraswasta'},
          {value:5,text: 'Pegawai Negeri Sipil'},
          {value:6,text: 'Karyawan Swasta'},
        ],
        periode_jangka_waktu: [
          {value:1,text: 'Mingguan'},
          {value:2,text: 'Bulanan'},
          {value:3,text: 'Jatuh Tempo'},
        ],
        rembug: [],
        anggota: []
      },
      step: 1,
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
    move(step){
      this.step = step
      window.scrollTo(0,0)
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
    this.getRembug()
    this.getAnggota()
    this.setForm()
  }
}
</script>