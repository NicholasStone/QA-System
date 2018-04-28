import Store from '~/store'

export default function () {
  // init
  if (Store.getters.authenticated && Store.getters.role === 0) {
    Store.dispatch('getProfile')
  }
}
