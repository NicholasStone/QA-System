import Cookies from 'js-cookie'

const token = 'Token'

function set (jwt, type = token, expires = 7) {
  return Cookies.set(type, jwt, {expires})
}

function get (val = token) {
  return Cookies.get(val)
}

function revoke (val = token) {
  return Cookies.remove(val)
}

export default {
  set, get, revoke
}
