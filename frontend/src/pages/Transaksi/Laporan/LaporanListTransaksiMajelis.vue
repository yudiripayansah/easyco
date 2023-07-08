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
                      @change="doGetMajelis()"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="4">
                  <b-input-group prepend="Majelis" class="mb-3">
                    <b-form-select
                      v-model="paging.rembug"
                      :options="opt.rembug"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="4">
                  <b-input-group prepend="Petugas" class="mb-3">
                    <b-form-select
                      v-model="paging.petugas"
                      :options="opt.petugas"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="6">
                  <b-input-group prepend="Dari Tanggal">
                    <b-form-datepicker
                      v-model="paging.from"
                      :date-format-options="{
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric',
                      }"
                      locale="id"
                    />
                  </b-input-group>
                </b-col>
                <b-col cols="6">
                  <b-input-group prepend="Sampai Tanggal">
                    <b-form-datepicker
                      v-model="paging.to"
                      :date-format-options="{
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric',
                      }"
                      locale="id"
                    />
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
            <template #cell(saldo_pokok)="item">
              Rp {{ thousand(item.item.saldo_pokok) }}
            </template>
            <template #cell(saldo_margin)="item">
              Rp {{ thousand(item.item.saldo_margin) }}
            </template>
            <template #cell(saldo_minggon)="item">
              Rp {{ thousand(item.item.saldo_minggon) }}
            </template>
            <template #cell(jangka_waktu)="item">
              {{ item.item.jangka_waktu }}
              {{ getPeriodJangkaWaktu(item.item.periode_jangka_waktu) }}
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
      title="PREVIEW LAPORAN LIST TRANSAKSI REMBUG"
      id="modal-pdf"
      hide-footer
      size="xxl"
      centered
    >
      <div id="table-print" class="p-5">
        <h5 class="text-center">
          KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
        </h5>
        <h5 class="text-center">LAPORAN LIST TRANSAKSI MAJELIS</h5>
        <h5 class="text-center" v-show="report.cabang">{{ report.cabang }}</h5>
        <h6 class="text-center mb-5 pb-5" v-show="report.from && report.to">
          Tanggal {{ dateFormatId(report.from) }} s.d
          {{ dateFormatId(report.to) }}
        </h6>

        <div v-if="report.items.length > 0" style="font-size: 12px !important">
          <div v-for="(dt, dtIndex) in report.items" :key="`dt-${dtIndex}`">
            <b-row>
              <b-col cols="9">
                <b-row class="w-100 no-gutters">
                  <b-col cols="3" class="bold"> Majelis </b-col>
                  <b-col cols="3"> : {{ dt.nama_rembug }} </b-col>
                  <b-col cols="3" class="bold"> Petugas </b-col>
                  <b-col cols="3"> : {{ dt.nama_petugas }} </b-col>
                  <b-col cols="3" class="bold"> Tanggal Bayar </b-col>
                  <b-col cols="3"> : {{ dt.tanggal_bayar }} </b-col>
                  <b-col cols="3" class="bold"> Tanggal Transaksi </b-col>
                  <b-col cols="3"> : {{ dt.tanggal }} </b-col>
                  <b-col cols="3" class="bold"> Status Verifikasi </b-col>
                  <b-col cols="3"> : {{ dt.status_verifikasi }} </b-col>
                </b-row>
              </b-col>
              <b-col cols="3">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th
                        rowspan="3"
                        style="
                          background-color: lightgrey;
                          font-size: 12px !important;
                          font-weight: bold;
                        "
                      >
                        Infaq
                      </th>
                      <th
                        rowspan="2"
                        style="
                          background-color: lightgrey;
                          font-size: 12px !important;
                          font-weight: bold;
                        "
                      >
                        Total Setoran
                      </th>
                      <th
                        rowspan="2"
                        style="
                          background-color: lightgrey;
                          font-size: 12px !important;
                          font-weight: bold;
                        "
                      >
                        Total Penarikan
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <td>Rp {{ thousand(dt.infaq) }}</td>
                    <td>Rp {{ thousand(dt.total_penerimaan) }}</td>
                    <td>Rp {{ thousand(dt.total_penarikan) }}</td>
                  </tbody>
                </table>
              </b-col>
            </b-row>
            <table
              role="table"
              aria-busy="false"
              aria-colcount="6"
              class="table b-table table-striped table-bordered table-sm border"
              id="__BVID__218"
            >
              <!----><!---->
              <thead role="rowgroup" class="f-12 bold">
                <!---->
                <tr role="row" class="">
                  <th class="text-center f-12 bold" colspan="2">
                    <div>Anggota</div>
                  </th>
                  <th class="text-center f-12 bold" colspan="7">
                    <div>Setoran</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Penarikan</div>
                  </th>
                  <th class="text-center f-12 bold" colspan="5">
                    <div>Pencairan</div>
                  </th>
                </tr>
                <tr>
                  <th class="text-center f-12 bold">
                    <div>Id</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Nama</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Frek</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Pokok</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Margin</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Catab</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Tab. Sukarela</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Tab. Simwa/Simpok</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Tab. Taber</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Tab. Sukarela</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Pokok</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Adm</div>
                  </th>
                  <th class="text-center f-12 bold">
                    <div>Asuransi</div>
                  </th>
                </tr>
              </thead>

              <tbody role="rowgroup">
                <tr
                  v-for="(dtl, dtlIndex) in dt.detail"
                  :key="`dtl-${dtlIndex}`"
                >
                  <td class="">
                    <div>{{ dtl.no_anggota }}</div>
                  </td>
                  <td class="">
                    <div>{{ dtl.nama_anggota }}</div>
                  </td>
                  <td class="">
                    <div>{{ dtl.frek }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.angsuran_pokok) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.angsuran_margin) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.angsuran_catab) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.setoran_sukarela) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.setoran_simpok) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.setoran_taber) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.penarikan_sukarela) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.pokok) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.biaya_administrasi) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dtl.biaya_asuransi_jiwa) }}</div>
                  </td>
                </tr>
                <!---->
                <tr>
                  <td colspan="3" class="text-right">
                    <div><b>Total</b></div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.angs_pokok) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.margin) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.catab) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.sukarela) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.simwa) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.taber) }}</div>
                  </td>
                  <td class="text-right">
                    <div>
                      Rp {{ thousand(dt.total.total_penarikan_sukarela) }}
                    </div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.pokok) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.adm) }}</div>
                  </td>
                  <td class="text-right">
                    <div>Rp {{ thousand(dt.total.asuransi) }}</div>
                  </td>
                </tr>
              </tbody>
              <!---->
            </table>
          </div>
        </div>
        <div v-else>
          <tbody>
            <tr class="text-center">
              <td colspan="12">There's no data to display...</td>
            </tr>
          </tbody>
        </div>
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
<style>
.f-12 {
  font-size: 12px !important;
}
.bold {
  font-weight: bold !important;
}
</style>
<script>
import html2pdf from "html2pdf.js";
import helper from "@/core/helper";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";
export default {
  name: "LaporanListTransaksiMajelis",
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
            key: "nama_rembug",
            sortable: true,
            label: "Nama Majelis",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama_petugas",
            sortable: true,
            label: "Petugas",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "total_penerimaan",
            sortable: true,
            label: "Total Setoran",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "total_penarikan",
            sortable: true,
            label: "Total Penarikan",
            thClass: "text-center",
            tdClass: "",
          },
        ],
        items: [],
        loading: false,
      },
      report: {
        items: [],
        total: {
          angs_pokok: 0,
          angs_margin: 0,
          catab: 0,
          sukarela: 0,
          simwa: 0,
          taber: 0,
          tarik_sukarela: 0,
          pokok: 0,
          adm: 0,
          asuransi: 0,
        },
        loading: false,
        cabang: 0,
        petugas: 0,
        rembug: 0,
      },
      paging: {
        page: 1,
        perPage: "~",
        sortDesc: true,
        sortBy: "",
        search: "",
        cabang: null,
        petugas: null,
        rembug: null,
        from: null,
        to: null,
      },
      opt: {
        perPage: [10, 25, 50, 100],
        cabang: [],
        petugas: [],
        rembug: [],
      },
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
    this.doGetPetugas();
    this.doGetRembug();
  },
  methods: {
    ...helper,
    async doGetMajelis() {
      this.opt.rembug = [];
      let payload = {
        perPage: "~",
        page: 1,
        sortBy: "kode_rembug",
        sortDir: "ASC",
        search: "",
        kode_cabang: this.paging.cabang,
      };
      try {
        let req = await easycoApi.rembugRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.majelis = [
            {
              value: 0,
              text: "All",
            },
          ];
          data.map((item) => {
            this.opt.rembug.push({
              value: item.kode_rembug,
              text: item.nama_rembug,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    doPrintPdf() {
      let filename = "LAPORAN LIST TRANSAKSI MAJELIS";
      if (this.report.cabang) {
        filename += ` - Cabang ${this.report.cabang}`;
      }
      if (this.report.from && this.report.to) {
        filename += ` - Dari ${this.dateFormatId(
          this.report.from
        )} Sampai ${this.dateFormatId(this.report.to)}`;
      }
      let element = document.getElementById("table-print");
      let options = {
        margin: 0,
        filename: `${filename}.pdf`,
        jsPDF: {
          unit: "in",
          format: "legal",
          orientation: "landscape",
          fontSize: 12,
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
      let filename = "LAPORAN TRANSAKSI MAJELIS";
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
    async exportXls() {
      let payload = `branch_code=${this.paging.cabang}&fa_code&cm_code&from_date=${this.paging.from}&thru_date=${this.paging.to}`;
      let req = await easycoApi.listTransaksiMajelisExcel(payload);
      const url = window.URL.createObjectURL(new Blob([req.data]));
      const link = document.createElement("a");
      let fileName = "List_Transaksi_Majelis.xls";
      link.href = url;
      link.setAttribute("download", fileName);
      document.body.appendChild(link);
      link.click();
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
    async doGetPetugas() {
      let payload = null;
      try {
        let req = await easycoApi.petugasRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.petugas = [
            {
              value: [],
              text: "Pilih Kantor Cabang",
              disabled: true,
            },
          ];
          data.map((item) => {
            this.opt.petugas.push({
              value: Number(item.kode_petugas),
              text: item.nama_kas_petugas,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGetRembug() {
      this.opt.rembug = [];
      let payload = {
        kode_cabang: this.user.kode_cabang,
      };
      try {
        let req = await easycoApi.anggotaRembug(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.rembug = [
            {
              value: null,
              text: "All",
            },
          ];
          data.map((item) => {
            this.opt.rembug.push({
              value: Number(item.kode_rembug),
              text: item.nama_rembug,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGet() {
      let payload = {
        branch_code: this.paging.cabang,
        cm_code: this.paging.rembug,
        fa_code: this.paging.petugas,
        from_date: this.paging.from,
        thru_date: this.paging.to,
      };
      try {
        let req = await easycoApi.listTransaksiMajelis(
          payload,
          this.user.token
        );
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
        this.notify("danger", "Login Error", error);
      }
    },
    async doGetReport() {
      let payload = {
        branch_code: this.paging.cabang,
        cm_code: this.paging.rembug,
        fa_code: this.paging.petugas,
        from_date: this.paging.from,
        thru_date: this.paging.to,
      };
      this.report.loading = true;
      this.report.from = payload.from_date;
      this.report.to = payload.thru_date;
      this.report.cabang = this.getCabangName(payload.branch_code);
      try {
        let req = await easycoApi.listTransaksiMajelisPdf(
          payload,
          this.user.token
        );
        let { data, status, msg, total } = req.data;
        if (status) {
          this.report.items = data;
          console.log(this.report.items);
          this.report.totalRows = total;
        } else {
          this.notify("danger", "Error", msg);
        }

        this.report.items.forEach((item, index) => {
          item.detail.forEach((dtl) => {
            this.report.total.angs_pokok += dtl.angsuran_pokok;
            this.report.total.angs_margin += dtl.angsuran_margin;
            this.report.total.catab += dtl.angsuran_catab;
            this.report.total.sukarela += dtl.setoran_sukarela;
            this.report.total.simwa += dtl.setoran_simpok;
            this.report.total.taber += dtl.setoran_taber;
            this.report.total.tarik_sukarela += dtl.penarikan_sukarela;
            this.report.total.pokok += dtl.pokok;
            this.report.total.adm += dtl.biaya_administrasi;
            this.report.total.asuransi += dtl.biaya_asuransi_jiwa;
          });
          item.total = {
            angs_pokok: this.report.total.angs_pokok,
            margin: this.report.total.angs_margin,
            catab: this.report.total.catab,
            sukarela: this.report.total.sukarela,
            simwa: this.report.total.simwa,
            taber: this.report.total.taber,
            total_penarikan_sukarela: this.report.total.tarik_sukarela,
            pokok: this.report.total.pokok,
            adm: this.report.total.adm,
            asuransi: this.report.total.asuransi,
          };
          this.report.items[index] = item;
        });
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
    