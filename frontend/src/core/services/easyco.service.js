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
  }
}

export default easycoApi