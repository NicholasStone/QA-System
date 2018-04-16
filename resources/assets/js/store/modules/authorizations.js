import TokenCookies from '~/utils/tokenCookies'
import Communication from '~/api/communication'

export default {
  state: {
    token: '',
    expiration: '',
    type: 'Bearer'
  },
  getters: {
    token: state => {
      return state.token
    },
    authorization: state => {
      return state.type + ' ' + state.token
    },
    expiration: state => {
      return state.expiration
    }
  },
  mutations: {
    'SET_TOKEN': (state, token) => {
      state.token = token
    },
    'SET_EXPIRATION': (state, expiration) => {
      state.expiration = expiration
    },
    'CLEAR_AUTHORIZATION': state => {
      state.expiration = ''
      state.token = ''
    }
  },
  actions: {
    authorize: ({commit, dispatch}, credentials) => {
      return new Promise((resolve, reject) => {
        Communication.post('authorization', credentials)
          .then(response => {
            commit('SET_TOKEN', response.data.token)
            commit('SET_EXPIRATION', response.data.expiration)
            TokenCookies.set(response.data.token)
            dispatch('updateProfile')
            resolve()
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    revoke: ({commit}) => {
      return new Promise(resolve => {
        commit('CLEAR_AUTHORIZATION')
        TokenCookies.revoke()
        resolve()
      })
    },
    refresh: ({commit, dispatch}) => {
      return new Promise((resolve, reject) => {
        Communication.put('authorization')
          .then(response => {
            commit('SET_TOKEN', response.data.token)
            commit('SET_EXPIRATION', response.data.expiration)
            resolve()
          })
          .catch(error => reject(error.response.data))
      })
    }
  }
}
