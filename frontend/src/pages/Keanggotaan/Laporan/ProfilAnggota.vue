<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col cols="8" class="mb-5">
          <div class="row">
            <b-col cols="12">
              <b-input-group prepend="Cabang" class="mb-3">
                <b-form-select v-model="paging.cabang" :options="opt.cabang" />
              </b-input-group>
            </b-col>
            <b-col>
              <b-input-group prepend="Rembug">
<<<<<<< HEAD
                <b-form-select v-model="paging.rembug" :options="opt.rembug" />
=======
                <b-form-select v-model="paging.kode_rembug" :options="opt.kode_rembug" />
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
              </b-input-group>
            </b-col>
            <b-col>
              <b-input-group prepend="Anggota">
<<<<<<< HEAD
                <b-form-select
                  v-model="paging.anggota"
                  :options="opt.anggota"
                /> </b-input-group
              ><br />
=======
                <b-form-select v-model="paging.no_anggota" :options="opt.no_anggota" />
              </b-input-group><br>
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
            </b-col>
          </div>
          <div class="row">
            <b-col cols="12">
              <b-input-group prepend="Nama Anggota" class="mb-3">
<<<<<<< HEAD
                <b-form-input v-model="paging.nama_anggota" />
              </b-input-group>
            </b-col>
            <b-col cols="12">
              <b-input-group prepend="No KTP" class="mb-3">
                <b-form-input v-model="paging.no_ktp" />
              </b-input-group>
            </b-col>
            <b-col cols="12">
              <b-input-group prepend="Alamat" class="mb-3">
                <b-form-textarea v-model="paging.alamat" />
              </b-input-group>
            </b-col>
            <b-col cols="12">
              <b-input-group prepend="Rembug" class="mb-3">
                <b-form-input v-model="paging.rembug" />
              </b-input-group>
=======
                <b-form-input v-model="paging.nama_anggota"/>
              </b-input-group>
            </b-col>
              <b-col cols="12">
                <b-input-group prepend="No KTP" class="mb-3">
                  <b-form-input v-model="paging.no_ktp" />
                </b-input-group>
            </b-col>
              <b-col cols="12">
                <b-input-group prepend="Alamat" class="mb-3">
                  <b-form-textarea v-model="paging.alamat" />
                </b-input-group>
            </b-col>
              <b-col cols="12">
                <b-input-group prepend="Rembug" class="mb-3">
                  <b-form-input v-model="paging.rembug" />
                </b-input-group>
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
            </b-col>
          </div>
        </b-col>
        <b-col cols="4" class="d-flex justify-content-end align-items-start">
          <b-button-group>
<<<<<<< HEAD
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
            <b-button text="Button" variant="success"> XLS </b-button>
            <b-button text="Button" variant="warning"> CSV </b-button>
=======
            <b-button text="Button" variant="danger" @click="$bvModal.show('modal-pdf'); doGetReport()">
              PDF
            </b-button>
            <b-button text="Button" variant="success">
              XLS
            </b-button>
            <b-button text="Button" variant="warning">
              CSV
            </b-button>
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
          </b-button-group>
        </b-col>
        <b-col cols="12">
          <h1 class="text-center">Tabungan Berencana</h1>
