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
                <b-col cols="6">
                  <b-input-group prepend="Cabang" class="mb-3">
                    <b-form-select
                      v-model="paging.cabang"
                      :options="opt.cabang"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="6">
                  <b-input-group prepend="No Akun" class="mb-3">
                    <b-form-select v-model="paging.gl" :options="opt.gl" />
                  </b-input-group>
                </b-col>
                <b-col>
                  <b-input-group prepend="Dari Tanggal">
                    <b-form-datepicker v-model="paging.from_date" />
                  </b-input-group>
                </b-col>
                <b-col>
                  <b-input-group prepend="Sampai Tanggal">
                    <b-form-datepicker v-model="paging.thru_date" />
                  </b-input-group>
                </b-col>
              </div>
            </b-col>
            <b-col
              cols="4"
              class="d-flex justify-content-end align-items-start"
            >
              <b-button-group>
                <b-button
                  text="Button"
                  variant="danger"
                  @click="
                    $bvModal.show('modal-pdf');
                    doGetReport();
                  "
                >
                  PDF
                </b-button>
                <b-button text="Button" variant="success" @click="exportXls()">
                  XLS
                </b-button>
                <b-button text="Button" variant="warning" @click="exportCsv()">
                  CSV
                </b-button>
              </b-button-group>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12">
          <b-table
            responsive
            bordered
            outlined
            small
            striped
            hover
            :fields="table.fields"
            :items="table.items"
            show-empty
            :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'"
          >
            <template #cell(no)="item">
              {{ item.index + 1 }}
            </template>
          </b-table>
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
          <b-pagination
            v-model="paging.page"
            :total-rows="table.totalRows"
            :per-page="paging.perPage"
          >
          </b-pagination>
        </b-col>
      </b-row>
    </b-card>
    <b-modal
      title="PREVIEW LAPORAN BUKU BESAR"
      id="modal-pdf"
      hide-footer
      size="xl"
      centered
    >
      <div id="table-print" class="p-5">
        <h5 class="text-center">
          KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
        </h5>
        <h5 class="text-center">LAPORAN BUKU BESAR</h5>
        <h5 class="text-center" v-show="report.cabang">{{ report.cabang }}</h5>
        <h6
          class="text-center mb-5 pb-5"
          v-show="report.from_date && report.thru_date"
        >
          Tanggal {{ dateFormatId(report.from_date) }} s.d
          {{ dateFormatId(report.thru_date) }}
        </h6>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th rowspan="2">No</th>
              <th rowspan="2">Tgl Transaksi</th>
              <th rowspan="2">Keterangan</th>
              <th rowspan="2">Debet</th>
              <th rowspan="2">Credit</th>
              <th rowspan="2">Saldo Akhir</th>
            </tr>
          </thead>
          <tbody v-if="report.items.length > 0">
            <tr
              v-for="(report, reportIndex) in report.items"
              :key="`report-${reportIndex}`"
            >
              <td>{{ reportIndex + 1 }}</td>
              <td>{{ report.trx_date }}</td>
              <td>{{ report.description }}</td>
              <td>Rp {{ thousand(report.debet) }}</td>
              <td>Rp {{ thousand(report.credit) }}</td>
              <td>Rp {{ thousand(report.saldo_akhir) }}</td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr class="text-center">
              <td colspan="12">There's no data to display...</td>
            </tr>
          </tbody>
        </table>
      </div>
      <b-row>
        <b-col
          cols="12"
          sm="12"
          class="d-flex justify-content-end border-top pt-5"
        >
          <b-button variant="secondary" @click="$bvModal.hide('modal-pdf')"
            >Cancel
          </b-button>
          <b-button
            variant="danger"
            type="button"
            class="ml-3"
            @click="doPrintPdf()"
          >
            Cetak PDF
          </b-button>
          <b-button
            variant="warning"
            type="button"
            class="ml-3"
            @click="doSavePdf()"
          >
            Simpan PDF
          </b-button>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>
  
