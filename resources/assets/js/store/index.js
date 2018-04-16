import Vue from 'vue'
import Vuex from 'vuex'
import modules from './modules'
import getters from './getters'
import 'es6-promise/auto'

Vue.use(Vuex)

export default new Vuex.Store(
  {modules},
  getters
)
