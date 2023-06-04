<template>
  <div class="bt-transaksi pa-5">
    <h6
      class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center"
    >
      <div
        class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3"
      >
        <v-icon small color="white">mdi-wallet-plus</v-icon>
      </div>
      Registrasi Taber
    </h6>
    <div>
      <Camera class="mt-5"/>
      <v-select solo label="Rembug" class="mb-3 mt-3" hide-details :items="opt.rembug" v-model="form.data.kode_rembug" @change="getAnggota()"/>
      <v-select solo label="Pilih Anggota" class="mb-3" hide-details :items="opt.anggota" v-model="form.data.no_anggota"/>
      <v-select solo label="Produk Tabungan" class="mb-3" hide-details :items="opt.produk" v-model="form.data.kode_produk" @change="setTabungan()"/>
    </div>
    <v-container class="pa-0">
      <div class="bt-page-steps d-flex pt-5 pb-3">
        <div class="bt-page-step-item">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <v-row>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.biaya_administrasi"
                  label="Biaya Administrasi"
                  v-mask="thousandMask"
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.setoran"
                  label="Setoran"
                  v-mask="thousandMask"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Periode Setoran"
                  hide-details
                  :items="opt.periode_setoran"
                  v-model="form.data.periode_setoran"
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
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.rencana_awal_setoran"
                  type="date"
                  label="Rencana Awal Setoran"
                />
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
export default {
  name: "Tabungan",
  components: {
    Camera,
  },
  data() {
    return {
      form: {
        data: {
          kode_rembug: null,
          no_anggota: null,
          kode_produk: null,
          biaya_administrasi: 0,
          setoran: 0,
          periode_setoran: null,
          jangka_waktu: 0,
          rencana_awal_setoran: null,
          jenis_tabungan: null,
          created_by: null,
        }
      },
      opt: {
        rembug: [],
        anggota: [],
        produk: [],
        periode_setoran: [
          {
            value: 0,
            text: 'Harian'
          },
          {
            value: 2,
            text: 'Mingguan'
          },
          {
            value: 3,
            text: 'Bulanan'
          }
        ]
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
    async getProduk() {
      let payload = {
        page: 1,
        perPage: '~',
        sortDir: 'ASC',
        sortBy: 'kode_produk',
        search: ""
      }
      this.opt.produk = []
      try {
        let req = await services.produkTabungan(payload, this.user.token)
        if(req.status === 200) {
          req.data.data.map((item) => {
            this.opt.produk.push({
              value: item.kode_produk,
              text: item.nama_singkat+'-'+item.nama_produk,
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
      let produk = this.opt.produk.find((item) => item.value == this.form.data.kode_produk).data
      this.form.data.biaya_administrasi = Number(produk.biaya_adm)
      this.form.data.jenis_tabungan = produk.jenis_tabungan
      this.form.data.created_by = this.user.kode_petugas
    },
    async doSave() {
      let payload = new FormData();
      let payloadData = {...this.form.data};
      delete payloadData.kode_rembug
      payloadData.rencana_awal_setoran = this.formatDate(payloadData.rencana_awal_setoran)
      if(payloadData.no_anggota && payloadData.setoran){
        for (let key in payloadData) {
          payload.append(key, payloadData[key]);
        }
        try {
          let req = await services.registrasiTabungan(payload, this.user.token);
          if (req.status === 200) {
            if(req.data.status){
              this.alert = {
                show: true,
                msg: "Registrasi Tabungan Berhasil",
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
              msg: "Registrasi Tabungan Gagal",
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
          msg: 'Silahkan pilih Rembug dan Anggota lalu pilih Produk dan isi Jumlah Setoran',
        };
      }
    },
  },
  mounted() {
    this.getRembug();
    this.getProduk();
  }
};
</script>
