export default {
  authentication: state => state.authorization.getters.authorization,
  authorized: state => state.authorization.getters.authorized,
  token: state => state.authorization.getters.token,
  profile: state => state.profile.getters.profile,
  role: state => state.profile.getters.role,
  name: state => state.profile.getters.name,
  messages: state => state.message.getters.messages
}
