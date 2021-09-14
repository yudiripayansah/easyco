<template>
<b-card :title="$route.name">
  <b-form class="border-top py-5" @submit.prevent="doSave()">
    <b-row class="m-0">
      <b-col sm=6 md=4>
        <b-form-group label="No Anggota">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Nama">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Nik">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Jenis Kelamin">
          <b-select :options="opt.jenis_kelamin" />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Tempat / Tanggal Lahir">
          <b-row>
            <b-col sm=12 md=4>
              <b-input />
            </b-col>
            <b-col sm=12 md=8>
              <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" />
            </b-col>
          </b-row>
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Alamat">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="No Telp">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Email">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Nama Ibu Kandung">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Pendidikan Terakhir">
          <b-select :options="opt.pendidikan_terakhir" />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Pekerjaan">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Keterangan Pekerjaan">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Status Pernikahan">
          <b-select :options="opt.status_pernikahan" />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Nama Pasangan">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="NIK Pasangan">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Tempat/ Tanggal Lahir Pasangan">
          <b-row>
            <b-col sm=12 md=4>
              <b-input />
            </b-col>
            <b-col sm=12 md=8>
              <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" />
            </b-col>
          </b-row>
        </b-form-group>
      </b-col>
      <b-col sm=6 md=4>
        <b-form-group label="Pekerjaan Pasangan">
          <b-input />
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
        jenis_kelamin: [{
            text: 'Laki-Laki',
            value: 'Laki-Laki'
          },
          {
            text: 'Perempuan',
            value: 'Perempuan'
          },
          {
            text: 'Lainnya',
            value: 'Lainnya'
          }
        ],
        pendidikan_terakhir: [{
            text: 'SD Sederajat',
            label: 'SD Sederajat',
          },
          {
            text: 'SMP Sederajat',
            label: 'SMP Sederajat',
          },
          {
            text: 'SMA Sederajat',
            label: 'SMA Sederajat',
          },
          {
            text: 'Diploma',
            label: 'Diploma',
          },
          {
            text: 'Sarjana',
            label: 'Sarjana',
          },
          {
            text: 'Magister',
            label: 'Magister',
          },
          {
            text: 'Professor',
            label: 'Professor',
          }
        ],
        status_pernikahan: [{
            text: 'Belum Menikah',
            value: 'Belum Menikah',
          },
          {
            text: 'Menikah',
            value: 'Menikah',
          },
          {
            text: 'Cerai',
            value: 'Cerai',
          }
        ]
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
