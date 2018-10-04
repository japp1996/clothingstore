import whosalerService from '../../services/wara/wholesaler'

const state = {
    all: [],
    option: 1,
    savedStatus: false,
    errMessage: ''
}

const getters = {}

const actions = {
    changeOption ({ commit }, option) {
        commit('setOption', option)
    },

    addWholesaler ({commit}, data) {
        whosalerService.store(data)
            .then(wholesalerSaved => {
                swal('', 'Se registro la colección correctamente', 'success')
                commit('add', wholesalerSaved)
                commit('setOption', 1)
            })
            .catch(err => {
                if(err.response.status === 422) {
                    swal('',  err.response.data.error, 'error')
                }else {
                    swal('',  'Algo ha ocurridom, intente nuevamente', 'error')
                }
            })
    }
}

const mutations = {
    setWholesalers (state, wholesalers) {
        state.all = wholesalers
    },

    setOption (state, option) {
        state.option = option
    },

    add (state, wholesaler) {
        state.all.push(wholesaler)
    },

    setSaveStatus (state, status) {
        state.savedStatus = status
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}