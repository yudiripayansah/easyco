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
      <div class="p-5">
        <h5 class="text-center">
          KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
        </h5>
        <h5 class="text-center">LAPORAN LIST TRANSAKSI MAJELIS</h5>
        <h5 class="text-center" v-show="report.cabang">{{ report.cabang }}</h5>
        <h6 class="text-center mb-5 pb-5" v-show="report.from && report.to">
          Tanggal {{ dateFormatId(report.from) }} s.d
          {{ dateFormatId(report.to) }}
        </h6>
      </div>
      <div v-if="report.items.length > 0">
        <div v-for="(dt, dtIndex) in report.items" :key="`dt-${dtIndex}`">
          <div class="justify-content-between d-flex">
            <div style="width: 70%">
              <b-col cols="12" class="mt-0 p-0">
                <b-row class="d-flex">
                  <table class="table table-no-bordered">
                    <thead>
                      <tr>
                        <th>Majelis</th>
                        <th style="border-bottom: 0 !important">
                          : {{ dt.nama_rembug }}
                        </th>
                        <th>Tanggal Bayar</th>
                        <th style="border-bottom: 0 !important">
                          : {{ dt.tanggal_bayar }}
                        </th>
                        <th style="border-bottom: 0 !important">
                          status Verifikasi
                        </th>
                        <th style="border-bottom: 0 !important">
                          : {{ dt.status_verifikasi }}
                        </th>
                      </tr>
                    </thead>
                  </table>
                </b-row>
                <b-row style="margin-top: -30px">
                  <table class="table">
                    <thead>
                      <tr>
                        <th style="border-bottom: 0 !important">Petugas</th>
                        <th style="border-bottom: 0 !important">
                          : {{ dt.nama_petugas }}
                        </th>
                        <th style="border-bottom: 0 !important">
                          Tanggal Transaksi
                        </th>
                        <th style="border-bottom: 0 !important">
                          : {{ dt.tanggal }}
                        </th>
                        <th style="border-bottom: 0 !important"></th>
                        <th style="border-bottom: 0 !important"></th>
                      </tr>
                    </thead>
                  </table>
                </b-row>
              </b-col>
            </div>
            <div style="width: 30%">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th rowspan="3">Infaq</th>
                    <th rowspan="2">Total Setoran</th>
                    <th rowspan="2">Total Penarikan</th>
                  </tr>
                </thead>
                <tbody>
                  <td>{{ dt.infaq }}</td>
                  <td>{{ dt.total_penerimaan }}</td>
                  <td>{{ dt.total_penarikan }}</td>
                </tbody>
              </table>
            </div>
          </div>
          <table
            role="table"
            aria-busy="false"
            aria-colcount="6"
            class="table b-table table-striped table-bordered table-sm border"
            id="__BVID__218"
          >
            <!----><!---->
            <thead role="rowgroup" class="">
              <!---->
              <tr role="row" class="">
                <th class="text-center" colspan="2">
                  <div>Anggota</div>
                </th>
                <th class="text-center" colspan="7">
                  <div>Setoran</div>
                </th>
                <th class="text-center">
                  <div>Penarikan</div>
                </th>
                <th class="text-center" colspan="5">
                  <div>Pencairan</div>
                </th>
              </tr>
              <tr>
                <th class="text-center">
                  <div>Id</div>
                </th>
                <th class="text-center">
                  <div>Nama</div>
                </th>
                <th class="text-center">
                  <div>Frek</div>
                </th>
                <th class="text-center">
                  <div>Pokok</div>
                </th>
                <th class="text-center">
                  <div>Margin</div>
                </th>
                <th class="text-center">
                  <div>Catab</div>
                </th>
                <th class="text-center">
                  <div>Tab.Sukarela</div>
                </th>
                <th class="text-center">
                  <div>Tab.Simwa/Simpok</div>
                </th>
                <th class="text-center">
                  <div>Tab.Taber</div>
                </th>
                <th class="text-center">
                  <div>Tab. Sukarela</div>
                </th>
                <th class="text-center">
                  <div>Pokok</div>
                </th>
                <th class="text-center">
                  <div>Administrasi</div>
                </th>
                <th class="text-center">
                  <div>Asuransi</div>
                </th>
              </tr>
            </thead>

            <tbody role="rowgroup">
              <tr v-for="(dtl, dtlIndex) in dt.detail" :key="`dtl-${dtlIndex}`">
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
                  <div>Rp {{ thousand(report.total.angs_pokok) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.angs_margin) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.catab) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.sukarela) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.simwa) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.taber) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.tarik_sukarela) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.pokok) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.adm) }}</div>
                </td>
                <td class="text-right">
                  <div>Rp {{ thousand(report.total.asuransi) }}</div>
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
            text="Button"
            variant="danger"
            @click="$bvModal.show('modal-pdf')"
          >
            PDF
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
              value: null,
              text: "All",
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
      this.report.from = payload.from;
      this.report.to = payload.to;
      this.report.cabang = this.getCabangName(payload.cabang);
      try {
        let req = await easycoApi.listTransaksiMajelisPdf(
          payload,
          this.user.token
        );
        let { data, status, msg, total } = req.data;
        if (status) {
          this.report.items = data;
          this.report.totalRows = total;
        } else {
          this.notify("danger", "Error", msg);
        }

        this.report.items.map((i) => {
          i.detail.map((dtl) => {
            this.report.total.tarik_sukarela =
              this.report.total.tarik_sukarela + dtl.penarikan_sukarela;
          });
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
    