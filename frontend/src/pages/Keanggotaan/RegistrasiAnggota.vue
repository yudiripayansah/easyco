<template>
<div>
  <h1 class="mb-5">{{$route.name}}</h1>
  <b-card>
    <b-row no-gutters>
      <b-col cols="12" class="d-flex justify-content-end mb-5 pb-5 border-bottom">
        <b-button variant="success" @click="$bvModal.show('modal-form');doClearForm()" v-b-tooltip.hover
          title="Tambah Data Baru">
          <b-icon icon="plus" />
          Tambah Baru
        </b-button>
      </b-col>
      <b-col cols="12" class="mb-5">
        <b-row no-gutters>
          <b-col cols="6">
            <div class="w-100 max-200 pr-5">
              <b-input-group size="sm" prepend="Per Halaman">
                <b-form-select v-model="paging.perPage" :options="opt.perPage" />
              </b-input-group>
            </div>
          </b-col>
          <b-col cols="6" class="d-flex justify-content-end">
            <div class="w-100 max-300">
              <b-input-group size="sm">
                <b-form-input />
                <b-input-group-append>
                  <b-button size="sm" text="Button" variant="primary">
                    <b-icon icon="search" />
                    Cari
                  </b-button>
                </b-input-group-append>
              </b-input-group>
            </div>
          </b-col>
        </b-row>
      </b-col>
      <b-col cols="12">
        <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
          show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
          <template #cell(no)="item">
            {{item.index + 1}}
          </template>
          <template #cell(action)="item">
            <b-button variant="danger" size="xs" class="mx-1" @click="doDelete(item,true)" v-b-tooltip.hover
              title="Hapus">
              <b-icon icon="trash" />
            </b-button>
            <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Ubah">
              <b-icon icon="pencil" />
            </b-button>
          </template>
        </b-table>
      </b-col>
      <b-col cols="12" class="justify-content-end d-flex">
        <b-pagination v-model="paging.currentPage" :total-rows="table.totalRows" :per-page="paging.perPage">
        </b-pagination>
      </b-col>
    </b-row>
  </b-card>
  <b-modal title="Form Registrasi Anggota" id="modal-form" hide-footer size="xl" centered>
    <b-form @submit="doSave()">
      <b-row>
        <b-col cols="12" class="mb-3">
          <h4 class="mb-3">Step 1</h4>
          <hr>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Nama">
            <b-input v-model="form.data.nama" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Jenis Kelamin">
            <input class="form-check-input ml-2" type="radio" name="flexRadioDefault">
              <label class="form-check-label ml-7">
                Perempuan
              </label>
            <input class="form-check-input ml-7" type="radio" name="flexRadioDefault" checked>
              <label class="form-check-label ml-12">
                Laki-Laki
              </label>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Tempat / Tanggal Lahir">
            <b-row>
              <b-col cols="6">
                <b-input />
              </b-col>
              <b-col cols="6">
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" />
              </b-col>
            </b-row>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Nama Ibu Kandung">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="NIK">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Alamat">
            <b-select :options="opt.kota_kabupaten" class="mb-3" />
            <b-select :options="opt.kecamatan" class="mb-3" />
            <b-select :options="opt.desa" class="mb-3" />
            <b-input placeholder="Jl:.............................,No...........,Rt.....,Rw......"/>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="No.Telp / HP">
            <b-input placeholder="0858123456" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Pendidikan Terakhir">
            <b-select :options="opt.pendidikan_terakhir" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Pekerjaan">
            <b-select :options="opt.pekerjaan" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Keterangan Pekerjaan">
            <b-input />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12" class="mb-3">
          <h4 class="mb-3">Step 2</h4>
          <hr>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Status Pernikahan">
            <b-select :options="opt.status_pernikahan" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Nama Pasangan">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Tempat / Tanggal Lahir">
            <b-row>
              <b-col cols="6">
                <b-input />
              </b-col>
              <b-col cols="6">
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" />
              </b-col>
            </b-row>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="NIK">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Pendidikan Terakhir">
            <b-select :options="opt.pendidikan_terakhir" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Pekerjaan">
          <b-select :options="opt.pekerjaan" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Keterangan Pekerjaan">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="No.Telp / HP">
            <b-input placeholder="0858123456" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Jumlah Anak">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Keterangan">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Jml Tanggungan Lain">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group label="Keterangan">
            <b-input />
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12" class="mb-3">
          <h4 class="mb-3">Step 3</h4>
          <hr>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Status Rumah">
            <b-select :options="opt.status_rumah" />
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Ukuran Rumah">
            <b-select :options="opt.ukuran_rumah" />
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Dinding">
            <b-select :options="opt.dinding" />
          </b-form-group>
        </b-col>
        <b-col cols="3">
          <b-form-group label="Atap">
            <b-select :options="opt.atap" />
          </b-form-group>
        </b-col>
        <b-col cols="3">
          <b-form-group label="Lantai">
            <b-select :options="opt.lantai" />
          </b-form-group>
        </b-col>
        <b-col cols="3">
          <b-form-group label="Jamban">
            <b-select :options="opt.jamban" />
          </b-form-group>
        </b-col>
        <b-col cols="3">
          <b-form-group label="Sumber Air">
            <b-select :options="opt.sumber_air" />
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-container class="bv-example-row mb-3 p-0">
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
        <b-col cols="6">
          <b-container class="bv-example-row mb-3 p-0">
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
        <b-col cols="6">
          <b-container class="bv-example-row mb-3 p-0">
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
        <b-col cols="6">
          <b-container class="bv-example-row mb-3 p-0">
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
      </b-row>
      <b-row>
        <b-col cols="12" class="mb-3">
          <h4 class="mb-3">Step 4</h4>
          <hr>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Pendapatan Usaha">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Pendapatan Pasangan">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="4">
          <b-form-group label="Total Pendapatan">
            <b-input />
          </b-form-group>
        </b-col>
        <b-col cols="12">
          <b-container class="bv-example-row mb-3 p-0">
            <p>Pengeluaran Rumah Tangga / Bulan</p>
            <b-row>
              <b-col cols="3">
                <b-form-group label="Beras">
                  <b-input />
                </b-form-group>
              </b-col>
              <b-col cols="3">
                <b-form-group label="Biaya Pendidikan">
                  <b-input />
                </b-form-group>
              </b-col>
              <b-col cols="3">
                <b-form-group label="Belanja Dapur">
                  <b-input />
                </b-form-group>
              </b-col>
              <b-col cols="3">
                <b-form-group label="Hutang Pihak Lain">
                  <b-input />
                </b-form-group>
              </b-col>
              <b-col cols="3">
                <b-form-group label="Biaya Listrik">
                  <b-input />
                </b-form-group>
              </b-col>
              <b-col cols="3">
                <b-form-group label="Biaya Lainnya">
                  <b-input />
                </b-form-group>
              </b-col>
              <b-col cols="3">
                <b-form-group label="Biaya Telp">
                  <b-input />
                </b-form-group>
              </b-col>
              <b-col cols="3">
                <b-form-group label="Total Biaya">
                  <b-input />
                </b-form-group>
              </b-col>
            </b-row>
          </b-container>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
          <b-button variant="secondary" @click="$bvModal.hide('modal-form')" :disabled="form.loading">Cancel
          </b-button>
          <b-button variant="primary" type="submit" :disabled="form.loading" class="ml-3">
            {{form.loading ? 'Memproses...' : 'Simpan' }}
          </b-button>
        </b-col>
      </b-row>
    </b-form>
  </b-modal>
  <b-modal title="Delete" id="modal-delete" hide-footer size="sm" header-bg-variant="warning"
    body-bg-variant="warning" centered>
    <p class="text-center py-3">Anda yakin ingin menghapus data ini?</p>
    <div class="d-flex justify-content-end">
      <b-button variant="light" type="button" :disabled="remove.loading" @click="$bvModal.hide('modal-delete')">Tidak
      </b-button>
      <b-button variant="danger" class="ml-3" type="button" :disabled="remove.loading"
        @click="doDelete(remove.data,false)">
        {{remove.loading ? 'Memproses...' : 'Ya' }}
      </b-button>
    </div>
  </b-modal>
