<template>
  <div v-if="authToken" class="navbar-fixed">
    <nav class="blue darken-2">
      <div class="nav-wrapper">
        <div class="left">
          <side-nav></side-nav>
          <a id="pi-title" href="/"><b>Pi</b> Sense</a>
        </div>
        <div class="nav-wrapper right">
          <!-- Dropdown Trigger -->
          <a class="dropdown-button btn" id="dd-btn" href='#' data-activates='dd-user'>Username</a>

          <!-- Dropdown Structure -->
          <ul id='dd-user' class='dropdown-content'>
            <router-link tag="li" class="pageLink" to="/logout" >
              <a class="waves-effect">
                <!--<i class="fa fa-desktop"></i>-->
                <span class="page">Logout</span>
              </a>
            </router-link>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
  import SideNav from './SideNav';

  export default {
    components: { SideNav },
    name: 'top-bar',
    data() {
      return {
        authToken: this.$store.getters.authToken,
      };
    },
    mounted() {
        $('#dd-btn').dropdown();
    }
  };
</script>

<style scoped>

</style>
