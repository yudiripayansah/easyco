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
              <b-input-group prepend="Dari Tanggal">
                <b-form-datepicker v-model="paging.from" :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id"/>
              </b-input-group>
            </b-col>
            <b-col>
              <b-input-group prepend="Sampai Tanggal">
                <b-form-datepicker v-model="paging.to" :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id"/>
              </b-input-group>
            </b-col>
          </div>
        </b-col>
        <b-col cols="4" class="d-flex justify-content-end align-items-start">
          <b-button-group>
            <b-button text="Button" variant="danger" @click="doPrintPdf()">
              PDF
            </b-button>
            <b-button text="Button" variant="success">
              XLS
            </b-button>
            <b-button text="Button" variant="warning">
              CSV
            </b-button>
          </b-button-group>
        </b-col>
        <b-col cols="12">
          <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
            show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'" id="table-print">
            <template #cell(no)="item">
              {{ item.index + 1 }}
            </template>
            <template #cell(jumlah_pengajuan)="item">
              Rp {{ thousand(item.item.jumlah_pengajuan) }}
            </template>
            <template #cell(status_pengajuan)="item">
              {{ showStatus(item.item.status_pengajuan) }}
            </template>
          </b-table>
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
          <b-pagination v-model="paging.page" :total-rows="table.totalRows" :per-page="paging.perPage">
          </b-pagination>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>
  
<script>
import html2pdf from "html2pdf.js";
import helper from '@/core/helper'
import { mapGetters } from 'vuex'
import easycoApi from '@/core/services/easyco.service'
export default {
  name: "LaporanPengajuanPembiayaan",
  components: {},
  data() {
    return {
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
            key: 'nama_cabang',
            sortable: true,
            label: 'Cabang',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'tanggal_pengajuan',
            sortable: true,
            label: 'Tanggal',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'nama_anggota',
            sortable: true,
            label: 'Nama',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'nama_rembug',
            sortable: true,
            label: 'Rembug',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'no_pengajuan',
            sortable: true,
            label: 'No Pengajuan',
            thClass: 'text-center',
            tdClass: 'text-center'
          },
          {
            key: 'jumlah_pengajuan',
            sortable: true,
            label: 'Jumlah',
            thClass: 'text-center',
            tdClass: 'text-right'
          },
          {
            key: 'status_pengajuan',
            sortable: true,
            label: 'Status',
            thClass: 'text-center',
            tdClass: 'text-right'
          }
        ],
        items: [],
        loading: false,
        totalRows: 0
      },
      paging: {
        page: 1,
        perPage: 10,
        sortDesc: true,
        sortBy: 'kop_anggota.id',
        search: '',
        status: [0,1],
        cabang: 0,
        from: null,
        to: null
      },
      opt: {
        cabang: []
      }
    }
  },
  computed: {
    ...mapGetters(["user"]),
  },
  watch: {
    paging: {
      handler(val) {
        this.doGet()
      },
      deep: true
    }
  },
  mounted() {
    this.doGet()
    this.doGetCabang()
  },
  methods: {
		...helper,
    doPrintPdf() {
      html2pdf(document.getElementById("table-print"), {
				margin: 1,
  			filename: "i-was-html.pdf",
        jsPDF: {
					unit: 'in',
					format: 'a4',
					orientation: 'landscape'
				}
			});
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
    async doGet() {
      let payload = this.paging
      payload.sortDir = payload.sortDesc ? 'DESC' : 'ASC'
      this.table.loading = true
      try {
        let req = await easycoApi.pengajuanRead(payload, this.user.token)
        let { data, status, msg, total } = req.data
        if (status) {
          this.table.items = data
          this.table.totalRows = total
        } else {
          this.notify('danger', 'Error', msg)
        }
        this.table.loading = false
      } catch (error) {
        this.table.loading = false
        console.error(error)
        this.notify('danger', 'Login Error', error)
      }
    },
    showStatus(status) {
      let statusText = ''
      switch (status) {
        case 1:
          statusText = 'Aktivasi'
          break;
        case 2:
          statusText = 'Ditolak'
          break;
        case 3:
          statusText = 'Batal'
          break;
        default:
          statusText = 'Registrasi'
          break;
      }
      return statusText
    },  
    doInfo(msg, title, variant) {
      this.$bvToast.toast(msg, {
        title: title,
        variant: variant,
        solid: true,
        toaster: 'b-toaster-bottom-right'
      })
    }
  }
};
</script>
