<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col cols="12" class="d-flex mb-5 pb-5 border-bottom">
          <b-form-group label="Cabang" class="mr-5 col-4 p-0 mb-0">
            <b-form-select
              v-model="paging.cabang"
              :options="opt.cabang"
              @change="doGetMajelis()"
            />
          </b-form-group>
          <b-form-group label="Majelis" class="mr-5 col-4 p-0 mb-0">
            <b-form-select
              v-model="paging.rembug"
              :options="opt.majelis"
            />
          </b-form-group>
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
            <template #cell(action)="data">
              <b-button
                variant="info"
                size="xs"
                class="mx-1"
                @click="doGetDetil(data.item)"
              >
                <b-icon icon="check" /> Verifikasi
              </b-button>
            </template>
          </b-table>
        </b-col>
      </b-row>
    </b-card>
    <b-modal
      title="Form Approval Registrasi Anggota Keluar"
      id="modal-form"
      hide-footer
      size="xl"
      centered
    >
      <b-form>
        <b-row>
          <b-col cols="6">
            <b-form-group label="Majlis" label-for="cabang">
              <b-form-input
                id="cabang"
                disabled
                :value="form.data.nama_rembug"
              />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="No Anggota" label-for="no_anggota">
              <b-form-input
                id="no_anggota"
                disabled
                :value="form.data.no_anggota"
              />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Nama Anggota" label-for="nama_anggota">
              <b-form-input
                id="nama_anggota"
                disabled
                :value="form.data.nama_anggota"
              />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Tgl Mutasi" label-for="tgl_mutasi">
              <b-form-input
                id="tgl_mutasi"
                disabled
                :value="dateFormatId(form.data.tanggal_mutasi)"
              />
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Keterangan" label-for="keterangan">
              <b-form-textarea
                id="keterangan"
                row="5"
                :value="form.data.keterangan_mutasi"
                disabled
              />
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Pokok" label-for="saldo_pokok">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_pokok"
                  disabled
                  :value="thousand(form.data.saldo_pokok)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Margin" label-for="saldo_margin">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_margin"
                  disabled
                  :value="thousand(form.data.saldo_margin)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Catab" label-for="saldo_catab">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_catab"
                  disabled
                  :value="thousand(form.data.saldo_catab)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Minggon" label-for="saldo_minggon">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_minggon"
                  disabled
                  :value="thousand(form.data.saldo_minggon)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Sukarela" label-for="saldo_sukarela">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_sukarela"
                  disabled
                  :value="thousand(form.data.saldo_sukarela)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Tab Berencana" label-for="saldo_tab_berencana">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_tab_berencana"
                  disabled
                  :value="thousand(form.data.saldo_tab_berencana)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Deposito" label-for="saldo_deposito">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_deposito"
                  disabled
                  :value="thousand(form.data.saldo_deposito)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Simpok" label-for="salso_simpok">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_simpok"
                  disabled
                  :value="thousand(form.data.saldo_simpok)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Saldo Simwa" label-for="saldo_simwa">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="saldo_simwa"
                  disabled
                  :value="thousand(form.data.saldo_simwa)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Bonus Bagi Hasil" label-for="bonus_bagihasil">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="bonus_bagihasil"
                  disabled
                  :value="thousand(form.data.bonus_bagihasil)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Penarikan Sukarela" label-for="penarikan_sukarela">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="penarikan_sukarela"
                  disabled
                  :value="thousand(form.data.penarikan_sukarela)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Setoran Tambahan" label-for="setoran_tambahan">
              <b-input-group prepend="Rp">
                <b-form-input
                  id="setoran_tambahan"
                  disabled
                  :value="thousand(form.data.setoran_tambahan)"
                />
              </b-input-group>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col
            cols="12"
            class="d-flex justify-content-center border-top pt-5"
          >
            <b-button
              variant="secondary"
              @click="$bvModal.hide('modal-form')"
              :disabled="form.loading"
              class="mx-1"
              >Cancel
            </b-button>
            <b-button
              variant="danger"
              type="button"
              :disabled="form.loading"
              class="mx-1"
              @click="doReject"
            >
              {{ form.loading ? "Memproses..." : "Reject" }}
            </b-button>
            <b-button
              variant="success"
              type="button"
              :disabled="form.loading"
              class="mx-1"
              @click="doSave"
            >
              {{ form.loading ? "Memproses..." : "Approve" }}
            </b-button>
          </b-col>
        </b-row>
      </b-form>
    </b-modal>
  </div>
</template>
  
  <script>
import { mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import easycoApi from "@/core/services/easyco.service";
import helper from "@/core/helper";
export default {
  name: "Cabang",
  components: {},
  data() {
    return {
      form: {
        data: {
          id: null,
          no_anggota: null,
          nama_rembug: null,
          nama_anggota: null,
          nama_alasan: null,
          keterangan_mutasi: null,
          tanggal_mutasi: null,
          saldo_pokok: null,
          saldo_margin: null,
          saldo_catab: null,
          saldo_minggon: null,
          saldo_sukarela: null,
          saldo_tab_berencana: null,
          saldo_deposito: null,
          saldo_simpok: null,
          saldo_bonus_bagihasil: null,
          penarikan_sukarela: null,
          setoran_tambahan: null,
        },
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
            key: "nama_rembug",
            sortable: true,
            label: "Majelis",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "no_anggota",
            sortable: true,
            label: "No Anggota",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama_anggota",
            sortable: true,
            label: "Nama Anggota",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "tanggal_mutasi",
            sortable: true,
            label: "Tgl Mutasi",
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
        items: [],
        loading: false,
        totalRows: 0,
      },
      paging: {
        page: 1,
        perPage: "~",
        sortyDir: "ASC",
        sortBy: "ka.no_anggota",
        search: "",
        status: 0,
        cabang: null,
        rembug: null,
      },
      remove: {
        data: Object,
        loading: false,
      },
      opt: {
        perPage: [10, 25, 50, 100],
        cabang: [],
        majelis: [],
        alasan: [
          {
            value: 1,
            text: "Meninggal",
          },
          {
            value: 2,
            text: "Karakter",
          },
          {
            value: 3,
            text: "Pindah Lembaga Lain",
          },
          {
            value: 4,
            text: "Tidak diijinkan Pasangan",
          },
          {
            value: 5,
            text: "Simpanan Kurang",
          },
          {
            value: 6,
            text: "Kondisi Keluarga",
          },
          {
            value: 7,
            text: "Pindah Alamat",
          },
          {
            value: 8,
            text: "Tidak Setuju Keputusan Lembaga",
          },
          {
            value: 9,
            text: "Usia / Jompo",
          },
          {
            value: 10,
            text: "Sakit",
          },
          {
            value: 11,
            text: "Kumpulan Bubar",
          },
          {
            value: 12,
            text: "Tidak Punya Waktu",
          },
          {
            value: 13,
            text: "Kerja",
          },
          {
            value: 14,
            text: "Cerai",
          },
          {
            value: 15,
            text: "Pembiayaan Bermasalah",
          },
          {
            value: 16,
            text: "Usaha Sudah Berkembang",
          },
          {
            value: 17,
            text: "Tidak Mau Kumpulan",
          },
          {
            value: 18,
            text: "Batal Pembiayaan (Anggota baru)",
          },
          {
            value: 19,
            text: "Migrasi Anggota Individu",
          },
        ],
      },
    };
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
    ...helper,
    validateState(name) {
      const { $dirty, $error } = this.$v.form.data[name];
      return $dirty ? !$error : null;
    },
    async doGetCabang() {
      let payload = {
        perPage: "~",
        page: 1,
        sortBy: "nama_cabang",
        sortDir: "ASC",
        search: "",
      };
      try {
        let req = await easycoApi.cabangRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          data.map((item) => {
            this.opt.cabang.push({
              value: item.kode_cabang,
              text: `${item.kode_cabang} - ${item.nama_cabang}`,
              data: item,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGetMajelis() {
      this.opt.majelis = [];
      let payload = {
        perPage: "~",
        page: 1,
        sortBy: "kode_rembug",
        sortDir: "ASC",
        search: "",
        kode_cabang: this.paging.cabang,
      };
      try {
        let req = await easycoApi.rembugRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          data.map((item) => {
            this.opt.majelis.push({
              value: item.kode_rembug,
              text: item.nama_rembug,
              data: item,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGetDetil(item) {
      console.log(item);
      this.form.data = { ...item };
      this.$bvModal.show("modal-form");
    },
    async doGet() {
      let payload = { ...this.paging };
      if (payload.cabang && payload.rembug) {
        this.table.loading = true;
        try {
          let req = await easycoApi.approvalAnggotaKeluar(
            payload,
            this.user.token
          );
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
      }
    },
    async doSave(e) {
      this.form.loading = true;
      try {
        let payload = `id=${this.form.data.id}`;
        let req = await easycoApi.approveAnggotaKeluar(
          payload,
          this.user.token
        );
        let { status } = req.data;
        if (status) {
          this.notify("success", "Success", "Berhasil Di Approve");
          this.doGet();
          this.$bvModal.hide("modal-form");
        } else {
          this.notify("danger", "Error", "Data gagal diapprove");
        }
        this.form.loading = false;
      } catch (error) {
        this.notify("danger", "Error", error);
        this.form.loading = false;
      }
    },
    async doReject(e) {
      this.form.loading = true;
      try {
        let payload = `id=${this.form.data.id}`;
        let req = await easycoApi.rejectAnggotaKeluar(payload, this.user.token);
        let { status } = req.data;
        if (status) {
          this.notify("success", "Success", "Berhasil Di Reject");
          this.doGet();
          this.$bvModal.hide("modal-form");
        } else {
          this.notify("danger", "Error", "Data gagal diapprove");
        }
        this.form.loading = false;
      } catch (error) {
        this.notify("danger", "Error", error);
        this.form.loading = false;
      }
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
    this.doGetCabang();
  },
};
</script>
  