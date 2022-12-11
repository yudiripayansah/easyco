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
            <b-col cols="8" class="mb-5">
            <div class="row">
              <b-col cols="6">
                <b-input-group prepend="Cabang" class="mb-3">
                  <b-form-select v-model="paging.cabang" :options="opt.cabang" />
                </b-input-group>
              </b-col>
              <b-col cols="6">
                <b-input-group prepend="Petugas" class="mb-3">
                  <b-form-select v-model="paging.petugas" :options="opt.petugas" />
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
          </b-row>
        </b-col>
        <b-col cols="12">
          <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
            show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
            <template #cell(no)="item">
              {{item.index + 1}}
            </template>
            <template #cell(action)="item">
              <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Edit">
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
    <b-modal title="Form Transaksi Kas Petugas" id="modal-form" hide-footer size="lg" centered>
      <b-form @submit="doSave()">
        <b-row>
          <b-col cols="12" sm="12" class="mb-3">
          <h4 class="mb-3">Modal Awal</h4>
          <b-button variant="danger" @click="$bvModal.show('modal-form-setoran-kas');doClearForm()" v-b-tooltip.hover
            title="Setoran Kas">Setoran Kas</b-button>
          <hr>  
        </b-col>
          <b-col cols="6">
          <b-form-group label="cabang">
            <b-select v-model="form.data.cabang" :options="opt.cabang" />
          </b-form-group>
        </b-col>
          <b-col cols="6">
          <b-form-group label="Petugas">
            <b-select v-model="form.data.petugas" :options="opt.petugas" />
          </b-form-group>
        </b-col>
          <b-col cols="6">
          <b-form-group label="Tanggal">
            <b-form-datepicker v-model="paging.tanggal"/>
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Jenis Transaksi">
            <b-input disabled v-model="form.data.jenis_transaksi" placeholder="Modal Awal" />
          </b-form-group>
        </b-col>
          <b-col cols="4">
          <b-form-group label="Jumlah Modal">
            <b-input v-model="form.data.jumlah_modal" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Keterangan">
            <b-textarea v-model="form.data.ket" />
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
    <b-modal title="Form Transaksi Kas Petugas" id="modal-form-setoran-kas" hide-footer size="lg" centered>
      <b-form @submit="doSave()">
        <b-row>
          <b-col cols="12" sm="12" class="mb-3">
          <h4 class="mb-3">Setoran Kas</h4>
          <b-button variant="info" @click="$bvModal.show('modal-form');doClearForm()" v-b-tooltip.hover
            title="Modal Awal">Modal Awal</b-button>
          <hr>  
        </b-col>
          <b-col cols="6">
          <b-form-group label="cabang">
            <b-select v-model="form.data.cabang" :options="opt.cabang" />
          </b-form-group>
        </b-col>
          <b-col cols="6">
          <b-form-group label="Petugas">
            <b-select v-model="form.data.petugas" :options="opt.petugas" />
          </b-form-group>
        </b-col>
          <b-col cols="6">
          <b-form-group label="Tanggal">
            <b-form-datepicker v-model="paging.tanggal"/>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Jenis Transaksi">
            <b-input disabled v-model="form.data.jenis_transaksi" placeholder="Setoran Kas" />
          </b-form-group>
        </b-col>
          <b-col cols="4">
          <b-form-group label="Modal Awal">
            <b-input v-model="form.data.modal_awal" />
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Setoran Rembug">
            <b-input v-model="form.data.setoran_rembug" />
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Penarikan Rembug">
            <b-input v-model="form.data.penarikan_rembug" />
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Jumlah Setoran Kas">
            <b-input v-model="form.data.jml_setoran_kas" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Keterangan">
            <b-textarea v-model="form.data.ket" />
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
  name: "transaksi_kas_petugas",
  components: {},
  data() {
    return {
      form: {
        data: {
          id: null,
          cabang: null,
          petugas: null,
          tanggal: null,
          jenis_transaksi: null,
          jumlah_modal: null,
          keterangan: null,
          modal_awal: null,
          setoran_rembug: null,
          penarikan_rembug: null,
          jml_setoran_kas: null,
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
            key: 'jenis_transaksi',
            sortable: true,
            label: 'Jenis Trx',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'no_rek',
            sortable: true,
            label: 'Nomer Rek',
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
            key: 'keterangan',
            sortable: true,
            label: 'keterangan',
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
        petugas: ['Andi','Danu']
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
        tanggal: {
          required,
        },
        jenis_transaksi: {
          required,
        },
        jumlah_modal: {
          required,
        },
        keterangan: {
          required,
        },
        modal_awal: {
          required,
        },
        setoran_rembug: {
          required,
        },
        penarikan_rembug: {
          required,
        },
        jml_setoran_kas: {
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
            tanggal: '01-12-20',
            nama: 'Siti Amaninah',
            jenis_transaksi: 'Modal Awal',
            no_rek: '201.0010001',
            jumlah: '2.0000.0000',
            keterangan: 'MBA',
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
          petugas: null,
          tanggal: null,
          jenis_transaksi: null,
          jumlah_modal: null,
          keterangan: null,
          modal_awal: null,
          setoran_rembug: null,
          penarikan_rembug: null,
          jml_setoran_kas: null,
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
  