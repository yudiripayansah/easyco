<template>
    <div>
      <h1 class="mb-5">{{$route.name}}</h1>
      <b-card>
        <b-row no-gutters>
          <b-col cols="12" class="d-flex justify-content-end mb-5 pb-5 border-bottom">
          </b-col>
          <b-col cols="12" class="mb-5">
            <b-row no-gutters>
                <b-col cols="8" class="mb-5">
          <div class="row">
            <b-col cols="7">
              <b-input-group prepend="Cabang" class="mb-3">
                <b-form-select v-model="paging.cabang" :options="opt.cabang" />
              </b-input-group>
            </b-col>
            <b-col cols="7">
              <b-input-group prepend="Petugas" class="mb-3">
                <b-form-select v-model="paging.petugas" :options="opt.petugas" />
              </b-input-group>
            </b-col>
            <b-col cols="7">
              <b-input-group prepend="Majelis" class="mb-3">
                <b-form-select v-model="paging.majelis" :options="opt.majelis" />
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
            </b-row>
          </b-col>
          <b-col cols="12">
            <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
              show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
              <template #cell(no)="item">
                {{item.index + 1}}
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
  import { mapGetters } from 'vuex'
  import { validationMixin } from "vuelidate";
  import easycoApi from '@/core/services/easyco.service'
  import { required, sameAs, email, minLength } from 'vuelidate/lib/validators'
  export default {
    name: "LaporanOutstanding",
    components: {},
    data() {
      return {
        form: {
          data: {
            id: null,
            cabang: null,
            petugas: null,
            majelis: null,
            no_rek: null,
            nama: null,
            majelis: null,
            produk: null,
            tgl_cair: null,
            jk_waktu: null,
            ctr_byr: null,
            saldo_pokok: null,
            saldo_mgn: null,
          },
          loading: false,
        },  
        table: {
          fields: [
            {
              key: 'no_rek',
              sortable: true,
              label: 'No Rek',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama',
              sortable: true,
              label: 'Nama',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'majelis',
              sortable: true,
              label: 'Majelis',
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
              key: 'tgl_cair',
              sortable: true,
              label: 'Tgl Cair',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jk_waktu',
              sortable: true,
              label: 'Jk Waktu',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'ctr_byr',
              sortable: true,
              label: 'Margin',
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
              key: 'saldo_mgn',
              sortable: true,
              label: 'Saldo Mgn',
              thClass: 'text-center',
              tdClass: ''
            },
          ],
          items: [],
          loading: false,
        },
        paging: {
          page: 1,
          perPage: 10
        },
        remove: {
          data: {
  
          },
          loading: false
        },
        opt: {
          perPage: [10,25,50,100],
          cabang: ['cabang 1','cabang 2','cabang 3'],
          petugas: ['Aldy','Danu'],
          majelis: ['Semua','Cempaka','Melati','Mawar'],
        }
      }
    },
    mixins: [validationMixin],
    validations: {
      form: {
        data: {
          cabang: {
            required
          },
          petugas: {
            required,
          },
          majelis: {
            required,
          },
          no_rek: {
            required,
          },
          nama: {
            required,
          },
          produk: {
            required,
          },
          tgl_cair: {
            required,
          },
          jk_waktu: {
            required,
          },
          ctr_byr: {
            required,
          },
          saldo_pokok: {
            required,
          },
          saldo_mgn: {
            required,
          },
        }
      }
    },
    computed: {
      ...mapGetters(["user"]),
    },
    mounted() {
      this.doGet()
    },
    methods: {
      validateState(name) {
        const { $dirty, $error } = this.$v.form.data[name];
        return $dirty ? !$error : null;
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
      async doSave() {
        this.$v.form.$touch();
        if (!this.$v.form.$anyError) {
          this.form.loading = true
          setTimeout(() => {
            this.form.loading = false
            this.$bvModal.hide('modal-form')
            let newItems = {...this.form.data}
            let date = new Date()
            newItems.created_at = date.toLocaleDateString() 
            newItems.id = this.table.items.length + 1
            this.table.items.push(newItems)
            this.doClearForm()
            this.doInfo('Data berhasil disimpan','Berhasil','success')
          }, 5000);
        }
      },
      async doUpdate(item) {
        console.log(item)
        this.form.data = {...item.item}
        this.$bvModal.show('modal-form')
      },
      async doDelete(item,prompt) {
        if(prompt){
          this.remove.data = item
          this.$bvModal.show('modal-delete')
        } else {
          this.remove.loading = true
          setTimeout(() => {
            this.remove.loading = false
            this.$bvModal.hide('modal-delete')
            this.doInfo('Data berhasil dihapus','Berhasil','success')
          }, 5000);
        }
      },
      doClearForm() {
        this.form.data = {
            id: null,
            cabang: null,
            petugas: null,
            majelis: null,
            no_rek: null,
            nama: null,
            majelis: null,
            produk: null,
            tgl_cair: null,
            jk_waktu: null,
            ctr_byr: null,
            saldo_pokok: null,
            saldo_mgn: null,
        }
        this.$v.form.$reset()
      },
      doInfo(msg,title,variant) {
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
    