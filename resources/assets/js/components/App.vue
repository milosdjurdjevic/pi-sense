<template>
    <div id="app">
        <div id="outer-container">
            <top-bar></top-bar>
            <div class="columns">
                <div class="container">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TopBar from './partials/TopBar';

    export default {
        name: 'app',
        components: { TopBar },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
