<template>
    <div class="row">
        <md-toolbar class="md-transparent">
            <h3 class="md-title">Add Program</h3>
            <div class="md-toolbar-section-end">
                <router-link tag="span" class="" to="/settings">
                    <a class="btn-floating waves-effect waves-light blue">
                        <!--<md-icon>add</md-icon>-->
                        <span class="page">Back To Settings</span>
                    </a>
                </router-link>
            </div>
        </md-toolbar>

        <form novalidate class="md-layout md-alignment-top-center" @submit.prevent="validateUser">
            <md-card class="md-layout-item">

                <md-card-content>

                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('name')">
                                <label for="name">Name</label>
                                <md-input type="text" name="name" id="name" autocomplete="name" v-model="form.name"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.form.name.required">The name is required</span>
                                <span class="md-error" v-else-if="!$v.form.name.minLength">Invalid name</span>
                            </md-field>
                        </div>

                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('min_temperature')">
                                <label for="min_temperature">Minimum Temperature</label>
                                <md-input type="number" id="min_temperature" name="min_temperature" autocomplete="min_temperature" v-model="form.min_temperature" :disabled="sending" />
                                <span class="md-error" v-if="!$v.form.min_temperature.required">The age is required</span>
                            </md-field>
                        </div>
                    </div>

                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('max_temperature')">
                                <label for="max_temperature">Maximum Temperature</label>
                                <md-input type="number" name="max_temperature" id="max_temperature" autocomplete="max_temperature" v-model="form.max_temperature"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.form.max_temperature.required">required</span>
                            </md-field>
                        </div>

                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('optimal_humidity')">
                                <label for="min_temperature">Optimal Humidity</label>
                                <md-input type="number" id="optimal_humidity" name="optimal_humidity" autocomplete="optimal_humidity" v-model="form.optimal_humidity" :disabled="sending" />
                                <span class="md-error" v-if="!$v.form.optimal_humidity.required">The age is required</span>
                            </md-field>
                        </div>
                    </div>

                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('temperature_tolerance')">
                                <label for="max_temperature">Temperature Tolerance</label>
                                <md-input type="number" name="temperature_tolerance" id="temperature_tolerance" autocomplete="temperature_tolerance" v-model="form.temperature_tolerance"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.form.temperature_tolerance.required">required</span>
                            </md-field>
                        </div>

                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('humidity_tolerance')">
                                <label for="min_temperature">Optimal Humidity</label>
                                <md-input type="number" id="humidity_tolerance" name="humidity_tolerance" autocomplete="humidity_tolerance" v-model="form.humidity_tolerance" :disabled="sending" />
                                <span class="md-error" v-if="!$v.form.humidity_tolerance.required">required</span>
                            </md-field>
                        </div>
                    </div>

                </md-card-content>

                <!--<md-progress-bar md-mode="indeterminate" v-if="sending"/>-->

                <md-card-actions>
                    <md-button type="submit" class="md-primary md-raised" :disabled="sending">Create user</md-button>
                </md-card-actions>
            </md-card>

            <md-snackbar :md-active.sync="programSaved">The program {{ lastProgram }} was saved with success!</md-snackbar>
        </form>

    </div>
</template>

<script>
    import {validationMixin} from 'vuelidate'
    import {
        required,
        minLength,
    } from 'vuelidate/lib/validators'

    export default {
        name: "add-program",
        mixins: [validationMixin],
        data: () => ({
            form: {
                name: '',
                min_temperature: 0,
                max_temperature: 0,
                optimal_humidity: 0,
                temperature_tolerance: 0,
                humidity_tolerance: 0,
            },
            programSaved: false,
            sending: false,
            lastProgram: null
        }),
        validations: {
            form: {
                name: {
                    required,
                    minLength: minLength(3)
                },
                min_temperature: {
                    required,
                },
                max_temperature: {
                    required,
                },
                optimal_humidity: {
                    required,
                },
                temperature_tolerance: {
                    required,
                },
                humidity_tolerance: {
                    required,
                }
            }
        },
        methods: {
            createProgram() {
                this.$emit('loading-start');
                this.sending = true;


                this.$store.dispatch('createProgram', this.form).then(() => {
                    this.lastProgram = this.form.name;
                    this.programSaved = true;
                    this.sending = false;
                    this.clearForm();

                    this.$emit('loading-done');
                }, (error) => {
                    // let errors = JSON.parse(error.message);
                    console.log(error);
                });
            },
            getValidationClass(fieldName) {
                const field = this.$v.form[fieldName];

                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty
                    }
                }
            },
            clearForm() {
                this.$v.$reset()
                this.form.name = '';
                this.form.min_temperature = 0;
                this.form.max_temperature = 0;
                this.form.optimal_humidity = 0;
                this.form.temperature_tolerance = 0;
                this.form.humidity_tolerance = 0;
            },
            validateUser() {
                this.$v.$touch()

                if (!this.$v.$invalid) {
                    this.createProgram()
                }
            }
        }
    }
</script>

<style scoped>

</style>