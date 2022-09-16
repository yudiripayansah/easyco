<template>
<b-card :title="$route.name">
  <b-form class="border-top py-5" @submit.prevent="doSave()">
    <b-row>
      <b-col cols="12">
        <b-form-group label="Nama">
          <b-input v-model="form.data.nama" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Jenis Kelamin">
          <input class="form-check-input ml-2" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label ml-7" for="flexRadioDefault1">
              Perempuan
            </label>
          <input class="form-check-input ml-7" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label ml-12" for="flexRadioDefault2">
              Laki-Laki
            </label>
        </b-form-group>
      </b-col>
      <b-col cols="8">
        <b-form-group label="Tempat / Tanggal Lahir">
          <b-row>
            <b-col cols="8">
              <b-input />
            </b-col>
            <b-col cols="4">
              <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" />
            </b-col>
          </b-row>
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Nama Ibu Kandung">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="NIK">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Alamat">
          <b-select :options="opt.kota_kabupaten" class="mb-3" />
          <b-select :options="opt.kecamatan" class="mb-3" />
          <b-select :options="opt.desa" class="mb-3" />
          <b-input placeholder="Jl:.............................,No...........,Rt.....,Rw......"/>
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="No.Telp / HP">
          <b-input placeholder="0858123456" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Pendidikan Terakhir">
          <b-select :options="opt.pendidikan_terakhir" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Pekerjaan">
        </b-form-group>
        <b-select :options="opt.pekerjaan" />
      </b-col>
      <b-col cols="12">
        <b-form-group label="Keterangan Pekerjaan">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
        <b-button variant="secondary" :disabled="form.loading" type="submit" class="ml-5">
          <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
          Kembali
        </b-button>
        <b-button variant="primary" :disabled="form.loading" type="submit" class="ml-5">
          <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
          Selanjutnya
        </b-button>
      </b-col>
    </b-row>
  </b-form>
</b-card>
</template>
<script src="works/frontend/src/pages/Keanggotaan/wizard_regis_anggota.js"></script>
<script>
import axios from '@/core/plugins/axios'
export default {
  name: "RegistrasiAnggota",
  components: {

  },
  data() {
    return {
      form: {
        data: {
          nama: null,
          jenis_kelamin: null,
        },
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
        ],
        kota_kabupaten: [{
          text: 'Kota / Kabupaten:',
          value: 'Kota / Kabupaten:',
        },
        {
          text: 'Kota Bogor',
          value: 'Kota Bogor',
        },
        {
          text: 'Kabupaten Bogor',
          value: 'Kabupaten Bogor',
        }
      ],
      kecamatan: [{
        text: 'Kecamatan:',
        value: 'Kecamatan:',
      },
      {
        text: 'Kecamatan Pakuan',
        value: 'Kecamatan Pakuan',
      },
      {
        text: 'Kecamatan Cibinong',
        value: 'Kecamatan Cibinong',
      }
    ],
    desa: [{
        text: 'Desa:',
        value: 'Desa:',
      },
      {
        text: 'Desa Sukasari',
        value: 'Desa Sukasari',
      },
      {
        text: 'Desa Sukahati',
        value: 'Desa Sukahati',
      }
    ],
    pekerjaan: [{
        text: 'Buruh:',
        value: 'Buruh:',
      },
      {
        text: 'Dokter',
        value: 'Dokter',
      },
      {
        text: 'Atlet',
        value: 'Atlet',
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
