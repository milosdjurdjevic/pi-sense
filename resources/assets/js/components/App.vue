<template>
    <div class="page-container">
        <md-progress-bar v-if="loading" md-mode="indeterminate" class="md-accent"></md-progress-bar>
        <md-app md-mode="reveal">

            <md-app-toolbar class="md-primary">
                <span class="md-title">Pi Sense</span>

                <div v-if="authenticated" class="md-toolbar-section-end">
                    <md-menu md-size="medium" md-align-trigger>
                        <md-button md-menu-trigger class="md-icon-button">
                            <md-icon>more_vert</md-icon>
                        </md-button>
                        <md-menu-content>
                            <md-menu-item>
                                <router-link tag="span" class="md-list-item-text" to="/logout">
                                    Logout
                                </router-link>
                            </md-menu-item>
                        </md-menu-content>
                    </md-menu>
                </div>
            </md-app-toolbar>

            <md-app-drawer v-if="authenticated" md-permanent="clipped">
                <md-list>
                    <md-list-item>
                        <md-icon>dashboard</md-icon>
                        <router-link tag="span" class="md-list-item-text" to="/">Dashboard
                        </router-link>
                    </md-list-item>

                    <md-list-item>
                        <md-icon>wb_sunny</md-icon>
                        <router-link tag="span" class="md-list-item-text" to="/temperature">
                            Temperature
                        </router-link>
                    </md-list-item>

                    <md-list-item>
                        <md-icon>people</md-icon>
                        <router-link tag="span" class="md-list-item-text" to="/users">Users
                        </router-link>
                    </md-list-item>

                    <md-list-item>
                        <md-icon>settings</md-icon>
                        <router-link tag="span" class="md-list-item-text" to="/settings">
                            Settings
                        </router-link>
                    </md-list-item>
                </md-list>
            </md-app-drawer>

            <md-app-content>
                <router-view @loading-done="loadingDone" @loading-start="loadingStart"></router-view>
            </md-app-content>
        </md-app>
    </div>
</template>

<script>
    import Vue from 'vue'
    import VueMaterial from 'vue-material'

    import 'vue-material/dist/vue-material.min.css'
    import 'vue-material/dist/theme/default.css'

    const io = require('socket.io-client');
    const host = window.location.host.split(':')[0];

    const socket = io('//' + host);

    Vue.use(VueMaterial);

    export default {
        name: 'app',
        data: () => ({
            loading: false,
            authenticated: localStorage.getItem('token'),
        }),
        mounted() {
            if (this.$store.getters.temperature === null && this.$route.path !== '/login') {
                this.initialFill();
            }

            socket.on('connect', () => {
                console.log('connected');
                socket.on('reading', (data) => {
                    this.$store.dispatch('readings', data).then(() => {
                        // Draw chart
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
            loadingStart() {
                this.loading = true;
            },
            loadingDone() {
                this.loading = false;
            },
            initialFill() {
                this.loadingStart();

                axios.get(`fire`)
                    .then(response => {
                        this.loadingDone();
                    }, error => {
                        console.log(error);
                    });
            }
        }
    }
</script>

<style scoped>
    .md-progress-bar {
        /*position: absolute;*/
        /*top: 100px;*/
        /*z-index: 999;*/
    }

    .md-drawer {
        width: 240px;
        min-height: 900px;
    }

    .md-list-item {
        cursor: pointer;
    }

    .router-link-exact-active {
        color: blue;
    }
</style>