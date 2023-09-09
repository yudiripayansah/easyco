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
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>Nama Anggota</th>
                                <th>Alasan Mutasi</th>
                                <th>Keterangan Mutasi</th>
                                <th>Tanggal Mutasi</th>
                                <th>Saldo Pokok</th>
                                <th>Saldo Margin</th>
                                <th>Saldo Catab</th>
                                <th>Saldo Minggon</th>
                                <th>Saldo Sukarela</th>
                                <th>Saldo Tab Berencana</th>
                                <th>Saldo Deposito</th>
                                <th>Saldo Simpanan Pokok</th>
                                <th>Saldo Simpanan Wajib</th>
                                <th>Bonus Bagi Hasil</th>
                                <th>Penarikan Sukarela</th>
                                <th>Nama Petugas</th>
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
                kode_cabang: null,
                from_date: null,
                thru_date: null,
            },
            paging: {
                page: 1,
                perPage: 10,
                sortDesc: true,
                sortBy: "id",
                search: "",
                status: "~",
                kode_cabang: "00000",
                kode_rembug: null,
                from_date: null,
                thru_date: null,
            },
            opt: {
                kode_cabang: [],
                kode_rembug: [],
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
        doPrintPdf() {
            let filename = "ANGGOTA KELUAR";
            if (this.report.kode_cabang) filename += ` - Cabang ${this.report.kode_cabang}`;
            if (this.report.from_date && this.report.thru_date) {
                filename += ` - Dari ${this.dateFormatId(
                    this.report.from_date
                )} Sampai ${this.dateFormatId(this.report.thru_date)}`;
            }
            let element = document.getElementById("table-print");
            let options = {
                margin: 0,
                filename: `${filename}.pdf`,
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
            let filename = "ANGGOTA KELUAR";
            if (this.report.kode_cabang) filename += ` - Cabang ${this.report.kode_cabang}`;
            if (this.report.from_date && this.report.thru_date) {
                filename += ` - Dari ${this.dateFormatId(
                    this.report.from_date
                )} Sampai ${this.dateFormatId(this.report.thru_date)}`;
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
            this.notify("info", "Info!", "Sorry, this feature in under development!");
        },
        async exportCsv() {
            this.notify("info", "Info!", "Sorry, this feature in under development!");
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
        async doGet() {
            let payload = this.paging;
            payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
            payload.perPage = 10;
            this.table.loading = true;
            try {
                let params = new FormData();
                params.append('kode_cabang', payload.kode_cabang);
                params.append('kode_rembug', payload.kode_rembug);
                params.append('from_date', payload.from_date);
                params.append('thru_date', payload.thru_date);

                let req = await easycoApi.listAnggotaKeluar(params, this.user.token);
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
                this.notify("danger", "Error", error);
            }
        },
        async doGetReport() {
            let payload = this.paging;
            payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
            payload.perPage = "~";
            this.report.loading = true;
            this.report.from_date = payload.from;
            this.report.thru_date = payload.to;
            this.report.kode_cabang = this.getCabangName(payload.kode_cabang);
            try {
                let params = new FormData();
                params.append('kode_cabang', payload.kode_cabang);
                params.append('kode_rembug', payload.kode_rembug);
                params.append('from_date', payload.from_date);
                params.append('thru_date', payload.thru_date);

                let req = await easycoApi.listAnggotaKeluar(params, this.user.token);
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
    