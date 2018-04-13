import Vue from 'vue'
import Router from 'vue-router'
import Index from '../components/Index'
import Register from '../components/Register'
import SignIn from '../components/SignIn'
import Home from '../components/Home'

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Index',
            component: Index,
            mate: {
                auth: false
            }
        }, {
            path: '/register',
            name: 'Register',
            component: Register,
            mate: {
                auth: false,
            }
        }, {
            path: '/sign-in',
            alias: '/login',
            name: 'Sign-in',
            component: SignIn,
            mate: {
                auth: false,
            }
        }, {
            path: '/home',
            name: 'Home',
            component: Home,
            mate: {
                auth: true
            }
        }
    ]
})
