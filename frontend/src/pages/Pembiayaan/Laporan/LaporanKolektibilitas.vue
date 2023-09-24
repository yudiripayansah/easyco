<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row>
        <b-col cols="10">
          <b-row>
            <b-col cols="6">
              <b-input-group prepend="Cabang" class="mb-3">
                <b-form-select v-model="paging.kode_cabang" :options="opt.cabang" @change="doGet()"/>
              </b-input-group>
            </b-col>
            <!-- <b-col cols="6">
              <b-input-group prepend="Petugas" class="mb-3">
                <b-form-select v-model="paging.kode_petugas" :options="opt.petugas" />
              </b-input-group>
            </b-col>
            <b-col cols="6">
              <b-input-group prepend="Sumber Dana" class="mb-3">
                <b-form-select v-model="paging.sumber_dana" :options="opt.sumber_dana" />
              </b-input-group>
            </b-col> -->
            <b-col cols="6">
              <b-input-group prepend="Tanggal" class="mb-3">
                <b-form-datepicker
                  v-model="paging.tanggal_hitung"
                  :date-format-options="{
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric',
                  }"
                  locale="id"
                  @change="doGet()"
                />
              </b-input-group>
            </b-col>
            <!-- <b-col cols="6">
              <b-input-group prepend="Kolektibilitas" class="mb-3">
                <b-form-select v-model="paging.kolektibilitas" :options="opt.kolektibilitas" />
              </b-input-group>
            </b-col> -->
          </b-row>
        </b-col>
        <b-col cols="2" class="d-flex align-items-start justify-content-end">
          <b-button-group>
            <!--<b-button text="Button" variant="danger" @click=" $bvModal.show('modal-pdf');
							doGetReport();">
              PDF
            </b-button>-->
            <b-button text="Button" variant="success" @click="exportXls()">
              XLS
            </b-button>
            <b-button text="Button" variant="warning" @click="exportCsv()">
              CSV
            </b-button>
          </b-button-group>
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
            </template>
          </b-table>
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
						<b-pagination v-model="paging.page" :total-rows="table.totalRows" :per-page="paging.perPage">
						</b-pagination>
					</b-col>
      </b-row>
    </b-card>
    <b-modal title="PREVIEW LAPORAN PAR KOLEKTIBILITAS" id="modal-pdf" hide-footer size="xl" centered>
			<div id="table-print" class="p-5">
				<h5 class="text-center">
					KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
				</h5>
				<h5 class="text-center">LAPORAN PAR KOLEKTIBILITAS</h5>
				<h5 class="text-center" v-show="report.kode_petugas">Cabang: {{ report.kode_cabang }}</h5>
				<h5 class="text-center" v-show="report.kode_petugas">Petugas: {{ report.kode_petugas }}</h5>
				<h5 class="text-center" v-show="report.kode_rembug">Majelis: {{ report.kode_rembug }}</h5>
				<h6 class="text-center mb-5 pb-5" v-show="report.from_date && report.thru_date"> Tanggal {{
					dateFormatId(report.from_date) }} s.d {{ dateFormatId(report.thru_date) }}</h6>
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<th v-for="table in table.fields" :key="table.key" :class="table.thClass">{{ table.label }}
							</th>
						</thead>
						<tbody v-if="report.items.length > 0">
							<tr v-for="(report, reportIndex) in report.items" :key="`report-${reportIndex}`">
								<td>{{ reportIndex + 1 }}</td>
								<td class="text-center">{{ report.no_rekening }}</td>
								<td class="text-center">{{ report.nama_rembug }}</td>
								<td class="text-left">{{ report.nama_anggota }}</td>
								<td class="text-center">Rp {{ numberFormat(report.angsuran_pokok, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.angsuran_margin, 0) }}</td>
								<td class="text-center">{{ report.angsuran_terbayar }}</td>
                <td class="text-center">Rp {{ numberFormat(report.cadangan_piutang, 0) }}</td>
								<td class="text-center">{{ report.hari_nunggak }}</td>
								<td class="text-center">{{ report.jangka_waktu }}</td>
								<td class="text-center">Rp {{ numberFormat(report.margin, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.pokok, 0) }}</td>
                <td class="text-center">{{ report.nama_anggota }}</td>
                <td class="text-center">{{ report.nama_cabang }}</td>
                <td class="text-center">{{ report.nama_pgw }}</td>
                <td class="text-center">{{ report.nama_anggota }}</td>
                <td class="text-center">{{ report.par_desc }}</td>
                <td class="text-center">{{ report.pengajuan_ke }}</td>
								<td class="text-center">Rp {{ numberFormat(report.saldo_margin, 0) }}</td>
                <td class="text-center">Rp {{ numberFormat(report.saldo_pokok, 0) }}</td>
                <td class="text-center">{{ report.seharusnya }}</td>
                <td class="text-center">{{ report.tanggal_akad }}</td>
                <td class="text-center">{{ report.tanggal_mulai_angsur }}</td>
								<td class="text-center">Rp {{ numberFormat(report.tunggakan_margin, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.tunggakan_pokok, 0) }}</td>
							</tr>
						</tbody>
						<tbody v-else>
							<tr class="text-center">
								<td :colspan="report.fields.length">There's no data to display...</td>
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
  name: "LaporanKolektibilitas",
  components: {},
  data() {
    return {
      table: {
        fields: [
        {
            key: "no_rekening",
            sortable: true,
            label: "No Rek",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama_rembug",
            sortable: true,
            label: "Majelis",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama_anggota",
            sortable: true,
            label: "Nama",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "angsuran_pokok",
            sortable: true,
            label: "Angsuran Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "angsuran_margin",
            sortable: true,
            label: " Angsuran Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "angsuran_terbayar",
            sortable: true,
            label: "Angsuran Terbayar",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "cadangan_piutang",
            sortable: true,
            label: "Cadangan Piutang",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "hari_nunggak",
            sortable: true,
            label: "Hari Nunggak",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "jangka_waktu",
            sortable: true,
            label: "Jangka Waktu",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "margin",
            sortable: true,
            label: "Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "pokok",
            sortable: true,
            label: "pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "nama_anggota",
            sortable: true,
            label: "Nama Anggota",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "nama_cabang",
            sortable: true,
            label: "Nama Cabang",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "nama_pgw",
            sortable: true,
            label: "Nama Pegawai",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "no_anggota",
            sortable: true,
            label: "No Anggota",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "par_desc",
            sortable: true,
            label: "Par",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "pengajuan_ke",
            sortable: true,
            label: "Pengajuan",
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
            key: "saldo_pokok",
            sortable: true,
            label: "Saldo Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "seharusnya",
            sortable: true,
            label: "seharusnya",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tanggal_akad",
            sortable: true,
            label: "Tanggal Akad",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tanggal_mulai_angsur",
            sortable: true,
            label: "Tanggal Mulai Angsur",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tunggakan_margin",
            sortable: true,
            label: "Tunggakan Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tunggakan_pokok",
            sortable: true,
            label: "Tunggakan Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          
        ],
        items: [],
        loading: false,
        totalRows: 0,
        
      },
      report: {
				fields: [
        {
            key: "no_rekening",
            sortable: true,
            label: "No Rek",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama_rembug",
            sortable: true,
            label: "Majelis",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama_anggota",
            sortable: true,
            label: "Nama",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "anguran_pokok",
            sortable: true,
            label: "Pokok",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "angsuran_margin",
            sortable: true,
            label: "Margin",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "angsuran_terbayar",
            sortable: true,
            label: "Angsuran Terbayar",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "cadangan_piutang",
            sortable: true,
            label: "Cadangan Piutang",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "hari_nunggak",
            sortable: true,
            label: "Hari Nunggak",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "jangka_waktu",
            sortable: true,
            label: "Jangka Waktu",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "margin",
            sortable: true,
            label: "Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "pokok",
            sortable: true,
            label: "pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "nama_anggota",
            sortable: true,
            label: "Nama Anggota",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "nama_cabang",
            sortable: true,
            label: "Nama Cabang",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "nama_pgw",
            sortable: true,
            label: "Nama Pegawai",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "no_anggota",
            sortable: true,
            label: "No Anggota",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "par_desc",
            sortable: true,
            label: "Par",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "pengajuan_ke",
            sortable: true,
            label: "Pengajuan",
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
            key: "saldo_pokok",
            sortable: true,
            label: "Saldo Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "seharusnya",
            sortable: false,
            label: "seharusnya",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tanggal_akad",
            sortable: true,
            label: "Tanggal Akad",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tanggal_mulai_angsur",
            sortable: true,
            label: "Tanggal Mulai Angsur",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tunggakan_margin",
            sortable: true,
            label: "Tunggakan Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tunggakan_pokok",
            sortable: true,
            label: "Tunggakan Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
				],
				items: [],
				loading: true,
				totalRows: 0,
				kode_cabang: null,
				tanggal_hitung: null,
        page: 1,
				perPage: 10,
			},
      paging: {
        page: 1,
				perPage: 10,
				sortDesc: true,
				sortBy: "id",
				search: "",
				status: "~",
				kode_cabang: null,
        tanggal_hitung: null
      },
      loading: false,
      opt: {
        cabang: [],
        tanggal_hitung: []
      },
      showOverlay: false,
      loading: false,
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
    this.doGet()
    this.doGetCabang()
  },

  methods: {
    ...helper,
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
    getFileName() {
			let fileName = "LAPORAN LAPORAN PAR KOLEKTIBILITAS";
			if (this.paging.kode_cabang) fileName += ` - Cabang ${this.paging.kode_cabang}`;
			if (this.paging.kode_petugas) fileName += ` - Petugas ${this.paging.kode_petugas}`;
			if (this.paging.kode_rembug) fileName += ` - Majelis ${this.paging.kode_rembug}`;
			if (this.paging.from_date && this.paging.thru_date) fileName += ` - Dari ${this.dateFormatId(this.paging.from_date)} Sampai ${this.dateFormatId(this.paging.thru_date)}`;
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
      let pCabang = (this.paging.cabang) ? this.paging.cabang : '~'
      let pRembug = (this.paging.rembug) ? this.paging.rembug : '~'
      let pPetugas = (this.paging.petugas) ? this.paging.petugas : '~'

      this.showOverlay = true;
      let payload = `kode_cabang=${this.paging.kode_cabang}&tanggal_hitung=${this.paging.tanggal_hitung}`;
      let req = await easycoApi.listReportKolektibilitasExportToXLSX(payload);
      console.log(req.data);
      const url = window.URL.createObjectURL(new Blob([req.data]));
      const link = document.createElement("a");
      let fileName = "Kolektibilitas.xls";
      link.href = url;
      link.setAttribute("download", fileName);
      document.body.appendChild(link);
      link.click();
      this.showOverlay = false;
    },
    async exportCsv() {
      let pCabang = (this.paging.cabang) ? this.paging.cabang : '~'
      let pRembug = (this.paging.rembug) ? this.paging.rembug : '~'
      let pPetugas = (this.paging.petugas) ? this.paging.petugas : '~'

      this.showOverlay = true;
      let payload = `kode_cabang=${this.paging.kode_cabang}&tanggal_hitung=${this.paging.tanggal_hitung}`;
      let req = await easycoApi.listReportKolektibilitasExportToCSV(payload);
      console.log(req.data);
      const url = window.URL.createObjectURL(new Blob([req.data]));
      const link = document.createElement("a");
      let fileName = "Kolektibilitas.csv";
      link.href = url;
      link.setAttribute("download", fileName);
      document.body.appendChild(link);
      link.click();
      this.showOverlay = false;
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
    async doGet() {
      this.showOverlay = true;
      let payload = this.paging;
      payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
      payload.perPage = 10;
      this.table.loading = true;
      try {
        let req = await easycoApi.laporanKolek(payload, this.user.token);
        
        let { data, status, msg, total } = req.data;
        if (status) {
          if (data && data.length > 0) {
						data.forEach(item => {
							item.angsuran_pokok = this.numberFormat(item.angsuran_pokok, 0);
							item.angsuran_margin = this.numberFormat(item.angsuran_margin, 0);
							item.cadangan_piutang = this.numberFormat(item.cadangan_piutang, 0);
							item.margin = this.numberFormat(item.margin, 0);
							item.pokok = this.numberFormat(item.pokok, 0);
							item.saldo_margin = this.numberFormat(item.saldo_margin, 0);
							item.saldo_margin = this.numberFormat(item.saldo_margin, 0);
							item.saldo_pokok = this.numberFormat(item.saldo_pokok, 0);
              item.tunggakan_margin = this.numberFormat(item.tunggakan_margin, 0);
              item.tunggakan_pokok = this.numberFormat(item.tunggakan_pokok, 0);
						});
					}

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
			let payload = this.paging;
			payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
			payload.perPage = "~";
			this.report.loading = true;
			this.report = {
				...this.paging
			};
			try {
				let req = await easycoApi.laporanKolek(payload, this.user.token);
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
    doClearForm() {
      this.form.data = {
        kode_cabang: null,
        tanggal_hitung: null
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
  