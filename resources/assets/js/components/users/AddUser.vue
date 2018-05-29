<template>
    <div class="row">
        <md-toolbar class="md-transparent">
            <h3 class="md-title">Add User</h3>
            <div class="md-toolbar-section-end">
                <router-link tag="span" class="" to="/users">
                    <a class="btn-floating waves-effect waves-light blue">
                        <!--<md-icon>add</md-icon>-->
                        <span class="page">Back To Users</span>
                    </a>
                </router-link>
            </div>
        </md-toolbar>
        <form novalidate class="md-layout md-alignment-top-center" @submit.prevent="validateUser">
            <md-card class="md-layout-item">

                <md-card-content>
                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('firstName')">
                                <label for="first-name">First Name</label>
                                <md-input name="first-name" id="first-name" autocomplete="given-name"
                                          v-model="form.firstName" :disabled="sending"/>
                                <span class="md-error"
                                      v-if="!$v.form.firstName.required">The first name is required</span>
                                <span class="md-error"
                                      v-else-if="!$v.form.firstName.minlength">Invalid first name</span>
                            </md-field>
                        </div>

                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('lastName')">
                                <label for="last-name">Last Name</label>
                                <md-input name="last-name" id="last-name" autocomplete="family-name"
                                          v-model="form.lastName" :disabled="sending"/>
                                <span class="md-error"
                                      v-if="!$v.form.lastName.required">The last name is required</span>
                                <span class="md-error" v-else-if="!$v.form.lastName.minlength">Invalid last name</span>
                            </md-field>
                        </div>
                    </div>

                    <md-field :class="getValidationClass('email')">
                        <label for="email">Email</label>
                        <md-input type="email" name="email" id="email" autocomplete="email" v-model="form.email"
                                  :disabled="sending"/>
                        <span class="md-error" v-if="!$v.form.email.required">The email is required</span>
                        <span class="md-error" v-else-if="!$v.form.email.email">Invalid email</span>
                    </md-field>

                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('password')">
                                <label for="password">Password</label>
                                <md-input type="password" name="password" id="password" autocomplete="password"
                                          v-model="form.password" :disabled="sending"/>
                                <span class="md-error"
                                      v-if="!$v.form.password.required">The password is required</span>
                                <span class="md-error" v-else-if="!$v.form.password.minlength">Invalid password</span>
                            </md-field>
                        </div>

                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClass('passwordConfirmation')">
                                <label for="passwordConfirmation">Confirm Password</label>
                                <md-input type="password" id="passwordConfirmation" name="passwordConfirmation" autocomplete="passwordConfirmation" v-model="form.passwordConfirmation"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.form.passwordConfirmation.sameAsPassword">The confirm password does not match password</span>
                            </md-field>
                        </div>
                    </div>

                </md-card-content>

                <!--<md-progress-bar md-mode="indeterminate" v-if="sending"/>-->

                <md-card-actions>
                    <md-button type="submit" class="md-primary md-raised" :disabled="sending">Create user</md-button>
                </md-card-actions>
            </md-card>

            <md-snackbar :md-active.sync="userSaved">The user {{ lastUser }} was saved with success!</md-snackbar>
        </form>

    </div>
</template>

<script>
    import {validationMixin} from 'vuelidate'
    import {
        required,
        email,
        minLength,
        sameAs
    } from 'vuelidate/lib/validators'

    export default {
        name: 'add-user',
        mixins: [validationMixin],
        data: () => ({
            form: {
                firstName: '',
                lastName: '',
                email: '',
                password: '',
                passwordConfirmation: '',
            },
            userSaved: false,
            sending: false,
            lastUser: null
        }),
        validations: {
            form: {
                firstName: {
                    required,
                    minLength: minLength(3)
                },
                lastName: {
                    required,
                    minLength: minLength(3)
                },
                email: {
                    required,
                    email
                },
                password: {
                    required,
                    minLength: minLength(6)
                },
                passwordConfirmation: {
                    sameAsPassword: sameAs('password')
                }
            }
        },
        methods: {
            createUser() {
                this.$emit('loading-start');
                this.sending = true;


                this.$store.dispatch('createUser', this.form).then(() => {
                    this.lastUser = `${this.form.firstName} ${this.form.lastName}`;
                    this.userSaved = true;
                    this.sending = false;
                    this.clearForm();

                    this.$emit('loading-done');
                }, (error) => {
                    // let errors = JSON.parse(error.message);
                    console.log(error);
                });
            },
            getValidationClass (fieldName) {
                const field = this.$v.form[fieldName];

                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty
                    }
                }
            },
            clearForm () {
                this.$v.$reset()
                this.form.firstName = null
                this.form.lastName = null
                this.form.email = null
                this.form.password = null
                this.form.passwordConfirmation = null
            },
            validateUser () {
                this.$v.$touch()

                if (!this.$v.$invalid) {
                    this.createUser()
                }
            }
        },
    };
</script>

<style lang="scss" scoped>
    .md-progress-bar {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
    }
</style>
