import Vue from 'vue';
import Vuex from 'vuex';
import createLogger from 'vuex/dist/logger';
import authentication from './modules/authentication';
// import users from './modules/users';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    authentication,
    // users,
  },
  plugins: [createLogger({
    collapsed: false,
  })],
});