<<<<<<< HEAD
          <b-table
            responsive
            bordered
            outlined
            small
            striped
            hover
            :fields="table_1.fields"
            :items="table_1.items"
            show-empty
            :emptyText="table_1.loading ? 'Memuat data...' : 'Tidak ada data'"
          >
            <template #cell(no)="item">
              {{ item.index + 1 }}
            </template>
            <template #cell(action)="item">
              <b-button
                variant="success"
                size="xs"
                class="mx-1"
                @click="doUpdate(item, false)"
              >
                Lihat statement
              </b-button>
            </template>
          </b-table>
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
          <b-pagination
            v-model="paging.page"
            :total-rows="table_1.totalRows"
            :per-page="paging.perPage"
          >
          </b-pagination>
        </b-col>
        <b-col cols="12">
          <h1 class="text-center">Pembiayaan</h1>
          <b-table
            responsive
            bordered
            outlined
            small
            striped
            hover
            :fields="table_2.fields"
            :items="table_2.items"
            show-empty
            :emptyText="table_2.loading ? 'Memuat data...' : 'Tidak ada data'"
          >
            <template #cell(no)="item">
              {{ item.index + 1 }}
            </template>
            <template #cell(action)="item">
              <b-button
                variant="success"
                size="xs"
                class="mx-1"
                @click="doUpdate(item, false)"
              >
                Lihat statement
              </b-button>
            </template>
          </b-table>
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
          <b-pagination
            v-model="paging.page"
            :total-rows="table_1.totalRows"
            :per-page="paging.perPage"
          >
          </b-pagination>
        </b-col>
      </b-row>
    </b-card>
    <!-- <b-modal title="PREVIEW LAPORAN SALDO ANGGOTA" id="modal-pdf" hide-footer size="xl" centered>
        <div id="table-print" class="p-5">
          <h5 class="text-center">KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )</h5>
          <h5 class="text-center">LAPORAN SALDO ANGGOTA</h5>
          <h5 class="text-center" v-show="report.cabang">{{ report.cabang }}</h5>
          <h6 class="text-center mb-5 pb-5" v-show="report.from && report.to">Tanggal {{ dateFormatId(report.from) }} s.d
            {{ dateFormatId(report.to) }}</h6>
          <b-table responsive bordered outlined small striped hover :fields="report.fields" :items="report.items"
            show-empty :emptyText="report.loading ? 'Memuat data...' : 'Tidak ada data'" class="mt-5 pt-5 d-block">
=======
          <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
            show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
            <template #cell(no)="item">
              {{ item.index + 1 }}
            </template>
          </b-table>
<<<<<<< HEAD
        </div>
        <b-row>
          <b-col cols="12" sm="12" class="d-flex justify-content-end border-top pt-5">
            <b-button variant="secondary" @click="$bvModal.hide('modal-pdf')">Cancel
            </b-button>
            <b-button variant="danger" type="button" class="ml-3" @click="doPrintPdf()">
              Simpan PDF
            </b-button>
          </b-col>
        </b-row>
      </b-modal> -->
    <b-modal
      title="PREVIEW LAPORAN PROFIL ANGGOTA"
      id="modal-pdf"
      hide-footer
      size="xl"
      centered
    >
      <div id="table-print" class="p-5">
        <h5 class="text-center">
          KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )
        </h5>
        <h5 class="text-center">LAPORAN PROFIL ANGGOTA</h5>
        <h5 class="text-center" v-show="report.cabang">{{ report.cabang }}</h5>
        <h6 class="text-center mb-5 pb-5" v-show="report.from && report.to">
          Tanggal {{ dateFormatId(report.from) }} s.d
          {{ dateFormatId(report.to) }}
        </h6>
