<template>
  <div class="bt-registrasi-anggota-masuk pa-5">
    <h6
      class="text-h5 font-weight-bold indigo--text text--lighten-1 d-flex align-center"
    >
      <div
        class="rounded-pill indigo lighten-1 me-2 px-2 d-flex align-center justify-center py-2 elevation-3"
      >
        <v-icon small color="white">mdi-account-multiple-check</v-icon>
      </div>
      Registrasi Calon Anggota
    </h6>
    <v-select solo label="Rembug" class="mb-3 mt-4" hide-details :items="opt.rembug" v-model="form.data.kode_rembug"/>
    <v-container class="pa-0">
      <div class="bt-page-indicator d-flex justify-space-between pt-3">
        <span
          class="d-flex align-center justify-center elevation-3 rounded-circle"
          :class="
            step == 1
              ? 'indigo lighten-1 white--text text--darken-1'
              : 'indigo lighten-5 indigo--text text--darken-1'
          "
        >
          1
        </span>
        <span
          class="d-flex align-center justify-center elevation-3 rounded-circle"
          :class="
            step == 2
              ? 'indigo lighten-1 white--text text--darken-1'
              : 'indigo lighten-5 indigo--text text--darken-1'
          "
        >
          2
        </span>
        <span
          class="d-flex align-center justify-center elevation-3 rounded-circle"
          :class="
            step == 3
              ? 'indigo lighten-1 white--text text--darken-1'
              : 'indigo lighten-5 indigo--text text--darken-1'
          "
        >
          3
        </span>
        <span
          class="d-flex align-center justify-center elevation-3 rounded-circle"
          :class="
            step == 4
              ? 'indigo lighten-1 white--text text--darken-1'
              : 'indigo lighten-5 indigo--text text--darken-1'
          "
        >
          4
        </span>
        <span
          class="d-flex align-center justify-center elevation-3 rounded-circle"
          :class="
            step == 5
              ? 'indigo lighten-1 white--text text--darken-1'
              : 'indigo lighten-5 indigo--text text--darken-1'
          "
        >
          5
        </span>
      </div>
      <div class="bt-page-steps d-flex pt-5 pb-3">
        <div class="bt-page-step-item" v-show="step == 1">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Data Pribadi</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.nama_anggota"
                  label="Nama Lengkap"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Jenis Kelamin"
                  hide-details
                  :items="opt.jenis_kelamin"
                  v-model="form.data.jenis_kelamin"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.ibu_kandung"
                  label="Ibu Kandung"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.tempat_lahir"
                  label="Tempat Lahir"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.tgl_lahir"
                  label="Tanggal Lahir"
                  type="date"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.no_ktp"
                  label="No KTP"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.no_telp"
                  label="No Telp/ HP"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Pendidikan"
                  hide-details
                  :items="opt.pendidikan"
                  v-model="form.data.pendidikan"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Pekerjaan"
                  hide-details
                  :items="opt.pekerjaan"
                  v-model="form.data.pekerjaan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.ket_pekerjaan"
                  label="Keterangan Pekerjaan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.jml_anak"
                  label="Jumlah Anak"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.jml_tanggungan"
                  label="Jumlah Tanggungan"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Status Pernikahan"
                  hide-details
                  :items="opt.status_perkawinan"
                  v-model="form.data.status_perkawinan"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
        <div class="bt-page-step-item" v-show="step == 2">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Data Pasangan</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.p_nama"
                  label="Nama"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.p_tmplahir"
                  label="Tempat Lahir"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.p_tgllahir"
                  label="Tanggal Lahir"
                  type="date"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.p_noktp"
                  label="No KTP"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.p_nohp"
                  label="No Telp/ HP"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Pendidikan"
                  hide-details
                  :items="opt.pendidikan"
                  v-model="form.data.p_pendidikan"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Pekerjaan"
                  hide-details
                  :items="opt.pekerjaan"
                  v-model="form.data.p_pekerjaan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.p_ketpekerjaan"
                  label="Keterangan Pekerjaan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.p_pendapatan"
                  label="Pendapatan"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
        <div class="bt-page-step-item" v-show="step == 3">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Alamat Sesuai KTP</h6>
            <v-row>
              <v-col cols="12">
                <v-textarea
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.alamat"
                  label="Alamat"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.desa"
                  label="Desa"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.kecamatan"
                  label="Kecamatan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.kabupaten"
                  label="Kabupaten"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.kodepos"
                  label="Kode Pos"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
        <div class="bt-page-step-item" v-show="step == 4">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Assets Rumah Tangga</h6>
            <h6 class="text-h6 font-weight-bold mb-4">Rumah</h6>
            <v-row>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Status"
                  hide-details
                  :items="opt.rumah_status"
                  v-model="form.data.rumah_status"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Ukuran"
                  hide-details
                  :items="opt.rumah_ukuran"
                  v-model="form.data.rumah_ukuran"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Atap"
                  hide-details
                  :items="opt.rumah_atap"
                  v-model="form.data.rumah_atap"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Dinding"
                  hide-details
                  :items="opt.rumah_dinding"
                  v-model="form.data.rumah_dinding"
                />
              </v-col>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Lantai"
                  hide-details
                  :items="opt.rumah_lantai"
                  v-model="form.data.rumah_lantai"
                />
              </v-col>
            </v-row>
            <h6 class="text-h6 font-weight-bold mb-4 mt-4">Ternak</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.ternak_sapi"
                  label="Sapi"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.ternak_domba"
                  label="Domba"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.ternak_unggas"
                  label="Unggas"
                />
              </v-col>
            </v-row>
            <h6 class="text-h6 font-weight-bold mb-4 mt-4">Elektronik</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.elc_kulkas"
                  label="Kulkas"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.elc_hp"
                  label="HP"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.elc_tv"
                  label="TV"
                />
              </v-col>
            </v-row>
            <h6 class="text-h6 font-weight-bold mb-4 mt-4">Kendaraan</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.kend_sepeda"
                  label="Sepeda"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.kend_motor"
                  label="Motor"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
        <div class="bt-page-step-item" v-show="step == 5">
          <v-card class="white elevation-3 rounded-lg pa-3 mb-3">
            <h6 class="text-h6 font-weight-bold mb-4">Pendapatan</h6>
            <v-row>
              <v-col cols="12">
                <v-select
                  color="black"
                  outlined
                  label="Usaha"
                  hide-details
                  :items="opt.ush_rumahtangga"
                  v-model="form.data.ush_rumahtangga"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.ush_komoditi"
                  label="Komoditi Usaha"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.ush_lokasi"
                  label="Lokasi"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.ush_omset"
                  label="Omset"
                />
              </v-col>
            </v-row>
            <h6 class="text-h6 font-weight-bold mb-4 mt-4">Pengeluaran</h6>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.by_beras"
                  label="Beras"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.by_dapur"
                  label="Dapur"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.by_listrik"
                  label="Listrik"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.by_telpon"
                  label="Telpon"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.by_sekolah"
                  label="Pendidikan"
                />
              </v-col>
              <v-col cols="12">
                <v-text-field
                  color="black"
                  autocomplete="off"
                  hide-details
                  outlined
                  v-model="form.data.by_lain"
                  label="Lainnya"
                />
              </v-col>
            </v-row>
          </v-card>
        </div>
      </div>
      <v-row>
        <v-col cols="6" class="pb-0" v-show="step > 1">
          <v-btn
            block
            class="indigo lighten-1 white--text"
            @click="move(step - 1)"
          >
            Sebelumnya
          </v-btn>
        </v-col>
        <v-col :cols="step > 1 ? 6 : 12" class="pb-0">
          <v-btn
            block
            class="indigo lighten-1 white--text"
            @click="move(step + 1)"
          >
            {{ step == 5 ? "Simpan" : "Selanjutnya" }}
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
import helper from "@/utils/helper";
import Toast from "@/components/Toast";
import { mapGetters, mapActions } from "vuex";
import services from "@/services";
export default {
  name: "Keangotaan",
  components: {
    Toast
  },
  data() {
    return {
      form: {
        data: {
          kode_cabang: null,
          kode_rembug: null,
          nama_anggota: "AMINAH",
          jenis_kelamin: "W",
          ibu_kandung: "IBU AMINAH",
          tempat_lahir: "PEKALONGAN",
          tgl_lahir: null,
          alamat: "JL KU",
          desa: "DESAKU",
          kecamatan: "KCMKU",
          kabupaten: "TANGERANG",
          kodepos: "16610",
          no_ktp: "3215000000000004",
          no_npwp: "0",
          no_telp: "0815",
          pendidikan: 3,
          status_perkawinan: 1,
          nama_pasangan: "AMIN",
          pekerjaan: 5,
          ket_pekerjaan: "BURUH",
          pendapatan_perbulan: 1000000,
          tgl_gabung: null,
          created_by: null,
          p_nama: "PAS AMINAH",
          p_tmplahir: "BOGOR",
          p_tgllahir: null,
          usia: 30,
          p_noktp: "327104010119920001",
          p_nohp: "0812",
          p_pendidikan: 3,
          p_pekerjaan: 1,
          p_ketpekerjaan: "KARYAWAN",
          p_pendapatan: 300000,
          jml_anak: 0,
          jml_tanggungan: 1,
          rumah_status: 1,
          rumah_ukuran: 1,
          rumah_atap: 1,
          rumah_dinding: 1,
          rumah_lantai: 3,
          rumah_jamban: 3,
          rumah_air: 1,
          lahan_sawah: 0,
          lahan_kebun: 0,
          lahan_pekarangan: 0,
          ternak_sapi: 0,
          ternak_domba: 0,
          ternak_unggas: 0,
          elc_kulkas: 1,
          elc_tv: 1,
          elc_hp: 1,
          kend_sepeda: 0,
          kend_motor: 1,
          ush_rumahtangga: 1,
          ush_komoditi: "Warung Sembako",
          ush_lokasi: "Di rumah",
          ush_omset: 5000000,
          by_beras: 200000,
          by_dapur: 500000,
          by_listrik: 200000,
          by_telpon: 100000,
          by_sekolah: 0,
          by_lain: 0,
        },
      },
      opt: {
        jenis_kelamin: [
          { value: "P", text: "Pria" },
          { value: "W", text: "Wanita" },
        ],
        pendidikan: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "SD / MI" },
          { value: 2, text: "SMP / MTs" },
          { value: 3, text: "SMK / SMA / MA" },
          { value: 4, text: "D1" },
          { value: 5, text: "D2" },
          { value: 6, text: "D3" },
          { value: 7, text: "S1" },
          { value: 8, text: "S2" },
          { value: 9, text: "S3" },
        ],
        status_perkawinan: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Sudah" },
          { value: 2, text: "Belum" },
        ],
        pekerjaan: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Ibu Rumah Tangga" },
          { value: 2, text: "Buruh" },
          { value: 3, text: "Petani" },
          { value: 4, text: "Pedagang" },
          { value: 5, text: "Wiraswasta" },
          { value: 6, text: "Karyawan Swasta" },
          { value: 7, text: "Pegawai Negeri Sipil" },
        ],
        rumah_status: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Rumah Sendiri" },
          { value: 2, text: "Sewa" },
          { value: 3, text: "Numpang" },
        ],
        rumah_ukuran: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Kecil" },
          { value: 2, text: "Besar" },
          { value: 3, text: "Sedang" },
        ],
        rumah_atap: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Genteng" },
          { value: 2, text: "Asbes" },
          { value: 3, text: "Rumbia" },
        ],
        rumah_dinding: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Tembok" },
          { value: 2, text: "Semi Tembok" },
          { value: 3, text: "Papan" },
          { value: 4, text: "Bambu" },
        ],
        rumah_lantai: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Tanah" },
          { value: 2, text: "Semen" },
          { value: 3, text: "Keramik" },
        ],
        rumah_jamban: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Sungai" },
          { value: 2, text: "Jamban Terbuka" },
          { value: 3, text: "WC" },
        ],
        rumah_air: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Sumur Sendiri" },
          { value: 2, text: "Sumur Bersama" },
          { value: 3, text: "Sungai" },
          { value: 4, text: "PDAM / PAMSIMAS" },
        ],
        ush_rumahtangga: [
          { value: 0, text: "Tidak Diketahui" },
          { value: 1, text: "Perdagangan" },
          { value: 2, text: "Pertanian" },
          { value: 3, text: "Industri Pengolahan" },
          { value: 4, text: "Jasa" },
          { value: 5, text: "Karyawan" },
          { value: 6, text: "Perikanan" },
          { value: 99, text: "Lainnya" },
        ],
        rembug: []
      },
      step: 1,
      alert: {
        show: false,
        msg: ''
      },
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  methods: {
    ...helper,
    setForm(){
      this.form.data.created_by = this.user.id
      this.form.data.kode_cabang = this.user.kode_cabang
      this.form.data.tgl_gabung = this.today()
      console.log(this.form.data.tgl_gabung)
      this.getRembug()
    },
    move(step) {
      if (step > 5) {
        this.doRegisterAnggota();
      } else {
        this.step = step;
        window.scrollTo(0, 0);
      }
    },
    async getRembug() {
      let day = new Date().getDay();
      day = 1;
      let payload = new FormData();
      payload.append("kode_petugas", this.user.kode_petugas);
      payload.append("hari_transaksi", day);
      try {
        let req = await services.infoRembug(payload, this.user.token);
        if (req.status === 200) {
          let { data } = req.data;
          this.opt.rembug = [];
          data.map((rembug, index) => {
            this.opt.rembug.push({
              text: rembug.nama_rembug,
              value: rembug.kode_rembug,
            });
          });
        } else {
          this.alert = {
            show: true,
            msg: data.message,
          };
        }
      } catch (error) {
        this.alert = {
          show: true,
          msg: `Error on get rembug ${error}`,
        };
      }
    },
    async doRegisterAnggota() {
      let payload = new FormData();
      let payloadData = this.form.data;
      if(this.form.data.kode_cabang && this.form.data.kode_rembug){
        for (let key in payloadData) {
          payload.append(key, payloadData[key]);
        }
        try {
          let req = await services.anggotaCreate(payload, this.user.token);
          if (req.status === 200) {
            this.alert = {
              show: true,
              msg: "Regis Anggota Berhasil",
            };
            setTimeout(() => {
              this.$router.push(`/keanggotaan/dashboard`);
            }, 2000);
          } else {
            this.alert = {
              show: true,
              msg: "Regis Anggota Gagal",
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
          msg: 'Silahkan pilih Rembug',
        };
      }
    },
  },
  mounted() {
    this.setForm()
  }
};
</script>
