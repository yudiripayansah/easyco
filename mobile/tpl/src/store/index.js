import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: localStorage.getItem('baikTpl') != null ? JSON.parse(localStorage.getItem('baikTpl')) : [],
  },
  getters: {
    user: state => state.user,
  },
  mutations: {
    setUser(state,payload){
      state.user = payload
      localStorage.setItem('baikTpl', JSON.stringify(state.user))
    },
    removeUser(state){
      state.user = []
      localStorage.removeItem('baikTpl')
    }
  },
  actions: {
    login({commit},payload) {
      commit('setUser',payload)
    },
    logout({commit}) {
      commit('removeUser')
    }
  },
  modules: {
  }
})