=======
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
          <b-pagination v-model="paging.page" :total-rows="table.totalRows" :per-page="paging.perPage">
          </b-pagination>
        </b-col>
        <b-col cols="12">
          <h1 class="text-center">Pembiayaan</h1>
          <b-table responsive bordered outlined small striped hover :fields="table_2.fields" :items="table_2.items"
            show-empty :emptyText="table_2.loading ? 'Memuat data...' : 'Tidak ada data'">
            <template #cell(no)="item">
              {{ item.index + 1 }}
            </template>
          </b-table>
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
          <b-pagination v-model="paging.page" :total-rows="table_2.totalRows" :per-page="paging.perPage">
          </b-pagination>
        </b-col>
      </b-row>
    </b-card>
    <!-- <b-modal title="PREVIEW LAPORAN PROFIL ANGGOTA" id="modal-pdf" hide-footer size="xl" centered>
      <div id="table-print" class="p-5">
        <h5 class="text-center">KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )</h5>
        <h5 class="text-center">LAPORAN PROFIL ANGGOTA</h5>
        <h5 class="text-center" v-show="report.cabang">{{ report.cabang }}</h5>
        <h6 class="text-center mb-5 pb-5" v-show="report.from && report.to">Tanggal {{ dateFormatId(report.from) }} s.d
          {{ dateFormatId(report.to) }}</h6>
        <b-table responsive bordered outlined small striped hover :fields="report.fields" :items="report.items"
          show-empty :emptyText="report.loading ? 'Memuat data...' : 'Tidak ada data'" class="mt-5 pt-5 d-block">
          <template #cell(no)="item">
            {{ item.index + 1 }}
          </template>
        </b-table>
      </div>
      <b-row>
        <b-col cols="12" sm="12" class="d-flex justify-content-end border-top pt-5">
          <b-button variant="secondary" @click="$bvModal.hide('modal-pdf')">Cancel
          </b-button>
          <b-button variant="danger" type="button" class="ml-3" @click="doPrintPdf()">
            Simpan PDF
          </b-button>
        </b-col>
      </b-row>
    </b-modal> -->
    <b-modal title="PREVIEW LAPORAN PROFIL ANGGOTA" id="modal-pdf" hide-footer size="xl" centered>
      <div id="table-print" class="p-5">
        <h5 class="text-center">KSPPS MITRA SEJAHTERA RAYA INDONESIA ( MSI )</h5>
        <h5 class="text-center">LAPORAN PROFIL ANGGOTA</h5>
        <h5 class="text-center" v-show="report.cabang">{{ report.cabang }}</h5>
        <h6 class="text-center mb-5 pb-5" v-show="report.from && report.to">Tanggal {{ dateFormatId(report.from) }} s.d
          {{ dateFormatId(report.to) }}</h6>
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th rowspan="2">No</th>
              <th rowspan="2">No Anggota</th>
              <th rowspan="2">Nama Anggota</th>
              <th rowspan="2">Nama Majelis</th>
              <th rowspan="2">Nama Cabang</th>
              <th rowspan="2">Desa</th>
              <th rowspan="2">No Telp</th>
              <th colspan="5">Saldo</th>
            </tr>
            <tr class="text-center">
              <th>Simpok</th>
              <th>Simwa</th>
              <th>Sukarela</th>
              <th>Taber</th>
              <th>Pembiayaan</th>
            </tr>
          </thead>
          <tbody v-if="report.items.length > 0">
<<<<<<< HEAD
            <tr
              v-for="(report, reportIndex) in report.items"
              :key="`report-${reportIndex}`"
            >
=======
            <tr v-for="(report,reportIndex) in report.items" :key="`report-${reportIndex}`">
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
              <td>{{ reportIndex + 1 }}</td>
              <td>{{ report.no_anggota }}</td>
              <td>{{ report.nama_anggota }}</td>
              <td>{{ report.nama_rembug }}</td>
              <td>{{ report.nama_cabang }}</td>
              <td>{{ report.desa }}</td>
              <td>{{ report.no_telp }}</td>
              <td class="text-right">Rp {{ thousand(report.simpok) }}</td>
              <td class="text-right">Rp {{ thousand(report.simwa) }}</td>
              <td class="text-right">Rp {{ thousand(report.simsuk) }}</td>
              <td class="text-right">Rp {{ thousand(0) }}</td>
              <td class="text-right">Rp {{ thousand(0) }}</td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr class="text-center">
              <td colspan="12">There's no data to display...</td>
            </tr>
          </tbody>
        </table>
      </div>
      <b-row>
<<<<<<< HEAD
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
=======
        <b-col cols="12" sm="12" class="d-flex justify-content-end border-top pt-5">
          <b-button variant="secondary" @click="$bvModal.hide('modal-pdf')">Cancel
          </b-button>
          <b-button variant="danger" type="button" class="ml-3" @click="doPrintPdf()">
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
            Simpan PDF
          </b-button>
        </b-col>
      </b-row>
    </b-modal>
  </div>
</template>
<<<<<<< HEAD
    
  <script>
import helper from "@/core/helper";
import html2pdf from "html2pdf.js";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";
=======
  
