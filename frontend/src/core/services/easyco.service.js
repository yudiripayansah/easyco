import axios from 'axios'
axios.defaults.baseURL = 'https://easyco.kopikoding.com/api/api/'

const easycoApi = {
  login(payload) {
    let url = 'authenticate/login'
    return axios.post(url, payload)
  },
  anggotaCreate(payload, token) {
    let url = 'anggota/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  anggotaRead(payload, token) {
    let url = 'anggota/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  anggotaUpdate(payload, token) {
    let url = 'anggota/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  anggotaDelete(payload, token) {
    let url = 'anggota/delete/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  anggotaDetail(payload, token) {
    let url = 'anggota/detail/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  anggotaSimpanan(token) {
    let url = 'anggota/simpanan_anggota'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  anggotaRembug(payload,token) {
    let url = 'anggota/rembug'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  anggotaExcel(payload,token) {
    let url = 'laporan/list/excel/anggota_masuk?kode_cabang=10101&kode_rembug=101010001&from_date=2022-09-01&thru_date=2022-09-07'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  // Petugas
  petugasRead(payload, token) {
    let url = 'pengajuan/fa'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  // Peruntukan
  peruntukanRead(payload, token) {
    let url = 'pengajuan/peruntukan'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  // Cabang
  cabangRead(payload, token) {
    let url = 'cabang/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  // Pengajuan Pembiayaan
  pengajuanAnggotaRead(payload, token){
    let url = 'pengajuan/member'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  pengajuanPembiayaanCreate(payload, token) {
    let url = 'pengajuan/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  pengajuanRead(payload, token) {
    let url = 'pengajuan/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  pengajuanUpdate(payload, token) {
    let url = 'pengajuan/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  pengajuanDetail(payload, token) {
    let url = 'pengajuan/detail'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  pengajuanDelete(payload, token) {
    let url = 'pengajuan/delete'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  // Registrasi Akad
  regisAkadRead(payload, token){
    let url = 'registrasiakad/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  regisAkadCreate(payload, token){
    let url = 'registrasiakad/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  regisAkadReadDetail(payload, token){
    let url = 'registrasiakad/detail'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  regisAkadUpdate(payload, token){
    let url = 'registrasiakad/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  pembiayaanGetRembug(payload, token) {
    let url = 'registrasiakad/rembug'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  PembiayaanGetPengajuan(payload, token) {
    let url = 'registrasiakad/pengajuan'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  PembiayaanGetPeruntukan(payload, token) {
    let url = 'registrasiakad/peruntukan'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  pembiayaanGetProduk(payload, token){
    let url = 'registrasiakad/product'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  pembiayaanGetKreditur(payload, token){
    let url = 'registrasiakad/kreditur'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  // Keanggotaan
  keanggotaanGetSimpananAnggota(payload, token){
    let url = 'anggota/simpanan_anggota'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  // Verifikasi Akad
  detailVerifikasiAkad(payload, token) {
    let url = 'registrasiakad/detail?id='+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  verifikasiAkadApprove(payload, token){
    let url = 'registrasiakad/approve'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  verifikasiAkadReject(payload, token){
    let url = 'registrasiakad/reject'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  penerimaanAngsuran(payload, token){
    let url = 'trx_member/penerimaan_angsuran'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  transaksiRembug(payload, token){
    let url = 'trx_member/transaksi_majelis'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  // cabang
  cabangRead(payload, token){
    let url = 'cabang/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  cabangDetail(payload, token){
    let url = 'cabang/detail?'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  cabangCreate(payload, token){
    let url = 'cabang/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  cabangUpdate(payload, token){
    let url = 'cabang/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  cabangDelete(payload, token){
    let url = 'cabang/delete?'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
    // rembug
    rembugRead(payload, token){
      let url = 'rembug/read'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    rembugDetail(payload, token){
      let url = 'rembug/detail?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
    rembugCreate(payload, token){
      let url = 'rembug/create'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    rembugUpdate(payload, token){
      let url = 'rembug/update'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    rembugDelete(payload, token){
      let url = 'rembug/delete?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
     // Produk Tabungan
     prdtabunganRead(payload, token){
      let url = 'prdtabungan/read'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prdtabunganDetail(payload, token){
      let url = 'prdtabungan/detail?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
    prdtabunganCreate(payload, token){
      let url = 'prdtabungan/create'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prdtabunganUpdate(payload, token){
      let url = 'prdtabungan/update'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prdtabunganDelete(payload, token){
      let url = 'prdtabungan/delete?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
     // Produk Pembiayaan
     prdpembiayaanRead(payload, token){
      let url = 'prdpembiayaan/read'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prdpembiayaanDetail(payload, token){
      let url = 'prdpembiayaan/detail?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
    prdpembiayaanCreate(payload, token){
      let url = 'prdpembiayaan/create'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prdpembiayaanUpdate(payload, token){
      let url = 'prdpembiayaan/update'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prdpembiayaanDelete(payload, token){
      let url = 'prdpembiayaan/delete?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
     // Produk Deposito
     prddepositoRead(payload, token){
      let url = 'prddeposito/read'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prddepositoDetail(payload, token){
      let url = 'prddeposito/detail?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
    prddepositoCreate(payload, token){
      let url = 'prddeposito/create'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prddepositoUpdate(payload, token){
      let url = 'prddeposito/update'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    prddepositoDelete(payload, token){
      let url = 'prddeposito/delete?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
     // LEMBAGA
     lembagaRead(payload, token){
      let url = 'lembaga/read'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    lembagaDetail(payload, token){
      let url = 'lembaga/detail?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
    lembagaCreate(payload, token){
      let url = 'lembaga/create'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    lembagaUpdate(payload, token){
      let url = 'lembaga/update'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    lembagaDelete(payload, token){
      let url = 'lembaga/delete?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
     // PEGAWAI
     pegawaiRead(payload, token){
      let url = 'pegawai/read'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    pegawaiDetail(payload, token){
      let url = 'pegawai/detail?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
    pegawaiCreate(payload, token){
      let url = 'pegawai/create'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    pegawaiUpdate(payload, token){
      let url = 'pegawai/update'
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.post(url, payload, config)
    },
    pegawaiDelete(payload, token){
      let url = 'pegawai/delete?'+payload
      let config = {
        headers: {
          'token': token
        }
      }
      return axios.get(url, config)
    },
}
export default easycoApi