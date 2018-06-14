<template>
    <div class="row">
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
                                <span class="md-error"
                                      v-else-if="!$v.password.password.minlength">Invalid password</span>
                            </md-field>
                        </div>

                        <div class="md-layout-item md-small-size-100">
                            <md-field :class="getValidationClassPassword('passwordConfirmation')">
                                <label for="passwordConfirmation">Confirm Password</label>
                                <md-input type="password" id="passwordConfirmation" name="passwordConfirmation"
                                          autocomplete="passwordConfirmation"
                                          v-model="password.passwordConfirmation"
                                          :disabled="sending"/>
                                <span class="md-error" v-if="!$v.password.passwordConfirmation.sameAsPassword">The confirm password does not match password</span>
                            </md-field>
                        </div>
                    </div>
                </md-card-content>

                <!--<md-progress-bar md-mode="indeterminate" v-if="sending"/>-->

                <md-card-actions>
                    <md-button type="submit" class="md-primary md-raised" :disabled="sending">Change Password
                    </md-button>
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
        minLength,
        sameAs
    } from 'vuelidate/lib/validators'

    export default {
        name: "change-password",
        mixins: [validationMixin],
        data: () => ({
            password: {
                id: null,
                password: '',
                passwordConfirmation: '',
            },
            sending: false,
            message: null,
            passwordSaved: false,
        }),
        created() {
        },
        validations: {
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
            changePassword() {
                this.password.id = this.$route.params.id;
                this.$emit('loading-start');
                this.sending = true;

                this.$store.dispatch('changePassword', this.password).then((response) => {
                    // this.message = `Password successfully changed`;
                    this.passwordSaved = true;
                    this.sending = false;
                    this.clearPassword();

                    this.$emit('loading-done');
                }, (error) => {
                    alert('Error Password');
                    // this.$toasted.show('Error', {duration: 3000});
                });
            },
            getValidationClassPassword(fieldName) {
                const field = this.$v.password[fieldName];

                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty
                    }
                }
            },
            clearPassword() {
                this.password.password = null;
                this.password.passwordConfirmation = null;
            },
            validatePassword() {
                this.$v.$touch();

                if (!this.$v.$invalid) {
                    this.changePassword();
                }
            },
        },
    }
</script>

<style scoped>

</style>