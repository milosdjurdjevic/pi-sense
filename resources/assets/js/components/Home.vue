<template>
    <div>
        <h1>Dashboard</h1>
        <p>Current temperature: {{ temperature }}°C</p>
        <p>Current humidity: {{ humidity }}%</p>
        <p>Heating status:
            <md-switch v-model="heatingStatus" class="md-primary"
                       @change="handleCheckbox($event)"
                       :disabled="sending"
            >Primary</md-switch>
            <span v-if="heatingStatus === 1">ON</span>
            <span v-else-if="heatingStatus === 0">OFF</span>
        </p>
    </div>
</template>

<script>
    export default {
        name: 'home',
        data() {
            return {
                heatingStatus: false,
                sending: false,
            }
        },
        computed: {
            temperature() {
                return this.$store.getters.temperature
            },
            humidity() {
                return this.$store.getters.humidity
            }
        },
        created() {
            if (this.$store.getters.temperature === null) {
                this.initial();
            }
        },
        methods: {
            initial() {
                this.$emit('loading-start');

                axios.get(`fire`)
                    .then(response => {
                        this.$emit('loading-done');
                    }, error => {
                        console.log(error);
                    });
            },
            handleCheckbox() {

            }
        },
    };
</script>

<style scoped>

</style>
