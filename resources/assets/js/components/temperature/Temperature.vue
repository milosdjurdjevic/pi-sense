<template>
    <div>
        <h1>Temperature</h1>
        <p>Current temperature: {{ temperature }}°C</p>
        <p>Current humidity: {{ humidity }}%</p>
        <chart
            :chart-data="chartData"
            :options="{responsive: true, maintainAspectRatio: false}"
            :height="250"
        ></chart>

        <p>Last 24 hours stats:</p>
        <chart
            :chart-data="statsData"
            :options="{responsive: true, maintainAspectRatio: false}"
            :height="250"
        ></chart>
    </div>
</template>

<script>
    import Chart from './Chart';

    const io = require('socket.io-client');
    const host = window.location.host.split(':')[0];

    const socket = io('//' + host);

    export default {
        name: 'temperature',
        components: {
            Chart
        },
        data() {
            return {
        //         chartData: this.$store.getters.chartData ? this.$store.getters.chartData : null,
        //         chartTemperature: this.$store.getters.chartTemperature ? this.$store.getters.chartTemperature : null,
        //         chartHumidity: this.$store.getters.chartHumidity ? this.$store.getters.chartHumidity : null,
        //         xLabels: null,
        //         temperature: this.$store.getters.temperature ? this.$store.getters.temperature : null,
        //         humidity: this.$store.getters.humidity ? this.$store.getters.humidity : null,
                statsData: null,
                statsTemperature: [],
                statsHumidity: [],
                statsLabels: [],
            }
        },
        computed: {
            chartData() {
                return this.$store.getters.chartData
            },
            chartTemperature() {
                return this.$store.getters.chartTemperature
            },
            chartHumidity() {
                return this.$store.getters.chartHumidity
            },
            temperature() {
                return this.$store.getters.temperature
            },
            humidity() {
                return this.$store.getters.humidity
            }
        },
        mounted() {
            if (this.$store.getters.temperature === null) {
                this.initialFill();
            }
            this.stats();

            socket.on('connect', () => {
                console.log('connected');
                socket.on('reading', (data) => {
                    this.$store.dispatch('readings', data).then(() => {
                        // Draw chart
                        this.fillData();
                    }, (error) => {
                        console.log(error)
                    });


                });

                socket.on('err', (data) => {
                    console.log(`Fatal error ${JSON.stringify(data)}`);
                });

                socket.on('stderr', (data) => {
                    console.log(`Reading error ${data}`);
                });
            });
        },
        methods: {
            fillData () {
                console.log('filling data');
                // this.chartTemperature = this.$store.getters.chartTemperature;
                // this.chartHumidity = this.$store.getters.chartHumidity;
                // this.chartData = this.$store.getters.chartData;
                // this.temperature = this.$store.getters.temperature;
                // this.humidity = this.$store.getters.humidity;
            },
            initialFill () {
                this.$emit('loading-start');

                axios.get(`fire`)
                    .then(response => {
                        this.$emit('loading-done');
                    }, error => {
                        console.log(error);
                    });
            },
            stats() {
                axios.get('stats')
                    .then(response => {
                        _.forIn(response.data.data, (res) => {
                            let date = new Date(res.created_at);

                            this.statsLabels.push(`${date.getHours()}:${date.getMinutes()}`);
                            this.statsTemperature.push(res.temperature)
                            this.statsHumidity.push(res.humidity)
                        });

                        this.statsData = {
                            labels: this.statsLabels,
                            datasets: [
                                {
                                    label: 'Temperature',
                                    backgroundColor: '#ff5252',
                                    data: this.statsTemperature
                                }, {
                                    label: 'Humidity',
                                    backgroundColor: '#448aff',
                                    data: this.statsHumidity
                                }
                            ]
                        };
                    }, error => {
                        console.log(error);
                    });
            }
        },
    }
</script>

<style scoped>

</style>