<template>
    <div class="row">
        <div class="md-layout md-centered">
            <div class="md-layout-item">
                <form novalidate class="md-layout" @submit.prevent="validateUser">
                    <md-card class="md-layout-item md-centered md-small-size-100">
                        <md-card-header>
                            <div class="md-title">Login</div>
                        </md-card-header>

                        <md-card-content>
                            <div class="md-layout md-gutter">
                                <div class="md-layout-item">
                                    <md-field :class="getValidationClass('email')">
                                        <label for="email">Username</label>
                                        <md-input name="email" id="email" autocomplete="email"
                                                  v-model="form.email" :disabled="sending"/>
                                        <span class="md-error"
                                              v-if="!$v.form.email.required">The email is required</span>
                                        <span class="md-error" v-else-if="!$v.form.email.minlength">Invalid email</span>
                                    </md-field>
                                </div>
                            </div>

                            <div class="md-layout md-gutter">
                                <div class="md-layout-item md-small-size-100">
                                    <md-field :class="getValidationClass('password')">
                                        <label for="password">Password</label>
                                        <md-input type="password" name="password" id="password" autocomplete="password"
                                                  v-model="form.password" :disabled="sending"/>
                                        <span class="md-error"
                                              v-if="!$v.form.password.required">The password is required</span>
                                        <span class="md-error"
                                              v-else-if="!$v.form.password.minlength">Invalid password</span>
                                    </md-field>
                                </div>
                            </div>

                        </md-card-content>

                        <md-progress-bar md-mode="indeterminate" v-if="sending"/>

                        <md-card-actions>
                            <md-button type="submit" class="md-primary" :disabled="sending">Login</md-button>
                        </md-card-actions>
                    </md-card>

                    <md-snackbar :md-active.sync="failedLogin">Invalid credentials!</md-snackbar>

                </form>
            </div>
        </div>


        <!--</div>-->
    </div>
    <!--</div>-->
</template>

<script>
    import {validationMixin} from 'vuelidate'
    import {
        required,
        email,
        minLength,
    } from 'vuelidate/lib/validators'

    export default {
        name: 'login',
        mixins: [validationMixin],
        data() {
            return {
                user: {
                    email: '',
                    password: '',
                },
                form: {
                    email: null,
                    password: null,
                },
                sending: false,
                failedLogin: false,
            };
        },
        validations: {
            form: {
                email: {
                    required,
                    minLength: minLength(3),
                    email
                },
                password: {
                    required,
                    minLength: minLength(3)
                },
            }
        },
        methods: {
            login() {
                this.sending = true
                axios.post('/auth/login', this.form).then(response => {
                    this.$store.dispatch('login', response.data);
                    this.sending = false
                    location.href = '/';
                }).catch(err => {
                    this.sending = false
                    this.failedLogin = true;
                    this.clearForm()
                })
            },
            getValidationClass(fieldName) {
                const field = this.$v.form[fieldName]

                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty
                    }
                }
            },
            clearForm() {
                this.$v.$reset()
                // this.form.email = null
                // this.form.password = null
            },
            validateUser() {
                this.$v.$touch()

                if (!this.$v.$invalid) {
                    this.login()
                }
            }
        },
    }
    ;
</script>

<style scoped>
    .row {
        margin-top: 50px;
    }

    .z-depth-5.grey {
        display: inline-block;
        padding: 0 48px 0 48px;
    }
</style>
