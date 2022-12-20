<template>
    <div>
      <h1 class="mb-5">{{$route.name}}</h1>
      <b-card>
        <b-row no-gutters>
          <b-col cols="12" class="d-flex justify-content-end mb-5 pb-5 border-bottom">
          </b-col>
          <b-col cols="12" class="mb-5">
            <b-row no-gutters>
                <b-col cols="8" class="mb-5">
          <div class="row">
            <b-col cols="5">
              <b-input-group prepend="No Rekening" class="mb-3">
                <b-form-select v-model="paging.no_rek" :options="opt.no_rek" />
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Nama" class="mb-3">
                <b-form-input v-model="paging.nama"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Majelis" class="mb-3">
                <b-form-input v-model="paging.majelis"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Desa" class="mb-3">
                <b-form-input v-model="paging.desa"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Produk" class="mb-3">
                <b-form-input v-model="paging.produk"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Tgl Akad" class="mb-3">
                <b-form-input v-model="paging.tgl_akad"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Mulai Angs" class="mb-3">
                <b-form-input v-model="paging.mulai_angs"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Plafon" class="mb-3">
                <b-form-input v-model="paging.plafon"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Margin" class="mb-3">
                <b-form-input v-model="paging.margin"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Jk Waktu" class="mb-3">
                <b-form-input v-model="paging.jk_waktu"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Angs Pokok" class="mb-3">
                <b-form-input v-model="paging.angs_pokok"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Angs margin" class="mb-3">
                <b-form-input v-model="paging.angs_margin"/>
              </b-input-group>
            </b-col>
            <b-col cols="5">
              <b-input-group prepend="Total Angs" class="mb-3">
                <b-form-input v-model="paging.total_angs"/>
              </b-input-group>
            </b-col>
          </div>
        </b-col>
        <b-col cols="4" class="d-flex justify-content-end align-items-start">
          <b-button-group>
            <b-button text="Button" variant="primary">
              GRID
            </b-button>
            <b-button text="Button" variant="warning">
              CSV
            </b-button>
            <b-button text="Button" variant="danger">
              PDF
            </b-button>
            <b-button text="Button" variant="success">
              XLS
            </b-button>
          </b-button-group>
        </b-col>
            </b-row>
          </b-col>
          <b-col cols="12">
            <b-table responsive bordered outlined small striped hover :fields="table.fields" :items="table.items"
              show-empty :emptyText="table.loading ? 'Memuat data...' : 'Tidak ada data'">
              <template #cell(no)="item">
                {{item.index + 1}}
              </template>
            </b-table>
          </b-col>
          <b-col cols="12" class="justify-content-end d-flex">
            <b-pagination v-model="paging.currentPage" :total-rows="table.totalRows" :per-page="paging.perPage">
            </b-pagination>
          </b-col>
        </b-row>
      </b-card>
    </div>
  </template>
  
  <script>
  import { validationMixin } from "vuelidate";
  import { required, sameAs, email, minLength } from 'vuelidate/lib/validators'
  export default {
    name: "LaporanKartuAngsuran",
    components: {},
    data() {
      return {
        form: {
          data: {
            id: null,
            no_rek: null,
            majelis: null,
            desa: null,
            produk: null,
            tgl_akad: null,
            mulai_angs: null,
            plafon: null,
            margin: null,
            jk_waktu: null,
            angs_pokok: null,
            angs_margin: null,
            total: null,
          },
          loading: false,
        },
        table: {
          fields: [
            {
              key: 'tanggal',
              sortable: true,
              label: 'Tanggal',
              label: 'Tanggal',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'no_trans',
              sortable: true,
              label: 'No Trans',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'keterangan',
              sortable: true,
              label: 'Keterangan',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'no_akun',
              sortable: true,
              label: 'No Akun',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'debit',
              sortable: true,
              label: 'Debit',
              thClass: 'text-center',
              tdClass: ''
            },
            {
              key: 'kredit',
              sortable: true,
              label: 'Kredit',
              thClass: 'text-center',
              tdClass: ''
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
          cabang: ['cabang 1','cabang 2','cabang 3'],
          no_rek: ['1010100101','2030300202','1020300301']
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
          tanggal: {
            required,
          },
          no_trans: {
            required,
          },
          keterangan: {
            required,
          },
          no_akun: {
            required,
          },
          debit: {
            required,
          },
          kredit: {
            required,
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
              tanggal: '01-12-2022',
              no_trans: '221201-01001',
              keterangan: 'Setor Tunai Ke BRI',
              no_akun: '101020101 BRI CAB SUDIRMAN',
              debit: '78.250.000',
              kredit: '0',
            },
            {
              tanggal: '',
              no_trans: '',
              keterangan: '',
              no_akun: '101010101 KAS BESAR',
              debit: '0',
              kredit: '78.250.000',
            },
            {
              tanggal: '01-12-2022',
              no_trans: '221201-01002',
              keterangan: 'UMB Perjalanan Dinas Tim Penumbuhan',
              no_akun: '501020105 BY PERJALANAN DINS',
              debit: '15.700.000',
              kredit: '0',
            },
            {
              tanggal: '',
              no_trans: '',
              keterangan: '',
              no_akun: '101010101 KAS BESAR',
              debit: '0',
              kredit: '15.700.000',
            },
          ]
          // this.doInfo('Data berhasil diambil','Berhasil','success')
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
            // this.doInfo('Data berhasil disimpan','Berhasil','success')
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
            // this.doInfo('Data berhasil dihapus','Berhasil','success')
          }, 5000);
        }
      },
      doClearForm() {
        this.form.data = {
            id: null,
            cabang: null,
            tanggal: null,
            no_trans: null,
            keterangan: null,
            no_akun: null,
            debit: null,
            kredit: null,
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
    