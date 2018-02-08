<template>
  <div id="users">
    <div class="row">
      <router-link tag="li" class="left" to="/add-user">
        <a class="btn-floating waves-effect waves-light blue">
          <i class="material-icons">add</i>
          <span class="page">Add User</span>
        </a>
      </router-link>
      <div class="input-field col s6 right">
        <input id="serachTable" type="text" class="validate" v-model="search">
        <label class="active" for="serachTable">Search Users</label>
      </div>

      <table class="highlight">
        <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in filteredList">
          <td>{{ user.id }}</td>
          <td>{{ user.attributes.name }}</td>
          <td>{{ user.attributes.email }}</td>
          <td>
            <button v-on:click="" class="btn-floating waves-effect waves-light teal"><i class="material-icons">edit</i>
            </button>
            <button v-on:click="confirmDelete(user.id)" class="btn-floating waves-effect waves-light red"><i
              class="material-icons">delete</i></button>
          </td>
        </tr>
        </tbody>
      </table>
      <div class="row center">
        <ul class="pagination">
          <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
          <li v-for="i in (0, totalPages)" v-on:click="loadData(i)" v-bind:class="currentPage === i ? 'active' : ''"
              class="waves-effect"><a>{{ i }}</a></li>
          <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue';
  import Toasted from 'vue-toasted';
  import api from '../../api/index';
  import {UPDATE_USER_STATE} from '../../store/mutation-types';

  Vue.use(Toasted, {
    iconPack: 'material', // set your iconPack, defaults to material. material|fontawesome
  });

  export default {
    name: 'users',
    data() {
      return {
        users: [],
        links: {},
        total: 0,
        totalPages: 0,
        currentPage: 0,
        search: '',
      };
    },
    computed: {
      filteredList() {
        // eslint-disable-next-line
        return this.users.filter((user) => {
          return user.attributes.name.toLowerCase().includes(this.search.toLowerCase());
        });
      },
    },
    created() {
      // Get users
      this.loadData();
    },
    methods: {
      loadData(page = 1) {
        this.$store.dispatch('fetchUsers', page).then((response) => {
          this.users = response.body.data;
          this.links = response.body.links;
          this.total = response.body.meta.pagination.total;
          this.totalPages = response.body.meta.pagination.total_pages;
          this.currentPage = response.body.meta.pagination.current_page;
        }, () => {
          this.users = [];
        });
      },
      confirmDelete(id) {
        this.$toasted.show('Are You sure?', {
          action: [
            {
              text: 'Cancel',
              onClick: (e, toastObject) => {
                toastObject.goAway(0);
              },
            },
            {
              text: 'Yes',
              // router navigation
              onClick: (e, toastObject) => {
                this.$store.dispatch('deleteUser', id).then(() => {
                  this.loadData(this.currentPage);
                  toastObject.goAway(0);
                }, () => {
                  toastObject.goAway(0);
                  this.$toasted.show('Error!', { duration: 3000 });
                });
              },
            },
          ],
        });
      },
    },
  };
</script>

<style scoped>

</style>
