<template>
  <div>
    <h1 class="mb-5">{{$route.name}}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col cols="12">
          <h5>Filter</h5>
        </b-col>
        <b-col cols="2" class="pr-2">
          <b-select/>
        </b-col>
        <b-col cols="2" class="pr-2">
          <b-select/>
        </b-col>
        <b-col cols="2" class="pr-2">
          <b-select/>
        </b-col>
        <b-col cols="6" class="d-flex justify-content-start">
          <b-button variant="danger">
            <b-icon icon="files" />
            PDF
          </b-button>
          <b-button variant="success" class="ml-2">
            <b-icon icon="files" />
            CSV
          </b-button>
        </b-col>
        <b-col cols="12" class="mb-5 pt-5 mt-5">
          <b-row no-gutters>
            <b-col cols="6">
              <div class="w-100 max-200 pr-5">
                <b-input-group size="sm" prepend="Per Halaman">
                  <b-form-select v-model="paging.perPage" :options="opt.perPage" @change="doGet()"/>
                </b-input-group>
              </div>
            </b-col>
            <b-col cols="6" class="d-flex justify-content-end">
              <div class="w-100 max-300">
                <b-input-group size="sm">
                  <b-form-input v-model="paging.search"/>
                  <b-input-group-append>
                    <b-button size="sm" text="Button" variant="primary" @click="doGet()">
                      <b-icon icon="search" />
                      Cari
                    </b-button>
                  </b-input-group-append>
                </b-input-group>
              </div>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12">
          <b-table 
            responsive bordered outlined small striped hover 
            :fields="table.fields" 
            :items="table.items"
            :sort-by.sync="paging.sortBy"
            :sort-desc.sync="paging.sortDesc"
            show-empty 
            @filtered="onTableUpdate"
            :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
            <template #cell(no)="item">
              {{item.index + 1}}
            </template>
            <template #cell(action)="item">
              <!-- <b-button variant="danger" size="xs" class="mx-1" @click="doDelete(item,true)">
                <b-icon icon="trash" />
              </b-button> -->
              <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item,false)">
                <b-icon icon="pencil" />
              </b-button>
              <!-- <b-button variant="info" size="xs" class="mx-1" @click="doUpdate(item,true)">
                <b-icon icon="check" />
              </b-button> -->
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
    name: "RegistrasiAnggota",
    components: {
  
    },
    data() {
      return {
        form: {
          data: Object,
          loading: false
        },
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
              key: 'nama_anggota',
              sortable: true,
              label: 'Nama Anggota',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'kode_rembug',
              sortable: true,
              label: 'Kode Rembug',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'kode_cabang',
              sortable: true,
              label: 'Kode Cabang',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'no_telp',
              sortable: true,
              label: 'No Telp',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'alamat',
              sortable: true,
              label: 'Alamat',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'action',
              sortable: false,
              label: 'Action',
              thClass: 'text-center w-10p',
              tdClass: 'text-center'
            },
          ],
          items: [],
          loading: false,
          totalRows: 0
        },
        paging: {
          page: 1,
          perPage: 10,
          sortDesc: true,
          sortBy: 'id',
          search: '',
          status: 1
        },
        opt: {
          perPage: [10,20,50,100,200]
        },
        loading: false,
      }
    },
    computed: {
      ...mapGetters(["user"]),
    },
    watch: {
      paging: {
        handler(val){
          this.doGet()
        },
        deep: true
      }
    },
    mounted() {
      this.doGet()
    },
    methods: {
      async doGet() {
        let payload = this.paging
        payload.sortDir = payload.sortDesc ? 'DESC' : 'ASC'
        this.table.loading = true
        try {
          let req = await  easycoApi.anggotaRead(payload, this.user.token)
          let { data, status, msg, total } = req.data
          if(status){
            this.table.items = data
            this.table.totalRows = total
          } else {
            this.notify('danger','Error',msg)
          }
          this.table.loading = false
        } catch (error) {
          this.table.loading = false
          console.error(error)
          this.notify('danger','Login Error',error)
        }
      },
      onTableUpdate(v){
        console.log(v)
      },
      notify(type, title, msg) {
        this.$bvToast.toast(msg, {
          title: title,
          autoHideDelay: 5000,
          variant: type,
          toaster: 'b-toaster-bottom-right',
          appendToast: true
        })
      }
    }
  };
  </script>
  