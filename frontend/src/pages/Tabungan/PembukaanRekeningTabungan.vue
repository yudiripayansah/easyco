<template>
  <b-card :title="$route.name">
    <b-form class="border-top py-5" @submit.prevent="doSave()">
      <b-row class="m-0">
        <b-col sm="12" md="12">
          <b-form-group label="Pilih Anggota">
            <b-select
              v-model="form.data.no_anggota"
              :options="opt.anggota"
              @change="doGetAnggota()"
            />
          </b-form-group>
        </b-col>
        <b-col sm="6" md="4">
          <b-form-group label="NIK Anggota">
            <b-form-input v-model="profil.nik" disabled />
          </b-form-group>
        </b-col>
        <b-col sm="6" md="4">
          <b-form-group label="Nama Anggota">
            <b-form-input v-model="profil.nama_anggota" disabled />
          </b-form-group>
        </b-col>
        <b-col sm="6" md="4">
          <b-form-group label="No Anggota">
            <b-form-input v-model="profil.no_anggota" disabled />
          </b-form-group>
        </b-col>
        <b-col sm="6" md="4">
          <b-form-group label="Produk">
            <b-select :options="opt.produk" />
          </b-form-group>
        </b-col>
        <b-col sm="6" md="4">
          <b-form-group label="Jenis Tabungan">
            <b-select :options="opt.produk" />
          </b-form-group>
        </b-col>
        <b-col sm="6" md="4">
          <b-form-group label="Jangka Waktu & Periode">
            <b-row>
              <b-col sm="3">
                <b-input />
              </b-col>
              <b-col sm="9" class="mt-3 mt-sm-0">
                <b-select :options="opt.periode" />
              </b-col>
            </b-row>
          </b-form-group>
        </b-col>
        <b-col sm="6" md="4">
          <b-form-group label="Jumlah Setoran">
            <b-input-group prepend="Rp">
              <b-input />
            </b-input-group>
          </b-form-group>
        </b-col>
        <b-col sm="6" md="4">
          <b-form-group label="Mulai Setoran">
            <b-form-datepicker
              :date-format-options="{
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
              }"
              locale="id"
            />
          </b-form-group>
        </b-col>
        <b-col sm="12" class="text-right border-top pt-5">
          <b-button variant="primary" :disabled="form.loading" type="submit">
            <b-spinner
              small
              label="Small Spinner"
              v-show="form.loading"
              class="mr-2"
            ></b-spinner>
            Simpan
          </b-button>
        </b-col>
      </b-row>
    </b-form>
  </b-card>
</template>

<script>
import axios from "@/core/plugins/axios";
export default {
  name: "PembukaanRekeningTabungan",
  components: {},
  data() {
    return {
      form: {
        data: {
          no_anggota: null,
          kode_produk: null,
          setoran: 0,
          periode_setoran: null,
          jangka_waktu: null,
          rencana_awal_setoran: null,
          jenis_tabungan: null,
          created_by: null,
        },
      },
      opt: {
        periode: [
          {
            text: "Harian",
            value: "0",
          },
          {
            text: "Mingguan",
            value: "1",
          },
          {
            text: "Bulanan",
            value: "2",
          },
        ],
        produk: [],
        anggota: [],
      },
      profil: {
        nik: null,
        nama_anggota: null,
        no_anggota: null,
      },
    };
  },
  mounted() {},
  methods: {
    doSave() {
      let vm = this;
      this.form.loading = true;
      setTimeout(() => {
        vm.form.loading = false;
      }, 5000);
    },
    async doGetAnggota() {
      let payload = null;
      try {
        let req = await easycoApi.anggotaRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          data.map((item) => {
            this.opt.anggota.push({
              value: Number(item.no_anggota),
              text: item.nama_anggota,
              data: item,
            });
          });
        } else {
          this.notify("danger", "Error", msg);
        }
      } catch (error) {
        console.error(error);
        this.notify("danger", "Login Error", error);
      }
    },
  },
};
</script>
