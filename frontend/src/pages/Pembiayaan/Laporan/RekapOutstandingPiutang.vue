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
                <b-input-group prepend="Rekap By">
                  <b-form-select v-model="paging.rekap_by" :options="opt.rekap_by" />
                </b-input-group>
              </b-col>
            </div>
          </b-col>
          <b-col cols="2" class="d-flex justify-content-end align-items-start">
            <b-button-group>
              <b-button text="Button" variant="danger" @click="$bvModal.show('modal-pdf');">PDF</b-button>
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
              <template #cell(saldo_pokok)="table">
              Rp. {{ table.item.saldo_pokok }}
            </template>
            <template #cell(saldo_margin)="table">
              Rp. {{ table.item.saldo_margin }}
            </template>
            <template #cell(saldo_catab)="table">
              Rp. {{ table.item.saldo_catab }}
            </template>
            <template #cell(persen_jumlah)="table">
              {{ table.item.persen_jumlah }}%
            </template>
            <template #cell(persen_nominal)="table">
              {{ table.item.persen_nominal }}%
            </template>
            </b-table>
          </b-col>
          <b-col cols="12" class="justify-content-end d-flex">
            <b-pagination v-model="paging.currentPage" :total-rows="table.totalRows" :per-page="paging.perPage"
              aria-controls="my-table"></b-pagination>
          </b-col>
          <b-col md="4" offset-md="8">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th v-for="tableSummary in tableSummary.fields" :key="tableSummary.key" :class="tableSummary.thClass">{{
                    tableSummary.label }}</th>
                </tr>
              </thead>
              <tbody v-if="tableSummary && tableSummary.items && tableSummary.items.length > 0">
                <tr v-for="(tableSummary, tableSummaryIndex) in tableSummary.items"
                  :key="`tableSummary-${tableSummaryIndex}`">
                  <td class="text-left">{{ tableSummary.text }}</td>
                  <td class="text-right">{{ tableSummary.value }}</td>
                </tr>
              </tbody>
            </table>
          </b-col>
        </b-row>
      </b-card>
    </b-overlay>

    <b-modal title="PREVIEW REKAP OUTSTANDING PIUTANG" id="modal-pdf" hide-footer size="xl" centered>
      <div id="table-print" class="p-5">
        <h5 class="text-center">
          KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
        </h5>
        <h5 class="text-center">REKAP OUTSTANDING PIUTANG</h5>
        <h5 class="text-center" v-show="nama_cabang">Cabang: {{ nama_cabang }}</h5>
        <h5 class="text-center" v-show="rekap_by_nama">Rekap By: {{ rekap_by_nama }}</h5>
        <b-col cols="12">
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
                  <td class="text-left">{{ table.keterangan }}</td>
                  <td class="text-center">{{ table.jumlah_anggota }}</td>
                  <td class="text-right">Rp. {{ table.saldo_pokok }}</td>
                  <td class="text-right">Rp. {{ table.saldo_margin }}</td>
                  <td class="text-right">Rp. {{ table.saldo_catab }}</td>
                  <td class="text-right">{{ table.persen_jumlah }}%</td>
                  <td class="text-right">{{ table.persen_nominal }}%</td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr class="text-center">
                  <td :colspan="table.fields.length">There's no data to display...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </b-col>
        <b-col md="4" offset-md="8">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th v-for="tableSummary in tableSummary.fields" :key="tableSummary.key" :class="tableSummary.thClass">
                  {{ tableSummary.label }}</th>
              </tr>
            </thead>
            <tbody v-if="tableSummary && tableSummary.items && tableSummary.items.length > 0">
              <tr v-for="(tableSummary, tableSummaryIndex) in tableSummary.items"
                :key="`tableSummary-${tableSummaryIndex}`">
                <td class="text-left">{{ tableSummary.text }}</td>
                <td class="text-right">{{ tableSummary.value }}</td>
              </tr>
            </tbody>
          </table>
        </b-col>
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
  name: "RekapOutstandingPiutang",
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
            key: "keterangan",
            sortable: true,
            label: "Keterangan",
            thClass: "text-center",
            tdClass: "text-left",
          },
          {
            key: "jumlah_anggota",
            sortable: true,
            label: "Jumlah Anggota",
            thClass: "text-center w-15p",
            tdClass: "text-center w-15p",
          },
          {
            key: "saldo_pokok",
            sortable: true,
            label: "Saldo Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "saldo_margin",
            sortable: true,
            label: "Saldo Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "saldo_catab",
            sortable: true,
            label: "Saldo Catab",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "persen_jumlah",
            sortable: true,
            label: "% Jumlah",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "persen_nominal",
            sortable: true,
            label: "% Nominal",
            thClass: "text-center",
            tdClass: "text-right",
          },
        ],
        items: [],
        loading: false,
        totalRows: 0,
      },
      tableSummary: {
        fields: [
          {
            key: "keterangan",
            sortable: false,
            label: "Keterangan",
            thClass: "text-center w-5p",
            tdClass: "text-center",
          },
          {
            key: "saldo",
            sortable: false,
            label: "Saldo",
            thClass: "text-center w-5p",
            tdClass: "text-center",
          },
        ],
        items: []
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
        rekap_by: '',
      },
      opt: {
        kode_cabang: [
          {
            value: '',
            text: "All",
          },
        ],
        rekap_by: [
          {
            value: '',
            text: "All",
          },
        ]
      },
      nama_cabang: "",
      rekap_by_nama: "",
      showOverlay: false,
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
    this.doGet();
    this.doGetCabang();
    this.doGetRekapBy();
  },
  methods: {
    ...helper,
    getFileName() {
      const singleObjKodeCabang = this.opt.kode_cabang.find(item => item.value == this.paging.kode_cabang);
      const singleObjRekapBy = this.opt.rekap_by.find(item => item.value == this.paging.rekap_by);

      let fileName = "REKAP OUTSTANDING PIUTANG_";
      fileName += `Cabang-${(singleObjKodeCabang?.value != null ? singleObjKodeCabang?.text : '')}_`;
      fileName += `Rekap By-${(singleObjRekapBy?.value != null ? singleObjRekapBy?.text : '')}_`;
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
      const payload = `kode_cabang=${this.paging.kode_cabang}&rekap_by=${this.paging.rekap_by}`;
      const req = await easycoApi.pembiayaanLaporanRekapOutstandingPiutangExportToXLSX(payload);
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
      const payload = `kode_cabang=${this.paging.kode_cabang}&rekap_by=${this.paging.rekap_by}`;
      const req = await easycoApi.pembiayaanLaporanRekapOutstandingPiutangExportToCSV(payload);
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
              text: `${item.kode_cabang} - ${item.nama_cabang}`,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGetRekapBy() {
      let payload = '';
      try {
        let req = await easycoApi.listReportRekapBy(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.rekap_by = [
            {
              value: '',
              text: "All",
            },
          ];
          data.map((item) => {
            this.opt.rekap_by.push({
              value: item.kode_value,
              text: item.kode_display,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGet() {
      this.showOverlay = true;

      const singleObjKodeCabang = this.opt.kode_cabang.find(item => item.value == this.paging.kode_cabang);
      const singleObjRekapBy = this.opt.rekap_by.find(item => item.value == this.paging.rekap_by);
      this.nama_cabang = singleObjKodeCabang.text;
      this.rekap_by_nama = singleObjRekapBy.text;

      let payload = this.paging;
      payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
      this.table.loading = true;
      try {
        let req = await easycoApi.pembiayaanLaporanRekapOutstandingPiutang(payload, this.user.token);
        const {
          data,
          status,
          msg = '',
          total_anggota,
          total_saldo_pokok,
          total_saldo_margin,
          total_saldo_catab,
        } = req.data;
        if (status) {

          if (data && data.length > 0) {
            data.forEach(item => {
              item.jumlah_anggota = this.numberFormat(item.jumlah_anggota, 0);
              item.saldo_pokok = this.numberFormat(item.saldo_pokok, 0);
              item.saldo_margin = this.numberFormat(item.saldo_margin, 0);
              item.saldo_catab = this.numberFormat(item.saldo_catab, 0);
              item.persen_jumlah = item.persen_jumlah;
              item.persen_nominal = item.persen_nominal;
            });
          }

          this.table.items = data;
          this.table.totalRows = data.length;

          this.tableSummary.items = [
            {
              text: "Total Anggota",
              value: this.numberFormat(total_anggota, 0),
            },
            {
              text: "Total Saldo Pokok",
              value: this.numberFormat(total_saldo_pokok, 0),
            },
            {
              text: "Total Saldo Margin",
              value: this.numberFormat(total_saldo_margin, 0),
            },
            {
              text: "Total Saldo Catab",
              value: this.numberFormat(total_saldo_catab, 0),
            },
          ]
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