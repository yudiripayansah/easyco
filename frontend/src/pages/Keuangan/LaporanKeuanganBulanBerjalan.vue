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
								<b-input-group prepend="Jenis">
									<b-form-select v-model="paging.jenis" :options="opt.jenis" />
								</b-input-group>
							</b-col>
							<b-col>
								<b-input-group prepend="Tanggal">
									<b-form-datepicker v-model="paging.closing_date" />
								</b-input-group>
							</b-col>
						</div>
					</b-col>
					<b-col cols="2" class="d-flex justify-content-end align-items-start">
						<b-button-group>
							<b-button text="Button" variant="danger" @click="doExportTo(1)">
								PDF
							</b-button>
							<b-button text="Button" variant="success" @click="doExportTo(2)">
								XLS
							</b-button>
						</b-button-group>
					</b-col>
				</b-row>
			</b-card>
		</b-overlay>
	</div>
</template>
      
<script>
import helper from "@/core/helper";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";

export default {
	name: "LaporanKeuanganBulanBerjalan",
	components: {},
	data() {
		return {
			paging: {
				page: 1,
				perPage: 10,
				sortDesc: true,
				sortBy: "id",
				search: "",
				status: "~",
				kode_cabang: '',
				jenis: '',
				closing_date: '',
			},
			opt: {
				kode_cabang: [
					{
						value: '',
						text: "All",
					},
				],
				jenis: [
					{
						value: '',
						text: "All",
					},
				],
				closing_date: [
					{
						value: '',
						text: "All",
					},
				],
			},
			showOverlay: false
		};
	},
	computed: {
		...mapGetters(["user"]),
	},
	watch: {
	},
	mounted() {
		this.doGetCabang();
		this.doGetJenis();
	},
	methods: {
		...helper,
		doExportTo(flag = 0) {
			if (!this.paging || this.paging.kode_cabang == null || !this.paging.jenis || this.paging.jenis.kode_value == null || this.paging.closing_date == null) {
				this.notify("info", "Info", "Please select a filter before export!");
				return false;
			}

			const jenisItem = this.opt.jenis.find(item => item.value?.kode_value === this.paging.jenis.kode_value);

			if (!jenisItem && flag === 0) {
				this.notify("info", "Info", "Oops! Something went wrong.");
				return false;
			}

			const baseUrl = flag === 1 ? jenisItem.value.url_pdf : jenisItem.value.url_xls;
			const url = `${baseUrl}${this.paging.kode_cabang}/${this.paging.jenis.kode_value}/${this.paging.closing_date}`;

			window.open(url, "_blank");
		},
		async doGetCabang() {
			this.showOverlay = true;
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
			} finally {
				this.showOverlay = false;
			}
		},
		async doGetJenis() {
			let payload = `kode=1`;
			try {
				let req = await easycoApi.getReportSetup(payload, this.user.token);
				let { data, status, msg } = req.data;
				if (status) {
					this.opt.jenis = [
						{
							value: '',
							text: "All",
						},
					];
					data.map((item) => {
						this.opt.jenis.push({
							value: item,
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
    