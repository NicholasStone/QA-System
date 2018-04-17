import Vue from 'vue'
import Router from 'vue-router'
import Index from '../views/Index'
import Register from '../views/Register'
import SignIn from '../views/SignIn'
import Home from '../views/Home'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Index',
      component: Index
    }, {
      path: '/register',
      name: 'Register',
      component: Register
    }, {
      path: '/sign-in',
      alias: '/login',
      name: 'Sign-in',
      component: SignIn
    }, {
      path: '/home',
      name: 'Home',
      component: Home
    }
  ]
})
