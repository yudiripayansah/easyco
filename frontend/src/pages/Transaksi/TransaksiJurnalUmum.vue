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
              <b-col cols="8" class="mb-5">
              <div class="row">
                <b-col cols="6">
                  <b-input-group prepend="Cabang" class="mb-3">
                    <b-form-select v-model="paging.cabang" :options="opt.cabang" />
                  </b-input-group>
                </b-col>
                <b-col cols="6">
                  <b-input-group prepend="Tanggal" class="mb-3">
                    <b-form-datepicker v-model="paging.from"/>
                  </b-input-group>
                </b-col>
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
                <b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Edit">
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
      <b-modal title="Form Transaksi Jurnal Umum" id="modal-form" hide-footer size="lg" centered>
        <b-form @submit="doSave()">
          <b-row>
            <b-col cols="6">
            <b-form-group label="cabang">
              <b-select v-model="form.data.cabang" :options="opt.cabang" />
            </b-form-group>
          </b-col>
            <b-col cols="6">
            <b-form-group label="No Ref">
              <b-input v-model="form.data.no_ref" />
            </b-form-group>
          </b-col>
            <b-col cols="6">
            <b-form-group label="Tanggal">
              <b-form-datepicker v-model="paging.tanggal"/>
            </b-form-group>
          </b-col>
          <b-col cols="6">
            <b-form-group label="Keterangan">
              <b-textarea v-model="form.data.ket" />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <b-form-group label="No Transaksi">
              <b-input v-model="form.data.no_transaksi"/>
            </b-form-group>
          </b-col>
          <b-col cols="12">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">No Akun</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Kredit</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td><b-select v-model="form.data.no_akun_1" :options="opt.no_akun_1" /></td>
                    <td>78.250.000</td>
                    <td>0</td>
                    <td>-</td>
                    <td><b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Ceklis">V</b-button>
                        <b-button variant="danger" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Silang">X</b-button>
                    </td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td><b-select v-model="form.data.no_akun_2" :options="opt.no_akun_2" /></td>
                    <td>0</td>
                    <td>78.250.000</td>
                    <td>-</td>
                    <td><b-button variant="success" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Ceklis">V</b-button>
                        <b-button variant="danger" size="xs" class="mx-1" @click="doUpdate(item)" v-b-tooltip.hover title="Silang">X</b-button>
                    </td>
                    </tr>
                </tbody>
            </table>
          </b-col>
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
  import { required, sameAs, email, minLength } from 'vuelidate/lib/validators'
  export default {
    name: "Transaksi Jurnal Umum",
    components: {},
    data() {
      return {
        form: {
          data: {
            id: null,
            cabang: null,
            no_ref: null,
            tanggal: null,
            no_transaksi: null,
            no_akun: null,
            debit: null,
            kredit: null,
            keterangan: null,
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
              key: 'tanggal',
              sortable: true,
              label: 'Tanggal',
              thClass: 'text-center',
              tdClass: 'text-center'
            },
            {
              key: 'no_voucher',
              sortable: true,
              label: 'No Voucher',
              thClass: 'text-center',
              tdClass: 'text-center'
            },
            {
              key: 'keterangan',
              sortable: true,
              label: 'Keterangan',
              thClass: 'text-left',
              tdClass: ''
            },
            {
              key: 'jumlah',
              sortable: true,
              label: 'Jumlah',
              thClass: 'text-right',
              tdClass: 'text-right',
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
          cabang: ['cabang 1','cabang 2','cabang 3'],
          petugas: ['Andi','Danu'],
          no_akun_1: ['101020101 BRI CAB SUDIRMAN','101010101 KAS BESAR'],
          no_akun_2: ['101020101 BRI CAB SUDIRMAN','101010101 KAS BESAR'],
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
          no_ref: {
            required,
          },
          tanggal: {
            required,
          },
          keterangan: {
            required,
          },
          no_transaksi: {
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
              tanggal: '01-12-22',
              no_voucher: '221201-01001',
              keterangan: 'Setor Tunai Ke BRI',
              jumlah: '78.250.000',
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
            no_ref: null,
            tanggal: null,
            keterangan: null,
            no_transaksi: null,
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
    