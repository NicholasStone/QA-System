export default {
  state: {
    messages: [] // {type: 'danger/success/info', message: 'some message', expire: 10(s)}
  },
  getters: {
    messages: function (state) {
      return state.messages
    }
  },
  mutations: {
    'ADD_MESSAGE': function (state, message) {
      state.messages.push(message)
    },
    'CLEAR_MESSAGE': function (state) {
      state.messages.length = 0
    }
  },
  actions: {
    addMessage: function ({commit}, {message, type, expire = 10}) {
      commit('SET_MESSAGE', {message, type, expire})
    }
  }
}
