<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-overlay :show="showOverlay" rounded="sm">
      <b-card>
        <b-row no-gutters>
          <b-col cols="10" class="mb-5">
            <div class="row mb-3">
              <b-col>
                <b-input-group prepend="Cabang">
                  <b-form-select v-model="paging.kode_cabang" :options="opt.kode_cabang" />
                </b-input-group>
              </b-col>
              <b-col>
                <b-input-group prepend="Tanggal">
                  <b-form-datepicker v-model="paging.tanggal" />
                </b-input-group>
              </b-col>
            </div>
          </b-col>
          <b-col cols="2" class="d-flex justify-content-end align-items-start">
            <b-button-group>
              <b-button text="Button" variant="danger" @click="$bvModal.show('modal-pdf'); doGetReport();">PDF</b-button>
              <b-button text="Button" variant="success" @click="exportXls()">XLS</b-button>
              <b-button text="Button" variant="warning" @click="exportCsv()">CSV</b-button>
            </b-button-group>
          </b-col>
          <b-col cols="12">
            <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
              :per-page="paging.perPage" :current-page="paging.currentPage" show-empty
              :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
              <template #cell(no)="item">
                {{ item.index + 1 }}
              </template>
            </b-table>
          </b-col>
          <b-col cols="12" class="justify-content-end d-flex">
            <b-pagination v-model="paging.currentPage" :total-rows="table.totalRows" :per-page="paging.perPage"
              aria-controls="my-table"></b-pagination>
          </b-col>
          <b-col md="3" offset-md="9">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col" class="bold">Keterangan</th>
                  <th scope="col" class="bold">Saldo</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td scope="row" class="col-md-5">Total Saldo Awal</td>
                  <td class="text-right">{{ total_saldo_awal }}</td>
                </tr>
                <tr>
                  <td scope="row">Total Saldo Akhir</td>
                  <td class="text-right">{{ total_saldo_akhir }}</td>
                </tr>
              </tbody>
            </table>
          </b-col>
        </b-row>
      </b-card>
    </b-overlay>

    <b-modal title="PREVIEW SALDO KAS PETUGAS" id="modal-pdf" hide-footer size="xl" centered>
      <div id="table-print" class="p-5">
        <h5 class="text-center">
          KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
        </h5>
        <h5 class="text-center">SALDO KAS PETUGAS</h5>
        <h5 class="text-center" v-show="paging.nama_cabang">Cabang: {{ paging.nama_cabang }}</h5>
        <h5 class="text-center" v-show="paging.tanggal">Tanggal: {{ this.dateFormatId(paging.tanggal) }}</h5>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th v-for="table in table.fields" :key="table.key" :class="table.thClass">{{ table.label }}
                </th>
              </tr>
            </thead>
            <tbody v-if="table.loading">
              <tr class="text-center">
                <td>Memuat data...</td>
              </tr>
            </tbody>
            <tbody v-if="table && table.items && table.items.length > 0">
              <tr v-for="(table, tableIndex) in table.items" :key="`table-${tableIndex}`">
                <td class="text-center">{{ tableIndex + 1 }}</td>
                <td class="text-center">{{ table.kode_kas_petugas }}</td>
                <td class="text-left">{{ table.nama_kas_petugas }}</td>
                <td class="text-right">{{ table.saldo_awal }}</td>
                <td class="text-right">{{ table.mutasi_debet }}</td>
                <td class="text-right">{{ table.mutasi_credit }}</td>
                <td class="text-right">{{ table.saldo_akhir }}</td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr class="text-center">
                <td :colspan="table.fields.length">There's no data to display...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <b-row>
        <b-col cols="12" sm="12" class="d-flex justify-content-end border-top pt-5">
          <b-button variant="secondary" @click="$bvModal.hide('modal-pdf')">Cancel
          </b-button>
          <b-button variant="danger" type="button" class="ml-3" @click="doPrintPdf()">
            Cetak PDF
          </b-button>
          <b-button variant="warning" type="button" class="ml-3" @click="doSavePdf()">
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
  name: "LaporanSaldoKasPetugas",
  components: {},
  data() {
    return {
      table: {
        fields: [
          {
            key: "no",
            sortable: false,
            label: "No",
            thClass: "text-center w-5p",
            tdClass: "text-center",
          },
          {
            key: "kode_kas_petugas",
            sortable: true,
            label: "Kode Petugas",
            thClass: "text-center",
            tdClass: "text-center",
          },
          {
            key: "nama_kas_petugas",
            sortable: true,
            label: "Nama Petugas",
            thClass: "text-center",
            tdClass: "text-left",
          },
          {
            key: "saldo_awal",
            sortable: true,
            label: "Saldo Awal",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "mutasi_debet",
            sortable: true,
            label: "Mutasi Debet",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "mutasi_credit",
            sortable: true,
            label: "Mutasi Credit",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "saldo_akhir",
            sortable: true,
            label: "Saldo Akhir",
            thClass: "text-center",
            tdClass: "text-right",
          },
        ],
        items: [],
        loading: false,
        totalRows: 0,
      },
      paging: {
        currentPage: 1,
        page: 1,
        perPage: 10,
        sortDesc: true,
        sortBy: "id",
        search: "",
        status: "~",
        kode_cabang: '',
        tanggal: '',
      },
      opt: {
        kode_cabang: [
          {
            value: '',
            text: "All",
          },
        ]
      },
      showOverlay: false,
      total_saldo_awal: 0,
      total_saldo_akhir: 0,
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  watch: {
    paging: {
      handler(val) {
        this.doGet();
      },
      deep: true,
    },
  },
  mounted() {
    // this.doGet();
    this.doGetCabang();
  },
  methods: {
    ...helper,
    getFileName() {
      const singleObjKodeCabang = this.opt.kode_cabang.find(item => item.value == this.paging.kode_cabang);
      let fileName = "SALDO KAS PETUGAS_";
      fileName += `Cabang-${(singleObjKodeCabang?.value != null ? singleObjKodeCabang?.text : '')}_`;
      fileName += `Tanggal-${this.paging.tanggal}`;
      return fileName;
    },
    doPrintPdf() {
      const fileName = this.getFileName();
      let element = document.getElementById("table-print");
      let options = {
        margin: 0,
        filename: `${fileName}.pdf`,
        scale: 0.75,
        jsPDF: {
          unit: "in",
          format: "a4",
          orientation: "landscape",
        },
      };
      html2pdf()
        .set(options)
        .from(element)
        .toPdf()
        .get("pdf")
        .then(function (pdf) {
          window.open(pdf.output("bloburl"), "_blank");
        });
    },
    doSavePdf() {
      const fileName = this.getFileName();
      html2pdf(document.getElementById("table-print"), {
        margin: 0,
        filename: `${fileName}.pdf`,
        jsPDF: {
          unit: "in",
          format: "a4",
          orientation: "landscape",
        },
      });
    },
    async exportXls() {
      this.showOverlay = true;
      const payload = `kode_cabang=${this.paging.kode_cabang}&tanggal=${this.paging.tanggal}`;
      const req = await easycoApi.listReportSaldoKasPetugasExportToXLSX(payload);
      const url = window.URL.createObjectURL(new Blob([req.data]));
      const link = document.createElement("a");
      const fileName = `${this.getFileName()}.xlsx`;
      link.href = url;
      link.setAttribute("download", fileName);
      document.body.appendChild(link);
      link.click();
      this.showOverlay = false;
    },
    async exportCsv() {
      this.showOverlay = true;
      const payload = `kode_cabang=${this.paging.kode_cabang}&tanggal=${this.paging.tanggal}`;
      const req = await easycoApi.listReportSaldoKasPetugasExportToCSV(payload);
      const url = window.URL.createObjectURL(new Blob([req.data]));
      const link = document.createElement("a");
      const fileName = `${this.getFileName()}.csv`;
      link.href = url;
      link.setAttribute("download", fileName);
      document.body.appendChild(link);
      link.click();
      this.showOverlay = false;
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
          this.opt.kode_cabang = [
            {
              value: '',
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
      }
    },
    async doGet() {
      this.showOverlay = true;

      let payload = this.paging;
      payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
      this.table.loading = true;
      try {
        let req = await easycoApi.listReportSaldoKasPetugas(payload, this.user.token);
        const {
          data,
          status,
          msg,
          // total,
          // totalPage,
          // perPage,
          // page,
          total_saldo_awal = 0,
          total_saldo_akhir = 0,
        } = req.data;
        if (status) {

          if (data && data.length > 0) {
            data.forEach(item => {
              item.saldo_awal = this.numberFormat(item.saldo_awal, 0);
              item.mutasi_debet = this.numberFormat(item.mutasi_debet, 0);
              item.mutasi_credit = this.numberFormat(item.mutasi_credit, 0);
              item.saldo_akhir = this.numberFormat(item.saldo_akhir, 0);
            });
          }

          this.table.items = data;
          this.table.totalRows = data.length;
          // this.paging.perPage = Number(perPage);

          this.total_saldo_awal = this.numberFormat(total_saldo_awal, 0);
          this.total_saldo_akhir = this.numberFormat(total_saldo_akhir, 0);
        } else {
          this.notify("danger", "Error", msg);
        }
        this.table.loading = false;
      } catch (error) {
        this.table.loading = false;
        console.error(error);
        this.notify("danger", "Error", error);
      } finally {
        this.showOverlay = false;
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