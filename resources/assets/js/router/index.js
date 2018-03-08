import Vue from 'vue';
import Router from 'vue-router';
import store from '../store';

import App from '../components/App';
import Home from '../components/Home';
import Login from '../components/Login';
import Logout from '../components/Logout';
import Users from '../components/users/Users';
import AddUser from '../components/users/AddUser';
import EditUser from '../components/users/EditUser';

Vue.use(Router);

const router = new Router({
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login,
            // beforeEnter (from, to, next) {
            //   next(store.state.token === '' ? true : {name: 'root'})
            // },
            meta: {
                guarded: false,
            },
        },
        {
            path: '/logout',
            name: 'logout',
            component: Logout,
            meta: {
                guarded: true,
            },
        },
        {
            path: '/',
            name: 'root',
            component: Home,
            meta: {
                guarded: true,
            },
        },
        {
            path: '/users',
            name: 'users',
            component: Users,
            meta: {
                guarded: true,
            },
        },
        {
            path: '/users/:id',
            name: 'editUser',
            component: EditUser,
            meta: {
                guarded: true,
            },
        },
        {
            path: '/add-user',
            name: 'add-user',
            component: AddUser,
            meta: {
                guarded: true,
            },
        },
    ],
});

router.beforeEach((to, from, next) => {
    next(
        (to.meta.guarded && store.state.authentication.token === '') ? {name: 'login'} : true
    )
});

export default router;
