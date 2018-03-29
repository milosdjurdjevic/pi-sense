<template>
    <div>
        <h1>Temperature</h1>
    </div>
</template>

<script>
    const socket = io('127.0.0.1:3000', {secure: true});

    export default {
        name: 'temperature',
        mounted() {
            // socket.on('connect', function () {
            //     console.log('Connected to server')
            // });
            //
            // socket.on('reading', (data) => {
            //     console.log(`Temperature is : ${data}`);
            // })
            this.loadData();
        },
        methods: {
            loadData() {

                console.log(socket);

                socket.on('connect', function () {
                    console.log('Connected to server')
                });

                socket.on('reading', (data) => {
                    console.log(`Temperature is : ${data}`);
                })
            },
        },
    }
</script>

<style scoped>

</style>