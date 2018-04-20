import Store from '~/store'

function RedirectIfUnauthenticated (to, from) {
  // router name
  let except = [
    'Sign-in', 'Register', 'Index'
  ]

  if (!Store.getters.authoried &&
    !except.includes(from.name)) {
    return {
      name: 'Sign-in', query: {redirect: to.fullPath}
    }
  }
}

export default RedirectIfUnauthenticated
