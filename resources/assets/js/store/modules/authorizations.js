import _ from 'lodash'
import TokenCookies from '~/utils/tokenCookies'
import Communication from '~/api/communication'

export default {
  state: {
    token: TokenCookies.get() ? TokenCookies.get() : '',
    expiration: TokenCookies.get('expiration'),
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
    },
    authorized: state => {
      return !_.isEmpty(state.token)
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
            dispatch('update', response.data)
            dispatch('addMessage', {message: '登录成功', type: 'success'})
            resolve()
          })
          .catch(error => {
            console.log('Error in authorization')
            console.log(error)
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
            dispatch('update', response.data)
            resolve()
          })
          .catch(error => reject(error))
      })
    },
    update: function ({commit, dispatch}, {token, expiration}) {
      return new Promise((resolve, reject) => {
        commit('SET_TOKEN', token)
        commit('SET_EXPIRATION', expiration)
        TokenCookies.set(token)
        TokenCookies.set(expiration, 'expiration')
        dispatch('updateProfile').then(() => {
          resolve()
        }).catch(error => {
          dispatch('addMessage', {type: 'danger', message: '用户信息更新失败，请登录'})
          reject(error)
        })
      })
    }
  }
}
