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
        'token': token,
        'Content-Type' : 'multipart/form-data'
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
}

export default easycoApi