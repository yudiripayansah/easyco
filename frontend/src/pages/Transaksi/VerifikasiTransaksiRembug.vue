<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col cols="12" class="d-flex mb-5 pb-5 border-bottom">
          <b-form-group label="Cabang" class="mr-5 col-3 p-0 mb-0">
            <b-form-select v-model="paging.cabang" :options="opt.cabang" />
          </b-form-group>
          <b-form-group label="Tanggal" class="col-3 p-0 mb-0">
            <b-form-datepicker
              v-model="paging.date"
              :date-format-options="{
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
              }"
              locale="id"
            /> 
          </b-form-group
        ></b-col>
        <b-col cols="12" class="mb-5">
          <b-row no-gutters>
            <b-col cols="6">
              <div class="w-100 max-200 pr-5">
                <b-input-group size="sm" prepend="Per Halaman">
                  <b-form-select
                    v-model="paging.perPage"
                    :options="opt.perPage"
                  />
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
          <b-table
            responsive
            bordered
            outlined
            small
            striped
            hover
            :fields="table.fields"
            :items="table.items"
            show-empty
            :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'"
          >
            <template #cell(no)="data">
              {{ data.index + 1 }}
            </template>
            <template #cell(action)="data">
              <b-button
                variant="info"
                size="xs"
                class="mx-1"
                @click="doUpdate(data.item)"
              >
                <b-icon icon="check" /> Verifikasi
              </b-button>
            </template>
          </b-table>
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
          <b-pagination
            v-model="paging.page"
            :total-rows="table.totalRows"
            :per-page="paging.perPage"
          >
          </b-pagination>
        </b-col>
      </b-row>
    </b-card>
    <b-modal title="Form Verifikasi Transaksi Rembug" id="modal-form" hide-footer size="xxl" centered>
      <b-form @submit="doSave">
        <b-row>
          <b-col cols="3">
            <b-form-group label="Cabang" label-for="cabang">
              <b-form-input
                id="cabang"
                disabled
              />
            </b-form-group>
          </b-col>
          <b-col cols="3">
            <b-form-group label="Tanggal" label-for="tanggal">
              <b-form-input
                id="tanggal"
                disabled
              />
            </b-form-group>
          </b-col>
          <b-col cols="3">
            <b-form-group label="Rembug" label-for="rembug">
              <b-form-input
                id="rembug"
                disabled
              />
            </b-form-group>
          </b-col>
          <b-col cols="3">
            <b-form-group label="Petugas" label-for="petugas">
              <b-form-input
                id="petugas"
                disabled
              />
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <div class="table-responsive">
              <table class="table table-bordered table-stripped border-dark">
                <thead class="bg-dark text-white">
                  <tr>
                    <td class="text-center align-center" rowspan="3">Id</td>
                    <td class="text-center align-center" rowspan="3" width="10%">Nama</td>
                    <td class="text-center align-center" rowspan="3" width="5%">Absen</td>
                    <td class="text-center align-center" colspan="5">Setoran</td>
                    <td class="text-center align-center">Penarikan</td>
                    <td class="text-center align-center" colspan="3">Realisasi Pembiayaan</td>
                    <td class="text-center align-center" rowspan="3">Ket.</td>
                  </tr>
                  <tr>
                    <td class="text-center align-center" colspan="2">Angsuran</td>
                    <td class="text-center align-center" rowspan="2">Tab. Sukarela</td>
                    <td class="text-center align-center" rowspan="2">Tab. Rembug Simpok</td>
                    <td class="text-center align-center" rowspan="2">Tab. Berencana</td>
                    <td class="text-center align-center" rowspan="2">Tab. Sukarela</td>
                    <td class="text-center align-center" rowspan="2">Plafon</td>
                    <td class="text-center align-center" rowspan="2">Adm</td>
                    <td class="text-center align-center" rowspan="2">Asuransi</td>
                  </tr>
                  <tr>
                    <td class="text-center align-center" width="5%">Frek</td>
                    <td class="text-center align-center">@</td>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(i,idx) in 20" :key="idx">
                    <td>1000187654321</td>
                    <td>Nama Anggota</td>
                    <td><b-form-select/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-button variant="info">...</b-button></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="text-right align-center">Total</td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-button variant="info">...</b-button></td>
                  </tr>
                  <tr>
                    <td colspan="13"></td>
                  </tr>
                </tbody>
                <thead class="bg-dark text-white">
                  <tr>
                    <td colspan="4"></td>
                    <td class="text-center">Kas Awal</td>
                    <td class="text-center">Infaq</td>
                    <td class="text-center">Setoran</td>
                    <td class="text-center">Penarikan</td>
                    <td class="text-center">Saldo Kas</td>
                    <td colspan="4"></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="4"></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td><b-form-input value="0" class="text-right"/></td>
                    <td colspan="4"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </b-col>
          <b-col cols="12" class="d-flex justify-content-center border-top pt-5">
            <b-button
              variant="secondary"
              @click="$bvModal.hide('modal-form')"
              :disabled="form.loading"
              class="mx-1"
              >Cancel
            </b-button>
            <b-button
              variant="danger"
              type="submit"
              :disabled="form.loading"
              class="mx-1"
            >
              {{ form.loading ? "Memproses..." : "Reject" }}
            </b-button>
            <b-button
              variant="success"
              type="submit"
              :disabled="form.loading"
              class="mx-1"
            >
              {{ form.loading ? "Memproses..." : "Approve" }}
            </b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
    <b-modal
      title="Delete"
      id="modal-delete"
      hide-footer
      size="sm"
      header-bg-variant="warning"
      body-bg-variant="warning"
      centered
    >
      <p class="text-center py-3">Anda yakin ingin menghapus data ini?</p>
      <div class="d-flex justify-content-end">
        <b-button
          variant="light"
          type="button"
          :disabled="remove.loading"
          @click="$bvModal.hide('modal-delete')"
          >Tidak
        </b-button>
        <b-button
          variant="danger"
          class="ml-3"
          type="button"
          :disabled="remove.loading"
          @click="doDelete(remove.data, false)"
        >
          {{ remove.loading ? "Memproses..." : "Ya" }}
        </b-button>
      </div>
    </b-modal>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import easycoApi from "@/core/services/easyco.service";
