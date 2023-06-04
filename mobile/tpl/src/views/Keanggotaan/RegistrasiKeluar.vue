<template>
  <div class="bt-transaksi pa-5">
    <h6
      class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center"
    >
      <div
        class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3"
      >
        <v-icon small color="white">mdi-account-multiple-minus</v-icon>
      </div>
      Registrasi Anggota Keluar
    </h6>
    <div>
      <Camera class="mt-5"/>
      <v-select solo label="Rembug" class="mb-3 mt-3" hide-details :items="opt.rembug" v-model="form.data.kode_rembug" @change="getAnggota()"/>
      <v-select solo label="Pilih Anggota" class="mb-3" hide-details :items="opt.anggota" v-model="form.data.no_anggota" @change="setAnggota()"/>
    </div>
    <v-container class="pa-0">
      <div class="bt-page-steps d-flex pt-5 pb-3">
        <div class="bt-page-step-item">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <v-row>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Alasan"
                  hide-details
                  :items="opt.alasan_mutasi"
                  v-model="form.data.alasan_mutasi"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.keterangan_mutasi"
                  label="Keterangan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.tanggal_mutasi"
                  type="date"
                  label="Tanggal Mutasi"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.saldo_pokok)"
                  label="Saldo Pokok"
                  
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-row>
                  <v-col cols="10">
                    <v-text-field 
                      color="black"
                      autocomplete="off" 
                      hide-details
                      outlined
                      :value="thousandMask(form.data.saldo_margin)"
                      label="Saldo Margin"
                      disabled
                    />
                  </v-col>
                  <v-col>
                    <v-checkbox
                      v-model="form.data.flag_saldo_margin"
                      hide-details
                      flat
                      solo
                      dense
                      @change="countHutang()"/>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12">
                <v-row>
                  <v-col cols="10">
                    <v-text-field 
                      color="black"
                      autocomplete="off" 
                      hide-details
                      outlined
                      :value="thousandMask(form.data.saldo_catab)"
                      label="Saldo Catab"
                      disabled
                    />
                  </v-col>
                  <v-col>
                    <v-checkbox
                      v-model="form.data.flag_saldo_catab"
                      hide-details
                      flat
                      solo
                      dense
                      @change="countHutang()"/>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.saldo_minggon)"
                  label="Saldo Minggon"
                  
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.simsuk)"
                  label="Saldo Sukarela"
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.saldo_tabungan)"
                  label="Saldo Tabungan Berencana"
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.saldo_deposito)"
                  label="Saldo Deposito"
                  
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.simpok)"
                  label="Saldo Simpok"
                  
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.simwa)"
                  label="Saldo Simwa"
                  
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.bonus_bagihasil)"
                  label="Bonus Bagihasil"
                  
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  :value="thousandMask(form.data.penarikan_sukarela)"
                  label="Penarikan Sukarela"
                  disabled
                />
              </v-col>
              <v-col cols="12">
                <v-text-field 
                  color="black"
                  autocomplete="off" 
                  hide-details
                  outlined
                  v-model="form.data.setoran_tambahan"
                  label="Setoran Tambahan"
                  v-mask="thousandMask"
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
    <v-snackbar
      v-model="alert.show"
      timeout="3000"
    >
      {{ alert.msg }}
    </v-snackbar>
  </div>
</template>

