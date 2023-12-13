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
                                    <b-form-select v-model="paging.kode_cabang" :options="opt.kode_cabang" @change="doGetPetugas()" />
                                </b-input-group>
                            </b-col>
                            <b-col>
                                <b-input-group prepend="Petugas">
                                    <b-form-select v-model="paging.kode_pgw" :options="opt.kode_pgw" @change="doGetRembug()" />
                                </b-input-group>
                            </b-col>
                            <b-col>
                                <b-input-group prepend="Majelis">
                                    <b-form-select v-model="paging.kode_rembug" :options="opt.kode_rembug" />
                                </b-input-group>
                            </b-col>
                            <b-col>
                                <b-input-group prepend="Produk">
                                    <b-form-select v-model="paging.kode_produk" :options="opt.kode_produk" />
                                </b-input-group>
                            </b-col>
                        </div>
                    </b-col>
                    <b-col cols="2" class="d-flex justify-content-end align-items-start">
                        <b-button-group>
                            <!-- <b-button text="Button" variant="danger" @click="
                                $bvModal.show('modal-pdf');
                            doGetReport();
                            ">
                                PDF
                            </b-button> -->
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
                            :items="table.items" :per-page="paging.perPage" :current-page="paging.currentPage" show-empty
                            :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
                            <template #cell(no)="item">
                                {{ item.index + 1 }}
                            </template>
                        </b-table>
                    </b-col>
                    <b-col cols="12" class="justify-content-end d-flex">
                        <b-pagination v-model="paging.page" :total-rows="table.totalRows" :per-page="paging.perPage"
                            aria-controls="my-table"></b-pagination>
                    </b-col>
                </b-row>
            </b-card>
        </b-overlay>

        <b-modal title="PREVIEW SALDO TABUNGAN" id="modal-pdf" hide-footer size="xl" centered>
            <div id="table-print" class="p-5">
                <h5 class="text-center">
                    KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
                </h5>
                <h5 class="text-center">SALDO TABUNGAN</h5>
                <h5 class="text-center" v-show="report.nama_cabang">Cabang: {{ report.nama_cabang }}</h5>
                <h5 class="text-center" v-show="report.nama_produk">Produk: {{ report.nama_produk }}</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th v-for="table in table.fields" :key="table.key" :class="table.thClass">{{ table.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="report.loading">
                            <tr class="text-center">
                                <td>Memuat data...</td>
                            </tr>
                        </tbody>
                        <tbody v-if="report && report.items && report.items.length > 0">
                            <tr v-for="(report, reportIndex) in report.items" :key="`report-${reportIndex}`">
                                <td>{{ reportIndex + 1 }}</td>
                                <td class="text-center">{{ report.no_rekening }}</td>
                                <td class="text-left">{{ report.nama_rembug }}</td>
                                <td class="text-left">{{ report.nama_pgw }}</td>
                                <td class="text-center">{{ report.no_anggota }}</td>
                                <td class="text-left">{{ report.nama_produk }}</td>
                                <td class="text-right">{{ report.saldo }}</td>
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
    name: "SaldoTabungan",
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
                        key: "no_rekening",
                        sortable: true,
                        label: "No Rekening",
                        thClass: "text-center",
                        tdClass: "text-center",
                    },
                    {
                        key: "nama_rembug",
                        sortable: true,
                        label: "Nama Majelis",
                        thClass: "text-center",
                        tdClass: "text-left",
                    },
                    {
                        key: "nama_pgw",
                        sortable: true,
                        label: "Nama Pegawai",
                        thClass: "text-center",
                        tdClass: "text-left",
                    },
                    {
                        key: "no_anggota",
                        sortable: true,
                        label: "No Anggota",
                        thClass: "text-center",
                        tdClass: "text-center",
                    },
                    {
                        key: "nama_produk",
                        sortable: true,
                        label: "Nama Produk",
                        thClass: "text-center",
                        tdClass: "text-left",
                    },
                    {
                        key: "saldo",
                        sortable: true,
                        label: "Saldo",
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
                        key: "no",
                        sortable: false,
                        label: "No",
                        thClass: "text-center w-5p",
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
                        key: "nama_rembug",
                        sortable: false,
                        label: "nama_rembug",
                        thClass: "text-center",
                        tdClass: "text-left",
                    },
                    {
                        key: "nama_pgw",
                        sortable: false,
                        label: "nama_pgw",
                        thClass: "text-center",
                        tdClass: "text-left",
                    },
                    {
                        key: "no_anggota",
                        sortable: false,
                        label: "no_anggota",
                        thClass: "text-center",
                        tdClass: "text-center",
                    },
                    {
                        key: "nama_produk",
                        sortable: false,
                        label: "nama_produk",
                        thClass: "text-center",
                        tdClass: "text-left",
                    },
                    {
                        key: "saldo",
                        sortable: false,
                        label: "saldo",
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
                kode_pgw: '',
                kode_rembug: '',
                kode_produk: '',
                nama_cabang: '',
                nama_pgw: '',
                nama_rembug: '',
                nama_produk: '',
            },
            opt: {
                kode_cabang: [
                    {
                        value: '',
                        text: "All",
                    },
                ],
                kode_pgw: [
                    {
                        value: '',
                        text: "All",
                    },
                ],
                kode_rembug: [
                    {
                        value: '',
                        text: "All",
                    },
                ],
                kode_produk: [
                    {
                        value: '',
                        text: "All",
                    },
                ],
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
        this.doGetPetugas();
        this.doGetRembug();
        this.doGetProduk();
    },
    methods: {
        ...helper,
        getFileName() {
            const singleObjKodeCabang = this.opt.kode_cabang.find(item => item.value == this.paging.kode_cabang);
            const singleObjKodeProduk = this.opt.kode_produk.find(item => item.value == this.paging.kode_produk);

            let fileName = "SALDO TABUNGAN_";
            fileName += `Cabang-${(singleObjKodeCabang?.value != null ? singleObjKodeCabang?.text : '')}_`;
            fileName += `Produk-${(singleObjKodeProduk?.value != null ? singleObjKodeProduk?.text : '')}`;
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
            const payload = `kode_cabang=${this.paging.kode_cabang}&kode_produk=${this.paging.kode_produk}`;
            const req = await easycoApi.listReportSaldoTabunganExportToXLSX(payload);
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
            const payload = `kode_cabang=${this.paging.kode_cabang}&kode_produk=${this.paging.kode_produk}`;
            const req = await easycoApi.listReportSaldoTabunganExportToCSV(payload);
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
            this.opt.kode_cabang = [];
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
        async doGetPetugas() {
            this.opt.kode_pgw = [];
            let payload = {
                perPage: "~",
                page: 1,
                sortBy: "nama_pgw",
                sortDir: "ASC",
                search: "",
                kode_cabang: this.paging.kode_cabang,
            };
            try {
                let req = await easycoApi.pegawaiRead(payload, this.user.token);
                let { data, status, msg } = req.data;
                if (status) {
                    this.opt.kode_pgw = [
                        {
                            value:'',
                            text: "All",
                        },
                    ];
                    data.map((item) => {
                        this.opt.kode_pgw.push({
                            value: item.kode_pgw,
                            text: `${item.kode_pgw} - ${item.nama_pgw}`,
                        });
                    });
                }
            } catch (error) {
                console.error(error);
            }
        },
        async doGetRembug() {
            this.opt.kode_rembug = [];
            let payload = {
                perPage: "~",
                page: 1,
                sortBy: "kode_rembug",
                sortDir: "ASC",
                search: "",
                kode_cabang: this.paging.kode_cabang,
                kode_pgw: this.paging.kode_pgw,
            };
            try {
                let req = await easycoApi.anggotaRembug(payload, this.user.token);
                let { data, status, msg } = req.data;
                if (status) {
                    this.opt.kode_rembug = [
                        {
                            value: '',
                            text: "All",
                        },
                    ];
                    data.map((item) => {
                        this.opt.kode_rembug.push({
                            value: item.kode_rembug,
                            text: `${item.kode_rembug} - ${item.nama_rembug}`,
                        });
                    });
                }
            } catch (error) {
                console.error(error);
            }
        },
        async doGetProduk() {
            let payload = {
                perPage: "~",
                page: 0,
                sortBy: "kode_produk",
                sortDir: "ASC",
                search: "",
            };
            try {
                let req = await easycoApi.prdtabunganRead(payload, this.user.token);
                let { data, status, msg } = req.data;
                if (status) {
                    this.opt.kode_produk = [
                        {
                            value: '',
                            text: "All",
                        },
                    ];
                    data.map((item) => {
                        this.opt.kode_produk.push({
                            value: item.kode_produk,
                            text: item.nama_produk,
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
                let req = await easycoApi.listReportSaldoTabungan(payload, this.user.token);
                const {
                    data,
                    status,
                    msg,
                    total,
                    totalPage,
                    perPage,
                    page
                } = req.data;
                if (status) {
                    if (data && data.length > 0) data.forEach(item => item.saldo = this.numberFormat(item.saldo, 0));

                    this.table.items = data;
                    this.table.totalRows = total;
                    this.paging.perPage = Number(perPage);
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
            this.showOverlay = true;
            let payload = this.paging;
            payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
            payload.perPage = "~";
            this.report.loading = true;
            this.report = {
                ...this.paging
            };

            const singleObjKodeCabang = this.opt.kode_cabang.find(item => item.value == this.paging.kode_cabang);
            const singleObjKodeProduk = this.opt.kode_produk.find(item => item.value == this.paging.kode_produk);

            this.report.nama_cabang = (singleObjKodeCabang?.value != null ? singleObjKodeCabang?.text : '');
            this.report.nama_produk = (singleObjKodeProduk?.value != null ? singleObjKodeProduk?.text : '');

            try {
                let req = await easycoApi.listReportSaldoTabungan(payload, this.user.token);
                let { data, status, msg, total, perPage } = req.data;
                if (status) {
                    if (data && data.length > 0) data.forEach(item => item.saldo = this.numberFormat(item.saldo, 0));

                    this.report.items = data;
                    this.report.totalRows = total;
                    this.paging.perPage = Number(perPage);
                } else {
                    this.notify("danger", "Error", msg);
                }
            } catch (error) {
                console.error(error);
                this.notify("danger", "Error", error);
            } finally {
                this.showOverlay = false;
                this.report.loading = false;
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