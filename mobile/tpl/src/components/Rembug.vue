<template>
  <div>
    <v-select
      solo
      label="Rembug"
      class="mb-4"
      hide-details
      :items="rembug"
      v-model="list.rembug"
      @change="$emit('refreshAnggota', list.rembug, list.date)"
    />
    <v-menu
      ref="menu"
      v-model="dateShow"
      :close-on-content-click="false"
      :return-value.sync="list.date"
      transition="scale-transition"
      offset-y
      min-width="auto"
      class="white"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-text-field
          solo
          v-model="list.date"
          label="Tanggal"
          readonly
          v-bind="attrs"
          v-on="on"
        />
      </template>
      <v-date-picker v-model="list.date" no-title scrollable>
        <v-spacer></v-spacer>
        <v-btn text color="primary" @click="dateShow = false"> Cancel </v-btn>
        <v-btn
          text
          color="primary"
          @click="
            $refs.menu.save(list.date);
            $emit('refreshAnggota', list.rembug, list.date);
          "
        >
          OK
        </v-btn>
      </v-date-picker>
    </v-menu>
    <!-- <v-btn small block class="indigo lighten-1 white--text rounded-lg mb-4" type="submit">
      Infaq
    </v-btn> -->
    <v-container class="pa-0" v-if="list.anggota && list.anggota.length > 0">
      <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3">
        <div class="d-flex justify-space-between">
          <span><b>Total Setoran</b></span>
          <h5>Rp {{ thousand(total.setoran) }}</h5>
        </div>
        <div class="d-flex justify-space-between">
          <span><b>Total Penarikan</b></span>
          <h5>Rp {{ thousand(total.penarikan) }}</h5>
        </div>
        <!-- <div class="d-flex justify-space-between">
          <span>Total Infaq</span>
          <h5>Rp 0</h5>
        </div> -->
      </v-card>
      <v-card
        class="white elevation-3 rounded-lg pa-3 align-items-end mb-3"
        v-for="(agt, agtIndex) in list.anggota"
        :key="agtIndex"
      >
        <v-container class="d-flex justify-space-between pa-0 flex-column">
          <h5
            class="text-h6 font-weight-bold d-inline-flex justify-space-between align-center"
          >
            {{ agt.nama_anggota }}
            <small class="text-caption grey--text ms-3">{{
              agt.no_anggota
            }}</small>
          </h5>
          <div
            class="d-flex block flex-row justify-space-between align-items-center"
          >
            <span><b>Total Setoran: </b></span>
            <h5 class="text-end">Rp {{ thousand(agt.total_penerimaan) }}</h5>
          </div>
          <div
            class="d-flex block flex-row justify-space-between align-items-center"
          >
            <span><b>Total Penarikan: </b></span>
            <h5 class="text-end">Rp {{ thousand(agt.total_penarikan) }}</h5>
          </div>
        </v-container>
        <v-divider class="my-2" />
        <v-container class="pa-0 d-flex justify-space-between">
          <v-row class="justify-end">
            <v-col cols="4">
              <router-link
                :to="`/transaksi/setoran-form/${list.rembug}/${agt.no_anggota}/${list.date}`"
              >
                <v-btn
                  small
                  block
                  class="indigo lighten-1 white--text rounded-lg"
                  type="submit"
                >
                  Transaksi
                </v-btn>
              </router-link>
            </v-col>
            <!-- <v-col cols="4">
              <router-link :to="`/transaksi/pembiayaan/${agt.no_anggota}`">
                <v-btn small block class="indigo lighten-1 white--text rounded-lg px-0" type="submit">
                  Pembiayaan
                </v-btn>
              </router-link>
            </v-col>
            <v-col cols="4">
              <router-link :to="`/transaksi/rekening/${agt.no_anggota}`">
                <v-btn small block class="indigo lighten-1 white--text rounded-lg" type="submit">
                  Tabungan
                </v-btn>
              </router-link>
            </v-col> -->
          </v-row>
        </v-container>
      </v-card>
    </v-container>
    <v-container class="pa-0" v-else>
      <v-card class="white elevation-3 rounded-lg pa-3 align-items-end mb-3">
        <v-container class="d-flex justify-space-between pa-0">
          <div class="d-flex flex-column">
            <h5 class="text-h5 font-weight-bold">
              {{ list.loading ? "Memproses data..." : "Tidak ada anggota" }}
            </h5>
          </div>
        </v-container>
      </v-card>
    </v-container>
  </div>
</template>
<script>
import helper from "@/utils/helper";
import Toast from "@/components/Toast";
import { mapGetters, mapActions } from "vuex";
import services from "@/services";
export default {
  props: ["list", "target", "total"],
  components: {
    Toast,
  },
  data() {
    return {
      alert: {
        show: false,
        msg: "",
      },
      dateShow: false,
      date: null,
      rembug: [],
      loading: false,
    };
  },
  computed: {
    ...mapGetters(["user"]),
  },
  watch: {
    date: {
      handler(val) {
        this.$emit("refreshAnggota", this.list.rembug, this.date);
      },
      deep: true,
    },
  },
  methods: {
    ...helper,
    async getRembug() {
      let hari_transaksi = new Date().getDay();
      hari_transaksi = this.user.hari_transaksi;
      let payload = new FormData();
      payload.append("kode_petugas", this.user.kode_petugas);
      payload.append("hari_transaksi", hari_transaksi);
      this.rembug = [];
      this.loading = true;
      try {
        let req = await services.infoRembug(payload, this.user.token);
        if (req.status === 200) {
          req.data.data.map((item) => {
            this.rembug.push({
              text: item.nama_rembug,
              value: item.kode_rembug,
            });
          });
        } else {
          this.alert = {
            show: true,
            msg: data.message,
          };
        }
        this.loading = false;
      } catch (error) {
        this.alert = {
          show: true,
          msg: error,
        };
        this.loading = false;
      }
    },
  },
  mounted() {
    this.getRembug();
  },
};
</script>