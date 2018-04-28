import Communication from '~/api/communication'
import _ from 'lodash'

export default {
  state: {
    id: '',
    name: '',
    email: '',
    avatar: '',
    role: 0,
    created: '',
    updated: '',
    introduction: ''
  },
  getters: {
    id: state => state.id,
    name: state => state.name,
    email: state => state.email,
    avatar: state => state.avatar,
    role: state => state.role,
    created: state => state.created,
    updated: state => state.updated,
    introduction: state => state.introduction,
    profile: ({id, name, email, avatar, role, created, updated, introduction}) => {
      return {id, name, email, avatar, role, created, updated, introduction}
    }
  },
  mutations: {
    'SET_EMAIL': (state, email) => {
      if (!_.isEmpty(email)) {
        state.email = email
      }
    },
    'SET_NAME': (state, name) => {
      if (!_.isEmpty(name)) {
        state.name = name
      }
    },
    'SET_AVATAR': (state, avatar) => {
      if (!_.isEmpty(avatar)) {
        state.avatar = avatar
      }
    },
    'SET_INTRODUCTION': (state, introduction) => {
      if (!_.isEmpty(introduction)) {
        state.introduction = introduction
      }
    },
    'SET_PROFILE': (state, {id, name, email, avatar, role, created, updated, introduction}) => {
      state.id = id
      state.name = name
      state.email = email
      state.avatar = avatar
      state.role = role
      state.created = created
      state.updated = updated
      state.introduction = introduction
    },
    'CLEAR_PROFILE': state => {
      Object.keys(state).forEach(key => {
        state[key] = ''
      })
    }
  },
  actions: {
    getProfile ({commit}) {
      return new Promise((resolve, reject) => {
        Communication.get('/user')
          .then(response => {
            commit('SET_PROFILE', response.data)
            resolve()
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    updateProfile ({commit, dispatch}, profile) {
      return new Promise((resolve, reject) => {
        let update = {}
        _.each(profile, function (value, key) {
          if (!_.isEmpty(value)) {
            update[key] = value
          }
        })
        Communication.patch('/user', update)
          .then(response => {
            commit('SET_NAME', profile.name)
            commit('SET_INTRODUCTION', profile.introduction)
            dispatch('success', '您的个人信息已更新完毕')
            console.log(response)
          })
          .catch(error => {
            dispatch('except', '更新个人信息时出现问题')
            console.log(error)
            reject(error)
          })
      })
    },
    deleteProfile ({commit}) {
      commit('CLEAR_PROFILE')
    }
  }
}
