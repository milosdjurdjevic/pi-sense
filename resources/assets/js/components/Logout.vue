<template>

</template>

<script>

  export default {
    name: 'logout',

    mounted() {
      this.logout();
    },
    methods: {
      logout() {
        this.$store.dispatch('logout');
        location.href = '/'
      },
    },
  };
</script>

<style scoped>

</style>
