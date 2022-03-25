import reporte                from '@/js/api/gastos/reporte'
const state = {
  breadCrumbs: [

    {
      text: 'Proyectos',
      disabled: false,
      exact:true,
      to: '/proyectos',
    },
  ],
  defaultBreadCrumb : {
    disabled: false,
    exact   : false,
    link    : false,
    text    : '',
    to      : ''
  },
  totalProjectYear:{}

};

const getters = {
  showBreadCrumbs : (state) => {
    return state.breadCrumbs;
  },
  showTotalProjectYear : (state) => {
    return state.totalProjectYear
  }
};
const actions = {
  addBreadCrumb({commit}, breadCrumb){
    commit('addBreadCrumb',Object.assign(state.defaultBreadCrumb,breadCrumb) )
  },
  setBreadCrumbs({commit}, breadCrumbs){
    commit('setBreadCrumbs', breadCrumb)
  },
  getTotalProjectYear({commit}) {
    return new Promise((resolve, reject) => {
      reporte
        .getResumenGlobal()
        .then(response => {
          commit('setTotalProjectYear', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error)
        })
    })
  }
};
const mutations = {
  addBreadCrumb(state, breadCrumb){
    state.breadCrumbs.push(breadCrumb)
  },
  setBreadCrumbs(state, breadCrumbs){
    state.breadCrumbs=breadCrumbs
  },
  setTotalProjectYear(state, u) {
    state.totalProjectYear = u
  }
};

export default {
  state,
  getters,
  actions,
  mutations
};
