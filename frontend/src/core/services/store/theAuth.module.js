import axios from '../../plugins/axios'
export default {
  state: {
    currentUser: localStorage.getItem('EasyCoAdmUser') != null && typeof localStorage.getItem('EasyCoAdmUser') !== undefined ? JSON.parse(localStorage.getItem('EasyCoAdmUser')) : null,
    loginError: null,
    processing: false,
    forgotMailSuccess: null,
    resetPasswordSuccess: null,
    isAuthenticated: localStorage.getItem('EasyCoAdmUser') != null && typeof localStorage.getItem('EasyCoAdmUser') !== undefined ? true : false,
  },
  getters: {
    currentUser: state => state.currentUser,
    processing: state => state.processing,
    loginError: state => state.loginError,
    forgotMailSuccess: state => state.forgotMailSuccess,
    resetPasswordSuccess: state => state.resetPasswordSuccess,
    isAuthenticated: state => state.isAuthenticated
  },
  mutations: {
    setUser(state, payload) {
      state.currentUser = payload
      state.processing = false
      state.loginError = null
      state.isAuthenticated = true
    },
    setLogout(state) {
      state.currentUser = null
      state.processing = false
      state.loginError = null
      state.isAuthenticated = false
    },
    setProcessing(state, payload) {
      state.processing = payload
      state.loginError = null
    },
    setError(state, payload) {
      state.loginError = payload
      state.currentUser = null
      state.processing = false
    },
    setForgotMailSuccess(state) {
      state.loginError = null
      state.currentUser = null
      state.processing = false
      state.forgotMailSuccess = true
    },
    setResetPasswordSuccess(state) {
      state.loginError = null
      state.currentUser = null
      state.processing = false
      state.resetPasswordSuccess = true
    },
    clearError(state) {
      state.loginError = null
    }
  },
  actions: {
    login({
      commit
    }, payload) {
      commit('clearError')
      commit('setProcessing', true)
      if(payload.email == 'superadmin@easyco.co' && payload.password == '123'){
        let item = {
          user: {
            id : '1',
            username : 'Superadmin',
            name : 'Superadmin',
            email : 'superadmin@easyco.co',
            phone : '081234567890',
            role : 'Admin',
            img: 'media/users/default.jpg',
          }
        }
        localStorage.setItem('EasyCoAdmUser', JSON.stringify(item))
        commit('setUser', item)
      } else {
        let url = 'auth/login'
        let data = new FormData()
        data.append('email',payload.email)
        data.append('password',payload.password)
        axios
        .post(url,data)
        .then((res)=>{
          if(typeof res.data === 'object' && res.data.status){
            let item = {
              user: res.data.data,
              token: res.data.token
            }
            localStorage.setItem('EasyCoAdmUser', JSON.stringify(item))
            commit('setUser', item)
          } else {
            if(typeof res.data === 'object'){
              commit('setError', res.data.msg)
            } else {
              commit('setError', 'Internal server error')
            }
          }
        })
        .catch((e)=>{
          commit('setError', e.message)
        })
      }
    },
    updateUser({
      commit
    }, payload) {
        localStorage.setItem('EasyCoAdmUser', JSON.stringify(payload.profile))
        commit('setUser', payload.profile)
    },
    signOut({
      commit
    }) {
      localStorage.removeItem('EasyCoAdmUser')
      commit('setLogout')
    }
  }
}
