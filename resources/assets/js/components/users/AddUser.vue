<template>
  <div class="row">
    <form class="col s12">
      <div class="row">
        <div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i>
          <input v-model="user.firstName" id="firstName" type="text" class="validate">
          <label for="firstName">First Name</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i>
          <input v-model="user.lastName" id="lastName" type="text" class="validate">
          <label for="lastName">Last Name</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">email</i>
          <input v-model="user.email" id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">lock</i>
          <input v-model="user.password" id="password" type="password" class="validate">
          <label for="password">Password</label>
        </div>
        <div class="input-field col s6">
          <i class="material-icons prefix">lock</i>
          <input v-model="user.confirmPassword" id="confirmPassword" type="password" class="validate">
          <label for="confirmPassword">Confirm Passowrd</label>
        </div>
        <div class="input-field col s6 center">
          <button v-on:click="createUser" class="btn-floating waves-effect waves-light blue"><i class="material-icons">add</i>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
    name: 'add-user',
    data() {
      return {
        user: {
          firstName: '',
          lastName: '',
          email: '',
          password: '',
          confirmPassword: '',
        },
      };
    },
    methods: {
      createUser() {
        this.$store.dispatch('createUser', this.user).then(() => {
          this.$toasted.show('Success', { duration: 3000 });
        }, (error) => {
          this.$toasted.show(JSON.parse(error.body.error.message).firstName, { duration: 3000 });
        });
      },
    },
  };
</script>

<style scoped>

</style>
