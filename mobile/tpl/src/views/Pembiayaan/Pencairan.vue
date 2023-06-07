<template>
  <div class="bt-transaksi pa-5">
    <h6
      class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center"
    >
      <div
        class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3"
      >
        <v-icon small color="white">mdi-cash-100</v-icon>
      </div>
      Pencairan/ Akad
    </h6>
    <div>
      <Camera class="mt-5"/>
      <v-select solo label="Rembug" class="mb-3 mt-3" hide-details :items="opt.rembug" v-model="form.data.kode_rembug" @change="getAnggota()"/>
      <v-select solo label="Pilih Anggota" class="mb-3" hide-details :items="opt.anggota" v-model="form.data.no_anggota" @change="getPembiayaan()"/>
      <v-select solo label="Pembiayaan" class="mb-3" hide-details :items="opt.pembiayaan" v-model="form.data.id" @change="setTabungan()"/>
    </div>
    <v-container class="pa-0">
      <div class="bt-page-steps d-flex pt-5 pb-3">
        <div class="bt-page-step-item">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <v-row>
              <v-col cols="12">
                <v-file-input
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.doc_pencairan"
                  label="Foto Dokumen Pencairan"
                />
              </v-col>
              <v-col cols="12">
                <v-card class="pa-3">
                  <label class="mb-4">Ttd Pencairan</label>
                  <VPerfectSignature :stroke-options="strokeOptions" ref="ttdPenciran" />
                  <v-btn block class="indigo lighten-1 white--text" @click="clearTtd('ttdPenciran')">
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
  name: "Pembiayaan",
  components: {
    Camera,
    VPerfectSignature
  },
  data() {
    return {
      form: {
        data: {
          kode_rembug: null,
          no_anggota: null,
          id: null,
          doc_pencairan: null,
          ttd_pencairan: null
        }
      },
      opt: {
        rembug: [],
        anggota: [],
        pembiayaan: []
      },
      alert: {
        show: false,
        msg: ''
      },
      loading: false
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    ...helper,
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
      payload.append('kode_rembug', this.form.data.kode_rembug)
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
    async getPembiayaan() {
      let payload = {
        page: 1,
        perPage: '~',
        sortDir: 'ASC',
        sortBy: 'kop_pembiayaan.tanggal_akad',
        search: this.form.data.no_anggota,
      }
      this.opt.pembiayaan = []
      try {
        let req = await services.readRekeningPembiayaan(payload, this.user.token)
        if(req.status === 200) {
          req.data.data.map((item) => {
            this.opt.pembiayaan.push({
              value: item.id,
              text: item.nama_produk+'-'+item.no_rekening,
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
    setTabungan(){
      let produk = this.opt.produk.find((item) => item.value == this.form.data.id).data
      this.form.data.saldo = Number(produk.saldo)
    },
    async doSave() {
      let payload = new FormData();
      let payloadData = {...this.form.data}
      payloadData.ttd_pencairan = this.$refs.ttdPenciran.toDataURL()
      if(payloadData.id){
        for (let key in payloadData) {
          payload.append(key, payloadData[key]);
        }
        try {
          let req = await services.prosesPenciran(payload, this.user.token);
          if (req.status === 200) {
            if(req.data.status){
              this.alert = {
                show: true,
                msg: "Registrasi Penciran Pembiayaan Berhasil",
              };
              setTimeout(() => {
                this.$router.push(`/tabungan`);
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
              msg: "Registrasi Penciran Pembiayaan Gagal",
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
          msg: 'Silahkan pilih Rekening Tabungan',
        };
      }
    },
    clearTtd(ttd){
      this.$refs[ttd].clear()
    }
  },
  mounted() {
    this.getRembug();
  }
};
</script>
