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
    </div>
</template>

<script>
    import Chart from './Chart';

    const io = require('socket.io-client');
    const host = window.location.host.split(':')[0];

    const socket = io('//' + host);
    console.log(socket);
    export default {
        name: 'temperature',
        components: {
            Chart
        },
        data() {
            return {
                chartData: this.$store.getters.chartData,
                chartTemperature: this.$store.getters.chartTemperature,
                chartHumidity: this.$store.getters.chartHumidity,
                xLabels: this.$store.getters.xLabels,
                temperature: this.$store.getters.temperature,
                humidity: this.$store.getters.humidity,
            }
        },
        mounted() {
            this.initialFill();

            socket.on('connect', () => {
                console.log('connected');
                socket.on('reading', (data) => {
                    console.log(data);

                    this.$store.dispatch('readings', data).then(() => {
                        // Draw chart
                        this.fillData();
                        console.log('readings')
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
                this.chartData = {
                    labels: this.xLabels,
                    datasets: [
                        {
                            label: 'Reading',
                            backgroundColor: '#ff5252',
                            data: this.chartTemperature
                        }, {
                            label: 'Humidity',
                            backgroundColor: '#448aff',
                            data: this.chartHumidity
                        }
                    ]
                }
            },
            initialFill () {
                // TODO:  Send request to node server to get readings for initial drawing of the chart
            }
        },
    }
</script>

<style scoped>

</style>