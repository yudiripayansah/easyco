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
  // kotakab
  kotakabRead(payload, token){
    let url = 'kotakab/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kotakabDetail(payload, token){
    let url = 'kotakab/detail?'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  kotakabCreate(payload, token){
    let url = 'kotakab/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kotakabUpdate(payload, token){
    let url = 'kotakab/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kotakabDelete(payload, token){
    let url = 'kotakab/delete?'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  // kecamatan
  kecamatanRead(payload, token){
    let url = 'kecamatan/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kecamatanDetail(payload, token){
    let url = 'kecamatan/detail?'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  kecamatanCreate(payload, token){
    let url = 'kecamatan/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kecamatanUpdate(payload, token){
    let url = 'kecamatan/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kecamatanDelete(payload, token){
    let url = 'kecamatan/delete?'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  // desa
  desaRead(payload, token){
    let url = 'desa/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  desaDetail(payload, token){
    let url = 'desa/detail?'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  desaCreate(payload, token){
    let url = 'desa/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  desaUpdate(payload, token){
    let url = 'desa/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  desaDelete(payload, token){
    let url = 'desa/delete?'+payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
}
export default easycoApi