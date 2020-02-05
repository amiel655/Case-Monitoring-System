<template>
    <div class="container-fluid">
        <div v-if="!$gate.isSuperAdmin()">
            <not-found></not-found>
        </div>
        <div class="card mt-5 shadow pr-3 pl-3 row pb-5" v-if="$gate.isSuperAdmin()">
            <div class="card-title text-center shadow client-header-card">
                Users
            </div>
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-success float-right" @click="addModal">
                        Add New <i class="material-icons">
                            person_add
                        </i>
                    </button>
                </div>
            </div>
            <div v-show="users.length === 0" class="empty col-md-12 pt-2 pb-5 text-center">
                <empty></empty><br>
                <h3 class="p-2">No user found...</h3>
            </div>
            <div class="row mt-3" v-show="users.length !== 0">
                <div class="col-md-3" v-for="user in users" :key="user.id">

                    <!-- Profile Image -->
                    <div class="card card-border-user shadow border-radius">
                        <div class="card-body box-profile">

                            <p class="text-muted text-left user-id">ID # ( {{user.id}} )</p>

                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle img-border img-size" :src="'img/profile-picture/' + user.image"
                                    alt="User profile picture">
                                <h5 class="profile-username"><span v-if="user.type === 'Admin' || user.type === 'Super Admin'">Atty. </span>{{ user.firstname }} {{ user.middlename }} {{
                                    user.lastname }}</h5>
                                <p class="badge" :class="{'badge-primary' : user.status === 'Available', 'badge-secondary' : user.status === 'Unavailable', 'badge-info' : user.status === 'On-Leave'}">{{
                                    user.status }}</p>
                            </div>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Gender</b> <a class="float-right">{{user.gender}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Username</b><br> <a class="float-right">{{user.username}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Type</b>
                                    <a class="float-right" v-if="user.type === 'Staff'">Staff</a>
                                    <a class="float-right" v-if="user.type === 'Admin'">Lawyer</a>
                                    <a class="float-right" v-if="user.type === 'Super Admin'">District Public Attorney</a>
                                </li>
                            </ul>
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-primary" @click="editModal(user)">
                                    <i class="material-icons">
                                        edit
                                    </i>
                                </button>
                                <button type="button" class="btn btn-danger" @click="deleteUser(user.id)">
                                    <i class="material-icons">
                                        delete
                                    </i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade bd-example-modal-lg" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editMode">Add New User</h5>
                            <h5 class="modal-title" v-show="editMode">Update User's Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editMode ? updateUser() : createUser()">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">First Name</label>
                                            <input v-model="form.firstname" type="text" name="firstname" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('firstname') }" placeholder="Firstname">
                                            <has-error :form="form" field="firstname"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="middlename">Middle Name</label>
                                            <input v-model="form.middlename" type="text" name="middlename" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('middlename') }" placeholder="Middlename">
                                            <has-error :form="form" field="middlename"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="lastname">Last Name</label>
                                            <input v-model="form.lastname" type="text" name="lastname" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('lastname') }" placeholder="Lastname">
                                            <has-error :form="form" field="lastname"></has-error>
                                        </div>
                                        <div class="form-group" v-show="editMode">
                                            <label for="type">Status</label>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success dropdown-toggle" type="button"
                                                    :class="{ 'is-invalid': form.errors.has('status') }" id="status"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span v-show="form.status === ''">Current Status</span>
                                                    <span v-show="form.status !== ''">{{
                                                        form.status }}
                                                        <span v-if="form.status === 'Available'"></span>
                                                        <span v-if="form.status === 'Unavailable'"></span>
                                                    </span>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="status">
                                                    <a class="dropdown-item" value="1" @click="form.status = 'Available'">Available</a>
                                                    <a class="dropdown-item" value="Unavailable" @click="form.status = 'Unavailable'">Unavailable</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input v-model="form.username" type="text" name="sername" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('username') }" placeholder="Username">
                                            <has-error :form="form" field="username"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success dropdown-toggle" type="button"
                                                    :class="{ 'is-invalid': form.errors.has('gender') }" id="gender"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span v-show="form.gender === ''">Select Gender</span>
                                                    <span v-show="form.gender !== ''">{{
                                                        form.gender }} <span v-if="form.gender === 'Male'">
                                                            <male-icon class="ml-1"></male-icon>
                                                        </span> <span v-if="form.gender === 'Female'">
                                                            <female-icon></female-icon>
                                                        </span> </span>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="gender">
                                                    <a class="dropdown-item" value="Male" @click="form.gender = 'Male'">Male
                                                        <male-icon class="ml-1"></male-icon></a>
                                                    <a class="dropdown-item" value="Female" @click="form.gender = 'Female'">Female
                                                        <female-icon></female-icon></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="type">User Type</label>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success dropdown-toggle" type="button"
                                                    :class="{ 'is-invalid': form.errors.has('type') }" id="type"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span v-show="form.type === ''">Select User Type</span>
                                                    <span v-show="form.type !== ''">
                                                        <span v-if="form.type === 'Staff'">Staff</span>
                                                        <span v-if="form.type === 'Admin'">Lawyer</span>
                                                        <span v-if="form.type === 'Super Admin'">District Public
                                                            Attorney</span>
                                                    </span>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="type">
                                                    <a class="dropdown-item" value="Staff" @click="form.type = 'Staff'">Staff</a>
                                                    <a class="dropdown-item" value="Admin" @click="form.type = 'Admin'">Lawyer</a>
                                                    <a class="dropdown-item" value="Super Admin" @click="form.type = 'Super Admin'">District
                                                        Public Attorney</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button v-show="!editMode" type="submit" class="btn btn-success">Create</button>
                                <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                editMode: false,
                users: {},
                dbUsers: {},
                form: new Form({
                    id: '',
                    firstname: '',
                    middlename: '',
                    lastname: '',
                    username: '',
                    gender: '',
                    password: '',
                    type: '',
                    status: 'Available',
                    image: 'profile-placeholder.jpg'
                })
            }
        },
        methods: {
            addModal() {
                this.editMode = false
                this.form.reset()
                $('#Modal').modal('show')
            },
            editModal(user) {
                this.editMode = true
                this.form.reset()
                this.form.errors.clear()
                $('#Modal').modal('show')
                this.form.fill(user)
            },
            loadUsers() {
                if (this.$gate.isSuperAdmin()) {
                    axios.get('api/user').then(({
                        data
                    }) => (this.users = data))
                }
            },
            createUser() {
                this.$Progress.start()
                if (this.$gate.isSuperAdmin()) {
                    this.form.post('api/user').then(() => {
                        Fire.$emit('Refresh')
                        $('#Modal').modal('hide')
                        toast({
                            type: 'success',
                            title: 'User Created Successfully! \n Note: The User\'s password is also the username.'
                        })
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                }
            },
            deleteUser(id) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        if (this.$gate.isSuperAdmin()) {
                            this.form.delete('api/user/' + id).then(() => {
                                swal(
                                    'Deleted!',
                                    'The user has been deleted.',
                                    'success'
                                )
                                Fire.$emit('Refresh')
                            }).catch(() => {
                                swal('Failed!', 'There was something wrong.', 'warning')
                            });
                        }
                    }
                })
            },
            updateUser() {
                this.$Progress.start();
                if (this.$gate.isSuperAdmin()) {
                    this.form.put('api/user/' + this.form.id).then(() => {
                        $('#Modal').modal('hide')
                        swal(
                            'Updated!',
                            'The user information has been updated.',
                            'success'
                        )
                        this.$Progress.finish()
                        Fire.$emit('Refresh')
                    }).catch(() => {
                        this.$Progress.fail()
                    });
                }
            }
        },
        created() {
            this.loadUsers()
            Fire.$on('Refresh', () => {
                this.loadUsers()
            });
            Fire.$on('searching', () => {
                let query = this.$parent.search
                axios.get('api/findUser?val=' + query).then((data) => {
                    this.$parent.searchResults = data.data
                }).catch(() => {
                    this.$Progress.fail()
                })
            })
        }
    }

</script>
