import Vue from 'vue'
import Router from 'vue-router'
import Middleware from './middlewares'
import Index from '../views/Index'
import Register from '../views/Register'
import SignIn from '../views/SignIn'
import Home from '../views/Home'
import Profile from '../views/Profile'
import Avatar from '../views/Avatar'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {path: '/', name: 'Index', component: Index},
    {path: '/register', name: 'Register', component: Register},
    {path: '/sign-in', alias: '/login', name: 'Sign-in', component: SignIn},
    {
      path: '/user',
      component: Home,
      redirect: {name: 'Home'},
      meta: {
        auth: true
      },
      children: [
        {path: 'home', name: 'Home', component: Home},
        {path: 'profile', name: 'Profile', component: Profile},
        {path: 'avatar', name: 'Avatar', component: Avatar}
      ]
    }
  ]
})

router.beforeEach(Middleware)

export default router
