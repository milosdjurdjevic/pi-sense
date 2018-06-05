<template>
    <div class="row">
        <md-toolbar class="md-transparent">
            <h3 class="md-title">Edit Program</h3>
            <div class="md-toolbar-section-end">
                <router-link tag="span" class="" to="/users">
                    <a class="btn-floating waves-effect waves-light blue">
                        <!--<md-icon>add</md-icon>-->
                        <span class="page">Back To Programs</span>
                    </a>
                </router-link>
            </div>
        </md-toolbar>
        <form novalidate class="md-layout md-alignment-top-center" @submit.prevent="validateProgram">
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
                                <md-input type="number" id="min_temperature" name="min_temperature"
                                          autocomplete="min_temperature" v-model="form.min_temperature"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.form.min_temperature.required">The minimum temperature is required</span>
                            </md-field>
                        </div>
                    </div>

                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('max_temperature')">
                                <label for="max_temperature">Maximum Temperature</label>
                                <md-input type="number" name="max_temperature" id="max_temperature"
                                          autocomplete="max_temperature" v-model="form.max_temperature"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.form.max_temperature.required">The maximum temperature is required</span>
                            </md-field>
                        </div>

                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('temperature_tolerance')">
                                <label for="min_temperature">Temperature Tolerance</label>
                                <md-input type="number" id="temperature_tolerance" name="temperature_tolerance"
                                          autocomplete="temperature_tolerance" v-model="form.temperature_tolerance"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.form.temperature_tolerance.required">The temperature tolerance is required</span>
                            </md-field>
                        </div>
                    </div>

                </md-card-content>

                <!--<md-progress-bar md-mode="indeterminate" v-if="sending"/>-->

                <md-card-actions>
                    <md-button type="submit" class="md-primary md-raised" :disabled="sending">Update user</md-button>
                </md-card-actions>
            </md-card>

            <md-snackbar :md-active.sync="programSaved">The user {{ lastProgram }} was saved with success!</md-snackbar>
        </form>

        <br><br>

    </div>
</template>

<script>
    import {validationMixin} from 'vuelidate'
    import {
        required,
        minLength,
    } from 'vuelidate/lib/validators'

    export default {
        name: "edit-program",
        mixins: [validationMixin],
        data: () => ({
            form: {
                name: '',
                min_temperature: null,
                max_temperature: null,
                temperature_tolerance: null,
            },
            programSaved: false,
            sending: false,
            lastProgram: null
        }),
        created() {
            // Get user
            this.getProgram(this.$route.params.id);
        },
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
                temperature_tolerance: {
                    required,
                },
            }
        },
        methods: {
            editProgram() {
                this.$emit('loading-start');
                this.sending = true;


                this.$store.dispatch('editProgram', this.form).then(() => {
                    alert('success')
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
            getProgram(id) {
                this.$emit('loading-start');

                this.$store.dispatch('getProgram', id).then((response) => {

                    this.form.name = response.data.data.name;
                    this.form.min_temperature = response.data.data.min_temperature;
                    this.form.max_temperature = response.data.data.max_temperature;
                    this.form.temperature_tolerance = response.data.data.temperature_tolerance;

                    this.$emit('loading-done')
                }, (error) => {
                    alert('Error');
                    // this.$toasted.show(JSON.parse(error.body.error.message).firstName, {duration: 3000});
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
            },
            validateProgram() {
                this.$v.$touch()

                if (!this.$v.$invalid) {
                    this.editProgram()
                }
            }
        }
    }
</script>

<style scoped>

</style>