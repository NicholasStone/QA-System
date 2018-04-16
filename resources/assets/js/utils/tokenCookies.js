import Cookies from 'js-cookie'

const token = 'Token'

function set (jwt, expires = 7) {
  return Cookies.set(token, jwt, {expires})
}

function get () {
  return Cookies.get(token)
}

function revoke () {
  return Cookies.remove(token)
}

export default {
  set, get, revoke
}
