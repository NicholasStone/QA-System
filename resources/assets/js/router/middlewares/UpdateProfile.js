import Store from '~/store'

export default function (to, from) {
  if (Store.getters.authoried && Store.getters.role.length === 0) {
    Store.dispatch('updateProfile')
  }
}
