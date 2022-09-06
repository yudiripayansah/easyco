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
    <b-modal title="Form Produk Tabungan" id="modal-form" hide-footer size="lg" centered>
      <b-form @submit="doSave()">
        <b-row>
          <b-col cols="6">
            <b-form-group label="Kode Produk" label-for="kode_produk">
              <b-form-input id="kode_produk" v-model="form.data.kode_produk" :state="validateState('kode_produk')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Nama Produk" label-for="nama_produk">
              <b-form-input id="nama_produk" v-model="$v.form.data.nama_produk.$model"
                :state="validateState('nama_produk')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Nama Singkat" label-for="nama_singkat">
              <b-form-input id="nama_singkat" v-model="$v.form.data.nama_singkat.$model"
                :state="validateState('nama_singkat')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Jenis Akad" label-for="jenis_akad">
              <b-form-input id="jenis_akad" v-model="$v.form.data.jenis_akad.$model"
                :state="validateState('jenis_akad')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Saldo Minimal" label-for="saldo_minimal">
              <b-form-input id="saldo_minimal" v-model="$v.form.data.saldo_minimal.$model"
                :state="validateState('saldo_minimal')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Biaya Adm" label-for="biaya_adm">
              <b-form-input id="biaya_adm" v-model="$v.form.data.biaya_adm.$model"
                :state="validateState('biaya_adm')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Jenis Tabungan" label-for="jenis tabungan">
              <b-form-input id="jenis_tabungan" v-model="$v.form.data.jenis_tabungan.$model"
                :state="validateState('jenis_tabungan')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Minimal Setoran" label-for="minimal_setoran">
              <b-form-input id="minimal_setoran" v-model="$v.form.data.minimal_setoran.$model"
                :state="validateState('minimal_setoran')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Periode Setoran" label-for="periode_setoran">
              <b-form-input id="periode_setoran" v-model="$v.form.data.periode_setoran.$model"
                :state="validateState('periode_setoran')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Minimal Kontrak" label-for="minimal_kontrak">
              <b-form-input id="minimal_kontrak" v-model="$v.form.data.minimal_kontrak.$model"
                :state="validateState('minimal_kontrak')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Kode GL" label-for="kode_gl">
              <b-form-input id="kode_gl" v-model="$v.form.data.kode_gl.$model" :state="validateState('kode_gl')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Nisbah" label-for="nisbah">
              <b-form-input id="nisbah" v-model="$v.form.data.nisbah.$model" :state="validateState('nisbah')" />
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
            kode_produk: null,
            nama_produk: null,
            nama_singkat: null,
            jenis_akad: null,
            saldo_minimal: null,
            biaya_adm: null,
            jenis_tabungan: null,
            minimal_setoran: null,
            periode_setoran: null,
            minimal_kontrak: null,
            kode_gl: null,
            nisbah: null,
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
              key: 'kode_produk',
              sortable: true,
              label: 'Kode Produk',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama_produk',
              sortable: true,
              label: 'Nama Produk',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama_singkat',
              sortable: true,
              label: 'Nama Singkat',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jenis_akad',
              sortable: true,
              label: 'Jenis Akad',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'saldo_minimal',
              sortable: true,
              label: 'Saldo Minimal',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'biaya_adm',
              sortable: true,
              label: 'Biaya Adm',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'jenis_tabungan',
              sortable: true,
              label: 'Jenis Tabungan',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'minimal_setoran',
              sortable: true,
              label: 'Minimal Setoran',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'periode_setoran',
              sortable: true,
              label: 'Periode Setoran',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'minimal_kontrak',
              sortable: true,
              label: 'Minimal Kontrak',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'kode_gl',
              sortable: true,
              label: 'Kode GL',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nisbah',
              sortable: true,
              label: 'Nisbah',
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
          kode_produk: {
            required
          },
          nama_produk: {
            required
          },
          nama_singkat: {
            required
          },
          jenis_akad: {
            required
          },
          saldo_minimal: {
            required
          },
          biaya_adm: {
            required
          },
          jenis_tabungan: {
            required
          },
          minimal_setoran: {
            required
          },
          periode_setoran: {
            required
          },
          minimal_kontrak: {
            required
          },
          kode_gl: {
            required
          },
          nisbah: {
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
              kode_produk: 'Kode Produk User',
              nama_produk: 'Nama Produk User',
              nama_singkat: 'Nama Singkat User',
              jenis_akad: 'Data Jenis Akad',
              saldo_minimal: 'Data Saldo Minimal',
              biaya_adm: 'Data Biaya Adm',
              jenis_tabungan: 'Data Jenis Tabungan',
              minimal_setoran: 'Data Minimal Setoran',
              periode_setoran: 'Data Periode Setoran',
              minimal_kontrak: 'Data Minimal Kontrak',
              kode_gl:'Kode GL User',
              nisbah:'Data Nisbah',
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
          kode_produk: null,
          nama_produk: null,
          nama_singkat: null,
          jenis_akad: null,
          saldo_minimal: null,
          biaya_adm: null,
          jenis_tabungan: null,
          minimal_setoran: null,
          periode_setoran: null,
          minimal_kontrak: null,
          kode_gl: null,
          nisbah: null,
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
    