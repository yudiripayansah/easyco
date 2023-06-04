import axios from 'axios';
const Axios = axios.create({
  baseURL: 'https://easyco.kopikoding.com/api/api/'
})
const authLogin = (payload) => {
  return Axios.post('/authenticate/login', payload)
}
const infoRembug = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/tpl/information/rembug', payload, config)
}
const infoMember = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/tpl/information/member', payload, config)
}
const transSetoranDeposit = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/tpl/transaction/deposit', payload, config)
}
const transSetoranProses = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/tpl/transaction/process_deposit', payload, config)
}
// Anggota
const anggotaCreate = (payload, token) => {
  let config = {
    headers: {
      'token': token
    }
  }
  return Axios.post('/anggota/create', payload, config);
}
// Pembiayaan
const pembiayaanCreate = (payload, token) => {
  let config = {
    headers: {
      'token': token
    }
  }
  return Axios.post('/pengajuan/create', payload, config);
}
// Produk Tabungan
const produkTabungan = (payload, token) => {
  let config = {
    headers: {
      'token': token
    }
  }
  return Axios.post('/prdtabungan/read', payload, config);
}
// Produk Tabungan
const registrasiTabungan = (payload, token) => {
  let config = {
    headers: {
      'token': token
    }
  }
  return Axios.post('/tabungan/registrasi', payload, config);
}
const anggotaKeluar = (payload, token) => {
  let config = {
    headers: {
      'token': token
    }
  }
  return Axios.post('/anggotamutasi/create', payload, config);
}
const rekeningTabunganAnggota = (payload, token) => {
  let config = {
    headers: {
      'token': token
    }
  }
  return Axios.post('/tabungan/read', payload, config);
}
const tutupTabunganAnggota = (payload, token) => {
  let config = {
    headers: {
      'token': token
    }
  }
  return Axios.post('/tabungan/tutup', payload, config);
}
const saldoAnggota = (payload, token) => {
  let config = {
    headers: {
      'token': token
    }
  }
  return Axios.get('/anggotamutasi/saldo_anggota?'+payload, config);
}
export default {
  authLogin,
  infoRembug,
  infoMember,
  transSetoranDeposit,
  transSetoranProses,
  anggotaCreate,
  pembiayaanCreate,
  produkTabungan,
  registrasiTabungan,
  saldoAnggota,
  anggotaKeluar,
  rekeningTabunganAnggota,
  tutupTabunganAnggota
}