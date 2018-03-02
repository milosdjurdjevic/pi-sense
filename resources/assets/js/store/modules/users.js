import * as types from '../mutation-types';
// import api from '../../api';


/**
 * STATE
 */
const state = {
    users: [],
    links: {},
    total: 0,
    totalPages: 0,
    currentPage: 0,
    search: '',
};

/**
 * GETTERS
 */
const getters = {
    // eslint-disable-next-line
    users: state => state.users,
    links: state => state.links,
    total: state => state.total,
    totalPages: state => state.totalPages,
    currentPage: state => state.currentPage,
    search: state => state.search,
};

/**
 * ACTIONS
 * @type {{login({commit: *}, *=): void}}
 */
const actions = {
    createUser({context}, user) {
        return new Promise((resolve, reject) => {
            axios.post('users', user).then((response) => {
                console.log(response);
                resolve(response);
            }, (error) => {
                console.log(error);
                resolve(error);
            });
        });
    },
    fetchUsers({context}, page = 1) {
        return new Promise((resolve, reject) => {
            axios.get(`users?page=${page}`).then((response) => {
                resolve(response);
            }, (error) => {
                reject(error);
            });
        });
    },
    deleteUser({context}, id) {
        return new Promise((resolve, reject) => {
            axios.delete(`users/${id}`).then((response) => {
                resolve(response);
            }, (error) => {
                reject(error)
            });
        })
    },
    getUser({context}, id) {
        return new Promise((resolve, reject) => {
            axios.get(`users/${id}`).then((response) => {
                resolve(response);
            }, (error) => {
                reject(error)
            });
        })
    },
    updateUser({context}, user) {
        return new Promise((resolve, reject) => {
            axios.put(`users/${user.id}`, user).then((response) => {
                resolve(response);
            }, (error) => {
                reject(error)
            });
        })
    }
};

/**
 * MUTATIONS
 */
const mutations = {
    // eslint-disable-next-line
    [types.CREATE_USER](user) {

    },
    [types.UPDATE_USER_STATE](user) {
        state.user.firstName = user.firstName;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
