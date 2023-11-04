<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>

    <b-overlay :show="showOverlay" rounded="sm">
      <b-card>
        <b-row>
          <b-col md="6" offset-md="3">
            <b-form @submit="onSubmit" @reset="onReset">
              <b-form-group id="input-group-no-kode_cabang" label="Cabang: *" label-for="input-group-no-kode_cabang">
                <b-form-select id="input-group-no-kode_cabang" :options="opt.kode_cabang" v-model="form.kode_cabang"
                  @change="doGetMajelis()" required></b-form-select>
              </b-form-group>
              <b-form-group id="input-group-kode-rembug" label="Majelis: *" label-for="input-group-kode-rembug">
                <b-form-select id="input-group-kode-rembug" :options="opt.kode_rembug" v-model="form.kode_rembug"
                  @change="doGetAnggota()" required></b-form-select>
              </b-form-group>
              <b-form-group id="input-group-no-rekening" label="Anggota: *" label-for="input-group-no-rekening">
                <b-form-select id="input-group-no-rekening" :options="opt.no_anggota" v-model="form.no_anggota"
                  @change="doGetRekening()" required></b-form-select>
              </b-form-group>
              <b-form-group id="input-group-no-rekening" label="No Rekening: *" label-for="input-group-no-rekening">
                <b-form-select id="input-group-no-rekening" :options="opt.no_rekening" v-model="form.no_rekening"
                  @change="doGetRekeningDetail()" required></b-form-select>
              </b-form-group>
              <b-form-group id="input-group-nama-anggota" label="Nama Anggota:" label-for="input-nama-anggota">
                <b-form-input id="input-nama-anggota" v-model="form.nama_anggota" disabled></b-form-input>
              </b-form-group>
              <b-form-group id="input-group-produk" label="Produk:" label-for="input-produk">
                <b-form-input id="input-produk" v-model="form.nama_produk" disabled></b-form-input>
              </b-form-group>
              <b-form-group id="input-group-saldo-efektif" label="Saldo Efektif:" label-for="input-saldo-efektif">
                <b-form-input id="input-saldo-efektif" v-model="form.saldo" class="text-right" disabled></b-form-input>
              </b-form-group>
              <hr>
              <b-form-group id="input-group-tanggal-transaksi" label="Tanggal Transaksi: *"
                label-for="input-tanggal-transaksi">
                <b-form-datepicker v-model="form.trx_date" required />
              </b-form-group>
              <b-form-group id="input-group-jumlah-pinbuk" label="Jumlah Pinbuk: *" label-for="input-jumlah-pinbuk">
                <b-form-input type="number" id="input-jumlah-pinbuk" v-model="form.amount" class="text-right"
                  required></b-form-input>
              </b-form-group>
              <dir class="d-flex justify-content-end border-top pt-5">
                <b-button type="submit" variant="primary">Submit</b-button>
                <b-button type="reset" variant="danger" class="ml-1">Reset</b-button>
              </dir>
            </b-form>
          </b-col>
        </b-row>
      </b-card>
    </b-overlay>

  </div>
</template>

<script>
import helper from "@/core/helper";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";

