<script>
    import { Line, mixins } from 'vue-chartjs'
    const { reactiveProp } = mixins

    export default {
        name: "chart",
        extends: Line,
        mixins: [reactiveProp],
        props: ['options'],
        mounted() {
            this.renderChart(this.chartData, this.options)
        },
        methods: {

        },
    }
</script>

<style scoped>

</style>