<template>
    <div>
        <h1>Dashboard</h1>
        <div class="item">
            <p>Current temperature: {{ temperature }}°C</p>
            <p>Current humidity: {{ humidity }}%</p>
            <p>Heating status:
                <span v-if="heatingStatus === 1">ON</span>
                <span v-else-if="heatingStatus === 0">OFF</span>
            </p>
        </div>

        <div class="item" v-for="item in settings" :key="item.id" v-if="item.is_active === 1">
            <h2>Active setting</h2>
            <p>Minimum temperature: {{ item.min_temperature }}°C</p>
            <p>Maximum temprature: {{ item.max_temperature }}%°C</p>
            <p>Optimal humidity: {{ item.optimal_humidity }}%°C</p>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'home',
        data() {
            return {
                // heatingStatus: false,
                sending: false,
            }
        },
        computed: {
            temperature() {
                return this.$store.getters.temperature
            },
            humidity() {
                return this.$store.getters.humidity
            },
            heatingStatus() {
                return this.$store.getters.heatingStatus
            },
            settings() {
                return this.$store.getters.settings
            }
        },
        created() {
            // Get settings
            if (_.isEmpty(this.$store.getters.settings)) {
                this.loadData();
            }
        },
        methods: {
            loadData() {
                this.$emit('loading-start');

                this.$store.dispatch('fetchSettings').then(() => {
                    // this.settings = this.$store.getters.settings;

                    this.$emit('loading-done');
                }, () => {
                    this.settings = [];
                });
            },
        }
    };
</script>

<style scoped>

</style>
