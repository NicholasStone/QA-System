import Store from '~/store'

function RedirectIfAuthenticated (to, from) {
  let router = [
    '/register', '/sign-in', '/login'
  ]

  if (Store.getters.authenticated && router.includes(to.fullPath)) {
    if (router.includes(from.fullPath)) {
      return {
        path: '/'
      }
    } else {
      return {
        path: from.fullPath
      }
    }
  }
}

export default RedirectIfAuthenticated
