<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row>
        <b-col cols="10">
          <b-row>
            <b-col cols="6">
              <b-input-group prepend="Cabang" class="mb-3">
                <b-form-select v-model="paging.kode_cabang" :options="opt.cabang"/>
              </b-input-group>
            </b-col>
            <!-- <b-col cols="6">
              <b-input-group prepend="Petugas" class="mb-3">
                <b-form-select v-model="paging.kode_petugas" :options="opt.petugas" />
              </b-input-group>
            </b-col>
            <b-col cols="6">
              <b-input-group prepend="Sumber Dana" class="mb-3">
                <b-form-select v-model="paging.sumber_dana" :options="opt.sumber_dana" />
              </b-input-group>
            </b-col> -->
            <b-col cols="6">
              <b-input-group prepend="Tanggal" class="mb-3">
                <b-form-datepicker
                  v-model="paging.tanggal_hitung"
                  :date-format-options="{
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric',
                  }"
                  locale="id"
                  @change="doGet()"
                />
              </b-input-group>
            </b-col>
            <!-- <b-col cols="6">
              <b-input-group prepend="Kolektibilitas" class="mb-3">
                <b-form-select v-model="paging.kolektibilitas" :options="opt.kolektibilitas" />
              </b-input-group>
            </b-col> -->
          </b-row>
        </b-col>
        <b-col cols="2" class="d-flex align-items-start justify-content-end">
          <b-button-group>
            <b-button text="Button" variant="danger" @click="$bvModal.show('modal-pdf');doGetReport();">
              PDF
            </b-button>
            <b-button text="Button" variant="success" @click="exportXls()">
              XLS
            </b-button>
            <b-button text="Button" variant="warning" @click="exportCsv()">
              CSV
            </b-button>
          </b-button-group>
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
            <template #cell(no)="item">
              {{ item.index + 1 }}
            </template>
            <template #cell(saldo_pokok)="item">
              Rp {{ thousand(item.item.saldo_pokok) }}
            </template>
            <template #cell(saldo_margin)="item">
              Rp {{ thousand(item.item.saldo_margin) }}
            </template>
            <template #cell(saldo_minggon)="item">
              Rp {{ thousand(item.item.saldo_minggon) }}
            </template>
            <template #cell(jangka_waktu)="item">
              {{ item.item.jangka_waktu }}
              {{ getPeriodJangkaWaktu(item.item.periode_jangka_waktu) }}
            </template>
          </b-table>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>
<script>
import helper from "@/core/helper";
import { mapGetters } from "vuex";
import easycoApi from "@/core/services/easyco.service";
export default {
  name: "LaporanKolektibilitas",
  components: {},
  data() {
    return {
      table: {
        fields: [
          {
            key: "no_rekening",
            sortable: true,
            label: "No Rek",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "majelis",
            sortable: true,
            label: "Majelis",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "nama",
            sortable: true,
            label: "Nama",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "pokok_4",
            sortable: true,
            label: "Pokok",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "margin_4",
            sortable: true,
            label: "Margin",
            thClass: "text-center",
            tdClass: "",
          },
          {
            key: "jangka_waktu",
            sortable: true,
            label: "Jangka Waktu",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "tanggal",
            sortable: true,
            label: "Tanggal",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "mulai_angsuran",
            sortable: true,
            label: "Mulai Angsuran",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "pokok_0",
            sortable: true,
            label: "Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "margin_0",
            sortable: true,
            label: "Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "terbayar",
            sortable: true,
            label: "Terbayar",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "seharusnya",
            sortable: true,
            label: "Seharusnya",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "pokok_1",
            sortable: true,
            label: "Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "margin_1",
            sortable: true,
            label: "Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "Hari",
            sortable: true,
            label: "Hari",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "jumlah",
            sortable: true,
            label: "Jumlah",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "pokok_2",
            sortable: true,
            label: "Pokok",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "margin_2",
            sortable: true,
            label: "Margin",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "par",
            sortable: true,
            label: "Par",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "persen",
            sortable: true,
            label: "%",
            thClass: "text-center",
            tdClass: "text-right",
          },
          {
            key: "nominal",
            sortable: true,
            label: "Nominal",
            thClass: "text-center",
            tdClass: "text-right",
          },
        ],
        items: [],
        loading: false,
      },
      paging: {
        kode_cabang: null,
        tanggal_hitung: null
      },
      loading: false,
      opt: {
        cabang: [],
        petugas: [],
        sumber_dana: ["SEMUA"],
        kolektibilitas: ["SEMUA"]
      },
      loading: false,
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  mounted() {
    this.doGetCabang()
  },
  methods: {
    ...helper,
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
          this.opt.cabang = [];
          data.map((item) => {
            this.opt.cabang.push({
              value: item.kode_cabang,
              text: item.nama_cabang,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGetPetugas() {
      let payload = null;
      try {
        let req = await easycoApi.petugasRead(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.opt.petugas = [
            {
              value: null,
              text: "All",
            },
          ];
          data.map((item) => {
            this.opt.petugas.push({
              value: Number(item.kode_petugas),
              text: item.nama_kas_petugas,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGet() {
      let payload = {...this.paging};
      try {
        let req = await easycoApi.laporanKolek(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          console.log(data)
        }
      } catch (error) {
        console.error(error);
      }
    },
    doClearForm() {
      this.form.data = {
        kode_cabang: null,
        tanggal: null
      }
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
};
</script>
  