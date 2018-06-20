<template>
    <div id="side-nav">
        <ul id="main-nav" class="side-nav">
            <router-link tag="li" class="pageLink" to="/">
                <a class="waves-effect">
                    <i class="fa fa-desktop"></i>
                    <span class="page">Dashboard</span>
                </a>
            </router-link>
            <router-link tag="li" class="pageLink" to="/temperature">
                <a class="waves-effect">
                    <i class="fa fa-desktop"></i>
                    <span class="page">Temperature</span>
                </a>
            </router-link>
            <router-link tag="li" class="pageLink" to="/users">
                <a class="waves-effect">
                    <i class="fa fa-desktop"></i>
                    <span class="page">Users</span>
                </a>
            </router-link>
            <router-link tag="li" class="pageLink" to="/settings">
                <a class="waves-effect">
                    <i class="fa fa-desktop"></i>
                    <span class="page">Settings</span>
                </a>
            </router-link>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'side-nav',
        data() {
            return {
                show: false,
            };
        },
    };
</script>

<style scoped>

</style>
