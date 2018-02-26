<template>
  <div id="side-nav">
    <button id="menu-button" data-activates="main-nav"
            class="btn waves-effect waves-light btn-floating transparent"><i class="material-icons">menu</i>
    </button>
    <ul id="main-nav" class="side-nav">
      <!--<li>-->
      <router-link tag="li" class="pageLink" to="/" >
        <a class="waves-effect">
          <i class="fa fa-desktop"></i>
          <span class="page">Dashboard</span>
        </a>
      </router-link>
      <router-link tag="li" class="pageLink" to="/temperature">
        <a class="waves-effect">
          <i class="fa fa-desktop"></i>
          <span class="page">Temperature</span>
        </a>
      </router-link>
      <router-link tag="li" class="pageLink" to="/users">
        <a class="waves-effect">
          <i class="fa fa-desktop"></i>
          <span class="page">Users</span>
        </a>
      </router-link>
      <router-link tag="li" class="pageLink" to="/settings">
        <a class="waves-effect">
          <i class="fa fa-desktop"></i>
          <span class="page">Settings</span>
        </a>
      </router-link>
    </ul>
  </div>
</template>

<script>
  export default {
    name: 'side-nav',
    data() {
      return {
        show: false,
      };
    },
    mounted() {
        $('#menu-button').sideNav();
    },
  };
</script>

<style scoped>

</style>
