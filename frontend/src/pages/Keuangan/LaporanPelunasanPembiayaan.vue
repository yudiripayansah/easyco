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
									<b-form-select v-model="paging.kode_cabang" :options="opt.kode_cabang"
										@change="doGetPetugas()" />
								</b-input-group>
							</b-col>
							<b-col>
								<b-input-group prepend="Petugas">
									<b-form-select v-model="paging.kode_petugas" :options="opt.kode_petugas"
										@change="doGetMajelis()" />
								</b-input-group>
							</b-col>
							<b-col>
								<b-input-group prepend="Majelis">
									<b-form-select v-model="paging.kode_rembug" :options="opt.kode_rembug"
										@change="doGetMajelis()" />
								</b-input-group>
							</b-col>
						</div>
						<div class="row">
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
					<b-col cols="2" class="d-flex justify-content-end align-items-start">
						<b-button-group>
							<b-button text="Button" variant="danger" @click="
								$bvModal.show('modal-pdf');
							doGetReport();
							">
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
					<b-col cols="12">
						<b-table responsive bordered outlined small striped hover :fields="table.fields"
							:items="table.items" show-empty
							:emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
							<template #cell(no)="item">
								{{ item.index + 1 }}
							</template>
						</b-table>
					</b-col>
					<b-col cols="12" class="justify-content-end d-flex">
						<b-pagination v-model="paging.page" :total-rows="table.totalRows" :per-page="paging.perPage">
						</b-pagination>
					</b-col>
				</b-row>
			</b-card>
		</b-overlay>

		<b-modal title="PREVIEW LAPORAN PELUNASAN PEMBIAYAAN" id="modal-pdf" hide-footer size="xl" centered>
			<div id="table-print" class="p-5">
				<h5 class="text-center">
					KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
				</h5>
				<h5 class="text-center">LAPORAN PELUNASAN PEMBIAYAAN</h5>
				<h5 class="text-center" v-show="report.nama_cabang">Cabang: {{ report.nama_cabang }}</h5>
				<h5 class="text-center" v-show="report.nama_petugas">Petugas: {{ report.nama_petugas }}</h5>
				<h5 class="text-center" v-show="report.nama_rembug">Majelis: {{ report.nama_rembug }}</h5>
				<h6 class="text-center mb-5 pb-5" v-show="report.from_date && report.thru_date"> Tanggal {{
					dateFormatId(report.from_date) }} s.d {{ dateFormatId(report.thru_date) }}</h6>
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<th v-for="table in table.fields" :key="table.key" :class="table.thClass">{{ table.label }}
							</th>
						</thead>
						<tbody v-if="report && report.items && report.items.length > 0">
							<tr v-for="(report, reportIndex) in report.items" :key="`report-${reportIndex}`">
								<td>{{ reportIndex + 1 }}</td>
								<td class="text-center">{{ report.tanggal_pelunasan }}</td>
								<td class="text-center">{{ report.no_rekening }}</td>
								<td class="text-left">{{ report.nama_anggota }}</td>
								<td class="text-left">{{ report.nama_rembug }}</td>
								<td class="text-center">Rp {{ numberFormat(report.pokok, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.margin, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.jangka_waktu, 0) }}</td>
								<td class="text-center">{{ report.periode_jangka_waktu }}</td>
								<td class="text-center">{{ report.tanggal_jtempo }}</td>
								<td class="text-center">Rp {{ numberFormat(report.counter_angsuran, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.saldo_pokok, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.saldo_margin, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.saldo_catab, 0) }}</td>
								<td class="text-center">Rp {{ numberFormat(report.potongan_margin, 0) }}</td>
								<td class="text-center">{{ report.nama_pgw }}</td>
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
	name: "LaporanPelunasanPembiayaan",
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
						key: "tanggal_pelunasan",
						sortable: false,
						label: "Tanggal Pelunasan",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "no_rekening",
						sortable: false,
						label: "No Rekening",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "nama_anggota",
						sortable: false,
						label: "Nama Anggota",
						thClass: "text-center",
						tdClass: "text-left",
					},
					{
						key: "nama_rembug",
						sortable: false,
						label: "Nama Rembug",
						thClass: "text-center",
						tdClass: "text-left",
					},
					{
						key: "pokok",
						sortable: false,
						label: "Pokok",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "margin",
						sortable: false,
						label: "Margin",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "jangka_waktu",
						sortable: false,
						label: "Jangka Waktu",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "periode_jangka_waktu",
						sortable: false,
						label: "Periode Jangka Waktu",
						thClass: "text-center",
						tdClass: "text-left",
					},
					{
						key: "tanggal_jtempo",
						sortable: false,
						label: "Tanggal Jatuh Tempo",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "counter_angsuran",
						sortable: false,
						label: "Angsuran",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "saldo_pokok",
						sortable: false,
						label: "Saldo Pokok",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "saldo_margin",
						sortable: false,
						label: "Saldo Margin",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "saldo_catab",
						sortable: false,
						label: "Saldo Catab",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "potongan_margin",
						sortable: false,
						label: "Potongan Margin",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						"ey": "nama_pgw",
						sortable: false,
						label: "Nama Pegawai",
						thClass: "text-center",
						tdClass: "text-left",
					},
				],
				items: [],
				loading: false,
				totalRows: 0,
			},
			report: {
				fields: [
					{
						key: "no",
						sortable: false,
						label: "No",
						thClass: "text-center w-5p",
						tdClass: "text-center",
					},
					{
						key: "tanggal_pelunasan",
						sortable: false,
						label: "Tanggal Pelunasan",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "no_rekening",
						sortable: false,
						label: "No Rekening",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "nama_anggota",
						sortable: false,
						label: "Nama Anggota",
						thClass: "text-center",
						tdClass: "text-left",
					},
					{
						key: "nama_rembug",
						sortable: false,
						label: "Nama Rembug",
						thClass: "text-center",
						tdClass: "text-left",
					},
					{
						key: "pokok",
						sortable: false,
						label: "Pokok",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "margin",
						sortable: false,
						label: "Margin",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "jangka_waktu",
						sortable: false,
						label: "Jangka Waktu",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "periode_jangka_waktu",
						sortable: false,
						label: "Periode Jangka Waktu",
						thClass: "text-center",
						tdClass: "text-left",
					},
					{
						key: "tanggal_jtempo",
						sortable: false,
						label: "Tanggal Jatuh Tempo",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "counter_angsuran",
						sortable: false,
						label: "Angsuran",
						thClass: "text-center",
						tdClass: "text-center",
					},
					{
						key: "saldo_pokok",
						sortable: false,
						label: "Saldo Pokok",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "saldo_margin",
						sortable: false,
						label: "Saldo Margin",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "saldo_catab",
						sortable: false,
						label: "Saldo Catab",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						key: "potongan_margin",
						sortable: false,
						label: "Potongan Margin",
						thClass: "text-center",
						tdClass: "text-right",
					},
					{
						"ey": "nama_pgw",
						sortable: false,
						label: "Nama Pegawai",
						thClass: "text-center",
						tdClass: "text-left",
					},
				],
				items: [],
				loading: false,
				totalRows: 0,
				kode_cabang: '',
				kode_petugas: '',
				kode_rembug: '',
				nama_cabang: '',
				nama_petugas: '',
				nama_rembug: '',
				from_date: '',
				thru_date: '',
			},
			paging: {
				page: 1,
				perPage: 10,
				sortDesc: true,
				sortBy: "id",
				search: "",
				status: "~",
				kode_cabang: '',
				kode_petugas: '',
				kode_rembug: '',
				from_date: '',
				thru_date: '',
			},
			opt: {
				kode_cabang: [],
				kode_petugas: [],
				kode_rembug: []
			},
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
	},
	methods: {
		...helper,
		getFileName() {
			const singleObjKodeCabang = this.opt.kode_cabang.find(item => item.value == this.paging.kode_cabang);
			const singleObjKodePetugas = this.opt.kode_petugas.find(item => item.value == this.paging.kode_petugas);
			const singleObjKodeRembug = this.opt.kode_rembug.find(item => item.value == this.paging.kode_rembug);

			let fileName = "LAPORAN PELUNASAN PEMBIAYAAN_";
			if (this.paging.kode_cabang) fileName += `Cabang ${(singleObjKodeCabang?.value != null ? singleObjKodeCabang?.text : '')}_`;
			if (this.paging.kode_petugas) fileName += `Petugas ${(singleObjKodePetugas?.value != null ? singleObjKodePetugas?.text : '')}_`;
			if (this.paging.kode_rembug) fileName += `Majelis ${(singleObjKodeRembug?.value != null ? singleObjKodeRembug?.text : '')}_`;
			if (this.paging.from_date && this.paging.thru_date) fileName += `Dari ${this.dateFormatId(this.paging.from_date)} Sampai ${this.dateFormatId(this.paging.thru_date)}`;
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
			if (this.paging.kode_cabang == null &&
				this.paging.kode_petugas == null &&
				this.paging.kode_rembug == null &&
				this.paging.from_date == null &&
				this.paging.thru_date == null) {
				this.notify("info", "Info", "Please entry a filter before export!");
				return false;
			}

			this.showOverlay = true;
			const payload = `kode_cabang=${this.paging.kode_cabang}&kode_petugas=${this.paging.kode_petugas}&kode_rembug=${this.paging.kode_rembug}&from_date=${this.paging.from_date}&thru_date=${this.paging.thru_date}`;
			const req = await easycoApi.listReportPelunasanPembiayaanExportToXLSX(payload);
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
			if (this.paging.kode_cabang == null &&
				this.paging.kode_petugas == null &&
				this.paging.kode_rembug == null &&
				this.paging.from_date == null &&
				this.paging.thru_date == null) {
				this.notify("info", "Info", "Please entry a filter before export!");
				return false;
			}

			this.showOverlay = true;
			const payload = `kode_cabang=${this.paging.kode_cabang}&kode_petugas=${this.paging.kode_petugas}&kode_rembug=${this.paging.kode_rembug}&from_date=${this.paging.from_date}&thru_date=${this.paging.thru_date}`;
			const req = await easycoApi.listReportPelunasanPembiayaanExportToCSV(payload);
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
							value: null,
							text: "Please Select",
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
		async doGetPetugas() {
			this.opt.kode_petugas = [];
			let payload = {
				perPage: "~",
				page: 1,
				sortBy: "tgl_gabung",
				sortDir: "ASC",
				search: "",
				kode_cabang: this.paging.kode_cabang,
			};
			try {
				let req = await easycoApi.pegawaiRead(payload, this.user.token);
				let { data, status, msg } = req.data;
				if (status) {
					this.opt.kode_petugas = [
						{
							value: null,
							text: "Please Select",
						},
					];
					data.map((item) => {
						this.opt.kode_petugas.push({
							value: item.kode_pgw,
							text: item.nama_pgw,
						});
					});
				}
			} catch (error) {
				console.error(error);
			}
		},
		async doGetMajelis() {
			this.opt.kode_rembug = [];
			let payload = {
				perPage: "~",
				page: 1,
				sortBy: "kode_rembug",
				sortDir: "ASC",
				search: "",
				kode_cabang: this.paging.kode_cabang,
			};
			try {
				let req = await easycoApi.rembugRead(payload, this.user.token);
				let { data, status, msg } = req.data;
				if (status) {
					this.opt.kode_rembug = [
						{
							value: null,
							text: "Please Select",
						},
					];
					data.map((item) => {
						this.opt.kode_rembug.push({
							value: item.kode_rembug,
							text: item.nama_rembug,
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
				let req = await easycoApi.listReportPelunasanPembiayaan(payload, this.user.token);
				let { data, status, msg, total } = req.data;
				if (status) {
					if (data && data.length > 0) {
						data.forEach(item => {
							item.pokok = this.numberFormat(item.pokok, 0);
							item.margin = this.numberFormat(item.margin, 0);
							item.jangka_waktu = this.numberFormat(item.jangka_waktu, 0);
							item.counter_angsuran = this.numberFormat(item.counter_angsuran, 0);
							item.saldo_pokok = this.numberFormat(item.saldo_pokok, 0);
							item.saldo_margin = this.numberFormat(item.saldo_margin, 0);
							item.saldo_catab = this.numberFormat(item.saldo_catab, 0);
							item.potongan_margin = this.numberFormat(item.potongan_margin, 0);
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
				this.notify("danger", "Error", error);
			} finally {
				this.showOverlay = false;
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

			const singleObjKodeCabang = this.opt.kode_cabang.find(item => item.value == this.paging.kode_cabang);
			const singleObjKodePetugas = this.opt.kode_petugas.find(item => item.value == this.paging.kode_petugas);
			const singleObjKodeRembug = this.opt.kode_rembug.find(item => item.value == this.paging.kode_rembug);

			this.report.nama_cabang = (singleObjKodeCabang?.value != null ? singleObjKodeCabang?.text : '');
			this.report.nama_petugas = (singleObjKodePetugas?.value != null ? singleObjKodePetugas?.text : '');
			this.report.nama_rembug = (singleObjKodeRembug?.value != null ? singleObjKodeRembug?.text : '');

			try {
				let req = await easycoApi.listReportPelunasanPembiayaan(payload, this.user.token);
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