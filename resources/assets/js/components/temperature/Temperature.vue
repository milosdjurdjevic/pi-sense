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

    export default {
        name: 'temperature',
        components: {
            Chart
        },
        data() {
            return {

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
            },
            statsData() {
                return this.$store.getters.statsData
            },
        },
        mounted() {
            if (_.isEmpty(this.statsData))
                this.stats();
        },
        methods: {
            stats() {
                this.$emit('loading-start');
                this.$store.dispatch('fetchStats').then(() => {

                    this.$emit('loading-done');
                })
            }
        },
    }
</script>

<style scoped>

</style>