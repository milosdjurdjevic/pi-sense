import * as types from '../mutation-types';
// import api from '../../api';


/**
 * STATE
 */
const state = {
    users: [],
    usersMeta: {},
    allUsers: [],
    search: '',
};

/**
 * GETTERS
 */
const getters = {
    // eslint-disable-next-line
    users: state => state.users,
    usersMeta: state => state.usersMeta,
    allUsers: state => state.allUsers,
    search: state => state.search,
};

/**
 * ACTIONS
 * @type {{login({commit: *}, *=): void}}
 */
const actions = {
    fetchUsers({commit}, page = 1) {
        return axios.get(`users?page=${page}`)
            .then(response => {
                commit(types.FETCH_USERS, response.data)
            }, error => {
                console.log(error);
            });
    },
    allUsers({commit}) {
        return axios.get(`users/all`)
            .then(response => {
                commit(types.ALL_USERS, response.data)
            }, error => {
                console.log(error);
            });
    },
    createUser({context}, user) {
        return new Promise((resolve, reject) => {
            axios.post('users', user).then((response) => {
                resolve(response);
            }, (error) => {
                resolve(error);
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
    },
    changePassword({context}, data) {
        return new Promise((resolve, reject) => {
            axios.put(`users/${data.id}/password`, data).then((response) => {
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
    [types.CREATE_USER](user) {
        return new Promise((resolve, reject) => {
            axios.get(`users?page=${page}`).then((response) => {
                console.log(response);
                state.users = response;
                resolve(response);
            }, (error) => {
                reject(error);
            });
        });
    },
    [types.FETCH_USERS](state, data) {
        state.users = data.data;
        state.usersMeta = data.meta;
    },
    [types.ALL_USERS](state, data) {
        state.allUsers = data.data;
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
