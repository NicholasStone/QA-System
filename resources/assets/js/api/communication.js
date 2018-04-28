import axios from 'axios'
import store from '~/store'
import _ from 'lodash'
import router from '~/router'
import config from '~/config'

const communicate = axios.create({
  baseURL: config.apiUrl,
  headers: {
    Accept: 'application/prs.qa.v1+json'
  }
})

communicate.interceptors.request.use(config => {
  if (store.getters.authorization) {
    config.headers['Authorization'] = store.getters.authorization
  }
  return config
}, error => {
  console.error(error)
})
communicate.interceptors.response.use(response => {
  return Promise.resolve(response)
}, error => {
  if (error.response.status === 401) {
    store.dispatch('revoke')
      .then(router.push({name: 'Sign-in'}))
  }
  let errors = []
  let response = error.response.data
  if (response.errors === undefined) {
    errors.push(response.message)
  } else {
    errors = formatErrors(response.errors)
  }
  // error.response.data.errors  // error object
  // error.response.data.message // error message
  return Promise.reject(errors)
})

function formatErrors (err) {
  if (_.isObject(err) || _.isArray(err)) {
    let result = []
    _.forEach(err, function (val) {
      result = result.concat(formatErrors(val))
    })
    return result
  } else {
    return [err]
  }
}

export default communicate
