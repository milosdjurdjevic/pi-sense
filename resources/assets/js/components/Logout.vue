<template>

</template>

<script>
  // import { LOGOUT } from '../store/mutation-types';

  export default {
    name: 'logout',

    mounted() {
      this.logout();
    },
    methods: {
      logout() {
        this.$store.dispatch('logout');
        location.href = '/'
        // this.$router.push({
        //   name: 'login',
        // });
      },
    },
  };
</script>

<style scoped>

</style>
