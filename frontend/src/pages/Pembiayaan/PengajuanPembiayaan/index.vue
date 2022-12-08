<template>
  <div>
    <b-card :title="$route.name">
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
              <template #cell(jumlah_pengajuan)="item">
                {{doFormatCurrency(item.item.jumlah_pengajuan)}}
              </template>
              <template #cell(action)="item">
                <b-button variant="success" size="xs" class="mx-1" @click="doShowEdit(item);$bvModal.show('modal-form')" v-b-tooltip.hover title="Update Status">
                    Update Status
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
    <b-modal title="Form Pembiayaan Pengajuan" id="modal-form" hide-footer size="lg" centered>
      <b-form class="border-top py-5 Halaman 1" @submit.prevent="doSave()">
        <b-row>  
          <b-col cols="12">
            <b-form-group label="Petugas">
              <b-select :options="opt.listPetugas" class="mb-3" v-model="form.data.petugas" required/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="No Anggota">
              <b-select :options="opt.listAnggota" class="mb-3" v-model="form.data.noAnggota" required/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Nama">
              <b-input disabled v-model="form.data.nama"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="No KTP">
              <b-input disabled v-model="form.data.noKTP"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Rembug">
              <b-input disabled v-model="form.data.rembug"/>
            </b-form-group>
          </b-col>
          <b-col cols="2">
            <b-form-group label="Pembiayaan Ke">
              <b-input type="number" v-model="form.data.pembiayaanKe" require/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Jumlah Pengajuan">
              <b-input v-model="form.data.jumlahPengajuan" @blur="focusOut($event, form.data.jumlahPengajuan)"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Peruntukan">
                <b-select :options="opt.listPeruntukan" v-model="form.data.peruntukan"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Keterangan">
                <b-form-textarea
                    id="textarea"
                    v-model="form.data.keterangan"
                    placeholder="Keterangan..."
                    rows="3"
                    max-rows="6"
                    ></b-form-textarea>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Rencana Jangka Waktu">
              <b-row>
                <b-col cols="2">
                  <b-input type="number" v-model="form.data.rencanaJangkaWaktu"/>
                </b-col>
                <b-col cols="10">
                    <b-select :options="opt.rencanaPeriodeJangkaWaktu" v-model="form.data.rencanaPeriodeJangkaWaktu"/>
                </b-col>
              </b-row>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Jenis Pembiayaan">
                <b-select :options="opt.jenisPembiayaan" v-model="form.data.jenisPembiayaan"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Sumber Pengambilan">
                <b-select :options="opt.sumberPengambilan" v-model="form.data.sumberPengambilan"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Tanggal Pengajuan">
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" v-model="form.data.tanggalPengajuan"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Tanggal Pencairan">
                <b-form-datepicker :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }" locale="id" v-model="form.data.tanggalDroping"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="TTD Anggota">
                <b-img v-if="form.data.ttdAnggota.default" :src="form.data.ttdAnggota.defaultImage" class="mb-3" fluid block rounded @click="chooseTtdAnggota()"></b-img>
                <b-img v-if="!form.data.ttdAnggota.default" :src="form.data.ttdAnggota.selectedImage" style="width: 400px; height: 250px;" class="mb-3" fluid block rounded></b-img>
                <b-form-file
                    v-model="form.data.ttdAnggota.file"
                    id="fileTTDAnggota"
                    style="display: none"
                    ></b-form-file>
                <b-button v-if="!form.data.ttdAnggota.default" variant="secondary" size="sm" class="ml-5" @click="chooseTtdAnggota()">
                    Change Image
                </b-button>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="TTD Ketua Rembug">
                <b-img v-if="form.data.ttdKetuaRembug.default" :src="form.data.ttdKetuaRembug.defaultImage" class="mb-3" fluid block rounded @click="chooseTtdKetuaRembug()"></b-img>
                <b-img v-if="!form.data.ttdKetuaRembug.default" :src="form.data.ttdKetuaRembug.selectedImage" style="width: 400px; height: 250px;" class="mb-3" fluid block rounded></b-img>
                <b-form-file
                    v-model="form.data.ttdKetuaRembug.file"
                    id="fileTTDKetuaRembug"
                    style="display: none"
                    ></b-form-file>
                <b-button v-if="!form.data.ttdKetuaRembug.default" variant="secondary" size="sm" class="ml-5" @click="chooseTtdKetuaRembug()">
                    Change Image
                </b-button>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="TTD TPL">
                <b-img v-if="form.data.ttdTPL.default" :src="form.data.ttdTPL.defaultImage" class="mb-3" fluid block rounded @click="chooseTtdTPL()"></b-img>
                <b-img v-if="!form.data.ttdTPL.default" :src="form.data.ttdTPL.selectedImage" style="width: 400px; height: 250px;" class="mb-3" fluid block rounded></b-img>
                <b-form-file
                    v-model="form.data.ttdTPL.file"
                    id="fileTTDTPL"
                    style="display: none"
                    ></b-form-file>
                <b-button v-if="!form.data.ttdTPL.default" variant="secondary" size="sm" class="ml-5" @click="chooseTtdTPL()">
                    Change Image
                </b-button>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="TTD Pasangan">
                <b-img v-if="form.data.ttdPasangan.default" :src="form.data.ttdPasangan.defaultImage" class="mb-3" fluid block rounded @click="chooseTtdPasangan()"></b-img>
                <b-img v-if="!form.data.ttdPasangan.default" :src="form.data.ttdPasangan.selectedImage" style="width: 400px; height: 250px;" class="mb-3" fluid block rounded></b-img>
                <b-form-file
                    v-model="form.data.ttdPasangan.file"
                    id="fileTTDPasangan"
                    style="display: none"
                    ></b-form-file>
                <b-button v-if="!form.data.ttdPasangan.default" variant="secondary" size="sm" class="ml-5" @click="chooseTtdPasangan()">
                    Change Image
                </b-button>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Dokumen KTP">
                <b-img v-if="form.data.documentKTP.default" :src="form.data.documentKTP.defaultImage" class="mb-3" fluid block rounded @click="chooseDocKTP()"></b-img>
                <b-img v-if="!form.data.documentKTP.default" :src="form.data.documentKTP.selectedImage" style="width: 400px; height: 250px;" class="mb-3" fluid block rounded></b-img>
                <b-form-file
                    v-model="form.data.documentKTP.file"
                    id="fileDocKTP"
                    style="display: none"
                    ></b-form-file>
                <b-button v-if="!form.data.documentKTP.default" variant="secondary" size="sm" class="ml-5" @click="chooseDocKTP()">
                    Change Document
                </b-button>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Dokumen Kartu Keluarga">
                <b-img v-if="form.data.documentKK.default" :src="form.data.documentKK.defaultImage" class="mb-3" fluid block rounded @click="chooseDocKK()"></b-img>
                <b-img v-if="!form.data.documentKK.default" :src="form.data.documentKK.selectedImage" style="width: 400px; height: 250px;" class="mb-3" fluid block rounded></b-img>
                <b-form-file
                    v-model="form.data.documentKK.file"
                    id="fileDocKK"
                    style="display: none"
                    ></b-form-file>
                <b-button v-if="!form.data.documentKK.default" variant="secondary" size="sm" class="ml-5" @click="chooseDocKK()">
                    Change Document
                </b-button>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <b-form-group label="Dokumen Pendukung">
                <b-img v-if="form.data.documentPendukung.default" :src="form.data.documentPendukung.defaultImage" class="mb-3" fluid block rounded @click="chooseDocPendukung()"></b-img>
                <b-img v-if="!form.data.documentPendukung.default" :src="form.data.documentPendukung.selectedImage" style="width: 400px; height: 250px;" class="mb-3" fluid block rounded></b-img>
                <b-form-file
                    v-model="form.data.documentPendukung.file"
                    id="fileDocPendukung"
                    style="display: none"
                    ></b-form-file>
                <b-button v-if="!form.data.documentPendukung.default" variant="secondary" size="sm" class="ml-5" @click="chooseDocPendukung()">
                    Change Document
                </b-button>
            </b-form-group>
          </b-col>
          <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
            <b-button variant="secondary" :disabled="form.loading" class="ml-5">
              <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
              Kembali
            </b-button>
            <b-button v-if="form.data.idPengajuan == null" variant="primary" :disabled="form.loading" type="submit" class="ml-5">
              <b-spinner small label="Small Spinner" v-show="form.loading"></b-spinner>
              Submit
            </b-button>
            <b-button v-if="form.data.idPengajuan != null" variant="primary" :disabled="form.loading" @click="doUpdate()" class="ml-5">
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
            paging: {
              handler(val){
                this.doGetPengajuan()
              },
              deep: true
            },
            "form.data.noAnggota"(val){
              if(val != null){
                this.form.data.nama = val.nama_anggota
                this.form.data.noKTP = val.no_ktp
                this.form.data.rembug = val.nama_rembug
              }
            },
            "form.data.ttdAnggota.file"(newValue, oldValue) {
                if (newValue !== oldValue) {
                    if (newValue) {
                    base64Encode(newValue)
                        .then(value => {
                            this.form.data.ttdAnggota.selectedImage = value;
                            this.form.data.ttdAnggota.default = false;

                        })
                        .catch(() => {
                            this.form.data.ttdAnggota.selectedImage = null;
                            this.form.data.ttdAnggota.default = true;
                        });
                    } else {
                        this.form.data.ttdAnggota.default = true;
                    }
                }
            },
            "form.data.ttdKetuaRembug.file"(newValue, oldValue) {
                if (newValue !== oldValue) {
                    if (newValue) {
                    base64Encode(newValue)
                        .then(value => {
                            this.form.data.ttdKetuaRembug.selectedImage = value;
                            this.form.data.ttdKetuaRembug.default = false;

                        })
                        .catch(() => {
                            this.form.data.ttdKetuaRembug.selectedImage = null;
                            this.form.data.ttdKetuaRembug.default = true;
                        });
                    } else {
                        this.form.data.ttdKetuaRembug.default = true;
                    }
                }
            },
            "form.data.ttdTPL.file"(newValue, oldValue) {
                if (newValue !== oldValue) {
                    if (newValue) {
                    base64Encode(newValue)
                        .then(value => {
                            this.form.data.ttdTPL.selectedImage = value;
                            this.form.data.ttdTPL.default = false;

                        })
                        .catch(() => {
                            this.form.data.ttdTPL.selectedImage = null;
                            this.form.data.ttdTPL.default = true;
                        });
                    } else {
                        this.form.data.ttdTPL.default = true;
                    }
                }
            },
            "form.data.ttdPasangan.file"(newValue, oldValue) {
                if (newValue !== oldValue) {
                    if (newValue) {
                    base64Encode(newValue)
                        .then(value => {
                            this.form.data.ttdPasangan.selectedImage = value;
                            this.form.data.ttdPasangan.default = false;

                        })
                        .catch(() => {
                            this.form.data.ttdPasangan.selectedImage = null;
                            this.form.data.ttdPasangan.default = true;
                        });
                    } else {
                        this.form.data.ttdPasangan.default = true;
                    }
                }
            },
            "form.data.documentKTP.file"(newValue, oldValue) {
                if (newValue !== oldValue) {
                    if (newValue) {
                    base64Encode(newValue)
                        .then(value => {
                            this.form.data.documentKTP.selectedImage = value;
                            this.form.data.documentKTP.default = false;

                        })
                        .catch(() => {
                            this.form.data.documentKTP.selectedImage = null;
                            this.form.data.documentKTP.default = true;
                        });
                    } else {
                        this.form.data.documentKTP.default = true;
                    }
                }
            },
            "form.data.documentKK.file"(newValue, oldValue) {
                if (newValue !== oldValue) {
                    if (newValue) {
                    base64Encode(newValue)
                        .then(value => {
                            this.form.data.documentKK.selectedImage = value;
                            this.form.data.documentKK.default = false;

                        })
                        .catch(() => {
                            this.form.data.documentKK.selectedImage = null;
                            this.form.data.documentKK.default = true;
                        });
                    } else {
                        this.form.data.documentKK.default = true;
                    }
                }
            },
            "form.data.documentPendukung.file"(newValue, oldValue) {
                if (newValue !== oldValue) {
                    if (newValue) {
                    base64Encode(newValue)
                        .then(value => {
                            this.form.data.documentPendukung.selectedImage = value;
                            this.form.data.documentPendukung.default = false;

                        })
                        .catch(() => {
                            this.form.data.documentPendukung.selectedImage = null;
                            this.form.data.documentPendukung.default = true;
                        });
                    } else {
                        this.form.data.documentPendukung.default = true;
                    }
                }
            },
        },
      computed: {
        ...mapGetters(["user"]),
      },
      data() {
        return {
          form: {
            data: {
              idPengajuan: null,
              noAnggota: {},
              petugas: {},
              nama: null,
              noKTP:'',
              rembug:'',
              pembiayaanKe: 0,
              jumlahPengajuan: 0,
              peruntukan: {},
              keterangan: "",
              rencanaJangkaWaktu: 0,
              rencanaPeriodeJangkaWaktu: {},
              jenisPembiayaan: '',
              sumberPengambilan: '',
              tanggalPengajuan: '',
              tanggalDroping: '',
              ttdAnggota: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
              ttdKetuaRembug: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
              ttdTPL: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
              ttdPasangan: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
              documentKTP: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
              documentKK: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null},
              documentPendukung: {default: true, file: null, defaultImage: defaultImageUpload, selectedImage: null}
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
                key: 'jumlah_pengajuan',
                sortable: true,
                label: 'Jumlah',
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
          },
          opt: {
            listAnggota: [],
            listPetugas: [],
            listPeruntukan: [],
            listCabang: [],
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
        date.setDate(date.getDate()+7)
        this.form.data.tanggalDroping = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`
        await this.doGetCabang()
        await this.doGetAnggota()
        await this.doGetPengajuan()
        await this.doGetPetugas()
        await this.doGetPeruntukan()
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
            console.log(findAnggota.value)
            return findAnggota.value.nama_rembug
          }
        },
        async doSave() {
          let payload = new FormData();
          payload.append('no_anggota', this.form.data.noAnggota.no_anggota)
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
          payload.append('sumber_perngambil',this.form.data.sumberPengambilan)
          payload.append('created_by', this.user.id)
          payload.append('doc_ktp', this.form.data.documentKTP.file)
          payload.append('doc_kk', this.form.data.documentKK.file)
          payload.append('doc_pendukung', this.form.data.documentPendukung.file)
          payload.append('ttd_anggota', this.form.data.ttdAnggota.file)
          payload.append('ttd_suami', this.form.data.ttdPasangan.file)
          payload.append('ttd_ketua_majelis', this.form.data.ttdKetuaRembug.file)
          payload.append('ttd_tpl', this.form.data.ttdTPL.file)
          try {
            let req = await easycoApi.pengajuanPembiayaanCreate(payload, this.user.token)
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
        doShowEdit(item){
          let itemSelected = item.item
          this.form.data.idPengajuan = itemSelected.id
          this.form.data.noAnggota = this.opt.listAnggota.filter(x=>x.value.no_anggota == itemSelected.no_anggota)[0].value
          this.form.data.petugas =  this.opt.listPetugas.filter(x=>x.value.kode_petugas == itemSelected.kode_petugas)[0].value
          this.form.data.pembiayaanKe =  itemSelected.pengajuan_ke
          let _value = parseFloat(itemSelected.jumlah_pengajuan.substring(0, itemSelected.jumlah_pengajuan.length-3).replace(",", ".")).toLocaleString(
              undefined,
              {
                  minimumFractionDigits: 0,
              }
          );
          this.form.data.jumlahPengajuan = _value
          this.form.data.peruntukan =  this.opt.listPeruntukan.filter(x=>x.value.kode_value == itemSelected.peruntukan)[0].value
          this.form.data.keterangan =  itemSelected.keterangan_peruntukan
          this.form.data.rencanaJangkaWaktu =  itemSelected.jangka_waktu
          this.form.data.rencanaPeriodeJangkaWaktu =  itemSelected.rencana_periode_jwaktu
          this.form.data.jenisPembiayaan =  itemSelected.jenis_pembiayaan
          this.form.data.sumberPengambilan =  itemSelected.sumber_pengembalian
          this.form.data.tanggalPengajuan =  itemSelected.tanggal_pengajuan
          this.form.data.tanggalDroping =  itemSelected.rencana_droping
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
        async doGetAnggota() {
          let payload = this.paging
          try {
            let req = await easycoApi.pengajuanAnggotaRead(payload, this.user.token)
            this.opt.listAnggota = req.data.data.map(anggotas => ({text: `${anggotas.no_anggota} - ${anggotas.nama_anggota}`, value: anggotas}))
          } catch (error) {
            console.log(error)
            this.notify('danger','Login Error',error)
          }
        },
        async doGetPetugas() {
          let payload = this.paging
          try {
            let req = await easycoApi.petugasRead(payload, this.user.token)
            this.opt.listPetugas = req.data.data.map(petugas => ({text: `${petugas.kode_petugas} - ${petugas.nama_kas_petugas}`, value: petugas}))
          } catch (error) {
            console.log(error)
            this.notify('danger','Login Error',error)
          }
        },
        async doGetPeruntukan() {
          let payload = this.paging
          try {
            let req = await easycoApi.peruntukanRead(payload, this.user.token)
            this.opt.listPeruntukan = req.data.data.map(peruntukan => ({text: `${peruntukan.kode_display}`, value: peruntukan}))
          } catch (error) {
            console.log(error)
            this.notify('danger','Login Error',error)
          }
        },
        async doGetPengajuan() {
          let payload = this.paging
          try {
            let req = await easycoApi.pengajuanRead(payload, this.user.token)
            this.table.items = req.data.data
            this.table.totalRows = req.data.total
          } catch (error) {
            console.log(error)
            this.notify('danger','Login Error',error)
          }
        },
        async doGetCabang() {
          let payload = this.paging
          try {
            let req = await easycoApi.cabangRead(payload, this.user.token)
            this.opt.listCabang = req.data.data.map(cabang => ({text: `${cabang.nama_cabang}`, value: cabang}))
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
        date.setDate(date.getDate()+7)
        this.form.data.tanggalDroping =  `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`
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
        focusOut: function (event, value) {
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
          this.form.data.jumlahPengajuan = _value
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
    