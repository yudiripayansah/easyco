import axios from '../../plugins/axios'
export default {
  state: {
    currentUser: localStorage.getItem('HseAdmUser') != null && typeof localStorage.getItem('HseAdmUser') !== undefined ? JSON.parse(localStorage.getItem('HseAdmUser')) : null,
    loginError: null,
    processing: false,
    forgotMailSuccess: null,
    resetPasswordSuccess: null,
    isAuthenticated: localStorage.getItem('HseAdmUser') != null && typeof localStorage.getItem('HseAdmUser') !== undefined ? true : false,
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
      if(payload.email == 'superadmin@easyco.co' && payload.password == 'superadmin123easyco'){
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
        localStorage.setItem('HseAdmUser', JSON.stringify(item))
        commit('setUser', item)
      } else {
        let url = 'auth/login'
        let data = {
          email: payload.email,
          password: payload.password
        }
        axios
        .post(url,data)
        .then((res)=>{
          if(res.status){
            let item = res.data
            localStorage.setItem('HseAdmUser', JSON.stringify(item))
            commit('setUser', item)
          } else {
            commit('setError', res.msg)
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
        localStorage.setItem('HseAdmUser', JSON.stringify(payload.profile))
        commit('setUser', payload.profile)
    },
    signOut({
      commit
    }) {
      localStorage.removeItem('HseAdmUser')
      commit('setLogout')
    }
  }
}
