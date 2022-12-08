<template>
  <div>
    <h1 class="mb-5">{{$route.name}}</h1>
    <b-card>
      <b-row no-gutters>
        <b-col cols="12" class="d-flex justify-content-end mb-5 pb-5 border-bottom">
        </b-col>
        <b-col cols="12" class="mb-5">
          <b-row no-gutters>
            <b-col cols="6">
              <div class="w-100 max-200 pr-5">
                <b-input-group size="sm" prepend="Per Halaman">
                  <b-form-select v-model="paging.perPage" :options="opt.perPage" @change="doGet()"/>
                </b-input-group>
              </div>
            </b-col>
            <b-col cols="6" class="d-flex justify-content-end">
              <div class="w-100 max-300">
                <b-input-group size="sm">
                  <b-form-input v-model="paging.search"/>
                  <b-input-group-append>
                    <b-button size="sm" text="Button" variant="primary" @click="doGet()">
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
          <b-table 
            responsive bordered outlined small striped hover 
            :fields="table.fields" 
            :items="table.items"
            :sort-by.sync="paging.sortBy"
            :sort-desc.sync="paging.sortDesc"
            show-empty 
            @filtered="onTableUpdate"
            :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
            <template #cell(no)="item">
              {{item.index + 1}}
            </template>
            <template #cell(action)="item">
              <!-- <b-button variant="danger" size="xs" class="mx-1" @click="doDelete(item,true)">
                <b-icon icon="trash" />
              </b-button> -->
              <!-- <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item,false)">
                <b-icon icon="pencil" />
              </b-button> -->
              <b-button variant="info" size="xs" class="mx-1" @click="doUpdate(item,true)">
                <b-icon icon="check" />
              </b-button>
            </template>
          </b-table>
        </b-col>
        <b-col cols="12" class="justify-content-end d-flex">
          <b-pagination v-model="paging.page" :total-rows="table.totalRows" :per-page="paging.perPage">
          </b-pagination>
        </b-col>
      </b-row>
    </b-card>
    <b-modal title="Form Registrasi Calon Anggota" id="modal-form" hide-footer size="xl" centered>
      <b-form @submit="doSave()">
        <b-row>
          <b-col cols="12" sm="4">
            <b-form-group label="Cabang">
              <b-select v-model="form.data.kode_cabang" :options="opt.cabang" @change="doGetRembug()"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="4">
            <b-form-group label="Rembug">
              <b-select v-model="form.data.kode_rembug" :options="opt.rembug"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="4">
            <b-form-group label="Nama">
              <b-input v-model="form.data.nama_anggota" />
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="4">
            <b-form-group label="No Anggota">
              <b-input v-model="form.data.nama_anggota" />
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="4">
            <b-form-group label="No Pengajuan">
              <b-input v-model="form.data.nama_anggota" />
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="4">
            <b-form-group label="Pembiayaan Ke">
              <b-input v-model="form.data.nama_anggota" />
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="4">
            <b-form-group label="Jumlah Pengajuan">
              <b-input v-model="form.data.nama_anggota" />
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="4">
            <b-form-group label="Peruntukan">
              <b-input v-model="form.data.peruntukan" />
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="4">
            <b-form-group label="Keterangan">
              <b-textarea v-model="form.data.keterangan" rows="5"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <hr>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Akd/ Produk">
              <b-input v-model="form.data.kode_produk"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Plafon">
              <b-input v-model="form.data.pokok"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Margin">
              <b-input v-model="form.data.margin"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Jangka Waktu">
              <b-row>
                <b-col cols="4">
                  <b-input v-model="form.data.jangka_waktu"/>
                </b-col>
                <b-col>
                  <b-select v-model="form.data.periode_jangka_waktu" :options="opt.rembug"/>
                </b-col>
              </b-row>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <hr>
          </b-col>
          <b-col cols="12" sm="6">
            <h4 class="mb-5">Angsuran</h4>
            <b-form-group label="Pokok">
              <b-input v-model="form.data.angsuran_pokok"/>
            </b-form-group>
            <b-form-group label="Margin">
              <b-input v-model="form.data.angsuran_margin"/>
            </b-form-group>
            <b-form-group label="Minggon">
              <b-input v-model="form.data.angsuran_minggon"/>
            </b-form-group>
            <b-form-group label="Total">
              <b-input :value="form.data.angsuran_pokok"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <h4 class="mb-5">Setoran Saat Pencairan</h4>
            <b-form-group label="Biaya Adm">
              <b-input v-model="form.data.biaya_administrasi"/>
            </b-form-group>
            <b-form-group label="Asuransi">
              <b-input v-model="form.data.biaya_asuransi_jiwa"/>
            </b-form-group>
            <b-form-group label="Dana Kebajikan">
              <b-input v-model="form.data.dana_kebajikan"/>
            </b-form-group>
            <b-form-group label="Simpanan Wajib">
              <b-input v-model="form.data.tabungan_persen"/>
            </b-form-group>
            <b-form-group label="Total">
              <b-input v-model="form.data.biaya_administrasi"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <hr>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Tanggal Pengajuan">
              <b-input v-model="form.data.tanggal_registrasi"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Tanggal Komite">
              <b-input v-model="form.data.tanggal_jtempo"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Tanggal Akad">
              <b-input v-model="form.data.tanggal_akad"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Mulai Angsur">
              <b-input v-model="form.data.tanggal_mulai_angsur"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Sumber Dana">
              <b-input v-model="form.data.sumber_dana"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" sm="6">
            <b-form-group label="Nama Kreditur">
              <b-input v-model="form.data.kode_kreditur"/>
            </b-form-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col cols="12" sm="12" class="d-flex justify-content-end border-top pt-5">
            <b-button 
              variant="secondary" 
              @click="$bvModal.hide('modal-form')" :disabled="form.loading">Cancel}}
            </b-button>
            <b-button 
              variant="primary" 
              type="submit"
              :disabled="form.loading" 
              class="ml-3" >
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
    name: "RegistrasiAkad",
    components: {
  
    },
    data() {
      return {
        form: {
          data: {
            id: null,
            nama_cabang: null,
            nama_rembug: null,
            nama_anggota: null,
            no_anggota: null,
            no_pengajuan: null,
            pembiayaan_ke: 0,
            jumlah_pengajuan: 0,
            keterangan: null,
            kode_produk:null,
            kode_akad:null,
            kode_petugas:null,
            no_pengajuan:null,
            no_rekening:null,
            pokok:0,
            margin:0,
            periode_jangka_waktu:null,
            jangka_waktu:0,
            angsuran_pokok:0,
            angsuran_margin:0,
            angsuran_minggon:0,
            biaya_administrasi:0,
            biaya_asuransi_jiwa:0,
            tabungan_persen:0,
            dana_kebajikan:0,
            tanggal_registrasi:null,
            tanggal_akad:null,
            tanggal_mulai_angsur:null,
            tanggal_jtempo:null,
            saldo_pokok:0,
            saldo_margin:0,
            saldo_catab:0,
            saldo_minggon:0,
            jtempo_angsuran_next:null,
            sumber_dana:null,
            kode_kreditur:null,
            peruntukan:null,
            norek_tabungan:null,
            created_by:null,
          },
          loading: false
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
              key: 'no_anggota',
              sortable: true,
              label: 'No Anggota',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama_anggota',
              sortable: true,
              label: 'Nama Anggota',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama_rembug',
              sortable: true,
              label: 'Majelis',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama_cabang',
              sortable: true,
              label: 'Cabang',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'no_pengajuan',
              sortable: true,
              label: 'No Pengajuan',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'pokok',
              sortable: true,
              label: 'Pokok',
              thClass: 'text-center',
              tdClass: 'text-right'
            },
            {
              key: 'margin',
              sortable: true,
              label: 'Margin',
              thClass: 'text-center',
              tdClass: 'text-right'
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
          totalRows: 0
        },
        paging: {
          page: 1,
          perPage: 10,
          sortDesc: true,
          sortBy: 'id',
          search: '',
          status: 0,
          cabang: '~',
          jenis_pembiayaan: '~',
          petugas: '~',
          rembug: '~',
          produk: '~',
          from: null,
          to: null
        },
        remove: {
          data: Object,
          loading: false
        },
        opt: {
          perPage: [10,20,50,100,200]
        },
        loading: false
      }
    },
    computed: {
      ...mapGetters(["user"]),
    },
    watch: {
      paging: {
        handler(val){
          this.doGet()
        },
        deep: true
      }
    },
    mounted() {
      this.doGet()
      this.doGetCabang()
    },
    methods: {
      async doGetCabang() {
        let payload = {
          perPage: '~',
          page: 1,
          sortBy: 'nama_cabang',
          sortDir: 'ASC',
          search: ''
        }
        try {
          let req = await  easycoApi.cabangRead(payload, this.user.token)
          let { data, status, msg } = req.data
          if(status){
            this.opt.cabang = []
            data.map((item) => {
              this.opt.cabang.push({
                value: item.kode_cabang,
                text: item.nama_cabang
              })
            })
          }
        } catch (error) {
          console.error(error)
        }
      },
      async doGetRembug() {
        let payload = {
          kode_cabang: this.form.data.kode_cabang
        }
        try {
          let req = await  easycoApi.anggotaRembug(payload, this.user.token)
          let { data, status, msg } = req.data
          if(status){
            this.opt.rembug = []
            data.map((item) => {
              this.opt.rembug.push({
                value: item.kode_rembug,
                text: item.nama_rembug
              })
            })
          }
        } catch (error) {
          console.error(error)
        }
      },
      async doGet() {
        let payload = this.paging
        payload.sortDir = payload.sortDesc ? 'DESC' : 'ASC'
        this.table.loading = true
        try {
          let req = await  easycoApi.regisAkadRead(payload, this.user.token)
          let { data, status, msg, total } = req.data
          if(status){
            this.table.items = data
            this.table.totalRows = total
          } else {
            this.notify('danger','Error',msg)
          }
          this.table.loading = false
        } catch (error) {
          this.table.loading = false
          console.error(error)
          this.notify('danger','Login Error',error)
        }
      },
      async doSave() {
        this.form.loading = true
        try {
          let payload = this.form.data
          let tgl_lahir = new Date(this.form.data.tgl_lahir)
          payload.usia = Number(this.calculateAge(tgl_lahir))
          payload.ktp = Number(payload.ktp)
          payload.created_by = this.user.id
          payload.status = 0
          let req = false
          if(payload.id){
            req = await easycoApi.anggotaUpdate(payload, this.user.token) 
          } else {
            req = await easycoApi.anggotaCreate(payload, this.user.token) 
          }
          let {data, status, msg} = req.data
          if(status){
            this.doGet()
            this.$bvModal.hide('modal-form')
            this.doClearForm()
            this.notify('success','Success',msg)
          } else {
            this.notify('danger','Error',msg)
          }
          this.form.loading = false
        } catch (error) {
          this.form.loading = false
          console.error(error)
          this.notify('danger','Login Error',error)         
        }
      },
      async doUpdate(data, setRembug) {
        this.form.setRembug = setRembug
        let id = data.item.id
        try {
          let req = await easycoApi.regisAkadReadDetail(id,this.user.token)
          let {data, status, msg} = req.data
          if(status){
            this.form.data = {...data.anggotauk,...data.anggota}
            this.doGetRembug()
            this.$bvModal.show('modal-form')
          } else {
            this.notify('danger','Error',msg)
          }
        } catch (error) {
          console.error(error)
        }
      },
      async doDelete(data, dialog) {
        if(dialog){
          console.log('dialog:',data)
          this.$bvModal.show('modal-delete')
          this.remove.data = data.item
        } else {
          console.log('on delete:',data)
          try {
            this.remove.loading = true
            let req = await easycoApi.anggotaDelete(`?id=${this.remove.data.id}`,this.user.token)
            let {data, status, msg} = req.data
            if(status){
              this.$bvModal.hide('modal-delete')
              this.doGet()
              this.remove.data = Object
              this.notify('success','Success',msg)
            } else {
              this.notify('danger','Error',msg)
            }
            this.remove.loading = false
          } catch (error) {
            console.log(error)
            this.notify('danger','Error',error)
          }
        }
      },  
      onTableUpdate(v){
        console.log(v)
      },
      calculateAge(birthday) { // birthday is a date
        var ageDifMs = Date.now() - birthday;
        var ageDate = new Date(ageDifMs); // miliseconds from epoch
        return Math.abs(ageDate.getUTCFullYear() - 1970);
      },
      moveStep(dir) {
        if(dir == 'Next'){
          this.form.activeStep++
          if(this.form.activeStep > this.form.steps){
            this.doSave()
          }
        } else {
          this.form.activeStep--
        }
      },
      doClearForm(){
        this.form.data = {
            id: null,
            kode_cabang: null,
            kode_rembug: null,
            nama_anggota: null,
            jenis_kelamin: 'W',
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
            pendapatan_perbulan: 0,
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
            p_pendapatan: 0,
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
            ush_rumahtangga: 0,
            ush_komoditi: 0,
            ush_lokasi: 0,
            ush_omset: 0,
            by_beras: 0,
            by_dapur: 0,
            by_listrik: 0,
            by_telpon: 0,
            by_sekolah: 0,
            by_lain: 0
          }
          this.form.activeStep = 1
          this.form.setRembug = false
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
  