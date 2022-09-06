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
          <b-pagination v-model="paging.currentPage" :total-rows="table.totalRows" :per-page="paging.perPage">
          </b-pagination>
        </b-col>
      </b-row>
    </b-card>
    <b-modal title="Form Rembug" id="modal-form" hide-footer size="lg" centered>
      <b-form @submit="doSave()">
        <b-row>
          <b-col cols="6">
            <b-form-group label="Kode Rembug" label-for="kode_rembug">
              <b-form-input id="kode_rembug" v-model="form.data.kode_rembug" :state="validateState('kode_rembug')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Nama Rembug" label-for="nama_rembug">
              <b-form-input id="nama_rembug" v-model="$v.form.data.nama_rembug.$model"
                :state="validateState('nama_rembug')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Kode Cabang" label-for="kode_cabang">
              <b-form-input id="kode_cabang" v-model="$v.form.data.kode_cabang.$model"
                :state="validateState('kode_cabang')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Kode Petugas" label-for="kode_petugas">
              <b-form-input id="kode_petugas" v-model="$v.form.data.kode_petugas.$model"
                :state="validateState('kode_petugas')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Kode Desa" label-for="kode_desa">
              <b-form-input id="kode_desa" v-model="$v.form.data.kode_desa.$model"
                :state="validateState('kode_desa')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Tanggal Pembentukan" label-for="tgl_pembentukan">
              <b-form-input id="tgl_pembentukan" v-model="$v.form.data.tgl_pembentukan.$model"
                :state="validateState('tgl_pembentukan')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Hari Transaksi" label-for="hari_transaksi">
              <b-form-input id="hari_transaksi" v-model="$v.form.data.hari_transaksi.$model"
                :state="validateState('hari_transaksi')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Jam Transaksi" label-for="jam_transaksi">
              <b-form-input id="jam_transaksi" v-model="$v.form.data.jam_transaksi.$model"
                :state="validateState('jam_transaksi')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Status Aktif" label-for="status_aktif">
              <b-form-input id="status_aktif" v-model="$v.form.data.status_aktif.$model"
                :state="validateState('status_aktif')" />
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
  import { required, sameAs, email, minLength } from 'vuelidate/lib/validators'
  export default {
    name: "Pengguna",
    components: {},
    data() {
      return {
        form: {
          data: {
            id: null,
            kode_rembug: null,
            nama_rembug: null,
            kode_cabang: null,
            kode_petugas: null,
            kode_desa: null,
            tgl_pembentukan: null,
            hari_transaksi: null,
            jam_transaksi: null,
            status_aktif: null,
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
              key: 'kode_rembug',
              sortable: true,
              label: 'Kode Rembug',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama_rembug',
              sortable: true,
              label: 'Nama Rembug',
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
              key: 'kode_petugas',
              sortable: true,
              label: 'Kode Petugas',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'kode_desa',
              sortable: true,
              label: 'Kode Desa',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'tgl_pembentukan',
              sortable: true,
              label: 'Tanggal Pembentukan',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'hari_transaksi',
              sortable: true,
              label: 'Hari Transaksi',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jam_transaksi',
              sortable: true,
              label: 'Jam Transaksi',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'status_aktif',
              sortable: true,
              label: 'Status Aktif',
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
          currentPage: 1,
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
          kode_rembug: {
            required
          },
          nama_rembug: {
            required
          },
          kode_cabang: {
            required
          },
          kode_petugas: {
            required
          },
          kode_desa: {
            required
          },
          tgl_pembentukan: {
            required
          },
          hari_transaksi: {
            required
          },
          jam_transaksi: {
            required
          },
          status_aktif: {
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
              kode_rembug: 'Kode Rembug User',
              nama_rembug: 'Nama Rembug User',
              kode_cabang: 'Kode Cabang User',
              kode_petugas: 'Kode Petugas User',
              kode_desa: 'Kode Desa User',
              tgl_pembentukan: 'Data Tanggal Pembentukan ',
              hari_transaksi: 'Data Hari Transaksi',
              jam_transaksi: 'Data Jam Transaksi',
              status_aktif: 'Data Status Aktif',
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
          kode_rembug: null,
          nama_rembug: null,
          kode_cabang: null,
          kode_petugas  : null,
          kode_desa: null,
          tgl_pembentukan: null,
          hari_transaksi: null,
          jam_transaksi: null,
          status_aktif: null,
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
    