export default {
  name: "Cabang",
  components: {},
  data() {
    return {
      form: {
        data: {
          id: null,
          kode_cabang: null,
          nama_cabang: null,
          induk_cabang: 0,
          jenis_cabang: null,
          pimpinan_cabang: null,
          created_by: null,
        },
        loading: false,
      },
      table: {
        fields: [
          {
            key: "no",
            sortable: false,
            label: "No",
            thClass: "text-center w-5p",
            tdClass: "text-center",
          },
          {
            key: "rembug",
            sortable: true,
            label: "Rembug",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "tanggal",
            sortable: true,
            label: "Tanggal",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "petugas",
            sortable: true,
            label: "Petugas",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "kas_awal",
            sortable: true,
            label: "Kas Awal",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "infaq",
            sortable: true,
            label: "Infaq",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "setoran",
            sortable: true,
            label: "Setoran",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "penarikan",
            sortable: true,
            label: "Penarikan",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "saldo_kas",
            sortable: true,
            label: "Saldo Kas",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "action",
            sortable: false,
            label: "Action",
            thClass: "text-center w-10p",
            tdClass: "text-center",
          },
        ],
        items: [
          {
            rembug: 'Nama Rembug',
            tanggal: '22/02/2023',
            petugas: 'Petugas',
            kas_awal: 'Kas Awal',
            infaq: 'Rp 1.000.000',
            setoran: 'Rp 20.000.000',
            penarikan: 'Rp 1.000.000',
            saldo_kas: 'Rp 30.000.000',
          }
        ],
        loading: false,
        totalRows: 0,
      },
      paging: {
        page: 1,
        perPage: 10,
        sortDesc: true,
        sortBy: "id",
        search: "",
        cabang: null,
        date: null,
      },
      remove: {
        data: Object,
        loading: false,
      },
      opt: {
        perPage: [10, 25, 50, 100],
        role: ["admin", "user", "staff", "accounting"],
        cabang: ["cabang 1", "cabang 2", "cabang 3"],
        status: ["aktif", "non aktif"],
        jenis_cabang: [
          {
            value: 1,
            text: "Area",
          },
          {
            value: 2,
            text: "Cabang",
          },
          {
            value: 3,
            text: "Unit",
          },
        ],
        induk_cabang: [],
      },
    };
  },
  mixins: [validationMixin],
  validations: {
    form: {
      data: {
        kode_cabang: {
          required,
        },
        nama_cabang: {
          required,
        },
        induk_cabang: {
          required,
        },
        jenis_cabang: {
          required,
        },
        pimpinan_cabang: {
          required,
        },
      },
    },
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
          this.opt.induk_cabang = [
            {
              value: 0,
              text: "Induk",
            },
          ];
          data.map((item) => {
            this.opt.induk_cabang.push({
              value: item.kode_cabang,
              text: item.nama_cabang,
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
        let req = await easycoApi.cabangRead(payload, this.user.token);
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
            req = await easycoApi.cabangUpdate(payload, this.user.token);
          } else {
            req = await easycoApi.cabangCreate(payload, this.user.token);
          }
          let { status } = req.data;
          if (status) {
            this.notify("success", "Success", "Data berhasil disimpan");
            this.doGet();
            this.doGetCabang();
            this.$bvModal.hide("modal-form");
          } else {
            this.notify("danger", "Error", "Data gagal disimpan");
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
      // try {
      //   let req = await easycoApi.cabangDetail(
      //     `id=${item.id}`,
      //     this.user.token
      //   );
      //   let { data, status, msg } = req.data;
      //   if (status) {
      //     this.form.data = data;
      //     this.$bvModal.show("modal-form");
      //   }
      // } catch (error) {
      //   console.log(error);
      //   this.notify("danger", "Error", "Gagal mengambil data");
      // }
      
      this.$bvModal.show("modal-form");
    },
    async doDelete(item, prompt) {
      if (prompt) {
        this.remove.data = item;
        this.$bvModal.show("modal-delete");
      } else {
        this.remove.loading = true;
        try {
          let req = await easycoApi.cabangDelete(
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
    getJenisCabang(val) {
      let res = this.opt.jenis_cabang.find((i) => i.value == val);
      if (res) {
        return res.text;
      }
      return "-";
    },
    getIndukCabang(val) {
      let res = this.opt.induk_cabang.find((i) => i.value == val);
      if (res) {
        return res.text;
      }
      return "-";
    },
    doClearForm() {
      this.form.data = {
        id: null,
        kode_cabang: null,
        nama_cabang: null,
        induk_cabang: 0,
        jenis_cabang: null,
        pimpinan_cabang: null,
        created_by: null,
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
  },
  mounted() {
    // this.doGet();
    // this.doGetCabang();
  },
};
</script>
<style>
  .modal-xxl {
    max-width: 99%;
  }
  .align-center {
    vertical-align: middle !important;
  }
</style>
