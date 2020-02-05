<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                    <div class="widget-user-background">
                        <div class="mt-5 pt-4 text-center">
                            <img class="img-circle img-fluid" :src="getProfilePicture()" alt="User Profile Picture">
                            <h3 class="mt-2 widget-user-username"><span v-if="$gate.isAdminAndSuperAdmin()">Atty.
                                </span>{{ form.firstname }} {{ form.middlename }} {{
                                form.lastname }}</h3>
                            <h5 class="widget-user-desc" v-if="form.type === 'Staff'">Staff</h5>
                            <h5 class="widget-user-desc" v-if="form.type === 'Admin'">Lawyer</h5>
                            <h5 class="widget-user-desc" v-if="form.type === 'Super Admin'">District Public Attorney</h5>
                        </div>
                        <ul class="nav nav-pills pt-5 row">
                            <div class="col-md-4 text-center">
                                <li class="nav-item" @click="tab = 'Settings'"><a class="nav-link" :class="{'active': tab == 'Settings'}"><i
                                            class="material-icons">settings</i> Settings</a></li>
                            </div>
                            <div class="col-md-4 text-center">
                                <li class="nav-item" @click="tab = 'Reports'"><a class="nav-link" :class="{'active': tab == 'Reports'}"><i
                                            class="material-icons">folder_open</i>
                                        Reports</a></li>
                            </div>
                            <div class="col-md-4 text-center">
                                <li class="nav-item" @click="tab = 'Activity'"><a class="nav-link" :class="{'active': tab == 'Activity'}"><i
                                            class="material-icons">timeline</i> Activity</a></li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="tab-pane" v-show="tab == 'Activity'">
                            <div class="container">
                                <div class="row justify-content-center table-responsive">
                                    <h3 class="report-heading">ACTIVITY LOG</h3>
                                    <div class="text-center pt-3" v-show="audits.data.length === 0">
                                        <h3>No Activity Log</h3>
                                    </div>
                                    <table class="table table-striped no-top-border" v-show="audits.data.length !== 0">
                                        <thead class="thead">
                                            <tr>
                                                <th scope="col">Type</th>
                                                <th scope="col">Event</th>
                                                <th scope="col">IP Address</th>
                                                <th scope="col">Date and Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="audit in audits.data" :key="audit.id" class="text-muted">
                                                <td>{{audit.auditable_type | auditType}}
                                                    <span v-if='audit.auditable_type === "App\\natureRequest"'>in
                                                        Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\natureOfTheCase"'>in
                                                        Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\clientProfile"'>in
                                                        Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\intervieweePersonalCircumstances"'>in
                                                        Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\clientCaseInvolvement"'>in
                                                        Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\clientClassification"'>in
                                                        Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\additionalInformationCase"'>in
                                                        Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\proofIndigency"'>in
                                                        Interview Form</span>
                                                    <span v-if='audit.auditable_type === "App\\Cases"'>Prepared</span>
                                                    <span v-if='audit.auditable_type === "App\\Event"'>in Calendar</span>
                                                    <span v-if='audit.auditable_type === "App\\Hearing"'>Date in
                                                        Calendar</span>
                                                </td>
                                                <td><span class="badge" :class="{'badge-warning': audit.event === 'created', 'badge-success': audit.event === 'updated', 'badge-danger': audit.event === 'deleted'}">{{audit.event
                                                        | capitalize}}</span></td>
                                                <td>{{audit.ip_address}}</td>
                                                <td>{{audit.created_at | auditDate}}</td>
                                            </tr>
                                        </tbody>
                                    </table><br>
                                    <div class="text-right">
                                        <pagination :data="audits" @pagination-change-page="paginateAudits"
                                            :show-disabled="true">
                                            <span slot="prev-nav">Prev</span>
                                            <span slot="next-nav">Next</span>
                                        </pagination>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-show="tab == 'Reports'" class="tab-pane">
                            <profile-reports></profile-reports>
                        </div>

                        <div class="tab-pane" v-show="tab == 'Settings'">
                            <h3 class="report-heading">USER SETTINGS</h3><br>
                            <form class="form-horizontal row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Profile Picture</label>
                                        <div class="ml-3 custom-file">
                                            <div class="col-md-6">
                                                <label for="profilePicture" class="custom-file-label control-label">Choose
                                                    Picture</label>
                                                <input type="file" @change="updateProfilePicture" class="custom-file-input"
                                                    id="profilePicture">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputFirstname" class="control-label">Firstname</label>
                                        <div class="col-sm-10">
                                            <input type="text" v-model="form.firstname" class="form-control" :class="{ 'is-invalid': form.errors.has('firstname') }"
                                                id="inputFirstname" placeholder="Firstname">
                                            <has-error :form="form" field="firstname"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputMiddlename" class="control-label">Middlename</label>
                                        <div class="col-sm-10">
                                            <input type="text" v-model="form.middlename" class="form-control" id="inputMiddlename"
                                                placeholder="Middlename" :class="{ 'is-invalid': form.errors.has('middlename') }">
                                            <has-error :form="form" field="middlename"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputLastname" class="control-label">Lastname</label>
                                        <div class="col-sm-10">
                                            <input type="text" v-model="form.lastname" class="form-control" id="inputLastname"
                                                placeholder="Lastname" :class="{ 'is-invalid': form.errors.has('lastname') }">
                                            <has-error :form="form" field="middlename"></has-error>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputUsername" class="control-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="username" v-model="form.username" class="form-control" id="inputUsername"
                                                placeholder="Username" :class="{ 'is-invalid': form.errors.has('username') }">
                                            <has-error :form="form" field="username"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="control-label">Old Password <small>(If you
                                                are
                                                newly registered, kindly change your password)</small></label>
                                        <div class="col-sm-10">
                                            <input type="password" v-model="old_password" class="form-control"
                                                placeholder="Old Password" @keyup="checkOldPass">
                                        </div>
                                    </div>
                                    <div class="form-group" v-show="$parent.is_confirmed">
                                        <label for="inputPassword" class="control-label">New Password </label>
                                        <div class="col-sm-10">
                                            <input type="password" v-model="form.password" class="form-control" id="inputPassword"
                                                placeholder="New Password" :class="{ 'is-invalid': form.errors.has('password') }">
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group" v-show="$parent.is_confirmed">
                                        <label for="inputPassword" class="control-label">Confirm Password </label>
                                        <div class="col-sm-10">
                                            <input type="password" v-model="confirm_password" class="form-control" id="inputPassword"
                                                placeholder="Confirm Password" :class="{ 'is-invalid': form.errors.has('password') }">
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                    </div>
                                    <div class="ml-2 mx-auto pb-4" v-show="confirm_password !== form.password && confirm_password.length !== 0" style="width: 50%!important">
                                        <small  class="alert alert-danger" style="border-radius: 20px  ">Password does not match.</small >
                                    </div>
                                    <div class="form-group" v-show="confirm_password === form.password && confirm_password.length !== 0 || old_password === ''">
                                        <div class="col-sm-offset-2 col-sm-10 text-right">
                                            <button type="submit" @click.prevent="updateUserInfo" class="btn btn-primary"><i
                                                    class="material-icons">update</i> Update Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                tab: 'Settings',
                old_password: '',
                confirm_password: '',
                form: new Form({
                    id: '',
                    firstname: '',
                    middlename: '',
                    lastname: '',
                    username: '',
                    gender: '',
                    password: '',
                    type: '',
                    image: 'profile-placeholder.jpg'
                }),
                audits: {}
            }
        },
        methods: {
            loadProfile() {
                axios.get('api/profile').then(({
                    data
                }) => {
                    this.form.fill(data)
                    this.form.password = ''
                })
                axios.get('api/audit').then(({
                    data
                }) => {
                    this.audits = data
                })
            },
            checkOldPass: _.debounce((e) => {
                let oldPass = new Form({
                    old_password: e.target._value
                })
                oldPass.post('api/check-old-password').then(({
                    data
                }) => {
                    console.log(app.__vue__.is_confirmed = data[0])
                })
            }, 1000),
            getProfilePicture() {
                let photo = (this.form.image.length > 200) ? this.form.image : 'img/profile-picture/' + this.form.image
                return photo
            },
            updateUserInfo() {
                this.$Progress.start()
                this.form.put('api/profile/').then(() => {
                    this.$Progress.finish()
                    document.getElementById('profilePicture').value = ''
                    toast({
                        type: 'success',
                        title: 'Profile Successfully Updated.'
                    })
                    Fire.$emit('Refresh')
                }).catch(() => {
                    this.$Progress.fail()
                })
            },
            updateProfilePicture(event) {
                let file = event.target.files[0];
                let reader = new FileReader();
                if (file['size'] < 2111775) {
                    reader.onloadend = (file) => {
                        this.form.image = reader.result
                    }
                    reader.readAsDataURL(file)
                } else {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file.'
                    })
                }
            },
            paginateAudits(page = 1) {
                axios.get('api/audit?page=' + page).then((response) => {
                    this.audits = response.data
                })
            },
        },
        mounted() {},
        created() {
            this.loadProfile();
            Fire.$on('Refresh', () => {
                this.loadProfile()
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
