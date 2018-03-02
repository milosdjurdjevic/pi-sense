<template>
    <div class="row">
        <form class="col s12" method="post" @submit.prevent>
            <div class="row">
                <div class="input-field col s6">
                    <i class="material-icons prefix">account_circle</i>
                    <input v-model="user.firstName" v-validate="'required|min:3'" id="firstName" name="firstName"
                           type="text" :class="{'invalid': errors.has('firstName') }">
                    <label for="firstName" :data-error="errors.first('firstName')">First Name</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">account_circle</i>
                    <input v-model="user.lastName" v-validate="'required|min:3'" id="lastName" name="lastName"
                           type="text" :class="{'invalid': errors.has('lastName') }">
                    <label for="lastName" :data-error="errors.first('lastName')">Last Name</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">email</i>
                    <input v-model="user.email" v-validate="'required|email'" id="email" name="email" type="email"
                           :class="{'invalid': errors.has('email') }">
                    <label for="email" :data-error="errors.first('email')">Email</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">lock</i>
                    <input v-model="user.password" v-validate="'required|confirmed'"
                           id="password" name="password" type="password" :class="{'invalid': errors.has('password') }">
                    <label for="password" :data-error="errors.first('password')">Password</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">lock</i>
                    <input v-model="user.passwordConfirmation" v-validate="'required'"
                           id="password_confirmation" name="password_confirmation"
                           type="password" :class="{'invalid': errors.has('password') }">
                    <label for="password_confirmation">Confirm Passowrd</label>
                </div>
                <div class="input-field col s6 center">
                    <button @click="createUser()" v-bind:disabled="errors.any()"
                            class="btn-floating waves-effect waves-light blue"><i
                            class="material-icons">add</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VeeValidate from 'vee-validate';

    Vue.use(VeeValidate);

    export default {
        name: 'add-user',
        data() {
            return {
                user: {
                    firstName: '',
                    lastName: '',
                    email: '',
                    password: '',
                    passwordConfirmation: '',
                },
            };
        },
        methods: {
            createUser() {
                this.$store.dispatch('createUser', this.user).then(() => {
                    this.$toasted.show('Success', {duration: 3000});
                }, (error) => {
                    // let errors = JSON.parse(error.message);
                    console.log(error);
                    this.$toasted.show(JSON.parse(error.data.error.message).firstName, {duration: 3000});
                });
            },
        },
    };
</script>

<style scoped>

</style>
