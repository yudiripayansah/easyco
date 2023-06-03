
<template>
  <div class="bt-pembiayaan-pengajuan pa-5">
    <h6
      class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center"
    >
      <div
        class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3"
      >
        <v-icon small color="white">mdi-note-plus-outline</v-icon>
      </div>
      Pengajuan Pembiayaan
    </h6>
    <div>
      <Camera class="mt-5"/>
      <v-select solo label="Rembug" class="mb-3 mt-3" hide-details :items="opt.rembug" v-model="form.rembug" @change="getAnggota()"/>
      <v-select solo label="Pilih Anggota" class="mb-3" hide-details :items="opt.anggota" v-model="form.anggota" @change="setAnggota()"/>
      <v-container class="pa-0 mb-3" v-show="aAnggota.nama_anggota != null">
        <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3">
          <v-container class="d-flex justify-space-between pa-0">
            <div class="d-flex flex-column">
              <h5 class="text-h5 font-weight-bold">{{ aAnggota.nama_anggota }}</h5>
              <span class="text-caption grey--text">{{ aAnggota.no_anggota }}</span>
              <span class="indigo--text lighten-1 font-weight-black">{{ aAnggota.nama_rembug }}</span>
            </div>
          </v-container>
        </v-card>
      </v-container>
    </div>
    <v-container class="pa-0">
      <div class="bt-page-steps d-flex pt-5 pb-3">
        <div class="bt-page-step-item">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Data Pengajuan</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  disabled
                  value="Auto Generated"
                  label="No. Pengajuan"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Jenis Pembiayaan"
                  hide-details
                  :items="opt.jenis_pembiayaan"
                  v-model="form.data.jenis_pembiayaan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.pengajuan_ke"
                  label="Pembiayaan Ke"
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.jumlah_pengajuan"
                  label="Jumlah Pengajuan"
                  v-mask="thousandMask"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Periode"
                  hide-details
                  :items="opt.periode_jangka_waktu"
                  v-model="form.data.rencana_periode_jwaktu"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.jangka_waktu"
                  label="Jangka Waktu"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Peruntukan"
                  hide-details
                  :items="opt.peruntukan"
                  v-model="form.data.peruntukan"
                />
              </v-col>
              <v-col cols="12">
                <v-textarea
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.keterangan_peruntukan"
                  label="Keterangan"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Sumber Pengembalian"
                  hide-details
                  :items="opt.sumber_pengembalian"
                  v-model="form.data.sumber_pengembalian"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.tanggal_pengajuan"
                  type="date"
                  label="Tanggal Pengajuan"
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.rencana_droping"
                  type="date"
                  label="Rencana Dropping"
                />
              </v-col>
              <v-col cols="12">
                <v-file-input
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.doc_ktp"
                  label="Foto KTP"
                />
              </v-col>
              <v-col cols="12">
                <v-file-input
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.doc_kk"
                  label="Foto Kartu Keluarga"
                />
              </v-col>
              <v-col cols="12">
                <v-file-input
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.doc_pendukung"
                  label="Foto Dokumen Pendukung"
                />
              </v-col>
              <v-col cols="12">
                <v-card class="pa-3">
                  <label class="mb-4">Ttd Anggota</label>
                  <VPerfectSignature :stroke-options="strokeOptions" ref="ttdAnggota" />
                  <v-btn block class="indigo lighten-1 white--text" @click="clearTtd('ttdAnggota')">
                    Ulangi
                  </v-btn>
                </v-card>
              </v-col>
              <v-col cols="12">
                <v-card class="pa-3">
                  <label class="mb-4">Ttd Pasangan</label>
                  <VPerfectSignature :stroke-options="strokeOptions" ref="ttdPasangan" />
                  <v-btn block class="indigo lighten-1 white--text" @click="clearTtd('ttdPasangan')">
                    Ulangi
                  </v-btn>
                </v-card>
              </v-col>
              <v-col cols="12">
                <v-card class="pa-3">
                  <label class="mb-4">Ttd Ketua Majelis</label>
                  <VPerfectSignature :stroke-options="strokeOptions" ref="ttdKetuaMajelis" />
                  <v-btn block class="indigo lighten-1 white--text" @click="clearTtd('ttdKetuaMajelis')">
                    Ulangi
                  </v-btn>
                </v-card>
              </v-col>
              <v-col cols="12">
                <v-card class="pa-3">
                  <label class="mb-4">Ttd Tpl</label>
                  <VPerfectSignature :stroke-options="strokeOptions" ref="ttdTpl" />
                  <v-btn block class="indigo lighten-1 white--text" @click="clearTtd('ttdTpl')">
                    Ulangi
                  </v-btn>
                </v-card>
              </v-col>
            </v-row>
          </v-card>
        </div>
      </div>
      <v-row>
        <v-col cols="6" class="pb-0">
          <router-link to="/pembiayaan">
          <v-btn
            block
            class="indigo lighten-1 white--text"
          >
            Kembali
          </v-btn>
          </router-link>
        </v-col>
        <v-col cols="6" class="pb-0">
          <v-btn
            block
            class="indigo lighten-1 white--text"
            @click="doSave()"
          >
            Simpan
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
    <v-snackbar v-model="alert.show" :timeout="5000">{{ alert.msg }}</v-snackbar>
  </div>
