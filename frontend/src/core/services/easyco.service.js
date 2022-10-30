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
  anggotaRembug(payload, token) {
    let url = 'anggota/rembug/'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  anggotaSimpanan(token) {
    let url = 'anggota/simpanan_anggota/'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  kotakabCreate(payload, token) {
    let url = 'kotakab/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kotakabRead(payload, token) {
    let url = 'kotakab/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kotakabUpdate(payload, token) {
    let url = 'kotakab/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kotakabDelete(payload, token) {
    let url = 'kotakab/delete/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  kotakabDetail(payload, token) {
    let url = 'kotakab/detail/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  desaCreate(payload, token) {
    let url = 'desa/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  desaRead(payload, token) {
    let url = 'desa/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  desaUpdate(payload, token) {
    let url = 'desa/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  desaDelete(payload, token) {
    let url = 'desa/delete/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  desaDetail(payload, token) {
    let url = 'desa/detail/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  kecamatanCreate(payload, token) {
    let url = 'kecamatan/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kecamatanRead(payload, token) {
    let url = 'kecamatan/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kecamatanUpdate(payload, token) {
    let url = 'kecamatan/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  kecamatanDelete(payload, token) {
    let url = 'kecamatan/delete/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  kecamatanDetail(payload, token) {
    let url = 'kecamatan/detail/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  cabangCreate(payload, token) {
    let url = 'cabang/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  cabangRead(payload, token) {
    let url = 'cabang/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  cabangUpdate(payload, token) {
    let url = 'cabang/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  cabangDelete(payload, token) {
    let url = 'cabang/delete/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  cabangDetail(payload, token) {
    let url = 'cabang/detail/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  rembugCreate(payload, token) {
    let url = 'rembug/create'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  rembugRead(payload, token) {
    let url = 'rembug/read'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  rembugUpdate(payload, token) {
    let url = 'rembug/update'
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.post(url, payload, config)
  },
  rembugDelete(payload, token) {
    let url = 'rembug/delete/'+ payload
    let config = {
      headers: {
        'token': token
      }
    }
    return axios.get(url, config)
  },
  rembugDetail(payload, token) {
    let url = 'rembug/detail/'+ payload
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