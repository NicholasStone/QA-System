import Store from '~/store'

function RedirectIfUnauthenticated (to, from) {
  if (to.matched.some(router => router.meta.auth) && !Store.getters.authenticated) {
    return {
      name: 'Sign-in', query: {redirect: to.fullPath}
    }
  }
}

export default RedirectIfUnauthenticated
