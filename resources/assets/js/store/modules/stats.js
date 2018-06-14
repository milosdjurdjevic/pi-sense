import * as types from '../mutation-types';


/**
 * STATE
 */
const state = {
    statsData: null,
    statsTemperature: [],
    statsHumidity: [],
    statsLabels: [],
};

/**
 * GETTERS
 */
const getters = {
    statsData: state => state.statsData,
    statsTemperature: state => state.statsTemperature,
    statsHumidity: state => state.statsHumidity,
    statsLabels: state => state.statsLabels,
};

/**
 * ACTIONS
 * @type {{login({commit: *}, *=): void}}
 */
const actions = {
    fetchStats({commit}) {
        return axios.get(`stats`)
            .then(response => {
                commit(types.FETCH_STATS, response.data.data)
            }, error => {
                console.log(error);
            });
    },
};

/**
 * MUTATIONS
 */
const mutations = {
    [types.FETCH_STATS](state, data) {

        _.forIn(data, (value) => {
            let d =new Date(value.created_at);

            state.statsTemperature.push(value.temperature);
            state.statsHumidity.push(value.humidity);
            state.statsLabels.push(`${d.getHours()}:${d.getMinutes()}`);

        });

        state.statsData = {
            labels: state.statsLabels,
            datasets: [
                {
                    label: 'Temperature',
                    backgroundColor: '#ff5252',
                    data: state.statsTemperature
                }, {
                    label: 'Humidity',
                    backgroundColor: '#448aff',
                    data: state.statsHumidity
                }
            ]
        };
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
};
