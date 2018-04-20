import Store from '~/store'

export default function () {
  // init
  if (Store.getters.authenticated && Store.getters.role.length === 0) {
    Store.dispatch('updateProfile')
  }
}
