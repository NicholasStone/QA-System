import Store from '~/store'

function RedirectIfAuthenticated (to, from) {
  let routerNames = [
    'Register', 'Sign-in'
  ]

  if (Store.getters.authoried && routerNames.includes(to.name)) {
    return {
      name: 'Index'
    }
  }
}

export default RedirectIfAuthenticated
