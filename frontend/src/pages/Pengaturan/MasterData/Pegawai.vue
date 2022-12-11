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
    <b-modal title="Form Pegawai" id="modal-form" hide-footer size="lg" centered>
      <b-form @submit="doSave()">
        <b-row>
          <b-col cols="6">
            <b-form-group label="Kode Pegawai" label-for="kode_pgw">
              <b-form-input id="kode_pgw" v-model="form.data.kode_pgw" :state="validateState('kode_pgw')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Nama Pegawai" label-for="nama_pgw">
              <b-form-input id="nama_pgw" v-model="$v.form.data.nama_pgw.$model" :state="validateState('nama_pgw')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Alamat Pegawai" label-for="alamat_pgw">
              <b-form-input id="alamat_pgw" v-model="$v.form.data.alamat_pgw.$model"
                :state="validateState('alamat_pgw')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Nomer KTP" label-for="no_ktp">
              <b-form-input id="no_ktp" v-model="$v.form.data.no_ktp.$model" :state="validateState('no_ktp')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Nomer HP" label-for="no_hp">
              <b-form-input id="no_hp" v-model="$v.form.data.no_hp.$model" :state="validateState('no_hp')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Jabatan" label-for="jabatan">
              <b-form-input id="jabatan" v-model="$v.form.data.jabatan.$model" :state="validateState('jabatan')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Tanggal Gabung" label-for="tgl_gabung">
              <b-form-input id="tgl_gabung" v-model="$v.form.data.tgl_gabung.$model"
                :state="validateState('tgl_gabung')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Jenis Kelamin" label-for="jenis_kelamin">
              <b-form-input id="jenis_kelamin" v-model="$v.form.data.jenis_kelamin.$model"
                :state="validateState('jenis_kelamin')" />
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
            kode_pgw: null,
            nama_pgw: null,
            alamat_pgw: null,
            no_ktp: null,
            no_hp: null,
            jabatan: null,
            tgl_gabung: null,
            jenis_kelamin: null,
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
              key: 'kode_pgw',
              sortable: true,
              label: 'Kode Pegawai',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama_pgw',
              sortable: true,
              label: 'Nama Pegawai',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'alamat_pgw',
              sortable: true,
              label: 'Alamat Pegawai',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'no_ktp',
              sortable: true,
              label: 'Nomer KTP',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'no_hp',
              sortable: true,
              label: 'Nomer HP',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jabatan',
              sortable: true,
              label: 'Jabatan',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'tgl_gabung',
              sortable: true,
              label: 'Tanggal Gabung',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jenis_kelamin',
              sortable: true,
              label: 'Jenis Kelamin',
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
          kode_pgw: {
            required
          },
          nama_pgw: {
            required
          },
          alamat_pgw: {
            required
          },
          no_ktp: {
            required
          },
          no_hp: {
            required
          },
          jabatan: {
            required
          },
          tgl_gabung: {
            required
          },
          jenis_kelamin: {
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
              kode_pgw: 'Kode Pegawai User',
              nama_pgw: 'Nama Pegawai User',
              alamat_pgw: 'Alamat Pegawai User',
              no_ktp: 'Nomer KTP User',
              no_hp: 'Nomer HP User',
              jabatan: 'Data Jabatan',
              tgl_gabung: 'Data Tanggal Gabung',
              jenis_kelamin: 'Jenis Kelamin User',
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
          kode_pgw: null,
          nama_pgw: null,
          alamat_pgw: null,
          no_ktp: null,
          no_hp: null,
          jabatan: null,
          tgl_gabung: null,
          jenis_kelamin: null,
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
    