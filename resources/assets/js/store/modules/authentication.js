import { omit } from 'lodash';
import localStorage from 'store';
import * as types from '../mutation-types';
// import api from '../../api';

/**
 * STATE
 */
const state = {
  // user: localStorage.get('user') || '',
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
  login({ commit }, response) {
    commit(types.LOGIN, response);
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
  [types.LOGIN](state, data) {
    state.token = data.access_token;
    // state.user = data.user[0];

    localStorage.set('token', state.token);
    // localStorage.set('user', state.user);
  },
  [types.LOGOUT]() {
    state.token = '';
    // state.user = {};

    localStorage.remove('token');
    // localStorage.remove('user');
  },
};

export default {
  state,
  getters,
  actions,
  mutations,
};