<script>
import helper from '@/core/helper'
import html2pdf from "html2pdf.js";
import { mapGetters } from 'vuex'
import easycoApi from '@/core/services/easyco.service'
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
export default {
  name: "LaporanProfilAnggota",
  components: {},
  data() {
    return {
<<<<<<< HEAD
      table_1: {
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
            tdClass: "",
          },
          {
            key: "produk",
            sortable: true,
            label: "Produk",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "tgl_buka",
            sortable: true,
            label: "Tanggal Buka",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "jangka_waktu",
            sortable: true,
            label: "Jangka Waktu",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "jatuh_tempo",
            sortable: true,
            label: "Jatuh Tempo",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "saldo",
            sortable: true,
            label: "Saldo",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "status",
            sortable: true,
            label: "Status",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "action",
            sortable: true,
            label: "Action",
            thClass: "text-center",
            tdClass: "",
          },
        ],
        items: [],
        loading: false,
        totalRows: 0,
      },
      table_2: {
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
            tdClass: "",
          },
          {
            key: "produk_pembiayaan",
            sortable: true,
            label: "Produk Pembiayaan",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "pokok",
            sortable: true,
            label: "Pokok",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "margin",
            sortable: true,
            label: "margin",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "tgl_cair",
            sortable: true,
            label: "Tanggal Cair",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "jk_waktu",
            sortable: true,
            label: "Jangka Waktu",
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
            key: "status",
            sortable: true,
            label: "Status",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "action",
            sortable: true,
            label: "Action",
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
            key: "nama_anggota",
            sortable: false,
            label: "Nama Anggota",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama_rembug",
            sortable: false,
            label: "Nama Rembug",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama_cabang",
            sortable: false,
            label: "Nama Cabang",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "desa",
            sortable: false,
            label: "Desa",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "no_telp",
            sortable: false,
            label: "No Telp",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "alamat",
            sortable: false,
            label: "Alamat",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "tgl_gabung",
            sortable: false,
            label: "Tanggal Gabung",
            thClass: "text-center",
            tdClass: "",
=======
      table: {
        fields: [
          {
              key: 'no',
              sortable: false,
              label: 'No',
              thClass: 'text-center w-5p',
              tdClass: 'text-center'
            },
            {
              key: 'no_rekening',
              sortable: true,
              label: 'No Rekening',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'produk',
              sortable: true,
              label: 'Produk',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'tgl_buka',
              sortable: true,
              label: 'Tanggal Buka',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jangka_waktu',
              sortable: true,
              label: 'Jangka Waktu',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jatuh_tempo',
              sortable: true,
              label: 'Jatuh Tempo',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'saldo',
              sortable: true,
              label: 'Saldo',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'status',
              sortable: true,
              label: 'Status',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'action',
              sortable: true,
              label: 'Action',
              thClass: 'text-center',
              tdClass: ''
            },
        ],
        items: [],
        loading: false,
        totalRows: 0
      },
      table_2: {
          fields: [
            {
              key: 'no',
              sortable: false,
              label: 'No',
              thClass: 'text-center w-5p',
              tdClass: 'text-center'
            },
            {
              key: 'no_rekening',
              sortable: true,
              label: 'No Rekening',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'produk_pembiayaan',
              sortable: true,
              label: 'Produk Pembiayaan',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'pokok',
              sortable: true,
              label: 'Pokok',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'margin',
              sortable: true,
              label: 'margin',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'tgl_cair',
              sortable: true,
              label: 'Tanggal Cair',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jk_waktu',
              sortable: true,
              label: 'Jangka Waktu',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'saldo_pokok',
              sortable: true,
              label: 'Saldo Pokok',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'saldo_margin',
              sortable: true,
              label: 'Saldo Margin',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'saldo_catab',
              sortable: true,
              label: 'Saldo Catab',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'status',
              sortable: true,
              label: 'Status',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'action',
              sortable: true,
              label: 'Action',
              thClass: 'text-center',
              tdClass: ''
            },
          ],
          items: [],
          loading: false,
          totalRows: 0
        },
      report: {
        fields: [
          {
            key: 'no',
            sortable: false,
            label: 'No',
            thClass: 'text-center w-5p',
            tdClass: 'text-center'
          },
          {
            key: 'nama_anggota',
            sortable: false,
            label: 'Nama Anggota',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'nama_rembug',
            sortable: false,
            label: 'Nama Rembug',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'nama_cabang',
            sortable: false,
            label: 'Nama Cabang',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'desa',
            sortable: false,
            label: 'Desa',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'no_telp',
            sortable: false,
            label: 'No Telp',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'alamat',
            sortable: false,
            label: 'Alamat',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'tgl_gabung',
            sortable: false,
            label: 'Tanggal Gabung',
            thClass: 'text-center',
            tdClass: ''
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
          },
        ],
        items: [],
        loading: false,
        totalRows: 0,
        cabang: null,
        from: null,
<<<<<<< HEAD
        to: null,
=======
        to: null
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
      },
      paging: {
        page: 1,
        perPage: 10,
        sortDesc: true,
<<<<<<< HEAD
        sortBy: "kop_anggota.id",
        search: "",
        status: "~",
        cabang: 0,
        from: null,
        to: null,
      },
      opt: {
        cabang: [],
      },
    };
=======
        sortBy: 'kop_anggota.id',
        search: '',
        status: '~',
        cabang: 0,
        kode_rembug: 0,
        no_anggota: 0
      },
      remove: {
        data: Object,
        loading: false
      },
      opt: {
        cabang: [],
        kode_rembug: [],
        no_anggota: []
      }
    }
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
  },
  computed: {
    ...mapGetters(["user"]),
  },
  watch: {
    paging: {
      handler(val) {
<<<<<<< HEAD
        this.doGet();
      },
      deep: true,
    },
  },
  mounted() {
    this.doGet();
    this.doGetCabang();
=======
        this.doGet()
      },
      deep: true
    }
  },
  mounted() {
    this.doGet()
    this.doGetCabang()
    this.doGetKodeRembug()
    this.doGetNoAnggota()
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
  },
  methods: {
    ...helper,
    doPrintPdf() {
<<<<<<< HEAD
      let filename = "LAPORAN PROFIL ANGGOTA";
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
      let filename = "LAPORAN PROFIL ANGGOTA";
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
              value: 0,
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
    //async doGettable1() {
    //let payload = this.paging
    //payload.sortDir = payload.sortDesc ? 'DESC' : 'ASC'
    //payload.perPage = 10
    //this.table_1.loading = true
    //try {
    //let req = await easycoApi.anggotaRead(payload, this.user.token)
    //let { data, status, msg, total } = req.data
    //if (status) {
    //this.table_1.items = data
    //this.table_1.totalRows = total
    //} else {
    //this.notify('danger', 'Error', msg)
    //}
    //this.table_1.loading = false
    //} catch (error) {
    //this.table_1.loading = false
    //console.error(error)
    //this.notify('danger', 'Error', error)
    //}
    //},
    //async doGettable2() {
    //let payload = this.paging
    //payload.sortDir = payload.sortDesc ? 'DESC' : 'ASC'
    //payload.perPage = 10
    //this.table_2.loading = true
    //try {
    //let req = await easycoApi.anggotaRead(payload, this.user.token)
    //let { data, status, msg, total } = req.data
    //if (status) {
    //this.table_2.items = data
    //this.table_2.totalRows = total
    //} else {
    //this.notify('danger', 'Error', msg)
    //}
    //this.table_2.loading = false
    //} catch (error) {
    //this.table_2.loading = false
    //console.error(error)
    //this.notify('danger', 'Error', error)
    //}
    //},
    async doGetReport() {
      let payload = this.paging;
      payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
      payload.perPage = "~";
      this.report.loading = true;
      this.report.from = payload.from;
      this.report.to = payload.to;
      this.report.cabang = this.getCabangName(payload.cabang);
      try {
        let req = await easycoApi.anggotaRead(payload, this.user.token);
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
    async excel() {
      let payload = this.paging;
      try {
        let req = await easycoApi.anggotaExcel(payload, this.user.token);
        console.log(req);
        let fileName = "Laporan Anggota.xls";
        const url = window.URL.createObjectURL(new Blob([req.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", fileName);
        document.body.appendChild(link);
        link.click();
      } catch (error) {
        console.log(error);
        this.notify("danger", "Error", error);
=======
      let filename = 'LAPORAN PROFIL ANGGOTA'
      if (this.report.cabang) {
        filename += ` - Cabang ${this.report.cabang}`
      }
      if (this.report.from && this.report.to) {
        filename += ` - Dari ${this.dateFormatId(this.report.from)} Sampai ${this.dateFormatId(this.report.to)}`
      }

      html2pdf(document.getElementById("table-print"), {
        margin: 0,
        filename: `${filename}.pdf`,
        jsPDF: {
          unit: 'in',
          format: 'a4',
          orientation: 'landscape'
        }
      });
    },
    getCabangName(id) {
      if(id > 0) {
        let cabangName = this.opt.cabang.find((i => i.value == id))
        if (cabangName) {
          console.log(cabangName.text)
          return cabangName.text
        } else {
          return null
        }
      } else {
        return null
      }
    },
    async doGetCabang() {
      let payload = {
        perPage: '~',
        page: 1,
        sortBy: 'nama_cabang',
        sortDir: 'ASC',
        search: ''
      }
      try {
        let req = await easycoApi.cabangRead(payload, this.user.token)
        let { data, status, msg } = req.data
        if (status) {
          this.opt.cabang = [{
            value: 0,
            text: 'All'
          }]
          data.map((item) => {
            this.opt.cabang.push({
              value: item.kode_cabang,
              text: item.nama_cabang
            })
          })
        }
      } catch (error) {
        console.error(error)
      }
    },
    async doGetKodeRembug() {
      let payload = {
        perPage: '~',
        page: 1,
        sortBy: 'nama_rembug',
        sortDir: 'ASC',
        search: ''
      }
      try {
        let req = await easycoApi.rembugRead(payload, this.user.token)
        let { data, status, msg } = req.data
        if (status) {
          this.opt.kode_rembug = [{
            value: 0,
            text: 'PILIH'
          }]
          data.map((item) => {
            this.opt.kode_rembug.push({
              value: item.kode_rembug,
              text: item.nama_rembug
            })
          })
        }
      } catch (error) {
        console.error(error)
      }
    },
    async doGetNoAnggota() {
      let payload = {
        perPage: '~',
        page: 1,
        sortBy: 'no_anggota',
        sortDir: 'ASC',
        search: ''
      }
      try {
        let req = await easycoApi.anggotaRead(payload, this.user.token)
        let { data, status, msg } = req.data
        if (status) {
          this.opt.no_anggota = [{
            value: 0,
            text: 'PILIH'
          }]
          data.map((item) => {
            this.opt.no_anggota.push({
              value: item.no_anggota,
              text: item.nama_anggota
            })
          })
        }
      } catch (error) {
        console.error(error)
      }
    },
    async doGet() {
      let payload = this.paging
      payload.sortDir = payload.sortDesc ? 'DESC' : 'ASC'
      payload.perPage = 10
    },
    async doGetReport() {
      let payload = this.paging
      payload.sortDir = payload.sortDesc ? 'DESC' : 'ASC'
      payload.perPage = '~'
      this.report.loading = true
      this.report.from = payload.from
      this.report.to = payload.to
      this.report.cabang = this.getCabangName(payload.cabang)
      try {
        let req = await easycoApi.anggotaRead(payload, this.user.token)
        let { data, status, msg, total } = req.data
        if (status) {
          this.report.items = data
          this.report.totalRows = total
        } else {
          this.notify('danger', 'Error', msg)
        }
        this.report.loading = false
      } catch (error) {
        this.report.loading = false
        console.error(error)
        this.notify('danger', 'Error', error)
      }
    },
    async excel() {
      let payload = this.paging
      try {
        let req = await easycoApi.anggotaExcel(payload, this.user.token)
        console.log(req)
        let fileName = 'Laporan Anggota.xls'
        const url = window.URL.createObjectURL(new Blob([req.data]))
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', fileName)
        document.body.appendChild(link)
        link.click()
      } catch (error) {
        console.log(error)
        this.notify('danger', 'Error', error)
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
      }
    },
    doInfo(msg, title, variant) {
      this.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true,
<<<<<<< HEAD
        toaster: "b-toaster-bottom-right",
      });
=======
        toaster: 'b-toaster-bottom-right'
      })
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
    },
    notify(type, title, msg) {
      this.$bvToast.toast(msg, {
        title: title,
        autoHideDelay: 5000,
        variant: type,
<<<<<<< HEAD
        toaster: "b-toaster-bottom-right",
        appendToast: true,
      });
    },
  },
};
</script>
  
=======
        toaster: 'b-toaster-bottom-right',
        appendToast: true
      })
    }
  }
};
</script>
>>>>>>> 5d41c4c8731f49d5d1bb3cfc8142f1b136b75803
