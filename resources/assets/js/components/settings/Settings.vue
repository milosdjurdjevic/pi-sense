<template>
    <div>
        <md-toolbar class="md-transparent">
            <h3 class="md-title">Settings</h3>
            <div class="md-toolbar-section-end">
                <router-link tag="span" class="" to="/add-program">
                    <a class="btn-floating waves-effect waves-light blue">
                        <!--<md-icon>add</md-icon>-->
                        <span class="page">Add Program</span>
                    </a>
                </router-link>
            </div>
        </md-toolbar>

        <br>

        <md-card v-for="setting in settings.settings" :key="setting.id" :class="setting.is_active === 1 ? 'md-primary' : ''">
            <md-card-header>
                <md-card-header-text>
                    <div class="md-title">{{ setting.name }}</div>
                </md-card-header-text>

                <md-menu v-if="setting.is_active === 0" md-size="big" md-direction="bottom-end">
                    <md-button class="md-icon-button" md-menu-trigger>
                        <md-icon>more_vert</md-icon>
                    </md-button>
                    <md-menu-content>
                        <md-menu-item @click="activateSetting(setting.id)">
                            <span>Activate</span>
                            <md-icon>airplanemode_active</md-icon>
                        </md-menu-item>
                        <md-menu-item @click="deleteSetting(setting.id)">
                            <span>Delete</span>
                            <md-icon>delete</md-icon>
                        </md-menu-item>
                    </md-menu-content>
                </md-menu>
            </md-card-header>

            <md-card-content>
                <p>Min temperature: {{ setting.min_temperature }} &#8451</p>
                <p>Max temperature: {{ setting.max_temperature }} &#8451</p>
                <p>Temperature tolerance: {{ setting.temperature_tolerance }} &#8451</p>
                <p>Humidity tolerance: {{ setting.humidity_tolerance }}%</p>
            </md-card-content>
        </md-card>

    </div>
</template>

<script>
    import { mapState } from 'vuex'
    export default {
        name: "settings",
        // data() {
        //     return {
        //         settings: this.$store.getters.settings,
        //     };
        // },
        computed: mapState([
            // map this.count to store.state.count
            'settings'
        ]),
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
            activateSetting(id) {
                this.$emit('loading-start');

                this.$store.dispatch('activateSetting', id).then(() => {
                    this.loadData();
                    this.$emit('loading-done');
                }, () => {
                    this.settings = [];
                });
            },
            deleteSetting(id) {
                this.$emit('loading-start');

                this.$store.dispatch('deleteSetting', id).then(() => {
                    this.loadData();
                    this.$emit('loading-done');
                }, () => {
                    this.settings = [];
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "~vue-material/dist/theme/engine";

    @include md-register-theme("green-card", (
    primary: md-get-palette-color(green, 500)
    ));

    @include md-register-theme("black-card", (
    primary: md-get-palette-color(black, 500)
    ));

    @include md-register-theme("purple-card", (
    primary: md-get-palette-color(purple, 500)
    ));

    @include md-register-theme("orange-card", (
    primary: md-get-palette-color(orange, 500)
    ));

    @import "~vue-material/dist/base/theme";
    @import "~vue-material/dist/components/MdCard/theme";

    .md-card {
        width: 390px;
        margin: 4px;
        display: inline-block;
        vertical-align: top;
    }

    .md-card-example .md-subhead .md-icon {
        width: 16px;
        min-width: 16px;
        height: 16px;
        font-size: 16px !important;
    }

    .md-card-example .md-subhead span {
        vertical-align: middle;
    }

    .md-card-example .card-reservation {
        margin-top: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .md-card-example .card-reservation .md-icon {
        margin: 8px;
    }

    .md-card-example .md-button-group {
        display: flex;
    }

    .md-card-example .md-button-group .md-button {
        min-width: 60px;
        border-radius: 2px;
    }

</style>