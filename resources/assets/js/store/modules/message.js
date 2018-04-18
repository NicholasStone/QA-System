export default {
  state: {
    index: 0,
    messages: [
      // {index: 0, type: 'success', message: 'success message', expire: 10, read: false, local: false},
    ]
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
    },
    'INCREASE_INDEX': function (state) {
      state.index += 1
    },
    'READ': function (state, index) {
      state.messages[index].read = true
    }
  },
  actions: {
    addMessage: function ({commit, state}, {message, type, expire = 10}) {
      commit('ADD_MESSAGE', {
        index: state.index,
        type,
        message,
        expire,
        read: false,
        local: false
      })
    },
    read: function ({commit}, index) {
      return new Promise(resolve => {
        commit('READ', index)
        resolve()
      })
    }
  }
}
