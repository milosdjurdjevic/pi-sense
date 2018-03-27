<template>
    <div>
        <h1>Temperature</h1>
    </div>
</template>

<script>
    const socket = io().connect('http://localhost:3000');

    export default {
        name: 'temperature',
        mounted() {
            this.loadData();
        },
        methods: {
            loadData() {
                socket.on('read.temp', (data) => {
                    console.log(`Temperature is : ${data}`);
                })
            },
        },
    }
</script>

<style scoped>

</style>