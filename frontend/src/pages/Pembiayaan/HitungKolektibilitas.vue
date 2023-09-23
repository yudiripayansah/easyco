<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row>
        <b-col cols="12">
          <b-input-group prepend="Cabang" class="mb-3">
            <b-form-select v-model="form.data.kode_cabang" :options="opt.cabang" />
          </b-input-group>
        </b-col>
        <b-col cols="12">
          <b-input-group prepend="Tanggal" class="mb-3">
            <b-form-datepicker
              v-model="form.data.tanggal"
              :date-format-options="{
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
              }"
              locale="id"
            />
          </b-input-group>
        </b-col>
        <b-col cols="12">
          <b-button
            variant="success"
            @click="prosesHitung()"
            v-b-tooltip.hover
            title="Proses Hitung"
            :disabled="form.loading"
          >
           {{ (form.loading) ? 'Memproses...' : 'Proses Hitung' }}
          </b-button>
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
  name: "RegistrasiAkad",
  components: {},
  data() {
    return {
      form: {
        data: {
          kode_cabang: null,
          tanggal: null
        },
        loading: false
      },
      opt: {
        cabang: []
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
    async prosesHitung() {
      this.form.loading = true;
      try {
        let payload = {...this.form.data};
        let req = await easycoApi.hitungKolek(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.doClearForm();
          this.notify("success", "Success", msg);
        } else {
          this.notify("danger", "Error", msg);
        }
        this.form.loading = false;
      } catch (error) {
        this.form.loading = false;
        console.error(error);
        this.notify("danger", "Error", error);
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
  