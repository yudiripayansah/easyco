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
    <b-modal title="Form Produk Pembiayaan" id="modal-form" hide-footer size="lg" centered>
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
            <b-form-group label="Periode Angsuran" label-for="periode_angsuran">
              <b-form-input id="periode_angsuran" v-model="$v.form.data.periode_angsuran.$model"
                :state="validateState('periode_angsuran')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Jangka Waktu" label-for="jangka_waktu">
              <b-form-input id="jangka_waktu" v-model="$v.form.data.jangka_waktu.$model"
                :state="validateState('jangka_waktu')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Biaya Adm" label-for="biaya_adm">
              <b-form-input id="biaya_adm" v-model="$v.form.data.biaya_adm.$model"
                :state="validateState('biaya_adm')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Kode Akad" label-for="kode_akad">
              <b-form-input id="kode_akad" v-model="$v.form.data.kode_akad.$model"
                :state="validateState('kode_akad')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Kode GL" label-for="kode_gl">
              <b-form-input id="kode_gl" v-model="$v.form.data.kode_gl.$model" :state="validateState('kode_gl')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Flag Wakalah" label-for="flag_wakalah">
              <b-form-input id="flag_wakalah" v-model="$v.form.data.flag_wakalah.$model"
                :state="validateState('flag_wakalah')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Flag Pdd" label-for="flag_pdd">
              <b-form-input id="flag_pdd" v-model="$v.form.data.flag_pdd.$model" :state="validateState('flag_pdd')" />
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
            periode_angsuran: null,
            jangka_waktu: null,
            biaya_adm: null,
            kode_akad: null,
            kode_gl: null,
            flag_wakalah: null,
            flag_pdd: null,
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
              key: 'periode_angsuran',
              sortable: true,
              label: 'periode_angsuran',
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
              key: 'biaya_adm',
              sortable: true,
              label: 'Biaya Adm',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'kode_akad',
              sortable: true,
              label: 'Kode Akad',
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
              key: 'flag_wakalah',
              sortable: true,
              label: 'Flag Wakalah',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'flag_pdd',
              sortable: true,
              label: 'Flag Pdd',
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
          periode_angsuran: {
            required,
          },
          jangka_waktu: {
            required
          },
          biaya_adm: {
            required
          },
          kode_akad: {
            required
          },
          kode_gl: {
            required
          },
          flag_wakalah: {
            required
          },
          flag_pdd: {
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
              kode_produk: 'Data Kode Produk',
              nama_produk: 'Nama Produk User',
              nama_singkat: 'Nama Singkat User',
              periode_angsuran: 'Data Periode Angsuran',
              jangka_waktu: 'Data Jangka Waktu',
              biaya_adm: 'Data Biaya Admin',
              kode_akad: 'Kode Akad User',
              kode_gl: 'Kode GL User',
              flag_wakalah: 'Data Flag Wakalah',
              flag_pdd: 'Data Flag Pdd',
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
          periode_angsuran: null,
          jangka_waktu: null,
          biaya_adm: null,
          kode_akad: null,
          kode_gl: null,
          flag_wakalah: null,
          flag_pdd: null,  
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
    