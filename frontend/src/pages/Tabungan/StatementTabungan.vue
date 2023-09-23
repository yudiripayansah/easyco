<template>
    <div>
        <h1 class="mb-5">{{ $route.name }}</h1>
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
                                <b-form-select v-model="paging.kode_rembug" :options="opt.kode_rembug"
                                    @change="doGetAnggota()" />
                            </b-input-group>
                        </b-col>
                    </div>
                    <div class="row">
                        <b-col>
                            <b-input-group prepend="Anggota">
                                <b-form-select v-model="paging.no_anggota" :options="opt.no_anggota"
                                    @change="doGetRekening()" />
                            </b-input-group><br />
                        </b-col>
                        <b-col>
                            <b-input-group prepend="Tabungan">
                                <b-form-select v-model="paging.jenis_tabungan" :options="opt.jenis_tabungan" />
                            </b-input-group><br />
                        </b-col>
                        <b-col>
                            <b-input-group prepend="Rekening">
                                <b-form-select v-model="paging.no_rekening" :options="opt.no_rekening" />
                            </b-input-group><br />
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
                    <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
                        show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
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

        <b-modal title="PREVIEW STATEMENT TABUNGAN" id="modal-pdf" hide-footer size="xl" centered>
            <div id="table-print" class="p-5">
                <h5 class="text-center">
                    KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
                </h5>
                <h5 class="text-center">STATEMENT TABUNGAN</h5>
                <h5 class="text-center" v-show="report.kode_cabang">Cabang: {{ report.kode_cabang }}</h5>
                <h5 class="text-center" v-show="report.kode_rembug">Majelis: {{ report.kode_rembug }}</h5>
                <h5 class="text-center" v-show="report.no_anggota">No Anggota: {{ report.no_anggota }}</h5>
                <h5 class="text-center" v-show="report.jenis_tabungan">Jenis Tabungan: {{
                    (opt.jenis_tabungan[report.jenis_tabungan] ? opt.jenis_tabungan[report.jenis_tabungan].text : '') }}
                </h5>
                <h5 class="text-center" v-show="report.no_rekening">No. Rekening: {{ report.no_rekening }}</h5>
                <h6 class="text-center mb-5 pb-5" v-show="report.from_date && report.thru_date">
                    Tanggal {{ dateFormatId(report.from_date) }} s.d
                    {{ dateFormatId(report.thru_date) }}
                </h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Trx Date</th>
                                <th>Setor</th>
                                <th>Tarik</th>
                                <th>Saldo Akhir</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody v-if="report.items.length > 0">
                            <tr v-for="(report, reportIndex) in report.items" :key="`report-${reportIndex}`">
                                <td>{{ reportIndex + 1 }}</td>
                                <td class="text-center">{{ dateFormatId(report.trx_date) }}</td>
                                <td class="text-right">Rp {{ numberFormat(report.setor, 0) }}</td>
                                <td class="text-right">Rp {{ numberFormat(report.tarik, 0) }}</td>
                                <td class="text-right">Rp {{ numberFormat(report.saldo_akhir, 0) }}</td>
                                <td>{{ report.keterangan }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr class="text-center">
                                <td colspan="6">There's no data to display...</td>
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
    name: "StatementTabungan",
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
                        key: "trx_date",
                        sortable: true,
                        label: "Trx Date",
                        thClass: "text-center",
                        tdClass: "text-center",
                    },
                    {
                        key: "setor",
                        sortable: false,
                        label: "Setor",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "tarik",
                        sortable: false,
                        label: "Tarik",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_akhir",
                        sortable: false,
                        label: "Saldo Akhir",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "keterangan",
                        sortable: true,
                        label: "Keterangan",
                        thClass: "text-left",
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
                        key: "trx_date",
                        sortable: true,
                        label: "Trx Date",
                        thClass: "text-center",
                        tdClass: "text-center",
                    },
                    {
                        key: "setor",
                        sortable: false,
                        label: "Setor",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "tarik",
                        sortable: false,
                        label: "Tarik",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_akhir",
                        sortable: false,
                        label: "Saldo Akhir",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "keterangan",
                        sortable: true,
                        label: "Keterangan",
                        thClass: "text-left",
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
                kode_cabang: null,
                kode_rembug: null,
                no_anggota: null,
                jenis_tabungan: null,
                no_rekening: null,
                from_date: null,
                thru_date: null,
            },
            opt: {
                kode_cabang: [],
                kode_rembug: [],
                no_anggota: [],
                jenis_tabungan: [
                    {
                        value: 0,
                        text: "All",
                    },
                    {
                        value: 1,
                        text: "Tabungan Sukarela",
                    },
                    {
                        value: 2,
                        text: "Tabungan Berencana",
                    },
                    {
                        value: 3,
                        text: "Tabungan Simpanan Wajib/Minggon",
                    }
                ],
                no_rekening: [],
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
    },
    methods: {
        ...helper,
        validateFilter() {
            if (this.paging.no_anggota == null &&
                this.paging.jenis_tabungan == null &&
                this.paging.from_date == null &&
                this.paging.thru_date == null) {
                this.notify("info", "Info", "Please entry a filter before export!");
                return false;
            }
        },
        getFileName() {
            let fileName = "STATEMENT TABUNGAN";
            if (this.paging.kode_cabang) fileName += ` - Cabang ${this.paging.kode_cabang}`;
            if (this.paging.kode_rembug) fileName += ` - Majelis ${this.paging.kode_rembug}`;
            if (this.paging.no_anggota) fileName += ` - Anggota ${this.paging.no_anggota}`;
            if (this.paging.jenis_tabungan) fileName += ` - Tabungan ${(this.opt.jenis_tabungan[this.paging.jenis_tabungan] ? this.opt.jenis_tabungan[this.paging.jenis_tabungan].text : '')}`;
            if (this.paging.no_rekening) fileName += ` - Rekening ${this.paging.no_rekening}`;
            if (this.paging.from_date && this.paging.thru_date) {
                fileName += ` - Dari ${this.dateFormatId(
                    this.paging.from_date
                )} Sampai ${this.dateFormatId(this.paging.thru_date)}`;
            }
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
            this.validateFilter();
            let payload = `no_anggota=${this.paging.no_anggota}&jenis_tabungan=${this.paging.jenis_tabungan}&from_date=${this.paging.from_date}&thru_date=${this.paging.thru_date}`;
            const req = await easycoApi.listStatementTabunganExportToXLSX(payload);
            const url = window.URL.createObjectURL(new Blob([req.data]));
            const link = document.createElement("a");
            const fileName = `${this.getFileName()}.xlsx`;
            link.href = url;
            link.setAttribute("download", fileName);
            document.body.appendChild(link);
            link.click();
        },
        async exportCsv() {
            this.validateFilter();
            let payload = `no_anggota=${this.paging.no_anggota}&jenis_tabungan=${this.paging.jenis_tabungan}&from_date=${this.paging.from_date}&thru_date=${this.paging.thru_date}`;
            let req = await easycoApi.listStatementTabunganExportToCSV(payload);
            const url = window.URL.createObjectURL(new Blob([req.data]));
            const link = document.createElement("a");
            const fileName = `${this.getFileName()}.csv`;
            link.href = url;
            link.setAttribute("download", fileName);
            document.body.appendChild(link);
            link.click();
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
                            value: 0,
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
            // reset value
            this.paging.kode_rembug = null;
            this.paging.no_anggota = null;
            this.paging.jenis_tabungan = null;
            this.paging.no_rekening = null;
            this.opt.no_anggota = [];
            this.opt.no_rekening = [];

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
                            value: 0,
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
        async doGetAnggota() {
            // reset value
            this.paging.no_anggota = null;
            this.paging.jenis_tabungan = null;
            this.paging.no_rekening = null;
            this.opt.no_rekening = [];

            this.opt.no_anggota = [];
            let payload = {
                perPage: "~",
                page: 1,
                sortBy: "kode_rembug",
                sortDir: "ASC",
                search: "",
                cabang: this.paging.kode_cabang,
                rembug: this.paging.kode_rembug,
            };
            try {
                let req = await easycoApi.anggotaRead(payload, this.user.token);
                let { data, status, msg } = req.data;
                if (status) {
                    this.opt.no_anggota = [
                        {
                            value: 0,
                            text: "All",
                        },
                    ];
                    data.map((item) => {
                        this.opt.no_anggota.push({
                            value: Number(item.no_anggota),
                            text: item.nama_anggota,
                            data: item,
                        });
                    });
                } else {
                    this.notify("danger", "Error", msg);
                }
            } catch (error) {
                console.error(error);
                this.notify("danger", "Login Error", error);
            }
        },
        async doGetRekening() {
            // reset value
            this.paging.jenis_tabungan = null;
            this.paging.no_rekening = null;
            this.opt.no_rekening = [];

            this.opt.no_rekening = [];
            let payload = {
                no_anggota: this.paging.no_anggota,
            };
            try {
                let req = await easycoApi.getRekeningTabungan(payload, this.user.token);
                let { data, msg } = req.data;
                if (data.length > 0) {
                    this.opt.no_rekening = [
                        {
                            value: 0,
                            text: "All",
                        },
                    ];
                    data.map((item) => {
                        console.log({ item });
                        this.opt.no_rekening.push({
                            value: Number(item.no_rekening),
                            text: item.no_rekening,
                            data: item,
                        });
                    });
                } else {
                    this.notify("danger", "Error", msg);
                }
            } catch (error) {
                console.error(error);
                this.notify("danger", "Login Error", error);
            }
        },
        async doGet() {
            let payload = this.paging;
            payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
            payload.perPage = 10;
            this.table.loading = true;
            try {
                let params = new FormData();
                params.append('no_anggota', (payload.no_anggota == null ? '1010200000254' : payload.no_anggota));
                params.append('jenis_tabungan', (payload.jenis_tabungan == null ? '1' : payload.jenis_tabungan));
                params.append('no_rekening', (payload.no_rekening == null ? '101020000025409901' : payload.no_rekening));
                params.append('from_date', (payload.from_date == null ? '2023-01-01' : payload.from_date));
                params.append('thru_date', (payload.thru_date == null ? '2023-01-01' : payload.thru_date));

                let req = await easycoApi.listStatementTabungan(params, this.user.token);
                let { data, status, msg, total } = req.data;
                if (status) {
                    if (data && data.length > 0) {
                        data.forEach(item => {
                            item.setor = this.numberFormat(item.setor, 0);
                            item.tarik = this.numberFormat(item.tarik, 0);
                            item.saldo_akhir = this.numberFormat(item.saldo_akhir, 0);
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
                let params = new FormData();
                params.append('no_anggota', (payload.no_anggota == null ? '1010200000254' : payload.no_anggota));
                params.append('jenis_tabungan', (payload.jenis_tabungan == null ? '1' : payload.jenis_tabungan));
                params.append('no_rekening', (payload.no_rekening == null ? '101020000025409901' : payload.no_rekening));
                params.append('from_date', (payload.from_date == null ? '2023-01-01' : payload.from_date));
                params.append('thru_date', (payload.thru_date == null ? '2023-01-01' : payload.thru_date));

                let req = await easycoApi.listStatementTabungan(params, this.user.token);
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
    