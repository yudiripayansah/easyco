<template>
    <div>
        <h1 class="mb-5">{{ $route.name }}</h1>
        <b-overlay :show="showOverlay" rounded="sm">
            <b-card>
                <b-row no-gutters>
                    <b-col cols="8" class="mb-5">
                        <div class="row mb-3">
                            <b-col>
                                <b-input-group prepend="Cabang">
                                    <b-form-select v-model="paging.kode_cabang" :options="opt.kode_cabang"
                                        @change="doGetMajelis()" />
                                </b-input-group>
                            </b-col>
                            <b-col>
                                <b-input-group prepend="Majelis">
                                    <b-form-select v-model="paging.kode_rembug" :options="opt.kode_rembug" />
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
                    <b-col cols="4" class="d-flex justify-content-end align-items-start">
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

        <b-modal title="PREVIEW ANGGOTA KELUAR" id="modal-pdf" hide-footer size="xl" centered>
            <div id="table-print" class="p-5">
                <h5 class="text-center">
                    KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
                </h5>
                <h5 class="text-center">ANGGOTA KELUAR</h5>
                <h5 class="text-center" v-show="report.kode_cabang">{{ report.kode_cabang }}</h5>
                <h6 class="text-center mb-5 pb-5" v-show="report.from_date && report.thru_date">
                    Tanggal {{ dateFormatId(report.from_date) }} s.d
                    {{ dateFormatId(report.thru_date) }}
                </h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th v-for="table in table.fields" :key="table.key" :class="table.thClass">{{ table.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="report.items.length > 0">
                            <tr v-for="(report, reportIndex) in report.items" :key="`report-${reportIndex}`">
                                <td>{{ reportIndex + 1 }}</td>
                                <td>{{ report.no_anggota }}</td>
                                <td>{{ report.nama_anggota }}</td>
                                <td>{{ report.alasan_mutasi }}</td>
                                <td>{{ report.keterangan_mutasi }}</td>
                                <td>{{ report.tanggal_mutasi }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_pokok) }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_margin) }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_catab) }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_minggon) }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_sukarela) }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_tab_berencana) }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_deposito) }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_simpok) }}</td>
                                <td class="text-right">Rp {{ thousand(report.saldo_simwa) }}</td>
                                <td class="text-right">Rp {{ thousand(report.bonus_bagihasil) }}</td>
                                <td class="text-right">Rp {{ thousand(report.penarikan_sukarela) }}</td>
                                <td>{{ report.nama_petugas }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr class="text-center">
                                <td colspan="18">There's no data to display...</td>
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
    name: "AnggotaKeluar",
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
                        key: "no_anggota",
                        sortable: true,
                        label: "Nama Anggota",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "nama_anggota",
                        sortable: true,
                        label: "Nama Anggota",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "alasan_mutasi",
                        sortable: false,
                        label: "Alasan Mutasi",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "keterangan_mutasi",
                        sortable: false,
                        label: "Keterangan Mutasi",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "tanggal_mutasi",
                        sortable: true,
                        label: "Tanggal Mutasi",
                        thClass: "text-center",
                        tdClass: "",
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
                        key: "saldo_minggon",
                        sortable: true,
                        label: "Saldo Minggon",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_sukarela",
                        sortable: true,
                        label: "Saldo Sukarela",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_tab_berencana",
                        sortable: true,
                        label: "Saldo Tab Berencana",
                        thClass: "saldo_tab_berencana",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_deposito",
                        sortable: true,
                        label: "Saldo Deposito",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_simpok",
                        sortable: true,
                        label: "Saldo Simpanan Pokok",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_simwa",
                        sortable: true,
                        label: "Saldo Simpanan Wajib",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "bonus_bagihasil",
                        sortable: true,
                        label: "Bonus Bagi Hasil",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "penarikan_sukarela",
                        sortable: true,
                        label: "Penarikan Sukarela",
                        thClass: "penarikan_sukarela",
                        tdClass: "text-right",
                    },
                    {
                        key: "nama_petugas",
                        sortable: true,
                        label: "Nama Petugas",
                        thClass: "text-center",
                        tdClass: "",
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
                        key: "no_anggota",
                        sortable: true,
                        label: "Nama Anggota",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "nama_anggota",
                        sortable: true,
                        label: "Nama Anggota",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "alasan_mutasi",
                        sortable: false,
                        label: "Alasan Mutasi",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "keterangan_mutasi",
                        sortable: false,
                        label: "Keterangan Mutasi",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "tanggal_mutasi",
                        sortable: true,
                        label: "Tanggal Mutasi",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "saldo_pokok",
                        sortable: true,
                        label: "Saldo Pokok",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "saldo_margin",
                        sortable: true,
                        label: "Saldo Margin",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "saldo_catab",
                        sortable: true,
                        label: "Saldo Catab",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "saldo_minggon",
                        sortable: true,
                        label: "Saldo Minggon",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "saldo_sukarela",
                        sortable: true,
                        label: "Saldo Sukarela",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "saldo_tab_berencana",
                        sortable: true,
                        label: "Saldo Tab Berencana",
                        thClass: "saldo_tab_berencana",
                        tdClass: "",
                    },
                    {
                        key: "saldo_deposito",
                        sortable: true,
                        label: "Saldo Deposito",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "saldo_simpok",
                        sortable: true,
                        label: "Saldo Simpanan Pokok",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "saldo_simwa",
                        sortable: true,
                        label: "Saldo Simpanan Wajib",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "bonus_bagihasil",
                        sortable: true,
                        label: "Bonus Bagi Hasil",
                        thClass: "text-center",
                        tdClass: "",
                    },
                    {
                        key: "penarikan_sukarela",
                        sortable: true,
                        label: "Penarikan Sukarela",
                        thClass: "penarikan_sukarela",
                        tdClass: "",
                    },
                    {
                        key: "nama_petugas",
                        sortable: true,
                        label: "Nama Petugas",
                        thClass: "text-center",
                        tdClass: "",
                    },
                ],
                items: [],
                loading: false,
                totalRows: 0,
            },
            paging: {
                page: 1,
                perPage: 10,
                sortDesc: true,
                sortBy: "id",
                search: "",
                status: "~",
                kode_cabang: '',
                kode_rembug: '',
                from_date: '',
                thru_date: '',
            },
            opt: {
                kode_cabang: [
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
            },
            showOverlay: false
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
            const singleObjKodeRembug = this.opt.kode_rembug.find(item => item.value == this.paging.kode_rembug);

            let fileName = "ANGGOTA KELUAR_";
            if (this.paging.kode_cabang) fileName += `Cabang ${(singleObjKodeCabang?.value != null ? singleObjKodeCabang?.text : '')}_`;
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
            this.showOverlay = true;
            let payload = `kode_cabang=${this.paging.kode_cabang}&kode_rembug=${this.paging.kode_rembug}&from_date=${this.paging.from_date}&thru_date=${this.paging.thru_date}`;
            const req = await easycoApi.listAnggotaKeluarExportToXLSX(payload);
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
            let payload = `kode_cabang=${this.paging.kode_cabang}&kode_rembug=${this.paging.kode_rembug}&from_date=${this.paging.from_date}&thru_date=${this.paging.thru_date}`;
            let req = await easycoApi.listAnggotaKeluarExportToCSV(payload);
            const url = window.URL.createObjectURL(new Blob([req.data]));
            const link = document.createElement("a");
            const fileName = `${this.getFileName()}.csv`;
            link.href = url;
            link.setAttribute("download", fileName);
            document.body.appendChild(link);
            link.click();
            this.showOverlay = false;
        },
        getCabangName(id) {
            if (id > 0) {
                let cabangName = this.opt.kode_cabang.find((i) => i.value == id);
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
            this.paging.kode_rembug = '';
            this.paging.from_date = '';
            this.paging.thru_date = '';
            this.opt.kode_rembug = [
                {
                    value: '',
                    text: "All",
                },
            ];

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
        async doGetMajelis() {
            this.paging.from_date = '';
            this.paging.thru_date = '';

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
                            value: '',
                            text: "All",
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
                let req = await easycoApi.listAnggotaKeluar(payload, this.user.token);
                let { data, status, msg, total } = req.data;
                if (status) {
                    if (data && data.length > 0) {
                        data.forEach(item => {
                            item.saldo_pokok = this.numberFormat(item.saldo_pokok, 0);
                            item.saldo_margin = this.numberFormat(item.saldo_margin, 0);
                            item.saldo_catab = this.numberFormat(item.saldo_catab, 0);
                            item.saldo_minggon = this.numberFormat(item.saldo_minggon, 0);
                            item.saldo_sukarela = this.numberFormat(item.saldo_sukarela, 0);
                            item.saldo_tab_berencana = this.numberFormat(item.saldo_tab_berencana, 0);
                            item.saldo_deposito = this.numberFormat(item.saldo_deposito, 0);
                            item.saldo_simpok = this.numberFormat(item.saldo_simpok, 0);
                            item.saldo_simwa = this.numberFormat(item.saldo_simwa, 0);
                            item.bonus_bagihasil = this.numberFormat(item.bonus_bagihasil, 0);
                            item.penarikan_sukarela = this.numberFormat(item.penarikan_sukarela, 0);
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
            try {
                let req = await easycoApi.listAnggotaKeluar(payload, this.user.token);
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
    