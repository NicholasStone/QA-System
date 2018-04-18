import Vue from 'vue'
import Router from 'vue-router'
import Index from '../views/Index'
import Register from '../views/Register'
import SignIn from '../views/SignIn'
import Home from '../views/Home'
import Profile from '../views/Profile'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {path: '/', name: 'Index', component: Index},
    {path: '/register', name: 'Register', component: Register},
    {path: '/sign-in', alias: '/login', name: 'Sign-in', component: SignIn},
    {path: '/home', name: 'Home', component: Home},
    {path: '/profile', name: 'Profile', component: Profile}
  ]
})

router.beforeEach((to, from, next) => {
  next()
})

export default router
