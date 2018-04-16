export default {
  authentication: state => state.authorization.getters.authorization,
  profile: state => state.profile.getters.profile
}
