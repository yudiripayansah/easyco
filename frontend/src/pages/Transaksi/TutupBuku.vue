<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row class="align-items-end">
        <!-- <b-col cols="5">
          <b-form-group label="Cabang" class="mb-0">
            <b-select
              v-model="form.data.kode_cabang"
              :options="opt.cabang"
              :state="validateState('kode_cabang')"
              @input="doGet"
            />
          </b-form-group>
        </b-col> -->
        <b-col cols="10">
          <b-form-group label="Periode" class="mb-0">
            <b-form-datepicker
              v-model="form.data.periode_akhir"
              :date-format-options="{
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
              }"
              locale="id"
              :state="validateState('periode_akhir')"
              disabled
            />
          </b-form-group>
        </b-col>
        <b-col cols="2">
          <b-button type="button" variant="primary" block :disabled="!form.data.status" @click="doSave()">Proses</b-button>
        </b-col>
        <b-col cols="12" class="pt-5">
          <b-alert variant="danger" :show="!form.data.status">{{ form.data.msg }}</b-alert>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>
  
<script>
import { mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import easycoApi from "@/core/services/easyco.service";
import helper from "@/core/helper";
export default {
  name: "PostingJurnal",
  data() {
    return {
      form: {
        data: {
          kode_cabang: null,
          periode_akhir: null,
          jumlah: 0,
          msg: null,
          status: true
        },
      },
      opt: {
        cabang: [],
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
        periode_akhir: {
          required,
        },
      },
    },
  },
  mounted() {
    this.doGet();
    this.doGetCabang();
  },
  computed: {
    ...mapGetters(["user"]),
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
        search: null,
      };
      this.opt.cabang = [];
      try {
        let req = await easycoApi.cabangRead(payload, this.user.token);
        let { data, status, msg, total } = req.data;
        if (status) {
          data.map((item) => {
            this.opt.cabang.push({
              text: item.nama_cabang,
              value: item.kode_cabang,
            });
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async doGet() {
      let payload = null
      try {
        let req = await easycoApi.tutupBukuCheck(payload, this.user.token);
        let { data, status, msg } = req.data;
        console.log(req);
        this.form.data.periode_akhir = data.periode_akhir
        this.form.data.msg = msg
        this.form.data.status = status
      } catch (error) {
        console.error(error);
        this.notify("danger", "Error", error);
      }
    },
    async doSave() {
      let payload = {
        periode_akhir: this.dateFormat(this.form.data.periode_akhir)
      }
      try {
        let req = await easycoApi.tutupBukuProses(payload, this.user.token);
        let { data, status, msg } = req.data;
        if(status) {
          location.reload();
          this.notify("success", "Success", msg);
        } else {
          this.notify("danger", "Error", msg);
        }
      } catch (error) {
        console.error(error);
        this.notify("danger", "Error", error);
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
  