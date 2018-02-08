import { omit } from 'lodash';
import localStorage from 'store';
import * as types from '../mutation-types';
// import api from '../../api';

/**
 * STATE
 */
const state = {
  user: localStorage.get('user') || '',
  token: localStorage.get('token') || '',
};

/**
 * GETTERS
 */
const getters = {
  authUser: state => state.user,
  authToken: state => state.token,
};

/**
 * ACTIONS
 */
const actions = {
  login({ commit }, user) {
    return new Promise((resolve, reject) => {
      api.post('users', user).then((response) => {
        console.log(response);
        // commit(types.LOGIN, user);
        // resolve(response);
      }, (error) => {
        reject(error);
      });
    });
  },
  logout({ commit }) {
    commit(types.LOGOUT);
  },
};

/**
 * MUTATIONS
 */
const mutations = {
  // eslint-disable-next-line
  [types.LOGIN](state, user) {
    state.token = user.api_token;
    state.user = omit(user, ['api_token']);

    localStorage.set('token', state.token);
    localStorage.set('user', state.user);
  },
  [types.LOGOUT]() {
    state.token = '';
    state.user = {};

    localStorage.remove('token');
    localStorage.remove('user');
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
