<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col
          cols="12"
          class="d-flex justify-content-end mb-5 pb-5 border-bottom"
        >
        </b-col>
        <b-col cols="12" class="mb-5">
          <b-row no-gutters>
            <b-col cols="10" class="mb-5 d-flex">
              <b-col cols="6">
                <b-input-group prepend="Cabang" class="mb-3">
                  <b-form-select
                    v-model="paging.cabang"
                    :options="opt.cabang"
                  />
                </b-input-group>
              </b-col>
              <b-col cols="6">
                <b-input-group prepend="Jenis" class="mb-3">
                  <b-form-select v-model="paging.jenis" :options="opt.jenis" />
                </b-input-group>
              </b-col>
            </b-col>
            <b-col
              cols="2"
              class="d-flex justify-content-end align-items-start"
            >
              <b-button-group>
                <b-button text="Button" variant="danger" @click="exportPdf()">
                  PDF
                </b-button>
                <b-button text="Button" variant="success" @click="exportXls()">
                  XLS
                </b-button>
              </b-button-group>
            </b-col>
          </b-row>
          <b-col cols="10" v-if="paging.jenis == '1'">
            <b-input-group prepend="Tanggal" class="mb-3">
              <b-form-datepicker v-model="paging.tanggal" />
            </b-input-group>
          </b-col>
          <b-col cols="10" v-if="paging.jenis == '2'">
            <b-input-group prepend="Tanggal" class="mb-3">
              <b-form-select
                v-model="paging.tanggal_bulan_lalu"
                :options="opt.tanggal_bulan_lalu"
              />
            </b-input-group>
          </b-col>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>
    
  <script>
import helper from "@/core/helper";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";
export default {
  name: "LaporanLabaRugi",
  components: {},
  data() {
    return {
      tabel: {
        items: [],
        loading: false,
      },
      paging: {
        cabang: null,
        jenis: null,
        tanggal: null,
        tanggal_bulan_lalu: null,
      },
      opt: {
        perPage: [10, 25, 50, 100],
        cabang: [],
        tanggal_bulan_lalu: [],
        jenis: [
          {
            value: 1,
            text: "Bulan Berjalan",
          },
          {
            value: 2,
            text: "Bulan lalu",
          },
        ],
      },
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  watch: {
    paging: {
      handler(val) {},
      deep: true,
    },
  },
  mounted() {
    this.doGetCabang();
    this.GetBulanLalu();
  },
  methods: {
    ...helper,
    async exportPdf() {
      // bulan berjalan
      if (this.paging.cabang && this.paging.tanggal) {
        const url = `https://easycop.kopikoding.com/report/print_profit_loss_current_pdf/${this.paging.cabang}/20/${this.paging.tanggal}`;
        window.open(url, "_blank");
      } else if (this.paging.cabang && this.paging.tanggal_bulan_lalu) {
        //bulan lalu
        const url = `https://easycop.kopikoding.com/report/print_profit_loss_pdf/${this.paging.cabang}/20/${this.paging.tanggal_bulan_lalu}`;
        window.open(url, "_blank");
      }
    },
    async exportXls() {
      // bulan berjalan
      if (this.paging.cabang && this.paging.tanggal) {
        const url = `https://easycop.kopikoding.com/report/print_profit_loss_current_xls/${this.paging.cabang}/20/${this.paging.tanggal}`;
        window.open(url, "_blank");
      } else if (this.paging.cabang && this.paging.tanggal_bulan_lalu) {
        //bulan lalu
        const url = `https://easycop.kopikoding.com/report/print_profit_loss_xls/${this.paging.cabang}/20/${this.paging.tanggal_bulan_lalu}`;
        window.open(url, "_blank");
      }
    },
    getCabangName(id) {
      if (id > 0) {
        let cabangName = this.opt.cabang.find((i) => i.value == id);
        if (cabangName) {
          console.log(cabangName.text);
          return cabangName.text;
        } else {
          return null;
        }
      } else {
        return null;
      }
    },
    async doGetCabang() {
      let payload = {
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
          this.opt.cabang = [];
          data.map((item) => {
            this.opt.cabang.push({
              value: item.kode_cabang,
              text: item.nama_cabang,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async GetBulanLalu() {
      let payload = null;
      try {
        let req = await easycoApi.closingDate(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.tanggal_bulan_lalu = [];
          data.map((item) => {
            this.opt.tanggal_bulan_lalu.push({
              value: item.thru_date_closing,
              text: item.thru_date_closing,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    doInfo(msg, title, variant) {
      this.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true,
        toaster: "b-toaster-bottom-right",
      });
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
  },
};
</script>
      