</div>
</template>
<script>
import { mapGetters } from 'vuex'
import easycoApi from '@/core/services/easyco.service'
export default {
  name: "RegistrasiAnggota",
  components: {

  },
  data() {
    return {
      form: {
        data: {
          id: null,
          kode_cabang: null,
          kode_rembug: null,
          nama_anggota: null,
          jenis_kelamin: null,
          ibu_kandung: null,
          tempat_lahir: null,
          tgl_lahir: null,
          alamat: null,
          desa: null,
          kecamatan: null,
          kabupaten: null,
          kodepos: null,
          no_ktp: null,
          no_npwp: null,
          no_telp: null,
          pendidikan: null,
          status_perkawinan: null,
          nama_pasangan: null,
          pekerjaan: null,
          ket_pekerjaan: null,
          pendapatan_perbulan: null,
          tgl_gabung: null,
          created_by: null,
          p_nama: null,
          p_tmplahir: null,
          p_tglahir: null,
          usia: null,
          p_noktp: null,
          p_nohp: null,
          p_pendidikan: null,
          p_pekerjaan: null,
          p_ketpekerjaan: null,
          p_pendapatan: null,
          jml_anak: null,
          jml_tanggungan: null,
          rumah_status: null,
          rumah_ukuran: null,
          rumah_atap: null,
          rumah_dinding: null,
          rumah_lantai: null,
          rumah_jamban: null,
          rumah_air: null,
          lahan_sawah: null,
          lahan_kebun: null,
          lahan_pekarangan: null,
          ternak_sapi: null,
          ternak_domba: null,
          ternak_unggas: null,
          elc_kulkas: null,
          elc_tv: null,
          elc_hp: null,
          kend_sepeda: null,
          kend_motor: null,
          ush_rumahtangga: null,
          ush_komoditi: null,
          ush_lokasi: null,
          ush_omset: null,
          by_beras: null,
          by_dapur: null,
          by_listrik: null,
          by_telpon: null,
          by_sekolah: null,
          by_lain: null
        },
        loading: false,
      },
      table: {
        fields: [
          {
            key: 'no',
            sortable: false,
            label: 'No',
            thClass: 'text-center w-5p',
            tdClass: 'text-center'
          },
          {
            key: 'nama_anggota',
            sortable: true,
            label: 'Nama Anggota',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'kode_rembug',
            sortable: true,
            label: 'Kode Rembug',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'kode_cabang',
            sortable: true,
            label: 'Kode Cabang',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'no_telp',
            sortable: true,
            label: 'No Telp',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'alamat',
            sortable: true,
            label: 'Alamat',
            thClass: 'text-center',
            tdClass: ''
          },
          {
            key: 'action',
            sortable: false,
            label: 'Action',
            thClass: 'text-center w-10p',
            tdClass: 'text-center'
          },
        ],
        items: [],
        loading: false,
      },
      paging: {
        page: 1,
        perPage: 10,
        sorDir: 'desc',
        sortBy: 'id',
        search: ''
      },
      remove: {
        data: {

        },
        loading: false
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
      },
      loading: false
    }
  },
  computed: {
    ...mapGetters(["user"]),
  },
  mounted() {
    this.doGet()
  },
  methods: {
    async doGet() {
      let payload = this.paging
      try {
        this.table.loading = true
        let req = await  easycoApi.anggotaRead(payload, this.user.token)
        let { data, status, msg } = req.data
        if(status){
          this.table.items = data
          this.notify('success','Success',msg)
        } else {
          this.notify('danger','Error',msg)
        }
        this.table.loading = false
      } catch (error) {
        this.table.loading = false
        console.log(error)
        this.notify('danger','Login Error',error)
      }
    },
    doSave() {
      let vm = this
      this.form.loading = true
      setTimeout(() => {
        vm.form.loading = false
      }, 5000)
    },
    notify(type, title, msg) {
      this.$bvToast.toast(msg, {
        title: title,
        autoHideDelay: 5000,
        variant: type,
        toaster: 'b-toaster-bottom-right',
        appendToast: true
      })
    }
  }
};
</script>
