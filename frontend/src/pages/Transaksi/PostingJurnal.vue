<template>
  <div>
    <h1 class="mb-5">{{ $route.name }}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col>
          <b-form @submit="doSave">
            <b-row>
              <b-col cols="6">
                <b-form-group label="Cabang">
                  <b-select
                    v-model="form.data.kode_cabang"
                    :options="opt.cabang"
                    :state="validateState('kode_cabang')"
                    @input="doGet"
                  />
                </b-form-group>
              </b-col>
              <b-col cols="6">
                <b-form-group label="Keterangan">
                  <b-textarea
                    v-model="form.data.description"
                    :state="validateState('description')"
                  />
                </b-form-group>
              </b-col>
              <b-col cols="6">
                <b-form-group label="Tanggal">
                  <b-form-datepicker
                    v-model="form.data.voucher_date"
                    :date-format-options="{
                      year: 'numeric',
                      month: 'numeric',
                      day: 'numeric',
                    }"
                    locale="id"
                    :state="validateState('voucher_date')"
                    @input="doGet"
                  />
                </b-form-group>
              </b-col>
              <b-col cols="12">
                <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th width="5%">No</th>
                      <th width="10%">Tanggal</th>
                      <th width="20%">Transaksi</th>
                      <th width="15%">Jumlah</th>
                      <th width="25%" colspan="2">Debit</th>
                      <th width="25%" colspan="2">Kredit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(pj, pjIndex) in form.data.detail"
                      :key="`pj-${pjIndex}`"
                    >
                      <!-- NO -->
                      <td
                        class="text-center align-middle"
                        style="font-size: 10px"
                      >
                        {{ pjIndex + 1 }}
                      </td>
                      <!-- TANGGAL-->
                      <td>
                        <b-form-input
                          v-model="pj.trx_date"
                          style="border: none"
                        />
                      </td>
                      <!-- TRANSAKSI -->
                      <td>
                        <b-form-input
                          v-model="pj.nama_trx"
                          style="border: none"
                        />
                      </td>
                      <!-- JUMLAH -->
                      <td>
                        <b-input-group>
                          <vue-numeric
                            class="form-control text-right"
                            separator="."
                            v-model="pj.amount"
                            style="border: none"
                          />
                        </b-input-group>
                      </td>
                      <!-- DEBIT -->
                      <td>
                        <b-form-input
                          v-model="pj.gl_debit"
                          style="border: none"
                        />
                      </td>
                      <td>
                        <b-form-input
                          v-model="pj.nama_gl_debit"
                          style="border: none"
                        />
                      </td>
                      <!-- KREDIT -->
                      <td>
                        <b-form-input
                          v-model="pj.gl_credit"
                          style="border: none"
                        />
                      </td>
                      <td>
                        <b-form-input
                          v-model="pj.nama_gl_credit"
                          style="border: none"
                        />
                      </td>
                    </tr>
                    <!-- <tr>
                      <td class="text-right" colspan="3">Total:</td>
                      <td class="text-right">
                        Rp {{ thousand(form.data.total_debet) }}
                      </td>
                      <td class="text-right">
                        Rp {{ thousand(form.data.total_kredit) }}
                      </td>
                      <td></td>
                    </tr> -->
                    <tr>
                      <td
                        class="text-right"
                        colspan="7"
                        style="font-size: 11px; font-weight: bold"
                      >
                        TOTAL KAS DEBET
                      </td>
                      <td
                        class="text-right"
                        style="font-size: 11px; font-weight: bold"
                      >
                        Rp {{ thousand(form.data.total_kas_debit) }}
                      </td>
                    </tr>
                    <tr>
                      <td
                        class="text-right"
                        colspan="7"
                        style="font-size: 11px; font-weight: bold"
                      >
                        TOTAL KAS KREDIT
                      </td>
                      <td
                        class="text-right"
                        style="font-size: 11px; font-weight: bold"
                      >
                        Rp {{ thousand(form.data.total_kas_credit) }}
                      </td>
                    </tr>
                    <tr>
                      <td
                        class="text-right"
                        colspan="7"
                        style="font-size: 11px; font-weight: bold"
                      >
                        SALDO KAS
                      </td>
                      <td
                        class="text-right"
                        style="font-size: 11px; font-weight: bold"
                      >
                        Rp {{ thousand(form.data.saldo_kas) }}
                      </td>
                    </tr>
                    <tr>
                      <td class="p-3" colspan="8" style="font-size: 12px">
                        <b-button variant="success" block type="submit">
                          Posting Jurnal <b-icon icon="plus" />
                        </b-button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </b-col>
            </b-row>
          </b-form>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>
<style>
.table td {
  padding: 0 !important;
}
.table th {
  padding: 5px 5px 5px 10px !important;
}
</style>
  
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
          voucher_date: null,
          description: null,
          detail: [],
          total_kas_debit: 0,
          total_kas_credit: 0,
          saldo_kas: 0,
        },
      },
      opt: {
        perPage: [10, 25, 50, 100],
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
        voucher_date: {
          required,
        },
        description: {
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
      let payload = {
        kode_cabang: this.form.data.kode_cabang,
        voucher_date: this.form.data.voucher_date,
      };
      if (payload.kode_cabang && payload.voucher_date) {
        try {
          let req = await easycoApi.postingJurnal(payload, this.user.token);
          let { data, status, msg, total } = req.data;
          console.log(req.data.total_kas_debit);
          if (status) {
            this.form.data.detail = data;
            this.form.data.total_kas_debit = req.data.total_kas_debit;
            this.form.data.total_kas_credit = req.data.total_kas_kredit;
            this.form.data.saldo_kas = req.data.saldo_kas;
          } else {
            this.notify("danger", "Error", msg);
          }
        } catch (error) {
          console.error(error);
          this.notify("danger", "Login Error", error);
        }
      }
    },
    async doSave(e) {
      try {
        let payload = {
          kode_cabang: this.form.data.kode_cabang,
          voucher_date: this.form.data.voucher_date,
        };
        let req = false;
        req = await easycoApi.sendPostingJurnal(payload, this.user.token);
        let { data, status, msg } = req.data;
        if (status) {
          this.notify("success", "Success", msg);
          this.doClearForm();
        } else {
          this.notify("danger", "Error", msg);
        }
      } catch (error) {
        console.error(error);
        this.notify("danger", "Login Error", error);
      }
    },
    doClearForm() {
      this.form.data = {
        kode_cabang: null,
        voucher_date: null,
        description: null,
        detail: [],
        total_kas_debit: 0,
        total_kas_kredit: 0,
        saldo_kas: 0,
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
};
</script>
  