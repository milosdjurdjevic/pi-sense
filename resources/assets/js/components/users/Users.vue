<template>
    <div id="users">
        <div class="row">
            <md-toolbar class="md-transparent">
                <h3 class="md-title">Users</h3>
                <div class="md-toolbar-section-end">
                    <router-link tag="span" class="" to="/add-user">
                        <a class="btn-floating waves-effect waves-light blue">
                            <!--<md-icon>add</md-icon>-->
                            <span class="page">Add User</span>
                        </a>
                    </router-link>
                </div>
            </md-toolbar>

            <md-table v-model="users.users" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
                <md-table-toolbar>
                    <div class="md-toolbar-section-start">
                        <!--<h1 class="md-title">Users</h1>-->
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
                    <md-table-cell md-label="Action">
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
                    <li :class="currentPage === 1 ? 'disabled' : 'waves-effect'">
                        <a @click="loadData(currentPage === 1 ? 1 : currentPage - 1)">
                            <i class="material-icons">chevron_left</i>
                        </a>
                    </li>
                    <li v-for="i in (0, totalPages)" v-on:click="loadData(i)"
                        :class="currentPage === i ? 'active' : ''"
                        class="waves-effect"><a>{{ i }}</a></li>
                    <li :class="currentPage === totalPages ? 'disabled' : 'waves-effect'" >
                        <a @click="loadData(currentPage === totalPages ? currentPage : currentPage + 1)">
                            <i class="material-icons">chevron_right</i>
                        </a>
                    </li>
                </ul>
            </div>

            <md-snackbar :md-active.sync="showSnackbar" md-persistent :md-duration="1000000">
                <span>Are you sure?</span>
                <md-button class="md-accent" @click="deleteUser()">Yes</md-button>
                <md-button class="md-primary" @click="showSnackbar = false">Cancel</md-button>
            </md-snackbar>

        </div>
    </div>
</template>

<script>
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
                search: null,
                searched: null,
                showSnackbar: false,
                deleteId: null,
            };
        },
        computed: {
            users() {
                return this.$store.state.users
            },
            currentPage() {
                return this.$store.state.users.currentPage
            },
            totalPages() {
                return this.$store.state.users.totalPages
            }
        },
        mounted() {
            if (this.$store.getters.users.length === 0) {
                this.loadData();
            }
        },
        methods: {
            loadData(page = 1) {
                this.$emit('loading-start');

                this.$store.dispatch('fetchUsers', page).then(() => {

                    this.$store.dispatch('allUsers').then(() => {
                        // this.searched = this.$store.getters.allUsers;
                    }, () => {
                        this.searched = [];
                    });

                    this.$emit('loading-done');
                }, () => {
                    this.users = null;
                });


            },
            searchOnTable() {
                this.users = searchByName(this.users.allUsers, this.search)
            },
            confirmDelete(id) {
                this.showSnackbar = true;
                this.deleteId = id;
            },
            deleteUser() {
                this.$store.dispatch('deleteUser', this.deleteId).then(() => {
                    // this.loadData(this.currentPage);
                    this.showSnackbar = false;
                }, () => {
                    // this.$toasted.show('Error!', {duration: 3000});
                });
            }
        },
    };
</script>

<style scoped>
    .md-table {
        min-height: 675px;
    }

    .center, .center-align {
        text-align: center;
    }

    .row {
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 20px;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .pagination li {
        display: inline-block;
        border-radius: 2px;
        text-align: center;
        vertical-align: top;
        height: 30px;
    }

    .pagination li a {
        color: #444;
        display: inline-block;
        font-size: 1.2rem;
        padding: 0 10px;
        line-height: 30px;
        cursor: pointer;
    }

    .pagination li.active a {
        color: #fff;
    }

    .pagination li.active {
        background-color: #ee6e73;
    }

    .pagination li.disabled a {
        cursor: default;
        color: #999;
    }

    .pagination li i {
        font-size: 2rem;
    }

    .pagination li.pages ul li {
        display: inline-block;
        float: none;
    }

    @media only screen and (max-width: 992px) {
        .pagination {
            width: 100%;
        }

        .pagination li.prev,
        .pagination li.next {
            width: 10%;
        }

        .pagination li.pages {
            width: 80%;
            overflow: hidden;
            white-space: nowrap;
        }
    }
</style>
