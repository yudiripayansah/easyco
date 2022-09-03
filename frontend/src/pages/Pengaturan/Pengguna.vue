<template>
<div>
  <h1 class="mb-5">{{$route.name}}</h1>
  <b-card>
    <b-row no-gutters>
      <b-col cols="12" class="d-flex justify-content-end mb-5 pb-5 border-bottom">
        <b-button variant="success" @click="$bvModal.show('modal-form');doClearForm()" v-b-tooltip.hover title="Tambah Data Baru">
          <b-icon icon="plus"/>
          Tambah Baru
        </b-button>
      </b-col>
      <b-col cols="12" class="mb-5">
        <b-row no-gutters>
          <b-col cols="6">
            <div class="w-100 max-200 pr-5">
              <b-input-group size="sm" prepend="Per Halaman">
                <b-form-select v-model="paging.perPage" :options="opt.perPage"/>
              </b-input-group>
            </div>
          </b-col>
          <b-col cols="6" class="d-flex justify-content-end">
            <div class="w-100 max-300">
              <b-input-group size="sm">
                <b-form-input/>
                <b-input-group-append>
                  <b-button size="sm" text="Button" variant="primary">
                    <b-icon icon="search"/>
                    Cari
                  </b-button>
                </b-input-group-append>
              </b-input-group>
            </div>
          </b-col>
        </b-row>
      </b-col>
      <b-col cols="12">
        <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items" show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
          <template #cell(no)="item">
            {{item.index + 1}}
          </template>
          <template #cell(action)="item">
            <b-button variant="danger" size="xs" class="mx-1" @click="doDelete(item,true)" v-b-tooltip.hover title="Hapus">
              <b-icon icon="trash"/>
            </b-button>
            <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Ubah">
              <b-icon icon="pencil"/>
            </b-button>
          </template>
        </b-table>
      </b-col>
      <b-col cols="12" class="justify-content-end d-flex">
        <b-pagination
          v-model="paging.currentPage"
          :total-rows="table.totalRows"
          :per-page="paging.perPage"
        ></b-pagination>
      </b-col>
    </b-row>
  </b-card>
  <b-modal title="Form Pengguna" id="modal-form" hide-footer size="lg" centered>
    <b-form @submit="doSave()">
      <b-row>
        <b-col cols="6">
          <b-form-group label="Kode User" label-for="kode">
            <b-form-input 
              id="kode" 
              v-model="form.data.kode"
              disabled/>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Nama" label-for="nama">
            <b-form-input 
              id="nama" 
              v-model="$v.form.data.nama.$model"
              :state="validateState('nama')"/>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Email" label-for="email">
            <b-form-input 
              id="email" 
              v-model="$v.form.data.email.$model"
              :state="validateState('email')"/>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Password" label-for="password">
            <b-form-input 
              id="password" 
              v-model="$v.form.data.password.$model" 
              type="password"
              :state="validateState('password')"/>
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Role" label-for="role">
            <b-form-select 
              id="role" 
              v-model="$v.form.data.role.$model" 
              :options="opt.role"
              :state="validateState('role')"/>
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Status" label-for="status">
            <b-form-select 
              id="status" 
              v-model="$v.form.data.status.$model" 
              :options="opt.status"
              :state="validateState('status')"/>
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Cabang" label-for="cabang">
            <b-form-select 
              id="cabang" 
              v-model="$v.form.data.cabang.$model" 
              :options="opt.cabang"
              :state="validateState('cabang')"/>
          </b-form-group>
        </b-col>
        <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
          <b-button variant="secondary" @click="$bvModal.hide('modal-form')" :disabled="form.loading">Cancel</b-button>
          <b-button variant="primary" type="submit" :disabled="form.loading" class="ml-3">
            {{form.loading ? 'Memproses...' : 'Simpan' }}
          </b-button>
        </b-col>
      </b-row>
    </b-form>
  </b-modal>
  <b-modal title="Delete" id="modal-delete" hide-footer size="sm" header-bg-variant="warning" body-bg-variant="warning" centered>
    <p class="text-center py-3">Anda yakin ingin menghapus data ini?</p>
    <div class="d-flex justify-content-end">
      <b-button variant="light" type="button" :disabled="remove.loading" @click="$bvModal.hide('modal-delete')">Tidak</b-button>
      <b-button variant="danger" class="ml-3" type="button" :disabled="remove.loading" @click="doDelete(remove.data,false)">
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
          kode: 'Auto Generated',
          nama: null,
          email: null,
          password: null,
          role: null,
          status: null,
          cabang: null,
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
            key: 'kode',
            sortable: true,
            label: 'Kode User',
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
            key: 'email',
            sortable: true,
            label: 'Email',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'role',
            sortable: true,
            label: 'Role',
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
          {
            key: 'cabang',
            sortable: true,
            label: 'Cabang',
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
        nama: {
          required
        },
        email: {
          required,
          email
        },
        password: {
          required,
          minLength: minLength(6)
        },
        role: {
          required
        },
        status: {
          required
        },
        cabang: {
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
            kode: '123456789',
            nama: 'Nama User',
            email: 'user@email.com',
            role: 'user',
            password: 'Password User',
            status: 'aktif',
            cabang: 'cabang 1',
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
        kode: 'Auto Generated',
        nama: null,
        email: null,
        password: null,
        role: null,
        status: null,
        cabang: null,
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
  