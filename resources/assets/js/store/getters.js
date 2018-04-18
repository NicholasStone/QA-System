export default {
  authentication: state => state.authorization.getters.authorization,
  token: state => state.authorization.getters.token,
  profile: state => state.profile.getters.profile,
  name: state => state.profile.getters.name,
  messages: state => state.message.getters.messages
}
