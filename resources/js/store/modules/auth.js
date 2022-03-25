import auth from '@/js/api/auth'
import Vue  from 'vue'

const state = {
  user: {
    id         : null,
    loaded     : false,
    loadGastos : false,
    permissions: [],
    roles      : []
  }

}

const getters   = {

  shwoUser: (state) => {
    return state.user.id
  },
  userCan : (state) => (permissions) => {
    let can = false
    if (state.user.roles.filter(d => d.special === 'all-access').length > 0) {
      can = true
    } else if(Array.isArray(permissions)) {
        for (let id in permissions) {
          can = state.user.permissions.filter(d => d.slug === permissions[id]).length > 0 ? true : can
        }
      }
    else{
      can =  state.user.permissions.filter(d => d.slug === permissions).length > 0
    }
    return can

  }
}
const actions   = {

  getUser({dispatch, commit}) {
    return new Promise((resolve, reject) => {
      auth.requestUser().then(response => {
        response.data.loaded = true
        commit('setUser', response.data)
        dispatch('afterGet')
        resolve(response)
      }).catch(error => {
        reject(error)
      })
    })
  },
  afterGet({dispatch, commit}) {
    if (state.user.loadGastos) {
      dispatch('establecerFormGastos', {user_id: state.user.id}, {root: true})
      dispatch('getProyectoGastos', true, {root: true})
    }
  },
  alterUser({commit}, u) {
    commit('setUser', u)
  }
}
const mutations = {
  setUser(state, u) {
    state.user = Object.assign(state.user, u)
    //Vue.set(state, 'user', u)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
