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
                  <b-form-input v-model="paging.search"/>
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
            <template #cell(kode_cabang)="item">
              {{ getCabang(item.item.kode_cabang) }}
            </template>
            <template #cell(role_user)="item">
              {{ getRole(item.item.role_user) }}
            </template>
            <template #cell(action)="item">
              <b-button variant="danger" size="xs" class="mx-1" @click="doDelete(item.item,true)" v-b-tooltip.hover
                title="Hapus">
                <b-icon icon="trash" />
              </b-button>
              <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item.item)" v-b-tooltip.hover title="Ubah">
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
    <b-modal title="Form Pengguna" id="modal-form" hide-footer size="lg" centered>
      <b-form @submit="doSave">
        <b-row>
          <b-col cols="6">
            <b-form-group label="Cabang" label-for="cabang">
              <b-form-select id="cabang" v-model="$v.form.data.kode_cabang.$model" :options="opt.cabang" :state="validateState('kode_cabang')" />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Kode Pegawai" label-for="kode_pgw">
              <b-form-input id="kode_pgw" v-model="form.data.kode_pgw" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Nama User" label-for="nama_user">
              <b-form-input id="nama_user" v-model="$v.form.data.nama_user.$model" :state="validateState('nama_user')" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Password" label-for="password">
              <b-form-input id="password" v-model="form.data.password" type="password"/>
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="Role User" label-for="role_user">
              <b-form-select id="role_user" v-model="$v.form.data.role_user.$model" :options="opt.role_user" :state="validateState('role_user')" />
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
import { mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required, email, minLength } from "vuelidate/lib/validators";
import easycoApi from "@/core/services/easyco.service";
export default {
  name: "Pengguna",
  components: {},
  data() {
    return {
      form: {
        data: {
          id: null,
          kode_cabang: null,
          kode_pgw: null,
          nama_user: null,
          role_user: null,
          akses_user: 1,
          photo: null,
          password: null,
          created_by: null
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
            key: 'kode_cabang',
            sortable: true,
            label: 'Cabang',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'kode_pgw',
            sortable: true,
            label: 'Kode Pegawai',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'nama_user',
            sortable: true,
            label: 'Nama',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'role_user',
            sortable: true,
            label: 'Role',
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
        perPage: 10,
        sortDesc: true,
        sortBy: "id",
        search: "",
      },
      remove: {
        data: Object,
        loading: false
      },
      opt: {
        perPage: [10,25,50,100],
        cabang: [],
        role_user: [
          {
            value: 99,
            text: 'Sysadmin'
          },
          {
            value: 0,
            text: 'Anggota'
          },
          {
            value: 1,
            text: 'Karyawan'
          }
        ]
      }
    }
  },
  mixins: [validationMixin],
  validations: {
    form: {
      data: {
        kode_cabang: {
          required
        },
        nama_user: {
          required
        },
        role_user: {
          required
        }
      }
    }
  },
  mounted() {
    this.doGet()
    this.doGetCabang()
  },
  computed: {
    ...mapGetters(["user"]),
  },
  watch: {
    paging: {
      handler(val) {
        this.doGet();
      },
      deep: true,
    },
  },
  methods: {
    validateState(name) {
      const { $dirty, $error } = this.$v.form.data[name];
      return $dirty ? !$error : null;
    },
    async doGetCabang() {
      let payload = { ...this.paging };
      payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
      payload.perPage = "~";
      try {
        let req = await easycoApi.cabangRead(payload, this.user.token);
        let { data, status, msg, total } = req.data;
        if (status) {
          this.opt.cabang = [
            {
              value: 0,
              text: "Pilih Cabang",
            },
          ];
          data.map((item) => {
            this.opt.cabang.push({
              value: item.kode_cabang,
              text: `${item.kode_cabang} - ${item.nama_cabang}`,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGet() {
      let payload = this.paging;
      payload.sortDir = payload.sortDesc ? "DESC" : "ASC";
      this.table.loading = true;
      try {
        let req = await easycoApi.userRead(payload, this.user.token);
        let { data, status, msg, total } = req.data;
        if (status) {
          this.table.items = data;
          this.table.totalRows = total;
        }
        this.table.loading = false;
      } catch (error) {
        this.table.loading = false;
        console.error(error);
      }
    },
    async doSave(e) {
      this.$v.form.$touch();
      if (!this.$v.form.$anyError) {
        this.form.loading = true;
        try {
          let payload = this.form.data;
          payload.created_by = this.user.id;
          let req = false;
          if (payload.id) {
            req = await easycoApi.userUpdate(payload, this.user.token);
          } else {
            if(payload.password){
              req = await easycoApi.userCreate(payload, this.user.token);
            } else {
              this.notify("danger", "Error", "Password harus diisi");
            }
          }
          if(req){
            let { status } = req.data;
            if (status) {
              this.notify("success", "Success", "Data berhasil disimpan");
              this.doGet();
              this.doGetCabang();
              this.$bvModal.hide("modal-form");
            } else {
              this.notify("danger", "Error", "Data gagal disimpan");
            }
          }
          this.form.loading = false;
        } catch (error) {
          this.notify("danger", "Error", error);
          this.form.loading = false;
        }
      } else {
        e.preventDefault();
      }
    },
    async doUpdate(item) {
      try {
        let req = await easycoApi.userDetail(
          `id=${item.id}`,
          this.user.token
        );
        let { data, status, msg } = req.data;
        if (status) {
          this.form.data = {...data};
          this.form.data.password = null
          this.$bvModal.show("modal-form");
        }
      } catch (error) {
        console.log(error);
        this.notify("danger", "Error", "Gagal mengambil data");
      }
    },
    async doDelete(item, prompt) {
      if (prompt) {
        this.remove.data = item;
        this.$bvModal.show("modal-delete");
      } else {
        this.remove.loading = true;
        try {
          let req = await easycoApi.userDelete(
            `id=${this.remove.data.id}`,
            this.user.token
          );
          let { status } = req.data;
          if (status) {
            this.remove.loading = false;
            this.$bvModal.hide("modal-delete");
            this.notify("success", "Success", "Data berhasil dihapus");
            this.doGet();
            this.doGetCabang();
          } else {
            this.notify("danger", "Error", "Data gagal dihapus");
          }
        } catch (error) {
          this.notify("danger", "Error", error);
        }
      }
    },
    getCabang(val) {
      let res = this.opt.cabang.find((i) => i.value == val);
      if (res) {
        return res.text;
      }
      return "-";
    },
    getRole(val) {
      let res = this.opt.role_user.find((i) => i.value == val);
      if (res) {
        return res.text;
      }
      return "-";
    },
    doClearForm() {
      this.form.data = {
        id: null,
        kode_cabang: null,
        kode_pgw: null,
        nama_user: null,
        role_user: null,
        akses_user: 1,
        photo: null,
        password: null,
        created_by: null
      };
      this.$v.form.$reset();
    },
    notify(type, title, msg) {
      this.$bvToast.toast(msg, {
        title: title,
        autoHideDelay: 5000,
        variant: type,
        toaster: "b-toaster-bottom-right",
        appendToast: true,
      });
    },
  }
};
</script>
  