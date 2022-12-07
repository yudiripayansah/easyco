<template>
  <div>
    <b-card :title="$route.name">
        <b-row no-gutters>
          <b-col cols="12" class="d-flex justify-content-end mb-5 pb-5 border-bottom">
            <b-button variant="success" @click="doOpenModalCreate()" v-b-tooltip.hover
              title="Tambah Data Baru">
              <b-icon icon="plus" />
              Tambah Baru
            </b-button>
          </b-col>
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
                <b-button variant="success" size="xs" class="mx-1" @click="doShowEdit(item)" v-b-tooltip.hover title="Update Status">
                    Update Status
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
            <b-form-group label="Majelis">
              <b-select :options="opt.listRembug" class="mb-3" v-model="form.data.rembug" required/>
            </b-form-group>
          </b-col>
          <b-col cols="12" v-if="Object.keys(form.data.detail).length == 0">
            <b-form-group label="Nama">
              <b-select :options="opt.listPengajuan" class="mb-3" v-model="form.data.pengajuan" required/>
            </b-form-group>
          </b-col>
          <b-col cols="12" v-else>
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
                <b-select :options="opt.listProduk" v-model="form.data.produk"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Plafon">
              <b-input v-model="form.data.plafon" @blur="form.data.plafon = focusOut($event, form.data.plafon)"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Margin">
              <b-input v-model="form.data.margin" @blur="form.data.margin = focusOut($event, form.data.margin)"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Rencana Jangka Waktu">
              <b-row>
                <b-col cols="2">
                  <b-input type="number" v-model="form.data.rencanaJangkaWaktu" @blur="sumAngsuran();sumSetoranSaatPencairan()"/>
                </b-col>
                <b-col cols="10">
                    <b-select :options="opt.rencanaPeriodeJangkaWaktu" v-model="form.data.rencanaPeriodeJangkaWaktu" require/>
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
                  <b-input disabled v-model="form.data.angsuran.pokok" @blur="form.data.angsuran.pokok = focusOut($event, form.data.angsuran.pokok)"/>
                </b-form-group>
              </b-col>
              <b-col cols="12">
                <b-form-group label="Margin">
                  <b-input disabled v-model="form.data.angsuran.margin" @blur="form.data.angsuran.margin = focusOut($event, form.data.angsuran.margin)"/>
                </b-form-group>
              </b-col>
              <b-col cols="12">
                <b-form-group label="Minggon">
                  <b-input v-model="form.data.angsuran.minggon" @blur="form.data.angsuran.minggon = focusOut($event, form.data.angsuran.minggon)"/>
                </b-form-group>
              </b-col>
              <b-col cols="12">
                <b-form-group label="Total">
                  <b-input disabled v-model="form.data.angsuran.total" @blur="form.data.angsuran.total = focusOut($event, form.data.angsuran.total)"/>
                </b-form-group>
              </b-col>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Setoran Saat Pencairan">
              <b-col cols="12">
                <b-form-group label="Biaya Adm">
                  <b-input v-model="form.data.setoranSaatPencarian.biayaAdm" @blur="form.data.setoranSaatPencarian.biayaAdm = focusOut($event, form.data.setoranSaatPencarian.biayaAdm);sumSetoranSaatPencairan()"/>
                </b-form-group>
                <b-form-group label="Asuransi">
                  <b-input v-model="form.data.setoranSaatPencarian.asuransi" @blur="form.data.setoranSaatPencarian.asuransi = focusOut($event, form.data.setoranSaatPencarian.asuransi);sumSetoranSaatPencairan()"/>
                </b-form-group>
                <b-form-group label="Dana Kebajikan">
                  <b-input v-model="form.data.setoranSaatPencarian.danaKebajikan" @blur="form.data.setoranSaatPencarian.danaKebajikan = focusOut($event, form.data.setoranSaatPencarian.danaKebajikan);sumSetoranSaatPencairan()"/>
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
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" v-model="form.data.tanggalAkad"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Mulai Angsur">
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" v-model="form.data.rencanaAngsur"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Sumber Dana">
                <b-select :options="opt.sumberDana" v-model="form.data.sumberDana"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" v-if="form.data.sumberDana == 1">
            <b-form-group label="Nama Kreditur">
                <b-select :options="opt.listKreditur" v-model="form.data.kreditur"/>
            </b-form-group>
          </b-col>
          <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
            <b-button variant="secondary" :disabled="form.loading" class="ml-5">
              <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
              Kembali
            </b-button>
            <b-button v-if="form.data.id == null" variant="primary" :disabled="form.loading" type="submit" class="ml-5">
              <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
              Submit
            </b-button>
            <b-button v-if="form.data.id != null" variant="primary" :disabled="form.loading" @click="doUpdate()" class="ml-5">
              <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
              Simpan
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
    export default {
      name: "Pengajuan_Pembiayaan",
      components: {  
      },
        watch: {
            "form.data.rembug"(val){
              if(val != null){
                this.doGetPengajuan(val.kode_rembug)
              }
            },
            "form.data.pengajuan"(val){
              if(val != null && typeof val == 'object' && Object.keys(val).length > 0){
                this.form.data.noPengajuan = val.no_pengajuan
                this.form.data.jumlahPengajuan = this.doFormatCurrency(val.jumlah_pengajuan)
                this.form.data.plafon = this.doFormatCurrency(val.jumlah_pengajuan)
                this.form.data.margin = this.doFormatCurrency(`${Math.ceil(((val.jumlah_pengajuan*30)/100))}`)
                this.form.data.pembiayaanKe = val.pembiayaan_ke
                this.form.data.noAnggota = val.no_anggota
                this.form.data.peruntukan = this.opt.listPeruntukan.filter(x=>x.value.kode_value == val.peruntukan)[0].value
                this.form.data.keterangan = val.keterangan_peruntukan
                let tglPegajuan = val.tanggal_pengajuan.split('/')
                tglPegajuan = new Date(`${tglPegajuan[2]}-${tglPegajuan[1]}-${tglPegajuan[0]}`)
                this.form.data.tanggalPengajuan = `${tglPegajuan.getFullYear()}-${tglPegajuan.getMonth()+1}-${tglPegajuan.getDate()}`
                tglPegajuan.setDate(tglPegajuan.getDate()+7)
                this.form.data.tanggalAkad = `${tglPegajuan.getFullYear()}-${tglPegajuan.getMonth()+1}-${tglPegajuan.getDate()}`
                tglPegajuan.setDate(tglPegajuan.getDate()+7)
                this.form.data.rencanaAngsur = `${tglPegajuan.getFullYear()}-${tglPegajuan.getMonth()+1}-${tglPegajuan.getDate()}`
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
              id: null,
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
                biayaAdm: 10000,
                asuransi: 0,
                danaKebajikan: 0,
                simpananWajib: 0,
                total: 0
              },
              keterangan: "",
              rencanaJangkaWaktu: 0,
              rencanaPeriodeJangkaWaktu: {},
              detail: {},
              tanggalAkad:'',
              rencanaAngsur: '',
              jenisPembiayaan: '',
              sumberPengambilan: '',
              tanggalPengajuan: '',
              tanggalDroping: '',
              sumberDana: null,
              kreditur: null
            },
            modal: {
              state: null
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
                label: 'Nama',
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
        doOpenModalCreate(){
          if(this.form.modal.state != 1){
            this.doClearForm()
            this.form.modal.state = 1
          }
          this.$bvModal.show('modal-form');
        },
        doCloseModal(){
          this.$bvModal.hide('modal-form')
          this.doClearForm()
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
          this.form.data.setoranSaatPencarian.biayaAdm = this.doFormatCurrency(`${this.form.data.setoranSaatPencarian.biayaAdm}`)
          this.form.data.setoranSaatPencarian.asuransi = this.doFormatCurrency(`${(parseInt(this.form.data.plafon.replaceAll(',', ''))*0.5)/100}`)
          this.form.data.setoranSaatPencarian.danaKebajikan = this.doFormatCurrency(`${(parseInt(this.form.data.plafon.replaceAll(',', ''))*1)/100}`)
          this.form.data.setoranSaatPencarian.simpananWajib = this.doFormatCurrency(`${(parseInt(this.form.data.plafon.replaceAll(',', ''))*4)/100}`)
        },
        sumSetoranSaatPencairan(){
          let biayaAdm = this.form.data.setoranSaatPencarian.biayaAdm != 0 ? parseInt(this.form.data.setoranSaatPencarian.biayaAdm.replaceAll(',', '')) : 0
          let asuransi = this.form.data.setoranSaatPencarian.asuransi != 0 ? parseInt(this.form.data.setoranSaatPencarian.asuransi.replaceAll(',', '')) : 0
          let danaKebajikan = this.form.data.setoranSaatPencarian.danaKebajikan != 0 ? parseInt(this.form.data.setoranSaatPencarian.danaKebajikan.replaceAll(',', '')) : 0
          let simpananWajib = this.form.data.setoranSaatPencarian.simpananWajib != 0 ? parseInt(this.form.data.setoranSaatPencarian.simpananWajib.replaceAll(',', '')) : 0
          this.form.data.setoranSaatPencarian.total = this.doFormatCurrency(`${parseInt(biayaAdm)+parseInt(asuransi)+parseInt(danaKebajikan)+parseInt(simpananWajib)}`)

        },
        async doSave() {
          this.form.loading = true
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
          payload.append('biaya_asuransi_jiwa', parseInt(this.form.data.setoranSaatPencarian.asuransi.replaceAll(',', '')))
          payload.append('kode_kreditur', this.form.data.kreditur.kode_value)
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
            // let req = await easycoApi.regisAkadCreate(payload, this.user.token)
            // if(req.status == 200){
            //   await this.doGetListRegisAkad()
            //   this.$bvModal.hide('modal-form')
            //   this.doClearForm()
            //   this.form.loading = false
            //   this.notify('success','Success',req.statusText)
            // }
          } catch (error) {
            console.log(error)
            this.form.loading = false
            this.notify('danger','Login Error',error)
          }
        },
        async doShowEdit(item){
          let itemSelected = item.item
          if(this.form.modal.state != 2 && this.form.data.id != itemSelected.id){
            this.doClearForm()
            this.form.modal.state = 2
          }
          this.form.data.detail = itemSelected
          this.form.data.id = itemSelected.id          
          let detailRegisAkad = await this.doGetDetail(itemSelected.id)
          this.form.data.rembug = this.opt.listRembug.filter(x=>x.text == detailRegisAkad.get2[0].nama_rembug)[0].value
          this.form.data.pengajuan = 'NEED RECORD'
          this.form.data.noAnggota = detailRegisAkad.get2[0].no_anggota
          this.form.data.noPengajuan = detailRegisAkad.get.no_pengajuan
          this.form.data.pembiayaanKe = '9999'
          this.form.data.jumlahPengajuan = this.doFormatCurrency(detailRegisAkad.get.pokok)
          this.form.data.peruntukan = this.opt.listPeruntukan.filter(x=>x.value.kode_value == detailRegisAkad.get.peruntukan)[0].value
          this.form.data.keterangan = 'NEED RECORD'
          this.form.data.produk = this.opt.listProduk.filter(x=>x.value.kode_produk == detailRegisAkad.get.kode_produk)[0].value
          this.form.data.plafon = this.doFormatCurrency(detailRegisAkad.get.pokok)
          this.form.data.margin = this.doFormatCurrency(detailRegisAkad.get.margin)
          this.form.data.rencanaJangkaWaktu = detailRegisAkad.get.jangka_waktu
          this.form.data.rencanaPeriodeJangkaWaktu = detailRegisAkad.get.periode_jangka_waktu
          this.form.data.angsuran.pokok = this.doFormatCurrency(detailRegisAkad.get.angsuran_pokok)
          this.form.data.angsuran.margin = this.doFormatCurrency(detailRegisAkad.get.angsuran_margin)
          this.form.data.angsuran.minggon = this.doFormatCurrency(detailRegisAkad.get.angsuran_minggon)
          this.form.data.angsuran.total = this.doFormatCurrency(`${parseInt(detailRegisAkad.get.angsuran_pokok.replaceAll(',', ''))+parseInt(detailRegisAkad.get.angsuran_margin.replaceAll(',', ''))+parseInt(detailRegisAkad.get.angsuran_minggon.replaceAll(',', ''))}`)
          this.form.data.setoranSaatPencarian.biayaAdm = this.doFormatCurrency(detailRegisAkad.get.biaya_administrasi)
          this.form.data.setoranSaatPencarian.asuransi = this.doFormatCurrency(detailRegisAkad.get.biaya_asuransi_jiwa)
          this.form.data.setoranSaatPencarian.danaKebajikan = this.doFormatCurrency(detailRegisAkad.get.dana_kebajikan)
          this.form.data.setoranSaatPencarian.simpananWajib = this.doFormatCurrency(`${(parseInt(detailRegisAkad.get.pokok.replaceAll(',', ''))*4)/100}`)
          this.sumSetoranSaatPencairan()
          this.form.data.tanggalAkad = detailRegisAkad.get.tanggal_akad
          this.form.data.rencanaAngsur = detailRegisAkad.get.tanggal_mulai_angsur
          this.form.data.sumberDana = detailRegisAkad.get.sumber_dana
          this.form.data.kreditur = this.opt.listKreditur.filter(x=>x.value.kode_value == detailRegisAkad.get.kode_kreditur)[0].value
          this.$bvModal.show('modal-form')
        },
        async doUpdate() {
          this.form.loading = true
          let payload = new FormData();
          let tglAkad = new Date(this.form.data.tanggalAkad)
          tglAkad.setDate(tglAkad.getDate()+this.form.data.rencanaJangkaWaktu*7)
          let jatuhTempo = `${tglAkad.getFullYear()}-${tglAkad.getMonth()+1}-${tglAkad.getDate()}`
          payload.append('id', this.form.data.id)
          payload.append('kode_produk', this.form.data.produk.kode_produk)
          payload.append('kode_akad', 0)
          payload.append('no_pengajuan', this.form.data.noPengajuan)
          payload.append('pokok', parseInt(this.form.data.plafon.replaceAll(',', '')))
          payload.append('margin', parseInt(this.form.data.margin.replaceAll(',', '')))
          payload.append('periode_jangka_waktu', this.form.data.rencanaPeriodeJangkaWaktu)
          payload.append('jangka_waktu', this.form.data.rencanaJangkaWaktu)
          payload.append('angsuran_pokok', parseInt(this.form.data.angsuran.pokok.replaceAll(',', '')))
          payload.append('angsuran_margin', parseInt(this.form.data.angsuran.margin.replaceAll(',', '')))
          payload.append('angsuran_minggon', parseInt(this.form.data.angsuran.minggon.replaceAll(',', '')))
          payload.append('biaya_administrasi', parseInt(this.form.data.setoranSaatPencarian.biayaAdm.replaceAll(',', '')))
          payload.append('dana_kebajikan', parseInt(this.form.data.setoranSaatPencarian.danaKebajikan.replaceAll(',', '')))
          payload.append('biaya_asuransi_jiwa', parseInt(this.form.data.setoranSaatPencarian.asuransi.replaceAll(',', '')))
          payload.append('kode_kreditur', this.form.data.kreditur.kode_value)
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
            let req = await easycoApi.regisAkadUpdate(payload, this.user.token)
            if(req.status == 200){
              this.doClearForm()
              this.notify('success','Success',req.statusText)
              this.$bvModal.hide('modal-form')
              this.form.loading = false
            }
          } catch (error) {
            console.log(error)
            this.form.loading = false
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
        async doGetDetail(payload){
          try {
            let req = await easycoApi.regisAkadReadDetail(payload, this.user.token)
            return req.data.data
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
            this.form.data.setoranSaatPencarian.simpananWajib = this.doFormatCurrency(req.data.data.simwa)
          } catch (error) {
            console.log(error)
            this.notify('danger','Login Error',error)
          }
        },
        doClearForm() {
          this.form.data.detail = {}
          this.form.modal.state = null
          this.form.data.id = null
          this.form.data.rembug = null
          this.form.data.pengajuan = null
          this.form.data.noAnggota = null
          this.form.data.noPengajuan = null
          this.form.data.pembiayaanKe = null
          this.form.data.jumlahPengajuan = null
          this.form.data.peruntukan = {}
          this.form.data.keterangan = null
          this.form.data.produk = {}
          this.form.data.plafon = 0
          this.form.data.margin = 0
          this.form.data.rencanaJangkaWaktu = 0
          this.form.data.rencanaPeriodeJangkaWaktu = null
          this.form.data.angsuran.pokok = 0
          this.form.data.angsuran.margin = 0
          this.form.data.angsuran.minggon = 0
          this.form.data.angsuran.total = 0
          this.form.data.setoranSaatPencarian.biayaAdm = 0
          this.form.data.setoranSaatPencarian.asuransi = 0
          this.form.data.setoranSaatPencarian.danaKebajikan = 0
          this.form.data.setoranSaatPencarian.simpananWajib = 0
          this.form.data.setoranSaatPencarian.total = 0
          this.form.data.tanggalPengajuan = null
          this.form.data.tanggalAkad = null
          this.form.data.rencanaAngsur = null
          this.form.data.sumberDana = null
          this.form.data.kreditur = {}
          this.$bvModal.show('modal-form')
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
    