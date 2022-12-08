import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: localStorage.getItem('easycoTpl') != null ? JSON.parse(localStorage.getItem('easycoTpl')) : [],
    transaksi: localStorage.getItem('easycoTrx') != null ? JSON.parse(localStorage.getItem('easycoTrx')) : [],
    kasPetugas: localStorage.getItem('easycoKasPetugas') != null ? JSON.parse(localStorage.getItem('easycoKasPetugas')) : [],
    transaksiRembug: localStorage.getItem('easycoTrxRembug') != null ? JSON.parse(localStorage.getItem('easycoTrxRembug')) : [],
  },
  getters: {
    user: state => state.user,
    transaksi: state => state.transaksi,
    transaksiRembug: state => state.transaksiRembug,
    kasPetugas: state => state.kasPetugas
  },
  mutations: {
    setUser(state,payload){
      state.user = payload
      localStorage.setItem('easycoTpl', JSON.stringify(state.user))
    },
    removeUser(state){
      state.user = []
      localStorage.removeItem('easycoTpl')
    },
    setTrx(state,payload){
      state.transaksi = payload
      localStorage.setItem('easycoTrx', JSON.stringify(state.transaksi))
    },
    clearTrx(state){
      state.transaksi = []
      localStorage.removeItem('easycoTrx')
    },
    setTrxRembug(state,payload){
      state.transaksiRembug = payload
      localStorage.setItem('easycoTrxRembug', JSON.stringify(state.transaksiRembug))
    },
    setKasPetugas(state,payload){
      state.kasPetugas = payload
      localStorage.setItem('easycoKasPetugas', JSON.stringify(state.kasPetugas))
    },
  },
  actions: {
    login({commit},payload) {
      commit('setUser',payload)
    },
    logout({commit}) {
      commit('removeUser')
    },
    setTrx({commit}, payload) {
      commit('setTrx', payload)
    },
    clearTrx({commit}) {
      commit('clearTrx')
    },
    setKasPetugas({commit}, payload) {
      commit('setKasPetugas', payload)
    },
  },
  modules: {
  }
})
