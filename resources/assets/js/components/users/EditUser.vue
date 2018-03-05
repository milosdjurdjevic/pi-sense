<template>
    <div class="row">
        <form class="col s12" id="change-data">
            <div class="row">
                <div class="input-field col s6">
                    <i class="material-icons prefix">account_circle</i>
                    <input v-model="user.firstName" id="firstName" type="text" class="validate">
                    <label for="firstName" class="active">First Name</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">account_circle</i>
                    <input v-model="user.lastName" id="lastName" type="text" class="validate">
                    <label for="lastName" class="active">Last Name</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">email</i>
                    <input v-model="user.email" id="email" type="email" class="validate">
                    <label for="email" class="active">Email</label>
                </div>
                <div class="input-field col s6 center">
                    <button @click="editUser()" class="btn-floating waves-effect waves-light blue"><i
                            class="material-icons">edit</i>
                    </button>
                </div>
            </div>
        </form>
        <!--<form class="col s12" id="change-password" method="post" @submin.prevent="onSubmit">-->
            <div class="row">
                <div class="input-field col s6">
                    <i class="material-icons prefix">lock</i>
                    <input v-model="password.password" v-validate="'required|confirmed|min:6'"
                           id="password" name="password" type="password" :class="{'invalid': errors.has('password') }">
                    <label for="password" :data-error="errors.first('password')">Password</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">lock</i>
                    <input v-model="password.passwordConfirmation" v-validate="'required'"
                           id="password_confirmation" name="password_confirmation"
                           type="password" :class="{'invalid': errors.has('password') }">
                    <label for="password_confirmation">Confirm Passowrd</label>
                </div>
                <div class="input-field col s6 center">
                    <button @click="changePassword()" class="btn-floating waves-effect waves-light blue"><i
                            class="material-icons">edit</i>
                    </button>
                </div>
            </div>
        <!--</form>-->
    </div>
</template>

<script>
    import Vue from 'vue';
    import VeeValidate from 'vee-validate';

    Vue.use(VeeValidate);

    export default {
        name: "edit-user",
        data() {
            return {
                user: {
                    id: '',
                    firstName: '',
                    lastName: '',
                    email: '',
                },
                password: {
                    password: '',
                    passwordConfirmation: '',
                }
            };
        },
        created() {
            // Get user
            this.getUser(this.$route.params.id);
        },
        methods: {
            getUser(id) {
                this.$store.dispatch('getUser', id).then((response) => {
                    let name = response.data.data.name.split(' ');

                    this.user.id = response.data.data.id;
                    this.user.firstName = name[0];
                    this.user.lastName = name[1];
                    this.user.email = response.data.data.email;
                }, (error) => {
                    this.$toasted.show(JSON.parse(error.body.error.message).firstName, {duration: 3000});
                });
            },
            editUser() {
                this.$store.dispatch('updateUser', this.user).then((response) => {
                    this.$toasted.show('User updated', {duration: 3000});
                }, (error) => {
                    this.$toasted.show('Error', {duration: 3000});
                });
            },
            changePassword() {
                this.password.id = this.$route.params.id;

                this.$store.dispatch('changePassword', this.password).then((response) => {
                    this.password.password = '';
                    this.password.passwordConfirmation = '';
                    this.$toasted.show('Password changed', {duration: 3000});
                }, (error) => {
                    this.$toasted.show('Error', {duration: 3000});
                });
            }
        },
    }
</script>

<style scoped>

</style>