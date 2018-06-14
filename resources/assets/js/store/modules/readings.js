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
    heatingStatus: false,
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
    heatingStatus: state => state.heatingStatus,
};

/**
 * ACTIONS
 * @type {{login({commit: *}, *=): void}}
 */
const actions = {
    readings({commit}, data) {
        commit(types.READINGS, data)
    }
};

/**
 * MUTATIONS
 */
const mutations = {
    [types.READINGS](state, data) {
        let d = new Date();

        if (state.chartTemperature.length === 10)
            state.chartTemperature.shift();
        state.chartTemperature.push(data.temperature);

        if (state.chartHumidity.length === 10)
            state.chartHumidity.shift();
        state.chartHumidity.push(data.humidity);

        if (state.xLabels.length === 10)
            state.xLabels.shift();
        state.xLabels.push(`${d.getHours()}:${d.getMinutes()}`);

        state.temperature = data.temperature;
        state.humidity = data.humidity;
        state.heatingStatus = data.heatingStatus;

        state.chartData = {
            labels: state.xLabels,
            datasets: [
                {
                    label: 'Temperature',
                    backgroundColor: '#ff5252',
                    data: state.chartTemperature
                }, {
                    label: 'Humidity',
                    backgroundColor: '#448aff',
                    data: state.chartHumidity
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
