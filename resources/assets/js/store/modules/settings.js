import * as types from '../mutation-types';


/**
 * STATE
 */
const state = {
    settings: {},
};

/**
 * GETTERS
 */
const getters = {
    // eslint-disable-next-line
    settings: state => state.settings,
};

/**
 * ACTIONS
 * @type {{login({commit: *}, *=): void}}
 */
const actions = {
    fetchSettings({commit}) {
        return axios.get(`settings`)
            .then(response => {
                commit(types.FETCH_SETTINGS, response.data)
            }, error => {
                console.log(error);
            });
    },
    activateSetting({commit}, id) {
        return axios.put(`settings`, {id: id})
            .then(response => {
                // commit(types.FETCH_SETTINGS, response.data)
            }, error => {
                console.log(error);
            });
    },
    deleteSetting({commit}, id) {
        return axios.delete(`settings/${id}`)
            .then(response => {
                // commit(types.FETCH_SETTINGS, response.data)
            }, error => {
                console.log(error);
            });
    },
    createProgram({commit}, data) {
        return axios.post(`settings/`, data)
            .then(response => {
                return true;
            }, error => {
                return false;
            });
    },
    getProgram({commit}, id) {
        return new Promise((resolve, reject) => {
            axios.get(`settings/${id}`).then((response) => {
                resolve(response);
            }, (error) => {
                reject(error)
            });
        })
    },
    editProgram({commit}, payload) {
        console.log(payload)
        return new Promise((resolve, reject) => {
            axios.put(`settings/${payload.id}`, payload.payload).then((response) => {
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
    [types.FETCH_SETTINGS](state, data) {
        state.settings = data.data;
    },
    [types.CREATE_PROGRAM](state, data) {

    }
};

export default {
    state,
    getters,
    actions,
    mutations,
};
