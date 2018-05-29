<template>
    <div class="row">
        <md-toolbar class="md-transparent">
            <h3 class="md-title">Edit User Info</h3>
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

                </md-card-content>

                <!--<md-progress-bar md-mode="indeterminate" v-if="sending"/>-->

                <md-card-actions>
                    <md-button type="submit" class="md-primary md-raised" :disabled="sending">Update user</md-button>
                </md-card-actions>
            </md-card>

            <md-snackbar :md-active.sync="userSaved">The user {{ lastUser }} was saved with success!</md-snackbar>
        </form>

        <br><br>

        <md-toolbar class="md-transparent">
            <h3 class="md-title">Change Password</h3>

        </md-toolbar>
        <form novalidate class="md-layout md-alignment-top-center" @submit.prevent="validatePassword">
            <md-card class="md-layout-item">
                <md-card-content>
                    <div class="md-layout md-gutter">
                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClassPassword('password')">
                                <label for="password">Password</label>
                                <md-input type="password" name="password" id="password" autocomplete="password"
                                          v-model="password.password" :disabled="sending"/>
                                <span class="md-error" v-if="!$v.password.password.required">The password is required</span>
                                <span class="md-error" v-else-if="!$v.password.password.minlength">Invalid password</span>
                            </md-field>
                        </div>

                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClassPassword('passwordConfirmation')">
                                <label for="passwordConfirmation">Confirm Password</label>
                                <md-input type="password" id="passwordConfirmation" name="passwordConfirmation"
                                          autocomplete="passwordConfirmation" v-model="password.passwordConfirmation"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.password.passwordConfirmation.sameAsPassword">The confirm password does not match password</span>
                            </md-field>
                        </div>
                    </div>
                </md-card-content>

                <!--<md-progress-bar md-mode="indeterminate" v-if="sending"/>-->

                <md-card-actions>
                    <md-button type="submit" class="md-primary md-raised" :disabled="sending">Change Password</md-button>
                </md-card-actions>
            </md-card>

            <md-snackbar :md-active.sync="passwordSaved">The user's password was changed with success!</md-snackbar>
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
        name: "edit-user",
        mixins: [validationMixin],
        data: () => ({

            form: {
                id: '',
                firstName: '',
                lastName: '',
                email: '',
            },
            password: {
                password: '',
                passwordConfirmation: '',
            },
            userSaved: false,
            sending: false,
            lastUser: null,
            passwordSaved: false,
        }),
        created() {
            // Get user
            this.getUser(this.$route.params.id);
        },
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
            },
            password: {
                password: {
                    required,
                    minLength: minLength(6)
                },
                passwordConfirmation: {
                    sameAsPassword: sameAs('password')
                },
            }
        },
        methods: {
            getUser(id) {
                this.$emit('loading-start');

                this.$store.dispatch('getUser', id).then((response) => {
                    let name = response.data.data.name.split(' ');

                    this.form.id = response.data.data.id;
                    this.form.firstName = name[0];
                    this.form.lastName = name[1];
                    this.form.email = response.data.data.email;

                    this.$emit('loading-done')
                }, (error) => {
                    alert('Error');
                    // this.$toasted.show(JSON.parse(error.body.error.message).firstName, {duration: 3000});
                });
            },
            editUser() {
                this.$emit('loading-start');
                this.sending = true;

                this.$store.dispatch('updateUser', this.form).then((response) => {
                    this.lastUser = `${this.form.firstName} ${this.form.lastName}`;
                    this.userSaved = true;
                    this.sending = false;

                    this.$emit('loading-done');
                }, (error) => {
                    alert('Error');
                    // this.$toasted.show('Error', {duration: 3000});
                });
            },
            changePassword() {
                this.password.id = this.$route.params.id;
                this.$emit('loading-start');
                this.sending = true;

                this.$store.dispatch('changePassword', this.password).then((response) => {
                    this.lastUser = `${this.form.firstName} ${this.form.lastName}`;
                    this.passwordSaved = true;
                    this.sending = false;
                    this.clearPassword();

                    this.$emit('loading-done');
                }, (error) => {
                    alert('Error Password');
                    // this.$toasted.show('Error', {duration: 3000});
                });
            },
            getValidationClass (fieldName) {
                console.log('validation class');
                const field = this.$v.form[fieldName];

                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty
                    }
                }
            },
            getValidationClassPassword (fieldName) {
                const field = this.$v.password[fieldName];

                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty
                    }
                }
            },
            clearPassword () {
                this.form.password = null;
                this.form.passwordConfirmation = null;
            },
            validateUser () {
                this.$v.$touch();

                if (!this.$v.$invalid) {
                    this.editUser();
                } else {
                    alert();
                }
            },
            validatePassword () {
                this.$v.$touch();

                if (!this.$v.$invalid) {
                    this.changePassword();
                }
            }
        },
    }
</script>

<style scoped>

</style>