</template>
<script>
import Camera from '@/components/Camera.vue'
import helper from "@/utils/helper";
import { mapGetters, mapActions } from "vuex";
import services from "@/services";
import VPerfectSignature, { StrokeOptions } from 'v-perfect-signature'
export default {
  name: "PembiayaanPengajuan",
  components: {
    Camera,
    VPerfectSignature
  },
  data() {
    return {
      form: {
        data: {
          no_anggota:null,
          kode_petugas:null,
          tanggal_pengajuan:null,
          jumlah_pengajuan:null,
          pengajuan_ke:1,
          peruntukan:null,
          keterangan_peruntukan:null,
          rencana_droping:null,
          jangka_waktu:null,
          rencana_periode_jwaktu:null,
          jenis_pembiayaan:null,
          sumber_pengembalian:null,
          doc_ktp:null,
          doc_kk:null,
          doc_pendukung:null,
          ttd_anggota:null,
          ttd_suami:null,
          ttd_ketua_majelis:null,
          ttd_tpl:null,
          created_by:null,
        },
      },
      opt: {
        jenis_pembiayaan: [
          { value: 0, text: "Kelompok" },
          { value: 1, text: "Individu" },
        ],
        peruntukan: [
          { value: 1, text: "Modal kerja" },
          { value: 2, text: "Investasi" },
          { value: 3, text: "Pendidikan" },
          { value: 4, text: "Perumahan" },
          { value: 5, text: "Kesehatan" },
          { value: 6, text: "Aset" },
          { value: 9, text: "Lain-Lain" },
          { value: 7, text: "Air bersih & Sanitasi" },
        ],
        sumber_pengembalian: [
          { value: 0, text: "Sumber Usaha" },
          { value: 1, text: "Non Usaha" },],
        pekerjaan: [
          { value: 0, text: "Ibu Rumah Tangga" },
          { value: 1, text: "Buruh" },
          { value: 2, text: "Petani" },
          { value: 3, text: "Pedagang" },
          { value: 4, text: "Wiraswasta" },
          { value: 5, text: "Pegawai Negeri Sipil" },
          { value: 6, text: "Karyawan Swasta" },
        ],
        periode_jangka_waktu: [
          { value: 0, text: "Harian" },
          { value: 1, text: "Mingguan" },
          { value: 2, text: "Bulanan" },
          { value: 3, text: "Jatuh Tempo" },
        ],
        rembug: [],
        anggota: [],
      },
      step: 1,
      rembug: null,
      anggota: null,
      aAnggota: {
        nama_anggota: null,
        no_anggota: null,
        nama_rembug: null,
      },
      alert: {
        show: false,
        msg: ''
      },
      loading: false,
      strokeOptions: {
        size: 5,
        thinning: 0.75,
        smoothing: 0.5,
        streamline: 0.5
      }
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    ...helper,
    move(step) {
      this.step = step;
      window.scrollTo(0, 0);
    },
    async getRembug() {
      let hari_transaksi = new Date().getDay();
      hari_transaksi = this.user.hari_transaksi;
      let payload = new FormData();
      payload.append("kode_petugas", this.user.kode_petugas);
      payload.append("hari_transaksi", hari_transaksi);
      this.opt.rembug = [];
      this.loading = true;
      try {
        let req = await services.infoRembug(payload, this.user.token);
        if (req.status === 200) {
          req.data.data.map((item) => {
            this.opt.rembug.push({
              text: item.nama_rembug,
              value: item.kode_rembug,
            });
          });
        } else {
          this.alert = {
            show: true,
            msg: data.message,
          };
        }
        this.loading = false;
      } catch (error) {
        this.alert = {
          show: true,
          msg: error,
        };
        this.loading = false;
      }
    },
    async getAnggota() {
      let payload = new FormData()
      payload.append('kode_rembug', this.form.rembug)
      this.opt.anggota = []
      try {
        let req = await services.infoMember(payload, this.user.token)
        if(req.status === 200) {
          req.data.data.map((item) => {
            this.opt.anggota.push({
              value: item.no_anggota,
              text: item.nama_anggota,
              data: item
            });
          });
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
    async doSave() {
      console.log('save')
      let payload = new FormData();
      let payloadData = {...this.form.data};
      payloadData.jumlah_pengajuan = Number(this.form.data.jumlah_pengajuan.replace(/\./g,""))
      payloadData.no_anggota = this.aAnggota.no_anggota
      payloadData.kode_petugas = this.user.kode_petugas
      payloadData.created_by = this.user.id
      payloadData.ttd_anggota = this.$refs.ttdAnggota.toDataURL()
      payloadData.ttd_suami = this.$refs.ttdPasangan.toDataURL()
      payloadData.ttd_ketua_majelis = this.$refs.ttdKetuaMajelis.toDataURL()
      payloadData.ttd_tpl = this.$refs.ttdTpl.toDataURL()
      payloadData.tanggal_pengajuan = this.formatDate(payloadData.tanggal_pengajuan)
      payloadData.rencana_droping = this.formatDate(payloadData.rencana_droping)
      if(payloadData.no_anggota && payloadData.jumlah_pengajuan){
        for (let key in payloadData) {
          payload.append(key, payloadData[key]);
        }
        try {
          let req = await services.pembiayaanCreate(payload, this.user.token);
          if (req.status === 200) {
            if(req.data.status){
              this.alert = {
                show: true,
                msg: "Pengajuan Pembiayaan Berhasil",
              };
              setTimeout(() => {
                this.$router.push(`/pembiayaan`);
              }, 2000);
            } else {
              this.alert = {
                show: true,
                msg: req.data.msg,
              };
            }
          } else {
            this.alert = {
              show: true,
              msg: "Pengajuan Pembiayaan Gagal",
            };
          }
        } catch (error) {
          this.alert = {
            show: true,
            msg: error,
          };
        }
      } else {
        this.alert = {
          show: true,
          msg: 'Silahkan pilih Rembug lalu pilih Anggota dan isi Jumlah Pengajuan',
        };
      }
    },
    getDate(){
      let today = new Date()
      let day = today.getDate()
      let month = today.getMonth()+1
      let year = today.getFullYear()
      month = ('0' + month.toString()).slice(-2)
      return `${year}-${month}-${day}`
    },
    setAnggota(){
      let anggota = this.opt.anggota.find((item) => item.value == this.form.anggota).data
      this.aAnggota = {...anggota}
    },
    clearTtd(ttd){
      this.$refs[ttd].clear()
    }
  },
  mounted() {
    this.getRembug();
    this.form.data.tanggal_pengajuan = this.getDate()
  },
};
</script>