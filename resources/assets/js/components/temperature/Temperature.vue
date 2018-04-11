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
                chartData: null,
                chartTemperature: [],
                chartHumidity: [],
                xLabels: [],
                temperature: null,
                humidity: null,
            }
        },
        mounted() {
            this.initialFill();

            socket.on('connect', () => {
                console.log('connected');
                socket.on('reading', (data) => {
                    console.log(data);

                    let reading = JSON.parse(data);
                    let d =new Date();

                    if (this.chartTemperature.length === 10)
                        this.chartTemperature.shift();
                    this.chartTemperature.push(reading.temperature);

                    if (this.chartHumidity.length === 10)
                        this.chartHumidity.shift();
                    this.chartHumidity.push(reading.humidity);

                    if (this.xLabels.length === 10)
                        this.xLabels.shift();
                    this.xLabels.push(`${d.getHours()}:${d.getMinutes()}`);

                    this.temperature = reading.temperature;
                    this.humidity = reading.humidity;

                    // Draw chart
                    this.fillData();
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
                this.chartData = {
                    labels: this.xLabels,
                    datasets: [
                        {
                            label: 'Temperature',
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