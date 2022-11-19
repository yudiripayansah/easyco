<template>
    <div>
      <h1 class="mb-5">{{$route.name}}</h1>
      <b-card>
        <b-row no-gutters>
          <b-col cols="8" class="mb-5">
            <b-row no-gutters>
              <b-col cols="4">
                <div class="w-100 max-200 pr-5">
                  <b-input-group size="sm" prepend="Cabang"> 
                    <b-form-select v-model="options" :options="opt.cabang" />
                  </b-input-group><br>
                  <b-input-group size="sm" prepend="Tanggal">
                    <b-form-select v-model="options" :options="opt.tanggal" />
                  </b-input-group><br>
                  <b-input-group size="sm" prepend="sd">
                    <b-form-select v-model="options" :options="opt.sd" />
                  </b-input-group>
                </div>
              </b-col>
              <b-col cols= "8" class="mb-5">
              <b-col cols="4" class="d-flex justify-content-end">
                <div class="w-100 max-300"><br><br><br>
                      <b-button size="sm" text="Button" variant="danger" class="mr-5">
                        PDF
                      </b-button>
                      <b-button size="sm" text="Button" variant="success">
                        XLS
                      </b-button><br><br>
                </div>
              </b-col>
              <b-col cols="4" class="d-flex justify-content-end">
                <div class="w-100 max-300">
                  <b-button size="sm" text="Button" variant="primary" class="mr-5">
                        GRID
                      </b-button>
                      <b-button size="sm" text="Button" variant="warning" >
                        CSV
                      </b-button>
                </div>
              </b-col>
              </b-col>
            </b-row>
          </b-col>
          <b-col cols="12">
            <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
              show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
              <template #cell(no)="item">
                {{item.index + 1}}
              </template>
              <template #cell(action)="item">
                <b-button variant="danger" size="xs" class="mx-1" @click="doDelete(item,true)" v-b-tooltip.hover
                  title="Hapus">
                  <b-icon icon="trash" />
                </b-button>
                <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Ubah">
                  <b-icon icon="pencil" />
                </b-button>
              </template>
            </b-table>
          </b-col>
          <b-col cols="12" class="justify-content-end d-flex">
            <b-pagination v-model="paging.currentPage" :total-rows="table.totalRows" :per-page="paging.perPage">
            </b-pagination>
          </b-col>
        </b-row>
      </b-card>
      <b-modal title="Delete" id="modal-delete" hide-footer size="sm" header-bg-variant="warning"
        body-bg-variant="warning" centered>
        <p class="text-center py-3">Anda yakin ingin menghapus data ini?</p>
        <div class="d-flex justify-content-end">
          <b-button variant="light" type="button" :disabled="remove.loading" @click="$bvModal.hide('modal-delete')">Tidak
          </b-button>
          <b-button variant="danger" class="ml-3" type="button" :disabled="remove.loading"
            @click="doDelete(remove.data,false)">
            {{remove.loading ? 'Memproses...' : 'Ya' }}
          </b-button>
        </div>
      </b-modal>
    </div>
  </template>
  
  <script>
  import { validationMixin } from "vuelidate";
  import { required, sameAs, email, minLength } from 'vuelidate/lib/validators'
  export default {
    name: "Pengguna",
    components: {},
    data() {
      return {
        form: {
          data: {
            id: null,
            cabang: null,
            tanggal: null,
            nama: null,
            rembug: null,
            no_pengajuan: null,
            jumlah: null,
            status: null,
          },
          loading: false,
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
              key: 'cabang',
              sortable: true,
              label: 'Cabang',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'tanggal',
              sortable: true,
              label: 'Tanggal',
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
              key: 'rembug',
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
              tdClass: ''
            },
            {
              key: 'jumlah',
              sortable: true,
              label: 'Jumlah',
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
          ],
          items: [],
          loading: false,
        },
        paging: {
          currentPage: 1,
          perPage: 10
        },
        remove: {
          data: {
  
          },
          loading: false
        },
        opt: {
          cabang: ['Cimauk','Cibinong'],
          status: ['Cair', 'Pengajuan'],
          tanggal: ['01-01-2021','08-01-2021'],
          sd:['01-01-2021','08-01-2021']
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
          tanggal: {
            required
          },
          nama: {
            required
          },
          rembug: {
            required
          },
          no_pengajuan: {
            required
          },
          jumlah: {
            required
          },
          status: {
            required
          },
        }
      }
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
        this.table.loading = true
        setTimeout(() => {
          this.table.loading = false
          this.table.items = [
            {
              cabang: 'Cimauk',
              tanggal: '01-01-2021',
              nama: 'Siti Aminah',
              rembug: 'Mawar',
              no_pengajuan: '320115004780001',
              jumlah: '2.000.000',
              status: 'Pengajuan',
            },
          ]
          this.doInfo('Data berhasil diambil','Berhasil','success')
        },5000)
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
          tanggal: null,
          nama: null,
          rembug: null,
          no_pengajuan: null,
          jumlah: null,
          status: null,
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
    