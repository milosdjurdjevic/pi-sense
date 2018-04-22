import * as types from '../mutation-types';


/**
 * STATE
 */
const state = {
    readings: [],
    chartData: null,
    chartTemperature: [],
    chartHumidity: [],
    xLabels: [],
    temperature: null,
    humidity: null,
};

/**
 * GETTERS
 */
const getters = {
    readings: state => state.readings,
    chartData: state => state.chartData,
    chartTemperature: state => state.chartTemperature,
    chartHumidity: state => state.chartHumidity,
    xLabels: state => state.xLabels,
    temperature: state => state.temperature,
    humidity: state => state.humidity,
};

/**
 * ACTIONS
 * @type {{login({commit: *}, *=): void}}
 */
const actions = {
    fetchReadings({commit}) {
        return axios.get(`settings`)
            .then(response => {
                commit(types.FETCH_READINGS, response.data)
            }, error => {
                console.log(error);
            });
    },
    readings({commit}, data) {
        commit(types.READINGS, data)
    }
};

/**
 * MUTATIONS
 */
const mutations = {
    [types.FETCH_READINGS](state, data) {
        state.settings = data.data;
    },
    [types.READINGS](state, data) {
        let reading = JSON.parse(data);
        let d =new Date();

        if (state.chartTemperature.length === 10)
            state.chartTemperature.shift();
        state.chartTemperature.push(reading.temperature);

        if (state.chartHumidity.length === 10)
            state.chartHumidity.shift();
        state.chartHumidity.push(reading.humidity);

        if (state.xLabels.length === 10)
            state.xLabels.shift();
        state.xLabels.push(`${d.getHours()}:${d.getMinutes()}`);

        state.temperature = reading.temperature;
        state.humidity = reading.humidity;
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
};
