// import vue configures
import router from './router'
import store from './store'
// import from node_modules
import Vue from 'vue'
import Axios from 'axios'
// import vue components
import App from './Main'
import alert from './components/alert'
// import third party components
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
// import config
import config from './config'

Axios.defaults.baseURL = config.apiUrl
Axios.defaults.headers.common['Accept'] = 'application/prs.qa.v1+json'

Vue.use(BootstrapVue)
// Vue.use(VueAxios, Axios)

// Config Vue
Vue.config.devtools = true
Vue.config.productionTip = true

// Register Axios to Vue
// Vue.prototype.$axios = Axios;

// Vue Components Register
Vue.component('alert', alert)

// eslint-disable-next-line no-unused-vars
const app = new Vue({
  el: '#app',
  store,
  router,
  components: {App},
  template: '<App/>'
})
