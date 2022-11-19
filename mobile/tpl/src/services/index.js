import axios from 'axios';
const Axios = axios.create({
  baseURL: 'https://tpl.baytulikhtiar.com/api/'
})
const authRegister = (payload) => {
  return Axios.post('auth/register', payload)
}
const authCheckPassword = (payload) => {
  return Axios.post('/auth/check_password', payload)
}
const authUsername = (payload) => {
  return Axios.post('auth/check_fa_code', payload)
}
const infoRembug = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/information/rembug', payload, config)
}
const infoMember = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/information/member', payload, config)
}
const transSetoranDeposit = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/transaction/deposit', payload, config)
}
const transSetoranDepositProses = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/transaction/process_deposit', payload, config)
}
const transPembiayaanPengajuan = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/transaction/submission', payload, config)
}
const transPembiayaanRab = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/transaction/rab', payload, config)
}
const transPembiayaanPencairan = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/transaction/droping', payload, config)
}
const transPembiayaanPencairanProses = (payload, token) => {
  let config = {
    headers: {
      'Token': token
    }
  }
  return Axios.post('/transaction/process_droping', payload, config)
}
export default {
  authRegister,
  authCheckPassword,
  authUsername,
  infoRembug,
  infoMember,
  transSetoranDeposit,
  transSetoranDepositProses,
  transPembiayaanPengajuan,
  transPembiayaanRab,
  transPembiayaanPencairan,
  transPembiayaanPencairanProses
}