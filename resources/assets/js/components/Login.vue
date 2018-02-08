<template>
  <div class="row">
    <div class="col s12 center">
      <div class="z-depth-5 grey lighten-4 row">
        <form @submit.prevent="login" class="col s12" method="post">
          <div class='row'>
            <div class='input-field col s12'>
              <input v-model="user.email" class='validate' type='email' name='email' id='email'/>
              <label for='email'>Enter your email</label>
            </div>
          </div>
          <div class='row'>
            <div class='input-field col s12'>
              <input v-model="user.password" class='validate' type='password' name='password' id='password'/>
              <label for='password'>Enter your password</label>
            </div>
            <label class="right">
              <a href='#!'><b>Forgot Password?</b></a>
            </label>
          </div>
          <br/>
          <div class='row center'>
            <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect blue'>Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  // import api from '../api';
  // import { LOGIN } from '../store/mutation-types';

  export default {
    name: 'login',
    data() {
      return {
        user: {
          email: '',
          password: '',
        },
      };
    },
    methods: {
      login() {
          axios.post('/authenticate', this.user).then(response => {
              console.log(response);
          }).catch(err => {
              console.log(err);
          })

        // api.post('login', this.user).then((response) => {
        //   this.$store.dispatch('login', response.body.users[0]);
        //   // this.$router.push({
        //   //   name: 'root',
        //   // });
        //   location.href = '/';
        //   // eslint-disable-next-line
        // }, (error) => {
        //
        // });
      },
    },
  };
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