<script>
import helper from "@/core/helper";
import html2pdf from "html2pdf.js";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";
export default {
  name: "LaporanBukuBesar",
  components: {},
  data() {
    return {
      table: {
        fields: [
          {
            key: "trx_date",
            sortable: true,
            label: "Tanggal",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "description",
            sortable: true,
            label: "Keterangan",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "debet",
            sortable: true,
            label: "Debet",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "credit",
            sortable: true,
            label: "Credit",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "saldo_akhir",
            sortable: true,
            label: "Saldo Akhir",
            thClass: "text-center",
            tdClass: "",
          },
        ],
        items: [],
        loading: false,
      },
      report: {
        fields: [
          {
            key: "trx_date",
            sortable: true,
            label: "Tanggal",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "description",
            sortable: true,
            label: "Keterangan",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "debet",
            sortable: true,
            label: "Debet",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "credit",
            sortable: true,
            label: "Credit",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "saldo_akhir",
            sortable: true,
            label: "Saldo Akhir",
            thClass: "text-center",
            tdClass: "",
          },
        ],
        items: [],
        loading: false,
        totalRows: 0,
        cabang: null,
        from_date: null,
        thru_date: null,
      },
      paging: {
        page: 1,
        totalRows: 0,
        perPage: 10,
        cabang: null,
        gl: null,
        from_date: null,
        thru_date: null,
      },
      opt: {
        cabang: [],
        gl: [],
      },
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  watch: {
    paging: {
      handler() {
        this.doGet();
      },
      deep: true,
    },
  },
  mounted() {
    this.doGet();
    this.doGetCabang();
    this.doGetGl();
  },
  methods: {
    ...helper,
    async doGet() {
      let payload = {
        kode_cabang: this.paging.cabang,
        kode_gl: this.paging.gl,
        from: this.paging.from_date,
        thru: this.paging.thru_date,
      };
      if (
        payload.kode_cabang &&
        payload.kode_gl &&
        payload.from &&
        payload.thru
      ) {
        this.table.loading = true;
        try {
          let req = await easycoApi.laporanBukuBesar(payload, this.user.token);
          let { data, status, msg, total } = req.data;
          if (status) {
            this.table.items = data;
            this.table.totalRows = total;
          } else {
            this.notify("danger", "Error", msg);
          }
          this.table.loading = false;
        } catch (error) {
          this.table.loading = false;
          console.error(error);
          this.notify("danger", "Error", error);
        }
      }
    },
    doPrintPdf() {
      let filename = "LAPORAN BUKU BESAR";
      if (this.report.cabang) {
        filename += ` - Cabang ${this.report.cabang}`;
      }
      if (this.report.from_date && this.report.thru_date) {
        filename += ` - Dari ${this.dateFormatId(
          this.report.from_date
        )} Sampai ${this.dateFormatId(this.report.thru_date)}`;
      }
      let element = document.getElementById("table-print");
      let options = {
        margin: 0,
        filename: `${filename}.pdf`,
        jsPDF: {
          unit: "in",
          format: "a4",
          orientation: "portrait",
        },
      };
      html2pdf()
        .set(options)
        .from(element)
        .toPdf()
        .get("pdf")
        .then(function (pdf) {
          console.log("hi");
          window.open(pdf.output("bloburl"), "_blank");
        });
    },
    doSavePdf() {
      let filename = "Laporan Buku Besar";
      if (this.report.cabang) {
        filename += ` - Cabang ${this.report.cabang}`;
      }
      if (this.report.from_date && this.report.thru_date) {
        filename += ` - Dari ${this.dateFormatId(
          this.report.from_date
        )} Sampai ${this.dateFormatId(this.report.thru_date)}`;
      }

      html2pdf(document.getElementById("table-print"), {
        margin: 0,
        filename: `${filename}.pdf`,
        jsPDF: {
          unit: "in",
          format: "a4",
          orientation: "portrait",
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
    async doGetGl() {
      let payload = {
        perPage: "~",
        page: 1,
        sortBy: "kode_gl",
        sortDir: "ASC",
        search: "",
      };
      try {
        let req = await easycoApi.glRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          data.map((item) => {
            this.opt.gl.push({
              value: item.kode_gl,
              text: item.nama_gl,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async exportXls() {
      let payload = `kode_cabang=${this.paging.cabang}&kode_gl=${this.paging.gl}&from_date=${this.paging.from_date}&thru_date=${this.paging.thru_date}`;
      let req = await easycoApi.bukuBesarExcel(payload);
      console.log(req.data);
      const url = window.URL.createObjectURL(new Blob([req.data]));
      const link = document.createElement("a");
      let fileName = "Buku_Besar.xls";
      link.href = url;
      link.setAttribute("download", fileName);
      document.body.appendChild(link);
      link.click();
    },
    async exportCsv() {
      let payload = `kode_cabang=${this.paging.cabang}&kode_gl=${this.paging.gl}&from_date=${this.paging.from_date}&thru_date=${this.paging.thru_date}`;
      let req = await easycoApi.bukuBesarCsv(payload);
      console.log(req.data);
      const url = window.URL.createObjectURL(new Blob([req.data]));
      const link = document.createElement("a");
      let fileName = "Buku_Besar.csv";
      link.href = url;
      link.setAttribute("download", fileName);
      document.body.appendChild(link);
      link.click();
    },
    async doGetReport() {
      let payload = {
        kode_cabang: this.paging.cabang,
        kode_gl: this.paging.gl,
        from: this.paging.from_date,
        thru: this.paging.thru_date,
      };
      this.report.loading = true;
      this.report.from_date = payload.from;
      this.report.thru_date = payload.thru;
      this.report.cabang = this.getCabangName(payload.kode_cabang);
      try {
        let req = await easycoApi.laporanBukuBesar(payload, this.user.token);
        let { data, status, msg, total } = req.data;
        if (status) {
          this.report.items = data;
          this.report.totalRows = total;
        } else {
          this.notify("danger", "Error", msg);
        }
        this.report.loading = false;
      } catch (error) {
        this.report.loading = false;
        console.error(error);
        this.notify("danger", "Error", error);
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
    