import Vue from 'vue';
import Vuex from 'vuex';

import createLogger from 'vuex/dist/logger';

import authentication from './modules/authentication';
import users from './modules/users';
import settings from './modules/settings';
import readings from './modules/readings';
import stats from './modules/stats';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        authentication,
        users,
        settings,
        readings,
        stats,
    },
    // plugins: [createLogger({
    //     collapsed: true,
    // })],
});
