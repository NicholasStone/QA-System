import axios from 'axios'
import store from '~/store'

axios.interceptors.request.use(config => {
  if (store.getters.authorization) {
    config.headers['Authorization'] = store.getters.authorization
  }
  return config
}, error => {
  console.error(error)
})

export default axios