export default {
  name: "TabunganPinBukSaldoTabunganSukarela",
  components: {
  },
  data() {
    return {
      form: {
        kode_cabang: null,
        kode_rembug: null,
        no_anggota: null,
        no_rekening: null,
        nama_anggota: '',
        nama_produk: '',
        saldo: 0,
        trx_date: null,
        amount: 0,
      },
      opt: {
        kode_cabang: [
          {
            value: null,
            text: "All",
          },
        ],
        kode_rembug: [
          {
            value: null,
            text: "All",
          },
        ],
        no_anggota: [
          {
            value: null,
            text: "All",
          },
        ],
        no_rekening: [
          {
            value: null,
            text: "All",
          },
        ],
      },
      showOverlay: false,
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  mounted() {
    this.doGetCabang();
  },
  methods: {
    ...helper,
    async doGetCabang() {
      this.showOverlay = true;
      const payload = {
        perPage: "~",
        page: 1,
        sortBy: "nama_cabang",
        sortDir: "ASC",
        search: "",
      };
      try {
        let req = await easycoApi.cabangRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.kode_cabang = [
            {
              value: null,
              text: "All",
            },
          ];
          data.map((item) => {
            this.opt.kode_cabang.push({
              value: item.kode_cabang,
              text: item.nama_cabang,
            });
          });
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.showOverlay = false;
      }
    },
    async doGetMajelis() {
      this.showOverlay = true;
      // reset value
      this.opt.no_anggota = [
        {
          value: null,
          text: "All",
        },
      ];
      this.opt.no_rekening = [
        {
          value: null,
          text: "All",
        },
      ];

      const payload = {
        perPage: "~",
        page: 1,
        sortBy: "kode_rembug",
        sortDir: "ASC",
        search: "",
        kode_cabang: this.form.kode_cabang,
      };
      try {
        let req = await easycoApi.rembugRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.kode_rembug = [
            {
              value: null,
              text: "All",
            },
          ];
          data.map((item) => {
            this.opt.kode_rembug.push({
              value: item.kode_rembug,
              text: item.nama_rembug,
            });
          });
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.showOverlay = false;
      }
    },
    async doGetAnggota() {
      this.showOverlay = true;
      // reset value
      this.opt.no_rekening = [
        {
          value: null,
          text: "All",
        },
      ];

      const payload = {
        perPage: "~",
        page: 1,
        sortBy: "kode_rembug",
        sortDir: "ASC",
        search: "",
        cabang: this.form.kode_cabang,
        rembug: this.form.kode_rembug,
      };
      try {
        let req = await easycoApi.anggotaRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.no_anggota = [
            {
              value: null,
              text: "All",
            },
          ];
          data.map((item) => {
            this.opt.no_anggota.push({
              value: item.no_anggota,
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
      } finally {
        this.showOverlay = false;
      }
    },
    async doGetRekening() {
      this.showOverlay = true;

      this.opt.no_rekening = [
        {
          value: null,
          text: "All",
        },
      ];
      const payload = {
        no_anggota: this.form.no_anggota,
      };
      try {
        let req = await easycoApi.getRekeningTabungan(payload, this.user.token);
        let { data, msg } = req.data;
        if (data.length > 0) {
          this.opt.no_rekening = [
            {
              value: null,
              text: "All",
            },
          ];
          data.map((item) => {
            this.opt.no_rekening.push({
              value: item.no_rekening,
              text: item.no_rekening,
              data: item,
            });
          });
        } else {
          this.notify("danger", "Error", msg);
        }
      } catch (error) {
        console.error(error);
        this.notify("danger", "Login Error", error);
      } finally {
        this.showOverlay = false;
      }
    },
    async doGetRekeningDetail() {
      this.form.nama_anggota = '';
      this.form.nama_produk = '';
      this.form.saldo = 0;
      this.form.trx_date = null;
      this.form.amount = 0;

      this.showOverlay = true;
      try {
        let payload = `no_rekening=${this.form.no_rekening}`;
        let req = await easycoApi.getDetailSaving(payload, this.user.token);
        let { data, msg } = req.data;
        if (data) {
          this.form.no_rekening = data.no_rekening || '';
          this.form.nama_anggota = data.nama_anggota || '';
          this.form.nama_produk = data.nama_produk || '';
          this.form.saldo = this.numberFormat(data.saldo, 0) || '';
        } else {
          this.notify("danger", "Error", msg);
        }
      } catch (error) {
        console.error(error);
        this.notify("danger", "Login Error", error);
      } finally {
        this.showOverlay = false;
      }
    },
    notify(type, title, msg) {
      this.$bvToast.toast(msg, {
        title: title,
        autoHideDelay: 5000,
        variant: type,
        toaster: "b-toaster-bottom-right",
        appendToast: true,
      });
    },
    formReset() {
      this.form.kode_cabang = null;
      this.form.kode_rembug = null;
      this.form.no_anggota = null;
      this.form.no_rekening = null;
      this.form.nama_anggota = '';
      this.form.nama_produk = '';
      this.form.saldo = 0;
      this.form.trx_date = null;
      this.form.amount = 0;
    },
    async onSubmit(event) {
      event.preventDefault()
      this.showOverlay = true;

      const isDataValid = this.areAllFieldsNotEmpty(this.form);
      if (!isDataValid) {
        this.notify("info", "Info", "Some fields are null or empty.");
        this.showOverlay = false;
        return false;
      }

      try {
        let payload = this.form;
        let req = await easycoApi.trxRembugProcessPinbukSimsuk(payload, this.user.token);
        let { data, status, msg } = req.data;

        console.log({ rd: req.data });

        if (status) {
          this.notify('success', 'Success', msg)

          // Reset our form values
          this.formReset();
        } else {
          this.notify("danger", "Error", msg);
        }
      } catch (error) {
        console.error(error);
        this.notify("danger", "Error Sumbit", error);
      } finally {
        this.showOverlay = false
      }
    },
    onReset(event) {
      event.preventDefault()
      // Reset our form values
      this.formReset();

      // Trick to reset/clear native browser form validation state
      this.showOverlay = true
      this.$nextTick(() => {
        this.showOverlay = false
      })
    },
  }
};
</script>