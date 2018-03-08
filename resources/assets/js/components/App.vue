<template>
    <div class="page-container">
        <md-app md-mode="reveal">

            <md-app-toolbar class="md-primary">
                <span class="md-title">Pi Sense</span>

                <div class="md-toolbar-section-end">
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

            <md-app-drawer md-permanent="clipped">
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
                <router-view></router-view>
            </md-app-content>
        </md-app>
    </div>
</template>

<script>
    import Vue from 'vue'
    import VueMaterial from 'vue-material'

    import 'vue-material/dist/vue-material.min.css'
    import 'vue-material/dist/theme/default.css'

    Vue.use(VueMaterial);

    export default {
        name: 'app',
        data: () => ({
            menuVisible: false
        }),
    }
</script>

<style scoped>
    .md-app {
        /*min-height: 1000px;*/
        /*max-height: 400px;*/
    }

    .md-drawer {
        width: 230px;
        max-width: calc(100vw - 125px);
    }

    .md-list-item {
        cursor: pointer;
    }

    .router-link-exact-active {
        color: blue;
    }
</style>