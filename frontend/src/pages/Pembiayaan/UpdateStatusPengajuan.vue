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
                  <b-input-group size="sm" prepend="Cabang">
                    <b-form-select v-model="$v.form.data.cabang.$model" :options="opt.cabang" />
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
                <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Update Status">
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
      <b-modal title="Form Upadate Status Pengajuan" id="modal-form" hide-footer size="lg" centered>
        <b-form @submit="doSave()">
          <b-row>
            <b-col cols="10">
              <b-form-group label="Cabang" label-for="cabang">
                <b-form-input id="cabang" v-model="$v.form.data.cabang.$model" :state="validateState('cabang')" />
              </b-form-group>
            </b-col>
            <b-col cols="10">
              <b-form-group label="Rembug" label-for="rembug">
                <b-form-input id="rembug" v-model="$v.form.data.rembug.$model" :state="validateState('rembug')" />
              </b-form-group>
            </b-col>
            <b-col cols="10">
              <b-form-group label="Nama" label-for="nama">
                <b-form-input id="nama" v-model="$v.form.data.nama.$model" :state="validateState('nama')" />
              </b-form-group>
            </b-col>
            <b-col cols="10">
              <b-form-group label="No Anggota" label-for="no_anggota">
                <b-form-input id="no_anggota" v-model="$v.form.data.no_anggota.$model"
                  :state="validateState('no_anggota')" />
              </b-form-group>
            </b-col>
            <b-col cols="10">
              <b-form-group label="No Pengajuan" label-for="no_pengajuan">
                <b-form-input id="no_pengajuan" v-model="$v.form.data.no_pengajuan.$model"
                  :state="validateState('no_pengajuan')" />
              </b-form-group>
            </b-col>
            <b-col cols="10">
              <b-form-group label="Pembiayaan Ke" label-for="pembiayaan_ke">
                <b-form-input id="pembiayaan_ke" v-model="$v.form.data.pembiayaan_ke.$model"
                  :state="validateState('pembiayaan_ke')" />
              </b-form-group>
            </b-col>
            <b-col cols="10">
              <b-form-group label="Jumlah Pengajuan" label-for="jmlh_pengajuan">
                <b-form-input id="jmlh_pengajuan" v-model="$v.form.data.jmlh_pengajuan.$model"
                  :state="validateState('jmlh_pengajuan')" />
              </b-form-group>
            </b-col>
            <b-col cols="10">
              <b-form-group label="Peruntukan" label-for="peruntukan">
                <b-form-input id="peruntukan" v-model="$v.form.data.peruntukan.$model"
                  :state="validateState('peruntukan')" />
              </b-form-group>
            </b-col>
            <b-col cols="12">
              <b-form-group label="Keterangan" label-for="keterangan">
                <b-form-textarea id="keterangan" v-model="$v.form.data.keterangan.$model"
                  :state="validateState('keterangan')" />
              </b-form-group>
            </b-col>
            <b-col cols="10">
              <b-form-group label="Tanggal Cair" label-for="tgl_cair">
                <b-form-input id="tgl_cair" type="date" v-model="$v.form.data.tgl_cair.$model"
                  :state="validateState('tgl_cair')" />
              </b-form-group>
            </b-col>
            <b-col cols="3">
              <b-form-group label="Jangka" label-for="jangka_waktu">
                <b-form-input id="jangka_waktu" v-model="$v.form.data.jangka_waktu.$model"
                  :state="validateState('jangka_waktu')" />
              </b-form-group>
            </b-col>
            <b-col cols="7">
              <b-form-group label="Waktu" label-for="jangka_waktu">
                <b-form-select id="jangka_waktu" v-model="$v.form.data.jangka_waktu.$model" :options="opt.jangka_waktu"
                  :state="validateState('jangka_waktu')" />
              </b-form-group>
            </b-col>
        </b-row>
            <b-row>
                <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
                    <b-container class="bv-example-row mb-3">
                        <b-row cols="2">
                            <b-col><p>Hasil Komite</p>
                                <b-form-group label="Status Pengajuan" label-for="stts_pengajuan">
                                        <b-form-select id="stts_pengajuan" v-model="$v.form.data.stts_pengajuan.$model" :options="opt.stts_pengajuan"
                                        :state="validateState('jangka_waktu')" />
                                    </b-form-group>
                                    <b-form-group label="Jumlah Di Setujui" label-for="jmlh_di_setujui">
                                        <b-form-input id="jmlh_di_setujui" v-model="$v.form.data.jmlh_di_setujui.$model" 
                                        :state="validateState('jmlh_di_setujui')" />
                                    </b-form-group>
                                    <b-row>
                                        <b-col cols="8" sm="6">
                                            <b-form-group label="Jangka" label-for="jangka_waktu">
                                        <b-form-input id="jangka_waktu" v-model="$v.form.data.jangka_waktu.$model"
                                        :state="validateState('jangka_waktu')" />
                                    </b-form-group>
                                        </b-col>
                                        <b-col cols="4" sm="6">
                                            <b-form-group label="Waktu" label-for="jangka_waktu">
                                        <b-form-select id="jangka_waktu" v-model="$v.form.data.jangka_waktu.$model" :options="opt.jangka_waktu"
                                        :state="validateState('jangka_waktu')" />
                                    </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-form-group label="Akad" label-for="akad">
                                        <b-form-input id="akad" v-model="$v.form.data.akad.$model" 
                                        :state="validateState('akad')" />
                                    </b-form-group>
                                    <b-form-group label="Margin" label-for="margin">
                                        <b-form-input id="margin" v-model="$v.form.data.margin.$model" 
                                        :state="validateState('margin')" />
                                    </b-form-group>
                                    </b-col>
                                    <b-col>
                                        <p>Catatan Komite</p>
                                        <b-form-group label-for="catatan">
                                                <b-form-textarea id="catatan" v-model="$v.form.data.catatan.$model" 
                                                :state="validateState('catatan')" />
                                            </b-form-group>
                                    </b-col>
                                </b-row>
                                </b-container>
            </b-col>
            </b-row>
            <b-row>
                <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
                    <b-container class="bv-example-row mb-3">
                        <b-row cols="2">
                            <b-col><p>Angsuran</p>
                                <b-form-group label="pokok" label-for="pokok">
                                        <b-form-input id="pokok" v-model="$v.form.data.pokok.$model"
                                        :state="validateState('pokok')" />
                                    </b-form-group>
                                    <b-form-group label="Margin" label-for="margin_2">
                                        <b-form-input id="margin_2" v-model="$v.form.data.margin_2.$model" 
                                        :state="validateState('margin_2')" />
                                    </b-form-group>
                                    <b-form-group label="Minggon" label-for="minggon">
                                        <b-form-input id="minggon" v-model="$v.form.data.minggon.$model" 
                                        :state="validateState('minggon')" />
                                    </b-form-group>
                                    <b-form-group label="Total" label-for="total">
                                        <b-form-input id="total" v-model="$v.form.data.total.$model" 
                                        :state="validateState('total')" />
                                    </b-form-group>
                                    </b-col>
                                <b-col>
                                    <p>Setoran Saat Pencairan</p>
                                        <b-form-group label="Biaya Adm" label-for="biaya_adm">
                                        <b-form-input id="biaya_adm" v-model="$v.form.data.biaya_adm.$model" 
                                        :state="validateState('biaya_adm')" />
                                    </b-form-group>
                                    <b-form-group label="Asuransi" label-for="asuransi">
                                        <b-form-input id="asurasi" v-model="$v.form.data.asuransi.$model" 
                                        :state="validateState('biaya_adm')" />
                                    </b-form-group>
                                    <b-form-group label="Dana Kebijakan" label-for="dana_kbjkn">
                                        <b-form-input id="dana_kbjkn" v-model="$v.form.data.dana_kbjkn.$model" 
                                        :state="validateState('dana_kbjkn')" />
                                    </b-form-group>
                                    <b-form-group label="Simpanan Wajib" label-for="simwa">
                                        <b-form-input id="simwa" v-model="$v.form.data.simwa.$model" 
                                        :state="validateState('simwa')" />
                                    </b-form-group>
                                    <b-form-group label="Total" label-for="total_2">
                                        <b-form-input id="total_2" v-model="$v.form.data.total_2.$model" 
                                        :state="validateState('total_2')" />
                                    </b-form-group>
                                    </b-col>
                                </b-row>
                                </b-container>
            </b-col>
            </b-row>
            <b-row>
                <b-col cols="12" class="d-flex justify-content-end border-top pt-5">
                <b-button variant="secondary" @click="$bvModal.hide('modal-form')" :disabled="form.loading">Kembali
                </b-button>
                <b-button variant="primary" type="submit" :disabled="form.loading" class="ml-3">
                {{form.loading ? 'Memproses...' : 'Update Status' }}
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
  import { validationMixin } from "vuelidate";
  import { required } from 'vuelidate/lib/validators'
  export default {
    name: "Pengguna",
    components: {},
    data() {
      return {
        form: {
          data: {
            id: null,
            cabang: null,
            nama: null,
            rembug: null,
            no_pengajuan: null,
            jumlah: null,
            tgl_pengajuan: null,
            no_anggota: null,
            pembiayaan_ke: null,
            jmlh_pengajuan: null,
            peruntukan: null,
            keterangan: null,
            tgl_cair: null,
            jangka_waktu: null,
            stts_pengajuan: null,
            jmlh_di_setujui: null,
            akad: null,
            margin: null,
            catatan: null,
            pokok: null,
            minggon: null,
            total: null,
            biaya_adm: null,
            asuransi: null,
            dana_kbjkn: null,
            simwa: null,
            margin_2: null,
            total_2: null,
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
              key: 'cabang',
              sortable: true,
              label: 'cabang',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'nama',
              sortable: true,
              label: 'nama',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'rembug',
              sortable: true,
              label: 'rembug',
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
              key: 'jumlah',
              sortable: true,
              label: 'Jumlah',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'tgl_pengajuan',
              sortable: true,
              label: 'Tanggal Pengajuan',
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
          currentPage: 1,
          perPage: 10
        },
        remove: {
          data: {
  
          },
          loading: false
        },
        opt: {
          perPage: [10,25,50,100],
          role: ['admin','user','staff','accounting'],
          cabang: ['Cimauk','cabang 1','cabang 2'],
          status: ['aktif','non aktif'],
          jangka_waktu: ['Pekan','Hari','Bulan','Tahun'],
          stts_pengajuan: ['Disetujui','Tidak Disetujui',],
        }
      }
    },
    mixins: [validationMixin],
    validations: {
      form: {
        data: {
            cabang: {
            required
          },
          nama: {
            required
          },
          rembug: {
            required
          },
          no_pengajuan: {
            required
          },
          jumlah: {
            required
          },
          tgl_pengajuan: {
            required
          },
          no_anggota: {
            required
          },
          pembiayaan_ke: {
            required
          },
          jmlh_pengajuan: {
            required
          },
          peruntukan: {
            required
          },
          keterangan: {
            required
          },
          tgl_cair: {
            required
          },
          jangka_waktu: {
            required
          },
          stts_pengajuan: {
            required
          },
          jmlh_di_setujui: {
            required
          },
          akad: {
            required
          },
          margin: {
            required
          },
          catatan: {
            required
          },
          pokok: {
            required
          },
          minggon: {
            required
          },
          total: {
            required
          },
          biaya_adm: {
            required
          },
          asuransi: {
            required
          },
          dana_kbjkn: {
            required
          },
          simwa: {
            required
          },
          margin_2: {
            required
          },
          total_2: {
            required
          },
        }
      }
    },
    mounted() {
      this.doGet()
    },
    methods: {
      validateState(name) {
        const { $dirty, $error } = this.$v.form.data[name];
        return $dirty ? !$error : null;
      },
      async doGet() {
        this.table.loading = true
        setTimeout(() => {
          this.table.loading = false
          this.table.items = [
            {
              cabang: 'Cimauk',
              nama: 'AMINANAH HASANAH',
              rembug: 'Mawar',
              no_pengajuan: '201.0010001',
              jumlah: '2.000.000',
              tgl_pengajuan: '01-08-2022',
              no_anggota: '201.0010001',
              pembiayaan_ke: '1',
              jmlh_pengajuan: '2.000.000',
              peruntukan: 'Modal Kerja',
              keterangan: 'Pembelian Blender dan Mesing Giling',
              tgl_cair: '08-08-2022',
              jangka_waktu: '50 Pekan',
              stts_pengajuan: 'disetujui',
              jmlh_di_setujui: '2.000.000',
              akad: 'Murobahah',
              margin: '600.000',
              catatan: '#',
              pokok: '40.000',
              minggon: '3.000',
              total: '55.000',
              biaya_adm: '10.000',
              asuransi: '10.000',
              dana_kbjkn: '5.000',
              simwa: '80.000',
              margin_2: '12.000',
              total_2: '105.000',
              created_at: 'Tanggal Dibuat',
            },
          ]
          this.doInfo('Data berhasil diambil','Berhasil','success')
        },5000)
      },
      async doSave() {
        this.$v.form.$touch();
        if (!this.$v.form.$anyError) {
          this.form.loading = true
          setTimeout(() => {
            this.form.loading = false
            this.$bvModal.hide('modal-form')
            let newItems = {...this.form.data}
            let date = new Date()
            newItems.created_at = date.toLocaleDateString() 
            newItems.id = this.table.items.length + 1
            this.table.items.push(newItems)
            this.doClearForm()
            this.doInfo('Data berhasil disimpan','Berhasil','success')
          }, 5000);
        }
      },
      async doUpdate(item) {
        console.log(item)
        this.form.data = {...item.item}
        this.$bvModal.show('modal-form')
      },
      async doDelete(item,prompt) {
        if(prompt){
          this.remove.data = item
          this.$bvModal.show('modal-delete')
        } else {
          this.remove.loading = true
          setTimeout(() => {
            this.remove.loading = false
            this.$bvModal.hide('modal-delete')
            this.doInfo('Data berhasil dihapus','Berhasil','success')
          }, 5000);
        }
      },
      doClearForm() {
        this.form.data = {
          id: null,
          cabang: null,
          rembug: null,
          nama: null,
          no_anggota: null,
          no_pengajuan: null,
          pembiayaan_ke: null,
          cabang: null,
          peruntukan: null,
          keterangan: null,
          tgl_cair: null,
          jangka_waktu: null,
          stts_pengajuan: null,
          jmlh_di_setujui: null,
          akad: null,
          margin: null,
          catatan: null,
          pokok: null,
          minggon: null,
          total: null,
          biaya_adm: null,
          asuransi: null,
          dana_kbjkn: null,
          simwa: null,
          margin_2: null,
          total_2: null,
        }
        this.$v.form.$reset()
      },
      doInfo(msg,title,variant) {
        this.$bvToast.toast(msg, {
          title: title,
          variant: variant,
          solid: true,
          toaster: 'b-toaster-bottom-right'
        })
      }
    }
  };
  </script>
    