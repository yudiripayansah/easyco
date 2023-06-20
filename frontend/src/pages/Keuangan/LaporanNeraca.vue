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
            <b-col cols="10" class="mb-5 justify-content-between d-flex">
              <div class="row">
                <b-col cols="4">
                  <b-input-group prepend="Cabang" class="mb-3">
                    <b-form-select
                      v-model="paging.cabang"
                      :options="opt.cabang"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="3">
                  <b-input-group prepend="Jenis" class="mb-3">
                    <b-form-select
                      v-model="paging.jenis"
                      :options="opt.jenis"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="5">
                  <b-input-group prepend="Tanggal" class="mb-3">
                    <b-form-datepicker v-model="paging.tanggal" />
                  </b-input-group>
                </b-col>
              </div>
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
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>
  
<script>
import html2pdf from "html2pdf.js";
import helper from "@/core/helper";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";
import axios from "axios";
export default {
  name: "laporanNeraca",
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
      },
      opt: {
        perPage: [10, 25, 50, 100],
        cabang: [],
        jenis: [],
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
    this.doGetJenis();
  },
  methods: {
    ...helper,
    async exportPdf() {
      console.log(this.paging.jenis);
      const url = `https://easycop.kopsyahmsi.com/report/print_balance_sheet_pdf/${this.paging.cabang}/${this.paging.jenis}/${this.paging.tanggal}`;
      window.open(url, "_blank");
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
          this.opt.cabang = [
            {
              value: null,
              text: "All",
            },
          ];
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
    async doGetJenis() {
      let payload = {
        page: 1,
        perPage: "~",
        sortDir: "ASC",
        sortBy: "nama_kode",
        nama_kode: "report_code",
        search: "",
      };
      try {
        let req = await easycoApi.listkodeRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        console.log(req.data);
        if (status) {
          data.map((item) => {
            this.opt.jenis.push({
              value: item.kode_value,
              text: item.kode_display,
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
    