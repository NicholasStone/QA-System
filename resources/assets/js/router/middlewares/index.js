import RedirectIfAuthenticated from './RedirectIfAuthenticated'
import RedirectIfUnauthenticated from './RedirectIfUnauthenticated'
import UpdateProfile from './UpdateProfile'

const middleware = [
  UpdateProfile,
  RedirectIfAuthenticated,
  RedirectIfUnauthenticated
]

export default function (to, from, next) {
  let result = null
  for (let i = 0; i < middleware.length; i++) {
    result = middleware[i](to, from)
    if (result) break
  }
  if (result) {
    next(result)
  } else {
    next()
  }
}
