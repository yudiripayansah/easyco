<template>
<b-card :title="$route.name">
  <b-form class="border-top py-5" @submit.prevent="doSave()">
    <b-row class="m-0">
      <b-col sm=12 md=12>
        <b-form-group label="Pilih Anggota">
          <b-select />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="NIK Anggota">
          <b-input disabled />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Nama Anggota">
          <b-input disabled />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="No Anggota">
          <b-input disabled />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="No Pengajuan">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Jumlah Pengajuan">
          <b-input-group prepend="Rp">
            <b-input />
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Peruntukan">
          <b-select :options="opt.peruntukan" />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Jangka Waktu & Periode">
          <b-row>
            <b-col sm=3>
              <b-input />
            </b-col>
            <b-col sm=9 class="mt-3 mt-sm-0">
              <b-select :options="opt.periode" />
            </b-col>
          </b-row>
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Tanggal Pencairan">
          <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" />
        </b-form-group>
      </b-col>
      <b-col sm=12 class="text-right border-top pt-5">
        <b-button variant="primary" :disabled="form.loading" type="submit">
          <b-spinner small label="Small Spinner" v-show="form.loading" class="mr-2"></b-spinner>
          Simpan
        </b-button>
      </b-col>
    </b-row>
  </b-form>
</b-card>
</template>

<script>
import axios from '@/core/plugins/axios'
export default {
  name: "RegistrasiAnggota",
  components: {

  },
  data() {
    return {
      form: {
        loading: false,
      },
      opt: {
        periode: [{
            text: 'Hari',
            value: 'Hari'
          },
          {
            text: 'Minggu',
            value: 'Minggu'
          },
          {
            text: 'Bulan',
            value: 'Bulan'
          },
          {
            text: 'Tahun',
            value: 'Tahun'
          }
        ],
        peruntukan: [{
            text: 'Modal Usaha/ Kerja',
            value: 'Modal Usaha/ Kerja'
          },
          {
            text: 'Pendidikan',
            value: 'Pendidikan'
          },
          {
            text: 'Pembangunan Rumah',
            value: 'Pembangunan Rumah'
          },
          {
            text: 'Konsumtif',
            value: 'Konsumtif'
          },
          {
            text: 'Lainnya',
            value: 'Lainnya'
          }
        ],
      }
    }
  },
  mounted() {},
  methods: {
    doSave() {
      let vm = this
      this.form.loading = true
      setTimeout(() => {
        vm.form.loading = false
      }, 5000)
    }
  }
};
</script>
