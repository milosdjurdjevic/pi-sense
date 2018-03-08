<template>
    <div id="users">
        <div class="row">
            <router-link tag="a" class="" to="/add-user">
                <a class="btn-floating waves-effect waves-light blue">
                    <md-icon>add</md-icon>
                    <span class="page">Add User</span>
                </a>
            </router-link>

            <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
                <md-table-toolbar>
                    <div class="md-toolbar-section-start">
                        <h1 class="md-title">Users</h1>
                    </div>

                    <md-field md-clearable class="md-toolbar-section-end">
                        <md-input placeholder="Search by name..." v-model="search" @input="searchOnTable"/>
                    </md-field>
                </md-table-toolbar>

                <md-table-empty-state md-label="No users found"
                                      :md-description="`No user found for this '${search}' query. Try a different search term or create a new user.`">
                    <router-link tag="md-button" class="md-primary md-raised" to="/add-user">
                        Create New User
                    </router-link>
                </md-table-empty-state>

                <md-table-row slot="md-table-row" slot-scope="{ item }">
                    <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                    <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
                    <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
                    <md-table-cell md-label="Action" >
                        <router-link tag="md-button" class="md-icon-button md-primary md-raised"
                                     :to="`/users/${item.id}`">
                            <i class="material-icons">edit</i>
                        </router-link>
                        <md-button @click="confirmDelete(item.id)" class="md-icon-button md-raised md-accent">
                            <md-icon>delete</md-icon>
                        </md-button>
                    </md-table-cell>
                </md-table-row>
            </md-table>

            <div class="row center">
                <ul class="pagination">
                    <!--<li v-bind:class="currentPage === 0 ? 'disabled' : 'waves-effect'" v-on:click="loadData(currentPage - 1)"><a href="#!"><i class="material-icons">chevron_left</i></a></li>-->
                    <li v-for="i in (0, totalPages)" v-on:click="loadData(i)"
                        v-bind:class="currentPage === i ? 'active' : ''"
                        class="waves-effect"><a>{{ i }}</a></li>
                    <!--<li class="waves-effect" v-on:click="loadData(currentPage + 1)"><a href="#!"><i class="material-icons">chevron_right</i></a></li>-->
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import Toasted from 'vue-toasted';

    Vue.use(Toasted, {
        iconPack: 'material', // set your iconPack, defaults to material. material|fontawesome
    });

    const toLower = text => {
        return text.toString().toLowerCase()
    };

    const searchByName = (items, term) => {

        if (term) {
            return items.filter(item => toLower(item.name).includes(toLower(term)))
        }

        return items
    };

    export default {
        name: 'users',
        data() {
            return {
                users: null,
                links: {},
                total: 0,
                totalPages: 0,
                currentPage: 0,
                search: null,
                searched: this.$store.getters.users,
            };
        },
        created() {
            // Get users
            if (this.$store.getters.users.length === 0) {
                this.loadData();
            }
        },
        methods: {
            loadData(page = 1) {
                this.$store.dispatch('fetchUsers', page).then(() => {
                    this.searched = this.$store.getters.users;
                    this.links = this.$store.getters.usersMeta.pagination.links;
                    this.total = this.$store.getters.usersMeta.pagination.total;
                    this.totalPages = this.$store.getters.usersMeta.pagination.total_pages;
                    this.currentPage = this.$store.getters.usersMeta.pagination.current_page;
                }, () => {
                    this.searched = [];
                });
            },
            searchOnTable() {
                this.searched = searchByName(this.$store.getters.users, this.search)
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
                                    this.$toasted.show('Error!', {duration: 3000});
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
    .md-table-content {
        height: 500px;
    }
</style>
