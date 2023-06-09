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
            <b-col cols="8" class="mb-5">
              <div class="row">
                <b-col cols="4">
                  <b-input-group prepend="Cabang" class="mb-3">
                    <b-form-select
                      v-model="paging.cabang"
                      :options="opt.cabang"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="4">
                  <b-input-group prepend="Petugas" class="mb-3">
                    <b-form-select
                      v-model="paging.jenis"
                      :options="opt.jenis"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="4">
                  <b-input-group prepend="Tanggal">
                    <b-form-datepicker v-model="paging.tanggal" />
                  </b-input-group>
                </b-col>
              </div>
            </b-col>
            <b-col
              cols="4"
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
    this.doGet();
  },
  methods: {
    ...helper,
    async exportPdf() {
      let url = `https://easycop.kopikoding.com/report/print_balance_sheet_current_pdf/${this.paging.cabang}/${this.paging.jenis}/${this.paging.tanggal}`;
      let req = axios.get(url);
      var fileURL = window.URL.createObjectURL(
        new Blob([req.data], { type: "application/pdf" })
      );
      var fileLink = document.createElement("a");
      fileLink.href = fileURL;
      fileLink.setAttribute("download", "file.pdf");
      document.body.appendChild(fileLink);
      fileLink.click();
    },
    doSavePdf() {
      let filename = "LAPORAN TRANSAKSI REMBUG";
      if (this.report.cabang) {
        filename += ` - Cabang ${this.report.cabang}`;
      }
      if (this.report.from && this.report.to) {
        filename += ` - Dari ${this.dateFormatId(
          this.report.from
        )} Sampai ${this.dateFormatId(this.report.to)}`;
      }

      html2pdf(document.getElementById("table-print"), {
        margin: 0,
        filename: `${filename}.pdf`,
        jsPDF: {
          unit: "in",
          format: "a4",
          orientation: "landscape",
        },
      });
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
    