<script>
import Camera from '@/components/Camera.vue'
import helper from "@/utils/helper";
import { mapGetters, mapActions } from "vuex";
import services from "@/services";
export default {
  name: "Keangotaan",
  components: {
    Camera,
  },
  data() {
    return {
      form: {
        data: {
          kode_rembug: null,
          no_anggota: null,
          jenis_mutasi: 2,
          alasan_mutasi: null,
          keterangan_mutasi: null,
          kode_rembug: null,
          kode_rembug_baru: 0,
          tanggal_mutasi: null,
          saldo_pokok: 0,
          saldo_margin: 0,
          saldo_catab: 0,
          saldo_minggon: 0,
          simsuk: 0,
          saldo_tabungan: 0,
          saldo_deposito: 0,
          simpok: 0,
          simwa: 0,
          bonus_bagihasil: 0,
          setoran_tambahan: 0,
          penarikan_sukarela: 0,
          flag_saldo_margin: 0,
          flag_saldo_catab: 0,
          status_mutasi: 0,
          kode_petugas: null,
          created_by: null
        }
      },
      opt: {
        alasan_mutasi: [
          {
            value:1,
            text:"Meninggal"
          },
          {
            value:2,
            text:"Karakter"
          },
          {
            value:3,
            text:"Pindah Lembaga Lain"
          },
          {
            value:4,
            text:"Tidak diijinkan Pasangan"
          },
          {
            value:5,
            text:"Simpanan Kurang"
          },
          {
            value:6,
            text:"Kondisi Keluarga"
          },
          {
            value:7,
            text:"Pindah Alamat"
          },
          {
            value:8,
            text:"Tidak Setuju Keputusan Lembaga"
          },
          {
            value:9,
            text:"Usia / Jompo"
          },
          {
            value:10,
            text:"Sakit"
          },
          {
            value:11,
            text:"Kumpulan Bubar"
          },
          {
            value:12,
            text:"Tidak Punya Waktu"
          },
          {
            value:13,
            text:"Kerja"
          },
          {
            value:14,
            text:"Cerai"
          },
          {
            value:15,
            text:"Pembiayaan Bermasalah"
          },
          {
            value:16,
            text:"Usaha Sudah Berkembang"
          },
          {
            value:17,
            text:"Tidak Mau Kumpulan"
          },
          {
            value:18,
            text:"Batal Pembiayaan (Anggota baru)"
          },
          {
            value:19,
            text:"Migrasi Anggota Individu"
          },
        ],
        rembug: [],
        anggota: []
      },
      alert: {
        show: false,
        msg: ''
      },
      loading: false
    }
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
      this.clearSaldo()
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
    async setAnggota(){
      this.clearSaldo()
      let payload = `no_anggota=${this.form.data.no_anggota}`
      try {
        let req = await services.saldoAnggota(payload, this.user.token)
        if(req){
          let { status, data, msg } =  req.data
          if(req.status === 200 && status) {
            let saldo = {...data}
            this.form.data.saldo_pokok = saldo.saldo_pokok
            this.form.data.saldo_margin = saldo.saldo_margin
            this.form.data.saldo_catab = saldo.saldo_catab
            this.form.data.saldo_minggon = saldo.saldo_minggon
            this.form.data.saldo_deposito = saldo.saldo_deposito
            this.form.data.bonus_bagihasil = saldo.bonus_bagihasil
            this.form.data.saldo_tabungan = saldo.saldo_tabungan
            this.form.data.simpok = saldo.simpok
            this.form.data.simwa = saldo.simwa
            this.form.data.simsuk = saldo.simsuk
            this.countHutang()
          } else {
            this.alert = {
              show: true,
              msg: data.message
            }
          }
        }
      } catch (error) {
        this.alert = {
          show: true,
          msg: error
        }
      }
    },
    clearSaldo() {
      this.form.data.saldo_pokok = 0
      this.form.data.saldo_margin = 0
      this.form.data.saldo_catab = 0
      this.form.data.saldo_minggon = 0
      this.form.data.saldo_deposito = 0
      this.form.data.bonus_bagihasil = 0
      this.form.data.saldo_tabungan = 0
      this.form.data.simpok = 0
      this.form.data.simwa = 0
      this.form.data.simsuk = 0
    },
    countHutang() {
      console.log('Count Hutang')
      let saldo_catab = (this.form.data.flag_saldo_catab) ? this.form.data.saldo_catab: 0
      let saldo_minggon = this.form.data.saldo_minggon
      let saldo_sukarela = this.form.data.simsuk
      let saldo_tab_berencana = this.form.data.saldo_tabungan
      let saldo_deposito = this.form.data.saldo_deposito
      let saldo_simpok = this.form.data.simpok
      let saldo_simwa = this.form.data.simwa
      let bonus_bagihasil = this.form.data.bonus_bagihasil
      let saldo_pokok = this.form.data.saldo_pokok
      let saldo_margin = (this.form.data.flag_saldo_margin) ? this.form.data.saldo_margin : 0
      this.form.data.penarikan_sukarela = (saldo_catab+saldo_minggon+saldo_sukarela+saldo_tab_berencana+saldo_deposito+saldo_simpok+saldo_simwa+bonus_bagihasil) - (saldo_pokok+saldo_margin)
    },
    async doSave() {
      let payload = new FormData();
      let payloadData = {...this.form.data};
      payloadData.tanggal_mutasi = this.formatDate(payloadData.tanggal_mutasi)
      payloadData.setoran_tambahan = Number(this.removeThousand(this.form.data.setoran_tambahan))
      payloadData.kode_petugas = this.user.kode_petugas
      console.log('Menyimpan')
      if(payloadData.no_anggota){
        let canProses = true
        if(payloadData.penarikan_sukarela >= 0){
          canProses = true
        } else {
          let nilai = Number(payloadData.penarikan_sukarela) + Number(payloadData.setoran_tambahan)
          console.log(nilai,payloadData)
          if(nilai != 0) {
            canProses = false
            this.alert = {
              show: true,
              msg: 'Nilai setoran tambahan tidak sesuai',
            };
          } else {
            canProses = true
          }
        }
        if(canProses){
          for (let key in payloadData) {
            payload.append(key, payloadData[key]);
          }
          try {
            let req = await services.anggotaKeluar(payload, this.user.token);
            if (req.status === 200) {
              if(req.data.status){
                this.alert = {
                  show: true,
                  msg: "Registrasi Anggota Keluar Berhasil",
                };
                setTimeout(() => {
                  this.$router.push(`/keanggotaan`);
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
                msg: "Registrasi Anggota Keluar Gagal",
              };
            }
          } catch (error) {
            this.alert = {
              show: true,
              msg: error,
            };
          }
        }
      } else {
        this.alert = {
          show: true,
          msg: 'Anggota belum dipilih',
        };
      }
    },
  },
  mounted() {
    this.getRembug();
  },
};
</script>
