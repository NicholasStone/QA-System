export default {
  authentication: state => state.authorization.getters.authorization,
  authenticated: state => state.authorization.getters.authenticated,
  token: state => state.authorization.getters.token,
  profile: state => state.profile.getters.profile,
  role: state => state.profile.getters.role,
  name: state => state.profile.getters.name,
  messages: state => state.message.getters.messages
}
