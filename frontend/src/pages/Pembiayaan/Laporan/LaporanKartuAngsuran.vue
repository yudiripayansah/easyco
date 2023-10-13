<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col cols="10" class="mb-5">
          <b-row class="no-gutters">
            <b-col cols="12">
              <multiselect label="text" v-model="paging.no_rekening" :options="opt.no_rekening" @select="setRekening()" />
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="2" class="d-flex justify-content-end align-items-start">
          <b-button-group>
            <b-button text="Button" variant="danger" @click="$bvModal.show('modal-pdf')">
              PDF
            </b-button>
            <b-button text="Button" variant="success" @click="exportXls()">
              XLS
            </b-button>
          </b-button-group>
        </b-col>
        <b-overlay :show="showOverlay">
          <b-col cols="12" class="mb-5">
            <b-row class="no-gutters">
              <b-col cols="2" class="mt-3">
                <b>Nama</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ rekening.nama_anggota }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Plafon</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ thousand(rekening.pokok) }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Majelis</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ rekening.nama_rembug }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Margin</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ thousand(rekening.margin) }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Desa</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ rekening.nama_desa }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Jangka Waktu</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ rekening.jangka_waktu }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Produk</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ rekening.nama_produk }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Angsuran Pokok</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ thousand(rekening.angsuran_pokok) }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Tanggal</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ dateFormatId(rekening.tanggal_akad) }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Angsuran Margin</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ thousand(rekening.angsuran_margin) }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Tanggal Jatuh Tempo</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ dateFormatId(rekening.tanggal_jtempo) }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Angsuran Minggon</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ thousand(rekening.angsuran_catab) }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Mulai Angsuran</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ dateFormatId(rekening.tanggal_mulai_angsur) }}
              </b-col>
              <b-col cols="2" class="mt-3">
                <b>Total Angsuran</b>
              </b-col>
              <b-col cols="4" class="mt-3">
                {{ thousand(Number(rekening.angsuran_pokok) + Number(rekening.angsuran_margin)) }}
              </b-col>
            </b-row>
          </b-col>
          <b-col cols="12">
            <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
              show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
              <template #cell(no)="item">
                {{ item.index + 1 }}
              </template>
              <template #cell(angsuran_pokok)="item">
                {{ thousand(item.item.angsuran_pokok) }}
              </template>
              <template #cell(angsuran_margin)="item">
                {{ thousand(item.item.angsuran_margin) }}
              </template>
              <template #cell(saldo_pokok)="item">
                {{ thousand(item.item.saldo_pokok) }}
              </template>
              <template #cell(saldo_margin)="item">
                {{ thousand(item.item.saldo_margin) }}
              </template>
              <template #cell(angsuran_catab)="item">
                {{ thousand(item.item.angsuran_catab) }}
              </template>
              <template #cell(jumlah)="item">
                {{ thousand(item.item.jumlah) }}
              </template>
              <template #cell(trx_date)="item">
                {{ dateFormatId(item.item.trx_date) }}
              </template>
              <template #cell(tgl_bayar)="item">
                {{ dateFormatId(item.item.tgl_bayar) }}
              </template>
            </b-table>
          </b-col>
          <b-col cols="12" class="justify-content-end d-flex">
            <b-pagination v-model="paging.page" :total-rows="table.totalRows" :per-page="paging.perPage">
            </b-pagination>
          </b-col>
        </b-overlay>
      </b-row>
    </b-card>
    <b-modal title="PREVIEW LAPORAN KARTU ANGSURAN" id="modal-pdf" hide-footer size="xl" centered>
      <div id="table-print" class="p-5">
        <h5 class="text-center">
          KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
        </h5>
        <h5 class="text-center">LAPORAN KARTU ANGSURAN</h5>
        <b-col cols="9">
          <b-row class="no-gutters">
            <b-col cols="2" class="mt-3">
              <b>No Rekening</b>
            </b-col>
            <b-col cols="10" class="mt-3">
              {{ paging.no_rekening.value }}
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" class="mb-5">
          <b-row class="no-gutters">
            <b-col cols="2" class="mt-3">
              <b>Nama</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ rekening.nama_anggota }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Plafon</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ thousand(rekening.pokok) }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Majelis</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ rekening.nama_rembug }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Margin</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ thousand(rekening.margin) }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Desa</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ rekening.nama_desa }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Jangka Waktu</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ rekening.jangka_waktu }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Produk</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ rekening.nama_produk }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Angsuran Pokok</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ thousand(rekening.angsuran_pokok) }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Tanggal</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ dateFormatId(rekening.tanggal_akad) }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Angsuran Margin</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ thousand(rekening.angsuran_margin) }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Tanggal Jatuh Tempo</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ thousand(rekening.tanggal_jtempo) }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Angsuran Minggon</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ thousand(rekening.angsuran_catab) }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Mulai Angsuran</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ dateFormatId(rekening.tanggal_mulai_angsur) }}
            </b-col>
            <b-col cols="2" class="mt-3">
              <b>Total Angsuran</b>
            </b-col>
            <b-col cols="4" class="mt-3">
              {{ thousand(Number(rekening.angsuran_pokok) + Number(rekening.angsuran_margin)) }}
            </b-col>
          </b-row>
        </b-col>
        <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items" show-empty
          :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
          <template #cell(no)="item">
            {{ item.index + 1 }}
          </template>
          <template #cell(angsuran_pokok)="item">
            {{ thousand(item.item.angsuran_pokok) }}
          </template>
          <template #cell(angsuran_margin)="item">
            {{ thousand(item.item.angsuran_margin) }}
          </template>
          <template #cell(saldo_pokok)="item">
            {{ thousand(item.item.saldo_pokok) }}
          </template>
          <template #cell(saldo_margin)="item">
            {{ thousand(item.item.saldo_margin) }}
          </template>
          <template #cell(angsuran_catab)="item">
            {{ thousand(item.item.angsuran_catab) }}
          </template>
          <template #cell(jumlah)="item">
            {{ thousand(item.item.jumlah) }}
          </template>
          <template #cell(trx_date)="item">
            {{ dateFormatId(item.item.trx_date) }}
          </template>
          <template #cell(tgl_bayar)="item">
            {{ dateFormatId(item.item.tgl_bayar) }}
          </template>
        </b-table>
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
import Multiselect from "vue-multiselect";
import helper from "@/core/helper";
import html2pdf from "html2pdf.js";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";
export default {
  name: "LaporanSaldoAnggota",
  components: { Multiselect },
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
            key: "trx_date",
            sortable: true,
            label: "Tanggal",
            thClass: "text-center",
            tdClass: "text-center",
          },
          {
            key: "tgl_bayar",
            sortable: true,
            label: "Tanggal Bayar",
            thClass: "text-center",
            tdClass: "text-center",
          },
          {
            key: "angsuran_ke",
            sortable: true,
            label: "Angsuran Ke",
            thClass: "text-center",
            tdClass: "text-center",
          },
          {
            key: "angsuran_pokok",
            sortable: true,
            label: "Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "angsuran_margin",
            sortable: true,
            label: "Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "angsuran_catab",
            sortable: true,
            label: "Minggon",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "jumlah",
            sortable: true,
            label: "Total",
            thClass: "text-center",
            tdClass: "text-right",
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
          }
        ],
        items: [],
        loading: false,
        totalRows: 0,
      },
      paging: {
        page: 1,
        perPage: 10,
        sortDesc: true,
        sortBy: "kop_pembiayaan.tanggal_registrasi",
        search: "",
        status: "~",
        cabang: "",
        from: null,
        to: null,
        no_rekening: Object
      },
      opt: {
        cabang: [],
        no_rekening: [],
      },
      rekening: Object,
      showOverlay: false,
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  mounted() {
    this.doGetNorek();
  },
  methods: {
    ...helper,
    doPrintPdf() {
      let filename = "LAPORAN KARTU ANGSURAN";
      let element = document.getElementById("table-print");
      let options = {
        margin: 0,
        filename: `${filename}.pdf`,
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
          console.log("hi");
          window.open(pdf.output("bloburl"), "_blank");
        });
    },
    doSavePdf() {
      let filename = "LAPORAN KARTU ANGSURAN";

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
    async exportXls() {
      this.showOverlay = true;
      let payload = `no_rekening=${this.paging.no_rekening.value}`;
      let req = await easycoApi.kartuAngsuranExcel(payload);
      console.log(req.data);
      const url = window.URL.createObjectURL(new Blob([req.data]));
      const link = document.createElement("a");
      let fileName = "Kartu_Angsuran.xls";
      link.href = url;
      link.setAttribute("download", fileName);
      document.body.appendChild(link);
      link.click();
      this.showOverlay = false;
    },
    async doGetNorek() {
      this.showOverlay = true;
      let payload = {
        perPage: "~",
        page: 1,
        sortBy: "kop_pembiayaan.no_rekening",
        sortDir: "ASC",
        search: "",
      };
      try {
        let req = await easycoApi.regisAkadRead(payload, this.user.token);
        console.log(req);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.no_rekening = [];
          data.map((item) => {
            this.opt.no_rekening.push({
              value: item.no_rekening,
              text: `${item.no_rekening}-${item.nama_anggota}-${item.nama_rembug}`,
              data: item,
            });
          });
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.showOverlay = false;
      }
    },
    async setRekening() {
      this.showOverlay = true;
      let payload = {
        no_rekening: this.paging.no_rekening.value,
      }
      try {
        let req = await easycoApi.kartuAngsuran(payload, this.user.token);
        let { data, status, msg } = req.data
        if (status) {
          this.rekening = data[0]
          this.table.items = this.rekening.detail
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.showOverlay = false;
      }
    }
  },
};
</script>
