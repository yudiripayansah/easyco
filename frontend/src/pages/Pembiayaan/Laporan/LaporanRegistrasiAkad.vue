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
                  <b-form-datepicker v-model="paging.from"/>
                </b-input-group>
              </b-col>
              <b-col>
                <b-input-group prepend="Sampai Tanggal">
                  <b-form-datepicker v-model="paging.to"/>
                </b-input-group>
              </b-col>
            </div>
          </b-col>
          <b-col cols="4" class="d-flex justify-content-end align-items-start">
            <b-button-group>
              <b-button text="Button" variant="primary">
                GRID
              </b-button>
              <b-button text="Button" variant="warning">
                CSV
              </b-button>
              <b-button text="Button" variant="danger">
                PDF
              </b-button>
              <b-button text="Button" variant="success">
                XLS
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
            <b-pagination v-model="paging.currentPage" :total-rows="table.totalRows" :per-page="paging.perPage">
            </b-pagination>
          </b-col>
        </b-row>
      </b-card>
    </div>
  </template>
    
  <script>
  import { mapGetters } from 'vuex'
  import easycoApi from '@/core/services/easyco.service'
  export default {
    name: "LaporanRegistrasiAnggota",
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
              key: 'cabang',
              sortable: true,
              label: 'cabang',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'tanggal',
              sortable: true,
              label: 'tanggal',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama',
              sortable: true,
              label: 'nama',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'majelis',
              sortable: true,
              label: 'majelis',
              thClass: 'text-center',
              tdClass: 'text-center'
            },
            {
              key: 'no_rek',
              sortable: true,
              label: 'No Rek',
              thClass: 'text-center',
              tdClass: 'text-right'
            },
            {
              key: 'produk',
              sortable: true,
              label: 'produk',
              thClass: 'text-center',
              tdClass: 'text-right'
            },
            {
              key: 'plafon',
              sortable: true,
              label: 'plafon',
              thClass: 'text-center',
              tdClass: 'text-right'
            },
            {
              key: 'margin',
              sortable: true,
              label: 'margin',
              thClass: 'text-center',
              tdClass: 'text-right'
            },
            {
              key: 'jk_waktu',
              sortable: true,
              label: 'Jk Waktu',
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
          sortBy: 'kop_pembiayaan.tanggal_registrasi',
          search: '',
          status_rekening: [0,1],
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
          let req = await easycoApi.regisAkadRead(payload, this.user.token)
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
  