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
                                <b-input-group prepend="Rekap By">
                                    <b-form-select v-model="paging.rekap_by" :options="opt.rekap_by" />
                                </b-input-group>
                            </b-col>
                            <b-col>
                                <b-input-group prepend="Tanggal">
                                    <b-form-datepicker v-model="paging.tanggal" />
                                </b-input-group>
                            </b-col>
                        </div>
                    </b-col>
                    <b-col cols="2" class="d-flex justify-content-end align-items-start">
                        <b-button-group>
                            <b-button text="Button" variant="danger" @click="
                                $bvModal.show('modal-pdf');
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
                            :items="table.items" :per-page="paging.perPage" :current-page="paging.currentPage" show-empty
                            :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
                            <template #thead-top="table">
                                <b-tr>
                                    <b-th colspan="2"><span class="sr-only"></span></b-th>
                                    <b-th colspan="3" class="text-center">PAR 1</b-th>
                                    <b-th colspan="3" class="text-center">PAR 2</b-th>
                                    <b-th colspan="3" class="text-center">PAR 3</b-th>
                                    <b-th colspan="3" class="text-center">PAR 4</b-th>
                                    <b-th colspan="3" class="text-center">PAR 5</b-th>
                                    <b-th colspan="3" class="text-center">PAR 6</b-th>
                                </b-tr>
                            </template>
                            <template #cell(no)="item">
                                {{ item.index + 1 }}
                            </template>
                        </b-table>
                    </b-col>
                    <b-col cols="12" class="justify-content-end d-flex">
                        <b-pagination v-model="paging.currentPage" :total-rows="table.totalRows" :per-page="paging.perPage">
                        </b-pagination>
                    </b-col>
                </b-row>
            </b-card>
        </b-overlay>

        <b-modal title="PREVIEW PEMBUKAAN TABUNGAN" id="modal-pdf" hide-footer size="xl" centered>
            <div id="table-print" class="p-5">
                <h5 class="text-center">
                    KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
                </h5>
                <h5 class="text-center">PEMBUKAAN TABUNGAN</h5>
                <h5 class="text-center" v-show="paging.nama_cabang">Cabang: {{ paging.nama_cabang }}</h5>
                <h5 class="text-center" v-show="paging.rekap_by_nama">Rekap By: {{ paging.rekap_by_nama }}</h5>
                <h6 class="text-center mb-5 pb-5" v-show="paging.tanggal"> Tanggal {{ dateFormatId(paging.tanggal) }}</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th colspan="2" class=""><span class="sr-only"></span></th>
                                <th colspan="3" class="text-center">PAR 1</th>
                                <th colspan="3" class="text-center">PAR 2</th>
                                <th colspan="3" class="text-center">PAR 3</th>
                                <th colspan="3" class="text-center">PAR 4</th>
                                <th colspan="3" class="text-center">PAR 5</th>
                                <th colspan="3" class="text-center">PAR 6</th>
                            </tr>
                            <tr>
                                <th v-for="table in table.fields" :key="table.key" :class="table.thClass">{{ table.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="table.loading">
                            <tr class="text-center">
                                <td :colspan="table.fields.length">Memuat data...</td>
                            </tr>
                        </tbody>
                        <tbody v-if="table && table.items && table.items.length > 0">
                            <tr v-for="(table, index) in table.items" :key="`table-${index}`">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td class="text-left">{{ table.keterangan }}</td>
                                <td class="text-right">{{ table.jumlah_1 }}</td>
                                <td class="text-right">{{ table.saldo_pokok_1 }}</td>
                                <td class="text-right">{{ table.cpp_1 }}</td>
                                <td class="text-right">{{ table.jumlah_2 }}</td>
                                <td class="text-right">{{ table.saldo_pokok_2 }}</td>
                                <td class="text-right">{{ table.cpp_2 }}</td>
                                <td class="text-right">{{ table.jumlah_3 }}</td>
                                <td class="text-right">{{ table.saldo_pokok_3 }}</td>
                                <td class="text-right">{{ table.cpp_3 }}</td>
                                <td class="text-right">{{ table.jumlah_4 }}</td>
                                <td class="text-right">{{ table.saldo_pokok_4 }}</td>
                                <td class="text-right">{{ table.cpp_4 }}</td>
                                <td class="text-right">{{ table.jumlah_5 }}</td>
                                <td class="text-right">{{ table.saldo_pokok_5 }}</td>
                                <td class="text-right">{{ table.cpp_5 }}</td>
                                <td class="text-right">{{ table.jumlah_6 }}</td>
                                <td class="text-right">{{ table.saldo_pokok_6 }}</td>
                                <td class="text-right">{{ table.cpp_6 }}</td>
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
    name: "LaporanRekapitulasiPar",
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
                        key: "keterangan",
                        sortable: true,
                        label: "Kantor",
                        thClass: "text-center",
                        tdClass: "text-left",
                    },
                    {
                        key: "jumlah_1",
                        sortable: true,
                        label: "Jmlh",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_pokok_1",
                        sortable: true,
                        label: "Saldo Pokok",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "cpp_1",
                        sortable: true,
                        label: "CPP",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "jumlah_2",
                        sortable: true,
                        label: "Jmlh",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_pokok_2",
                        sortable: true,
                        label: "Saldo Pokok",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "cpp_2",
                        sortable: true,
                        label: "CPP",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "jumlah_3",
                        sortable: true,
                        label: "Jmlh",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_pokok_3",
                        sortable: true,
                        label: "Saldo Pokok",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "cpp_3",
                        sortable: true,
                        label: "CPP",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "jumlah_4",
                        sortable: true,
                        label: "Jmlh",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_pokok_4",
                        sortable: true,
                        label: "Saldo Pokok",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "cpp_4",
                        sortable: true,
                        label: "CPP",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "jumlah_5",
                        sortable: true,
                        label: "Jmlh",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_pokok_5",
                        sortable: true,
                        label: "Saldo Pokok",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "cpp_5",
                        sortable: true,
                        label: "CPP",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "jumlah_6",
                        sortable: true,
                        label: "Jmlh",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "saldo_pokok_6",
                        sortable: true,
                        label: "Saldo Pokok",
                        thClass: "text-center",
                        tdClass: "text-right",
                    },
                    {
                        key: "cpp_6",
                        sortable: true,
                        label: "CPP",
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
                nama_cabang: '',
                rekap_by: '',
                rekap_by_nama: '',
                tanggal: '',
            },
            opt: {
                kode_cabang: [
                    {
                        value: '',
                        text: "All",
                    },
                ],
                rekap_by: [
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
        this.doGetRekapBy();
    },
    methods: {
        ...helper,
        getFileName() {
            let fileName = "REKAPITULASI PAR_";
            fileName += `Cabang-${this.paging.nama_cabang}_`;
            fileName += `Rekap By-${this.paging.rekap_by_nama}`;
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
            const payload = `kode_cabang=${this.paging.kode_cabang}&rekap_by=${this.paging.rekap_by}&tanggal=${this.paging.tanggal}`;
            const req = await easycoApi.pembiayaanLaporanRekapParExportToXLSX(payload);
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
            const payload = `kode_cabang=${this.paging.kode_cabang}&rekap_by=${this.paging.rekap_by}&tanggal=${this.paging.tanggal}`;
            const req = await easycoApi.pembiayaanLaporanRekapParExportToCSV(payload);
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
        async doGetRekapBy() {
            let payload = '';
            try {
                let req = await easycoApi.listReportRekapBy(payload, this.user.token);
                let { data, status, msg } = req.data;
                if (status) {
                    this.opt.rekap_by = [
                        {
                            value: '',
                            text: "All",
                        },
                    ];
                    data.map((item) => {
                        this.opt.rekap_by.push({
                            value: item.kode_value,
                            text: item.kode_display,
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

            const singleObjKodeCabang = this.opt.kode_cabang.find(item => item.value == this.paging.kode_cabang);
            const singleObjRekapBy = this.opt.rekap_by.find(item => item.value == this.paging.rekap_by);
            this.paging.nama_cabang = (singleObjKodeCabang?.value != null ? singleObjKodeCabang?.text : '');
            this.paging.rekap_by_nama = (singleObjRekapBy?.value != null ? singleObjRekapBy?.text : '');

            try {
                let req = await easycoApi.pembiayaanLaporanRekapPar(payload, this.user.token);
                let { data, status, msg, total } = req.data;
                if (status) {
                    if (data && data.length > 0) {
                        for (let i = 0; i < data.length; i++) {
                            const item = data[i];
                            item.jumlah_1 = this.numberFormat(item.jumlah_1, 0);
                            item.saldo_pokok_1 = this.numberFormat(item.saldo_pokok_1, 0);
                            item.cpp_1 = this.numberFormat(item.cpp_1, 0);
                            item.jumlah_2 = this.numberFormat(item.jumlah_2, 0);
                            item.saldo_pokok_2 = this.numberFormat(item.saldo_pokok_2, 0);
                            item.cpp_2 = this.numberFormat(item.cpp_2, 0);
                            item.jumlah_3 = this.numberFormat(item.jumlah_3, 0);
                            item.saldo_pokok_3 = this.numberFormat(item.saldo_pokok_3, 0);
                            item.cpp_3 = this.numberFormat(item.cpp_3, 0);
                            item.jumlah_4 = this.numberFormat(item.jumlah_4, 0);
                            item.saldo_pokok_4 = this.numberFormat(item.saldo_pokok_4, 0);
                            item.cpp_4 = this.numberFormat(item.cpp_4, 0);
                            item.jumlah_5 = this.numberFormat(item.jumlah_5, 0);
                            item.saldo_pokok_5 = this.numberFormat(item.saldo_pokok_5, 0);
                            item.cpp_5 = this.numberFormat(item.cpp_5, 0);
                            item.jumlah_6 = this.numberFormat(item.jumlah_6, 0);
                            item.saldo_pokok_6 = this.numberFormat(item.saldo_pokok_6, 0);
                            item.cpp_6 = this.numberFormat(item.cpp_6, 0);
                        }
                    }

                    this.table.items = data;
                    this.table.totalRows = data.length;
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