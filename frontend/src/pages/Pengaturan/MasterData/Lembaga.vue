<template>
  <div>
    <h1 class="mb-5">{{$route.name}}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col cols="12" class="d-flex justify-content-end mb-5 pb-5 border-bottom">
          <b-button variant="success" @click="$bvModal.show('modal-form');doClearForm()" v-b-tooltip.hover
            title="Tambah Data Baru">
            <b-icon icon="plus" />
            Tambah Baru
          </b-button>
        </b-col>
        <b-col cols="12" class="mb-5">
          <b-row no-gutters>
            <b-col cols="6">
              <div class="w-100 max-200 pr-5">
                <b-input-group size="sm" prepend="Per Halaman">
                  <b-form-select v-model="paging.perPage" :options="opt.perPage" />
                </b-input-group>
              </div>
            </b-col>
            <b-col cols="6" class="d-flex justify-content-end">
              <div class="w-100 max-300">
                <b-input-group size="sm">
                  <b-form-input />
                  <b-input-group-append>
                    <b-button size="sm" text="Button" variant="primary">
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
          <b-pagination v-model="paging.page" :total-rows="table.totalRows" :per-page="paging.perPage">
          </b-pagination>
        </b-col>
      </b-row>
    </b-card>
    <b-modal title="Form Lembaga" id="modal-form" hide-footer size="lg" centered>
      <b-form @submit="doSave()">
        <b-row>
          <b-col cols="6">
            <b-form-group label="Kode Kop" label-for="kode kop">
              <b-form-input id="kode_kop" v-model="$v.form.data.kode_kop.$model" :state="validateState('kode_kop')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Nama Kop" label-for="nama_kop">
              <b-form-input id="nama_kop" v-model="$v.form.data.nama_kop.$model" :state="validateState('nama_kop')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Alamat Kop" label-for="almat_kop">
              <b-form-input id="alamat_kop" v-model="$v.form.data.alamat_kop.$model"
                :state="validateState('alamat_kop')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Ketua Kop" label-for="ketua_kop">
              <b-form-input id="ketua_kop" v-model="$v.form.data.ketua_kop.$model"
                :state="validateState('ketua_kop')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Nik Kop" label-for="nik_kop">
              <b-form-input id="nik_kop" v-model="$v.form.data.nik_kop.$model" :state="validateState('nik_kop')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Simpok" label-for="simpok">
              <b-form-input id="simpok" v-model="$v.form.data.simpok.$model" :state="validateState('simpok')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Simwa" label-for="simwa">
              <b-form-input id="simwa" v-model="$v.form.data.simwa.$model" :state="validateState('simwa')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="GL Simpok" label-for="gl_simpok">
              <b-form-input id="gl_simpok" v-model="$v.form.data.gl_simpok.$model"
                :state="validateState('gl_simpok')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="GL Simwa" label-for="gl_simwa">
              <b-form-input id="gl_simwa" v-model="$v.form.data.gl_simwa.$model" :state="validateState('gl_simwa')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Tangline Kop" label-for="tangline_kop">
              <b-form-input id="tangline_kop" v-model="$v.form.data.tangline_kop.$model"
                :state="validateState('tangline_kop')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="GL Simsuk" label-for="gl_simsuk">
              <b-form-input id="gl_simsuk" v-model="$v.form.data.gl_simsuk.$model"
                :state="validateState('gl_simsuk')" />
            </b-form-group>
          </b-col>
          <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
            <b-button variant="secondary" @click="$bvModal.hide('modal-form')" :disabled="form.loading">Cancel
            </b-button>
            <b-button variant="primary" type="submit" :disabled="form.loading" class="ml-3">
              {{form.loading ? 'Memproses...' : 'Simpan' }}
            </b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
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
  import { required } from 'vuelidate/lib/validators'
  export default {
    name: "Pengguna",
    components: {},
    data() {
      return {
        form: {
          data: {
            id: null,
            kode_kop: null,
            nama_kop: null,
            alamat_kop: null,
            ketua_kop: null,
            nik_kop: null,
            simpok: null,
            simwa: null,
            gl_simpok: null,
            gl_simwa:null,
            tangline_kop: null,
            gl_simsuk: null,
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
              key: 'kode_kop',
              sortable: true,
              label: 'Kode Kop',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama_kop',
              sortable: true,
              label: 'Nama Kop',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'alamat_kop',
              sortable: true,
              label: 'Alamat Kop',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'ketua_kop',
              sortable: true,
              label: 'Ketua Kop',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nik_kop',
              sortable: true,
              label: 'Nik Kop',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'simpok',
              sortable: true,
              label: 'Simpok',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'simwa',
              sortable: true,
              label: 'Simwa',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'gl_simpok',
              sortable: true,
              label: 'GL Simpok',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'gl_simwa',
              sortable: true,
              label: 'GL Simwa',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'tangline_kop',
              sortable: true,
              label: 'Tangline Kop',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'gl_simsuk',
              sortable: true,
              label: 'GL Simsuk',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'created_at',
              sortable: true,
              label: 'Dibuat Tanggal',
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
          role: ['admin','user','staff','accounting'],
          cabang: ['cabang 1','cabang 2','cabang 3'],
          status: ['aktif','non aktif']
        }
      }
    },
    mixins: [validationMixin],
    validations: {
      form: {
        data: {
          kode_kop: {
            required
          },
          nama_kop: {
            required
          },
          alamat_kop: {
            required
          },
          ketua_kop: {
            required
          },
          nik_kop: {
            required
          },
          simpok: {
            required
          },
          simwa: {
            required
          },
          gl_simpok: {
            required
          },
          gl_simwa: {
            required
          },
          tangline_kop: {
            required
          },
          gl_simsuk: {
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
              kode_kop: 'Kode Kop User',
              nama_kop: 'Nama Kop User',
              alamat_kop: 'Alamat Kop User',
              ketua_kop: 'ketua Kop User',
              nik_kop: 'Data Nik Kop',
              simpok: 'Data Simpok',
              simwa: 'Data Simwa',
              gl_simpok: 'Data GL Simpok',
              gl_simwa: 'Data GL Simwa',
              tangline_kop: 'Data Tangline Kop',
              gl_simsuk: 'Data GL Simsuk',
              created_at: 'Tanggal Dibuat',
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
          kode_kop: null,
          nama_kop: null,
          alamat_kop: null,
          ketua_kop: null,
          nik_kop: null,
          simwa: null,
          cabang: null,
          gl_simpok: null,
          gl_simwa: null,
          tangline_kop: null,
          gl_simsuk: null,
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
    