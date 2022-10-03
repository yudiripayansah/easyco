<template>
<b-card :title="$route.name">
  <b-form class="border-top py-5 Halaman 1" @submit.prevent="doSave()">
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
  <b-form class="border-top py-5 Halaman 2" @submit.prevent="doSave()">
    <b-row>
      <b-col cols="12">
        <b-form-group label="Status Pernikahan">
          <b-select :options="opt.status_pernikahan" />
        </b-form-group>
      </b-col>
      <b-col cols="12"><p>Data Pasangan</p>
        <b-form-group label="Nama">
          <b-input />
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
        <b-form-group label="NIK">
          <b-input />
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
      <b-col cols="12">
        <b-form-group label="No.Telp / HP">
          <b-input placeholder="0858123456" />
        </b-form-group>
      </b-col>
      <b-col cols="2" sm="2">
        <b-form-group label="Jumlah Anak">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col cols="12" sm="10">
        <b-form-group label="Keterangan">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col cols="2" sm="2">
        <b-form-group label="Jml Tanggungan Lain">
          <b-input />
        </b-form-group>
      </b-col>
      <b-col cols="12" sm="10">
        <b-form-group label="Keterangan">
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
  <b-form class="border-top py-5 Halaman 3" @submit.prevent="doSave()">
    <b-row>
      <b-col cols="12"><h3>Data Aset Rumah Tangga</h3><p>Data Rumah</p>
        <b-form-group label="Status Rumah">
          <b-select :options="opt.status_rumah" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Ukuran Rumah">
          <b-select :options="opt.ukuran_rumah" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Dinding">
          <b-select :options="opt.dinding" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Atap">
          <b-select :options="opt.atap" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Lantai">
          <b-select :options="opt.lantai" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Jamban">
          <b-select :options="opt.jamban" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-form-group label="Sumber Air">
          <b-select :options="opt.sumber_air" />
        </b-form-group>
      </b-col>
      <b-col cols="12">
        <b-container class="bv-example-row mb-3">
          <p>Lahan</p>
          <b-row cols="3">
              <b-col>
                <b-form-group label="Sawah">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Kebun">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Pekalangan">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="12">
        <b-container class="bv-example-row mb-3">
          <p>Ternak</p>
          <b-row cols="3">
              <b-col>
                <b-form-group label="Sawah">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Kebun">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Pekalangan">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="12">
        <b-container class="bv-example-row mb-3">
          <p>Kendaraan</p>
          <b-row cols="3">
              <b-col>
                <b-form-group label="Sepeda">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Motor">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="12">
        <b-container class="bv-example-row mb-3">
          <p>Elektronik</p>
          <b-row cols="3">
              <b-col>
                <b-form-group label="Kulkas">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Tv">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Handphone">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
        </b-container>
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
  <b-form class="border-top py-5 Halaman 4" @submit.prevent="doSave()">
    <b-row>
      <b-col cols="12">
          <h3>Data Ekonomi Rumah Tangga</h3>
            <p>Pendapatan Rumah Tangga/Bulan</p>
      </b-col>
      <b-col cols="12">
        <b-container class="bv-example-row mb-3">
          <b-row cols="3">
              <b-col>
                <b-form-group label="Pendapatan Usaha">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="12">
        <b-container class="bv-example-row mb-3">
          <b-row cols="3">
              <b-col>
                <b-form-group label="Pendapatan Pasangan">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="12">
        <b-container class="bv-example-row mb-3">
          <b-row cols="3">
              <b-col>
                <b-form-group label="Total Pendapatan">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
        </b-container>
      </b-col>
      <b-col cols="12">
        <b-container class="bv-example-row mb-3">
          <p>Pengeluaran Rumah Tangga / Bulan</p>
          <b-row cols="3">
              <b-col>
                <b-form-group label="Beras">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Biaya Pendidikan">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
          <b-row cols="3">
              <b-col>
                <b-form-group label="Belanja Dapur">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Hutang Pihak Lain">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
          <b-row cols="3">
              <b-col>
                <b-form-group label="Biaya Listrik">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Biaya Lainnya">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
          <b-row cols="3">
              <b-col>
                <b-form-group label="Biaya Telp">
          <b-input />
        </b-form-group>
              </b-col>
              <b-col>
                <b-form-group label="Total Biaya">
          <b-input />
        </b-form-group>
              </b-col>
          </b-row>
        </b-container>
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
            text: '1.Menikah',
            value: '1.Menikah',
          },
          {
            text: '2.Belum Menikah',
            value: '2.Belum Menikah',
          },
          {
            text: '3.Cerai',
            value: '3.Cerai',
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
    status_rumah: [{
        text: 'Milik Sendiri:',
        value: 'Milik Sendiri:',
      },
      {
        text: 'Saudara',
        value: 'Saudara',
      },
      {
        text: 'Orang Tua',
        value: 'Orang Tua',
      }
    ],
    ukuran_rumah: [{
        text: 'Besar:',
        value: 'Besar:',
      },
      {
        text: 'Sedang',
        value: 'Sedang',
      },
      {
        text: 'Kecil',
        value: 'Kecil',
      }
    ],
    dinding: [{
        text: 'Papan Kayu',
        value: 'Papan Kayu',
      },
      {
        text: 'Tembok',
        value: 'Tembok',
      }
    ],
    atap: [{
        text: 'Asbes',
        value: 'Asbes',
      },
      {
        text: 'Genteng',
        value: 'Genteng',
      }
    ],
    lantai: [{
        text: 'Plester Semen',
        value: 'Plester Semen',
      },
      {
        text: 'Keramik',
        value: 'Keramik',
      }
    ],
    jamban: [{
        text: 'Sungai',
        value: 'Sungai',
      }
    ],
    sumber_air: [{
        text: 'Sumur Sendiri',
        value: 'Sumur Sendiri',
      },
      {
        text : 'Air Pam',
        value : 'Air Pam',
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
