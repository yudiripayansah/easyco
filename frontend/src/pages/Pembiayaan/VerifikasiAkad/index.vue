<template>
    <div>
      <b-card :title="$route.name">
          <b-row no-gutters>
            <b-col cols="12" class="mb-5">
              <b-row no-gutters>
                <b-col cols="6">
                  <div class="w-100 max-200 pr-5">
                    
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
                <template #cell(pokok)="item">
                  {{doFormatCurrency(item.item.pokok)}}
                </template>
                <template #cell(action)="item">
                  <b-button variant="success" size="xs" class="mx-1" @click="doShowEdit(item);">
                      Details
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
      <b-modal title="Form Pembiayaan Pengajuan" id="modal-form" hide-footer size="lg" centered>
        <b-form @submit.prevent="doSave()">
          <b-row>  
            <b-col cols="12">
              <b-form-group label="Rembug">
                <b-select disabled :options="opt.listRembug" class="mb-3" v-model="form.data.rembug" required/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Nama">
                <b-input disabled v-model="form.data.pengajuan"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="No Anggota">
                <b-input disabled v-model="form.data.noAnggota"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="No Pengajuan">
                <b-input disabled v-model="form.data.noPengajuan"/>
              </b-form-group>
            </b-col>
            <b-col cols="2">
              <b-form-group label="Pembiayaan Ke">
                <b-input disabled type="number" v-model="form.data.pembiayaanKe"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Jumlah Pengajuan">
                <b-input disabled v-model="form.data.jumlahPengajuan" @blur="form.data.jumlahPengajuan = focusOut($event, form.data.jumlahPengajuan)"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Peruntukan">
                <b-select disabled :options="opt.listPeruntukan" v-model="form.data.peruntukan"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Keterangan">
                <b-form-textarea
                  disabled
                  id="textarea"
                  v-model="form.data.keterangan"
                  placeholder="Keterangan..."
                  rows="3"
                  max-rows="6"
                  ></b-form-textarea>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row class="border-top py-5">
            <b-col cols="12">
              <b-form-group label="Akad / Produk">
                  <b-select disabled :options="opt.listProduk" v-model="form.data.produk"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Plafon">
                <b-input disabled v-model="form.data.plafon" @blur="form.data.plafon = focusOut($event, form.data.plafon)"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Margin">
                <b-input disabled v-model="form.data.margin" @blur="form.data.margin = focusOut($event, form.data.margin)"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Rencana Jangka Waktu">
                <b-row>
                  <b-col cols="2">
                    <b-input disabled type="number" v-model="form.data.rencanaJangkaWaktu" @blur="sumAngsuran()"/>
                  </b-col>
                  <b-col cols="10">
                      <b-select disabled :options="opt.rencanaPeriodeJangkaWaktu" v-model="form.data.rencanaPeriodeJangkaWaktu" require/>
                  </b-col>
                </b-row>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row class="border-top py-5">
            <b-col cols="6">
              <b-form-group label="Angsuran">
                <b-col cols="12">
                  <b-form-group label="Pokok">
                    <b-input disabled v-model="form.data.angsuran.pokok"/>
                  </b-form-group>
                </b-col>
                <b-col cols="12">
                  <b-form-group label="Margin">
                    <b-input disabled v-model="form.data.angsuran.margin"/>
                  </b-form-group>
                </b-col>
                <b-col cols="12">
                  <b-form-group label="Minggon">
                    <b-input disabled v-model="form.data.angsuran.minggon"/>
                  </b-form-group>
                </b-col>
                <b-col cols="12">
                  <b-form-group label="Total">
                    <b-input disabled v-model="form.data.angsuran.total"/>
                  </b-form-group>
                </b-col>
              </b-form-group>
            </b-col>
            <b-col cols="6">
              <b-form-group label="Setoran Saat Pencairan">
                <b-col cols="12">
                  <b-form-group label="Biaya Adm">
                    <b-input disabled v-model="form.data.setoranSaatPencarian.biayaAdm" @blur="form.data.setoranSaatPencarian.biayaAdm = focusOut($event, form.data.setoranSaatPencarian.biayaAdm);sumSetoranSaatPencairan()"/>
                  </b-form-group>
                  <b-form-group label="Asuransi">
                    <b-input disabled v-model="form.data.setoranSaatPencarian.asuransi" @blur="form.data.setoranSaatPencarian.asuransi = focusOut($event, form.data.setoranSaatPencarian.asuransi);sumSetoranSaatPencairan()"/>
                  </b-form-group>
                  <b-form-group label="Dana Kebajikan">
                    <b-input disabled v-model="form.data.setoranSaatPencarian.danaKebajikan" @blur="form.data.setoranSaatPencarian.danaKebajikan = focusOut($event, form.data.setoranSaatPencarian.danaKebajikan);sumSetoranSaatPencairan()"/>
                  </b-form-group>
                  <b-form-group label="Simpanan Wajib 4%">
                    <b-input disabled v-model="form.data.setoranSaatPencarian.simpananWajib" @blur="form.data.setoranSaatPencarian.simpananWajib = focusOut($event, form.data.setoranSaatPencarian.simpananWajib);sumSetoranSaatPencairan()"/>
                  </b-form-group>
                  <b-form-group label="Total">
                    <b-input disabled v-model="form.data.setoranSaatPencarian.total" @blur="form.data.setoranSaatPencarian.total = focusOut($event, form.data.setoranSaatPencarian.total)"/>
                  </b-form-group>
                </b-col>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row class="border-top py-5">
            <b-col cols="12">
              <b-form-group label="Tanggal Pengajuan">
                  <b-form-datepicker disabled :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" v-model="form.data.tanggalPengajuan"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Tanggal Akad">
                  <b-form-datepicker disabled :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" v-model="form.data.tanggalAkad"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Mulai Angsur">
                  <b-form-datepicker disabled :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" v-model="form.data.rencanaAngsur"/>
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Sumber Dana">
                  <b-select disabled :options="opt.sumberDana" v-model="form.data.sumberDana"/>
              </b-form-group>
            </b-col>
            <b-col cols="12" v-if="form.data.sumberDana == 1">
              <b-form-group label="Nama Kreditur">
                  <b-select disabled :options="opt.listKreditur" v-model="form.data.kreditur"/>
              </b-form-group>
            </b-col>
            <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
              <b-button variant="secondary" :disabled="form.loading" class="ml-5">
                <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
                Kembali
              </b-button>
              <b-button variant="primary" @click="doReject()" class="ml-5">
                <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
                Reject
              </b-button>
              <b-button variant="primary" @click="doApprove()" class="ml-5">
                <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
                Approve
              </b-button>
            </b-col>
          </b-row>
        </b-form>
      </b-modal>
    </div>
    </template>
    <script src="works/frontend/src/pages/Keanggotaan/wizard_regis_anggota.js"></script>
    <script>
      import { mapGetters } from 'vuex'
      import easycoApi from '@/core/services/easyco.service'
      import { validationMixin } from "vuelidate";
      import { required } from 'vuelidate/lib/validators';
      import defaultImageUpload from '../../../../public/media/default/image_upload_default.png'
      const base64Encode = data =>
          new Promise((resolve, reject) => {
              const reader = new FileReader();
              reader.readAsDataURL(data);
              reader.onload = () => resolve(reader.result);
              reader.onerror = error => reject(error);
          });
      export default {
        name: "Pengajuan_Pembiayaan",
        components: {  
        },
          watch: {
              "form.data.rembug"(val){
                  if(val != null){
                      this.doGetPengajuan(val.kode_rembug)
                  }
              }
          },
        computed: {
          ...mapGetters(["user"]),
        },
        data() {
          return {
            form: {
              data: {
                id:null,
                noPengajuan: '',
                noAnggota: '',
                petugas: {},
                nama: null,
                noKTP:'',
                rembug:{},
                pengajuan: {},
                pembiayaanKe: 0,
                jumlahPengajuan: 0,
                plafon: 0,
                margin: 0,
                peruntukan: {},
                produk: {},
                angsuran: {
                    pokok: 0,
                    margin: 0,
                    minggon: 0,
                    total: 0
                },
                setoranSaatPencarian: {
                  biayaAdm: 0,
                  asuransi: 0,
                  danaKebajikan: 0,
                  simpananWajib: 0,
                  total: 0
                },
                keterangan: "",
                rencanaJangkaWaktu: 0,
                rencanaPeriodeJangkaWaktu: {},
                tanggalAkad:'',
                rencanaAngsur: '',
                jenisPembiayaan: '',
                sumberPengambilan: '',
                tanggalPengajuan: '',
                tanggalDroping: '',
                sumberDana: null,
                kreditur: null,
                ttdAnggota: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
                ttdKetuaRembug: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
                ttdTPL: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
                ttdPasangan: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
                documentKTP: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
                documentKK: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
                documentPendukung: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null}
              },
              loading: true,
              modal:{
                state: null
              }
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
                  label: 'Nama',
                  thClass: 'text-center',
                  tdClass: ''
                },
                {
                  key: 'nama_rembug',
                  sortable: true,
                  label: 'Rembug',
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
                  label: 'Jumlah',
                  thClass: 'text-center',
                  tdClass: ''
                },
                {
                  key: 'tanggal_registrasi',
                  sortable: true,
                  label: 'Tanggal Komite',
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
            opt: {
              listRembug: [],
              listPengajuan: [],
              listKreditur: [],
              listProduk: [],
              listPeruntukan: [],
              sumberDana: [{
                text: "Sendiri",
                value: 0
              },{
                text: "Kreditur",
                value: 1
              },{
                text: "Campuran",
                value: 2
              }],
              peruntukan: [{
                  text: "Modal Kerja",
                  value: "modal_kerja"
              },{
                  text: "Modal Usaha",
                  value: "modal_usaha"
              },{
                  text: "Modal Pendidikan",
                  value: "modal_pendidikan"
              }],
              rencanaPeriodeJangkaWaktu: [{
                  text: "Harian",
                  value: "0"
              },{
                  text: "Mingguan",
                  value: "1"
              },{
                  text: "Bulanan",
                  value: "2"
              },{
                  text: "Tempo",
                  value: "3"  
              }],
              jenisPembiayaan: [{
                  text: "Kelompok",
                  value: "0"
              },{
                  text: "Individu",
                  value: "1"
              }],
              sumberPengambilan: [{
                text: "Sumber Usaha",
                value: "0"
              },{
                text: "Non Usaha",
                value: "1"
              }]
            },
            paging: {
              page: 1,
              perPage: 10,
              sorDir: 'desc',
              sortBy: 'id',
              search: ''
            },
          }
        },
        mixins: [validationMixin],
        async mounted() {
          let date = new Date();
          this.form.data.tanggalPengajuan = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`
          await this.doGetRembug()
          await this.doGetPeruntukan()
          await this.doGetProduk()
          await this.doGetKreditur()
          await this.doGetSimpananAnggota()
          await this.doGetListRegisAkad()
        },
        methods: {
          doFormatCurrency(curr){
            let _value = parseFloat(curr.replace(",", ".")).toLocaleString(
                undefined,
                {
                    minimumFractionDigits: 0,
                }
            );
            return _value
          },
          doFindAnggota(idAnggota){
            let findAnggota = this.opt.listAnggota.filter(anggota => anggota.value.no_anggota == idAnggota)[0]
            if(findAnggota != undefined){
              return findAnggota.value.nama_anggota
            }
          },
          doFindRembug(idAnggota){
            let findAnggota = this.opt.listAnggota.filter(anggota => anggota.value.no_anggota == idAnggota)[0]
            if(findAnggota != undefined){
              return findAnggota.value.nama_rembug
            }
          },
          sumAngsuran(){
            let plafon = parseInt(this.form.data.plafon.replaceAll(',', ''))
            let margin = parseInt(this.form.data.margin.replaceAll(',', ''))
            let jangkaWaktu = this.form.data.rencanaJangkaWaktu
            this.form.data.angsuran.pokok = this.doFormatCurrency(`${Math.ceil((plafon/jangkaWaktu))}`)
            this.form.data.angsuran.margin = this.doFormatCurrency(`${Math.ceil((margin/jangkaWaktu))}`)
            this.form.data.angsuran.total = this.doFormatCurrency(`${parseInt(this.form.data.angsuran.pokok.replaceAll(',', ''))+parseInt(this.form.data.angsuran.margin.replaceAll(',', ''))+parseInt(this.form.data.angsuran.minggon.replaceAll(',', ''))}`)
          },
          sumSetoranSaatPencairan(){
            let biayaAdm = this.form.data.setoranSaatPencarian.biayaAdm != 0 ? parseInt(this.form.data.setoranSaatPencarian.biayaAdm.replaceAll(',', '')) : 0
            let asuransi = this.form.data.setoranSaatPencarian.asuransi != 0 ? parseInt(this.form.data.setoranSaatPencarian.asuransi.replaceAll(',', '')) : 0
            let danaKebajikan = this.form.data.setoranSaatPencarian.danaKebajikan != 0 ? parseInt(this.form.data.setoranSaatPencarian.danaKebajikan.replaceAll(',', '')) : 0
            let simpananWajib = this.form.data.setoranSaatPencarian.simpananWajib != 0 ? parseInt(this.form.data.setoranSaatPencarian.simpananWajib.replaceAll(',', '')) : 0
            this.form.data.setoranSaatPencarian.total = this.doFormatCurrency(`${parseInt(biayaAdm)+parseInt(asuransi)+parseInt(danaKebajikan)+parseInt(simpananWajib)}`)
  
          },
          async doSave() {
            let payload = new FormData();
            let tglAkad = new Date(this.form.data.tanggalAkad)
            tglAkad.setDate(tglAkad.getDate()+this.form.data.rencanaJangkaWaktu*7)
            let jatuhTempo = `${tglAkad.getFullYear()}-${tglAkad.getMonth()+1}-${tglAkad.getDate()}`
            payload.append('kode_produk', this.form.data.produk.kode_produk)
            payload.append('kode_akad', 0)
            payload.append('kode_petugas', null)
            payload.append('no_pengajuan', this.form.data.pengajuan.no_pengajuan)
            payload.append('no_rekening', this.form.data.pengajuan.no_anggota+''+this.form.data.produk.kode_produk+''+this.form.data.pembiayaanKe)
            payload.append('pokok', parseInt(this.form.data.plafon.replaceAll(',', '')))
            payload.append('margin', parseInt(this.form.data.margin.replaceAll(',', '')))
            payload.append('periode_jangka_waktu', this.form.data.rencanaPeriodeJangkaWaktu)
            payload.append('jangka_waktu', this.form.data.rencanaJangkaWaktu)
            payload.append('angsuran_pokok', parseInt(this.form.data.angsuran.pokok.replaceAll(',', '')))
            payload.append('angsuran_margin', parseInt(this.form.data.angsuran.margin.replaceAll(',', '')))
            payload.append('angsuran_minggon', parseInt(this.form.data.angsuran.minggon.replaceAll(',', '')))
            payload.append('biaya_administrasi', parseInt(this.form.data.setoranSaatPencarian.biayaAdm.replaceAll(',', '')))
            payload.append('dana_kebajikan', parseInt(this.form.data.setoranSaatPencarian.danaKebajikan.replaceAll(',', '')))
            payload.append('tanggal_registrasi', this.form.data.tanggalPengajuan)
            payload.append('tanggal_akad', this.form.data.tanggalAkad)
            payload.append('tanggal_mulai_angsur', this.form.data.rencanaAngsur)
            payload.append('tanggal_jtempo', jatuhTempo)
            payload.append('saldo_pokok', parseInt(this.form.data.plafon.replaceAll(',', '')))
            payload.append('saldo_margin', parseInt(this.form.data.plafon.replaceAll(',', '')))
            payload.append('saldo_catab', 0)
            payload.append('saldo_minggon', 0)
            payload.append('jtempo_angsuran_next', this.form.data.rencanaAngsur)
            payload.append('sumber_dana', this.form.data.sumberDana)
            payload.append('peruntukan', this.form.data.peruntukan.kode_value)
            payload.append('norek_tabungan', null)
            payload.append('created_by', this.user.id)
            try {
              let req = await easycoApi.regisAkadCreate(payload, this.user.token)
              if(req.status == 200){
                await this.doGetListRegisAkad()
                this.$bvModal.hide('modal-form')
                this.doClearForm()
                this.notify('success','Success',req.statusText)
              }
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doShowEdit(item){
            await this.doGetDetailVerifikasiAkad(item)
            this.$bvModal.show('modal-form')
          },
          async doUpdate() {
            let payload = new FormData();
            payload.append('id', this.form.data.idPengajuan)
            payload.append('kode_petugas', this.form.data.petugas.kode_petugas)
            payload.append('tanggal_pengajuan', this.form.data.tanggalPengajuan)
            payload.append('jumlah_pengajuan', parseInt(this.form.data.jumlahPengajuan.replaceAll(',', '')))
            payload.append('pengajuan_ke', parseInt(this.form.data.pembiayaanKe))
            payload.append('peruntukan', this.form.data.peruntukan.kode_value)
            payload.append('keterangan_peruntukan', this.form.data.keterangan)
            payload.append('rencana_droping', this.form.data.tanggalDroping)
            payload.append('jangka_waktu', this.form.data.rencanaJangkaWaktu)
            payload.append('rencana_periode_jwaktu', this.form.data.rencanaPeriodeJangkaWaktu)
            payload.append('jenis_pembiayaan', this.form.data.jenisPembiayaan)
            payload.append('sumber_pengembalian',this.form.data.sumberPengambilan)
            try {
              let req = await easycoApi.pengajuanUpdate(payload, this.user.token)
              if(req.status == 200){
                await this.doGetPengajuan()
                this.$bvModal.hide('modal-form')
                this.doClearForm()
                this.notify('success','Success',req.statusText)
              }
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doGetKreditur() {
            let payload = this.paging
            try {
              let req = await easycoApi.pembiayaanGetKreditur(payload, this.user.token)
              this.opt.listKreditur = req.data.data.map(kreditur => ({text: `${kreditur.kode_display}`, value: kreditur}))
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doGetProduk() {
            let payload = this.paging
            try {
              let req = await easycoApi.pembiayaanGetProduk(payload, this.user.token)
              this.opt.listProduk = req.data.data.map(produk => ({text: `${produk.nama_produk}`, value: produk}))
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doGetPeruntukan() {
            let payload = this.paging
            try {
              let req = await easycoApi.PembiayaanGetPeruntukan(payload, this.user.token)
              this.opt.listPeruntukan = req.data.data.map(peruntukan => ({text: `${peruntukan.kode_display}`, value: peruntukan}))
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doGetRembug(){
            let payload = this.paging
            try {
              let req = await easycoApi.pembiayaanGetRembug(payload, this.user.token)
              this.opt.listRembug = req.data.data.map(rembug => ({text: `${rembug.nama_rembug}`, value: rembug}))
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doGetListRegisAkad(){
            let payload = this.paging
            try {
              let req = await easycoApi.regisAkadRead(payload, this.user.token)
              this.table.items = req.data.data
              this.table.totalRows = req.data.total
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doGetPengajuan(idRembug) {
            let payload = new FormData();
            payload.append('kode_rembug', idRembug)
            try {
              let req = await easycoApi.PembiayaanGetPengajuan(payload, this.user.token)
              this.opt.listPengajuan = req.data.data.map(pengajuan => ({text: `${pengajuan.nama_anggota} - ${pengajuan.no_pengajuan}`, value: pengajuan}))
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doGetSimpananAnggota(idRembug) {
            let payload = new FormData();
            payload.append('kode_rembug', idRembug)
            try {
              let req = await easycoApi.keanggotaanGetSimpananAnggota(payload, this.user.token)
              this.form.data.angsuran.minggon = this.doFormatCurrency(req.data.data.simwa)
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doGetDetailVerifikasiAkad(id){
            try {
              let req = await easycoApi.detailVerifikasiAkad(id.item.id, this.user.token)
              this.form.data.id = req.data.data.get.id
              this.form.data.rembug =  this.opt.listRembug.filter(x=>x.value.nama_rembug == req.data.data.get2[0].nama_rembug)[0].value
                await this.doGetPengajuan(this.opt.listRembug.filter(x=>x.value.nama_rembug == req.data.data.get2[0].nama_rembug)[0].value.kode_rembug);
                let getRegis = this.table.items.filter(x=>x.no_pengajuan == req.data.data.get.no_pengajuan)[0]
                this.form.data.pengajuan = `${getRegis.nama_anggota} - ${getRegis.no_pengajuan}`
                this.form.data.noAnggota = req.data.data.get2[0].no_anggota
                this.form.data.noPengajuan = getRegis.no_pengajuan
                this.form.data.jumlahPengajuan = this.doFormatCurrency(`${req.data.data.get.pokok.substring(0,req.data.data.get.pokok.length-3)}`) 
                this.form.data.peruntukan = this.opt.listPeruntukan.filter(x=>x.value.kode_value == req.data.data.get.peruntukan)[0].value
                this.form.data.produk = this.opt.listProduk.filter(x=>x.value.kode_produk == req.data.data.get.kode_produk)[0].value
                this.form.data.plafon = this.doFormatCurrency(`${req.data.data.get.pokok.substring(0,req.data.data.get.pokok.length-3)}`) 
                this.form.data.margin = this.doFormatCurrency(`${req.data.data.get.margin.substring(0,req.data.data.get.margin.length-3)}`) 
                this.form.data.rencanaJangkaWaktu = req.data.data.get.jangka_waktu
                this.form.data.rencanaPeriodeJangkaWaktu = req.data.data.get.periode_jangka_waktu
                this.form.data.angsuran.pokok = this.doFormatCurrency(`${req.data.data.get.angsuran_pokok.substring(0,req.data.data.get.angsuran_pokok.length-3)}`) 
                this.form.data.angsuran.margin = this.doFormatCurrency(`${req.data.data.get.angsuran_margin.substring(0,req.data.data.get.angsuran_margin.length-3)}`) 
                this.form.data.angsuran.minggon = this.doFormatCurrency(`${req.data.data.get.angsuran_minggon.substring(0,req.data.data.get.angsuran_minggon.length-3)}`) 
                this.sumAngsuran()
                this.form.data.setoranSaatPencarian.biayaAdm = this.doFormatCurrency(`${req.data.data.get.biaya_administrasi.substring(0,req.data.data.get.biaya_administrasi.length-3)}`) 
                this.form.data.setoranSaatPencarian.asuransi= this.doFormatCurrency(`${req.data.data.get.biaya_asuransi_jiwa.substring(0,req.data.data.get.biaya_asuransi_jiwa.length-3)}`) 
                this.form.data.setoranSaatPencarian.danaKebajikan = this.doFormatCurrency(`${req.data.data.get.dana_kebajikan.substring(0,req.data.data.get.dana_kebajikan.length-3)}`) 
                this.sumSetoranSaatPencairan()
                this.form.data.tanggalAkad = req.data.data.get.tanggal_akad
                this.form.data.rencanaAngsur = req.data.data.get.tanggal_mulai_angsur
                this.form.data.sumberDana = req.data.data.get.sumber_dana
                this.form.data.kreditur = this.opt.listKreditur.filter(x=>x.value.kode_value == req.data.data.get.kode_kreditur)[0].value
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doApprove(){
            try {
              let req = await easycoApi.verifikasiAkadApprove(this.form.data.id, this.user.token)
              if(req.data.status){
                this.notify('success','Success',req.data.msg)
                await this.doGetListRegisAkad();
                this.$bvModal.hide('modal-form')
              }
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          async doReject(){
            try {
              let req = await easycoApi.verifikasiAkadReject(this.form.data.id, this.user.token)
              if(req.data.status){
                this.notify('success','Success',req.data.msg)
                await this.doGetListRegisAkad();
                this.$bvModal.hide('modal-form')
              }
            } catch (error) {
              console.log(error)
              this.notify('danger','Login Error',error)
            }
          },
          doClearForm() {
          let date = new Date();
          this.form.data.idPengajuan = null
          this.form.data.noAnggota =  null
          this.form.data.petugas =  null
          this.form.data.nama =  null
          this.form.data.noKTP =  null
          this.form.data.rembug =  null
          this.form.data.pembiayaanKe =  null
          this.form.data.jumlahPengajuan =  null
          this.form.data.peruntukan =  null
          this.form.data.keterangan =  null
          this.form.data.rencanaJangkaWaktu =  null
          this.form.data.rencanaPeriodeJangkaWaktu =  null
          this.form.data.jenisPembiayaan =  null
          this.form.data.sumberPengambilan =  null
          this.form.data.tanggalPengajuan =  `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`
          this.form.data.tanggalDroping =  null
          },
          notify(type, title, msg) {
            this.$bvToast.toast(msg, {
              title: title,
              autoHideDelay: 5000,
              variant: type,
              toaster: 'b-toaster-bottom-right',
              appendToast: true
            })
          },
          focusOut: function (event, value, key = false) {
              if (["Arrow", "Backspace", "Shift"].includes(event.key)) {
                  this.preventNextIteration = true;
                  return;
              }
              if (this.preventNextIteration) {
                  this.preventNextIteration = false;
                  return;
              }
  
            let _value = parseFloat(value.replace(",", ".")).toLocaleString(
                undefined,
                {
                    minimumFractionDigits: 0,
                }
            );
            if(key){
              this.form.data[key] = _value
            }else{
              return _value
            }
          },
          chooseTtdAnggota(){
              document.getElementById('fileTTDAnggota').click()
          },
          chooseTtdKetuaRembug(){
              document.getElementById('fileTTDKetuaRembug').click()
          },
          chooseTtdTPL(){
              document.getElementById('fileTTDTPL').click()
          },
          chooseTtdPasangan(){
            document.getElementById('fileTTDPasangan').click()
          },
          chooseDocKTP(){
            document.getElementById('fileDocKTP').click()
          },
          chooseDocKK(){
            document.getElementById('fileDocKK').click()
          },
          chooseDocPendukung(){
            document.getElementById('fileDocPendukung').click()
          }
        }
      };
      </script>
      