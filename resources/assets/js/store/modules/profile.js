import Communication from '~/api/communication'

export default {
  state: {
    id: '',
    name: '',
    email: '',
    avatar: '',
    role: '',
    created: '',
    updated: ''
  },
  getters: {
    id: state => {
      return state.id
    },
    name: state => {
      return state.name
    },
    email: state => {
      return state.email
    },
    avatar: state => {
      return state.avatar
    },
    role: state => {
      return state.role
    },
    created: state => {
      return state.created
    },
    updated: state => {
      return state.updated
    },
    profile: ({id, name, email, avatar, role, created, updated}) => {
      return {id, name, email, avatar, role, created, updated}
    }
  },
  mutations: {
    'SET_EMAIL': (state, email) => {
      state.email = email
    },
    'SET_NAME': (state, name) => {
      state.name = name
    },
    'SET_AVATAR': (state, avatar) => {
      state.avatar = avatar
    },
    'SET_PROFILE': (state, {id, name, email, avatar, role_id: role, created_at: created, updated_at: updated}) => {
      state.id = id
      state.name = name
      state.email = email
      state.avatar = avatar
      state.role = role
      state.created = created
      state.updated = updated
    },
    'CLEAR_PROFILE': state => {
      Object.keys(state).forEach(key => {
        state[key] = ''
      })
    }
  },
  actions: {
    updateProfile ({commit}) {
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
    }
  }
}
