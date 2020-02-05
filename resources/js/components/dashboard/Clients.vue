<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5 shadow pr-3 pl-3">
                    <div class="card-title text-center shadow client-header-card">
                        {{$parent.client_request}}
                        Clients
                    </div>
                    <div v-if="clients[0].data.length === 0" class="empty col-md-12 pt-2 pb-5 text-center">
                        <empty></empty><br>
                        <h3 class="p-2">No client found...</h3>
                    </div>
                    <div v-if="clients[0].data.length !== 0" class="dropdown m-2 text-right pt-2 form-inline ml-auto ">
                        <div v-if="$parent.client_request !== ''" class="pr-3">
                            <button class="btn btn-success" type="button" @click="$parent.client_request = ''">Show All</button>
                        </div>
                        <button class="btn btn-success dropdown-toggle" type="button" id="orderBy" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{orderBy}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="orderBy">
                            <h6 class="dropdown-header">Order By</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" @click="orderClient(sortBy, 'control_num')">Control No.</a>
                            <a class="dropdown-item" @click="orderClient(sortBy, 'client_name')">Name</a>
                            <a class="dropdown-item" @click="orderClient(sortBy, 'client_address')">Address</a>
                            <a class="dropdown-item" @click="orderClient(sortBy, 'client_contact')">Contact No.</a>
                            <a class="dropdown-item" @click="orderClient(sortBy, 'nature_request')">Nature of Request</a>
                            <a class="dropdown-item" @click="orderClient(sortBy, 'assigned_to')">Assigned to</a>
                            <a class="dropdown-item" @click="orderClient(sortBy, 'created_at')">Date Received</a>
                            <a class="dropdown-item" @click="orderClient(sortBy, 'proof_of_indigency')">Status</a>
                        </div>
                    </div>

                    <div v-if="clients[0].data.length !== 0" id="clients-table">
                        <table class="table table-hover text-center no-top-border pr-3 pl-3">
                            <thead class="thead">
                                <tr>
                                    <th><small style="font-size: 13px"><b>Control No.</b></small></th>
                                    <th><small style="font-size: 13px"><b>Name</b></small></th>
                                    <th><small style="font-size: 13px"><b>Address</b></small></th>
                                    <th><small style="font-size: 13px"><b>Contact No.</b></small></th>
                                    <th><small style="font-size: 13px"><b>Nature of Request</b></small></th>
                                    <th v-if="$gate.isStaffAndSuperAdmin()"><small style="font-size: 13px"><b>Assigned
                                                to</b></small></th>
                                    <th><small style="font-size: 13px"><b>Date Received</b></small></th>
                                    <th><small style="font-size: 13px"><b>Form</b></small></th>
                                    <th><small style="font-size: 13px"><b>Status</b></small></th>
                                    <th><small style="font-size: 13px"><b>Actions</b></small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="client in sortBy" :key="client.id" v-if="$parent.client_request === client.nature_request && $parent.client_request !== ''">
                                    <td><small style="font-size: 13px">{{ client.control_num }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.client_name }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.client_address }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.client_contact }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.nature_request }}</small></td>
                                    <td v-if="$gate.isStaffAndSuperAdmin()"><small style="font-size: 13px">Atty. {{
                                            client.assigned_to }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.created_at | renderDate }}</small></td>
                                    <td>
                                        <small style="font-size: 13px"><span v-if="client.proof_of_indigency.length !== 0"
                                                class="badge badge-success">Complete</span></small>
                                        <small style="font-size: 13px"><span v-if="client.proof_of_indigency.length === 0"
                                                class="badge badge-warning">Incomplete</span></small>
                                    </td>
                                    <td><small style="font-size: 13px">
                                            <div class="form-group" v-show="client.nature_request !== 'Representation in Court/Quasi-Judicial Bodies' && client.proof_of_indigency.length !== 0">
                                                <small for="detained" class="form__label">{{client.status}}
                                                </small>
                                                <label class="m-2 switch">
                                                    <input type="checkbox" @click="clientStatus(client, $event)" class="access_code">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>

                                            <span v-show="clients[1].length !== 0">
                                                <small v-show="client.nature_request === 'Representation in Court/Quasi-Judicial Bodies' && client.proof_of_indigency.length !==0">
                                                    <span v-show="checkControlNum(clients[1], client.control_num)"
                                                        v-tooltip.bottom="'Case Unprepared'"><i class="material-icons">remove</i></span>
                                                </small>

                                                <small v-show="client.nature_request !== 'Representation in Court/Quasi-Judicial Bodies' && client.proof_of_indigency.length ===0">
                                                    <span v-show="checkControlNum(clients[1], client.control_num)"
                                                        v-tooltip.bottom="'Form Incomplete'"><i class="material-icons">remove</i></span>
                                                </small>
                                            </span>


                                            <span v-for="data in cases" :key="data.id" v-if="client.proof_of_indigency.length !== 0">
                                                <span class="badge" v-if="client.control_num === data.control_num"
                                                    v-show="client.nature_request === 'Representation in Court/Quasi-Judicial Bodies'"
                                                    :class="{'badge-success': data.status === 'Pending', 'badge-primary': data.status === 'Arraignment', 'badge-secondary': data.status === 'Pre-Trial', 'badge-warning': data.status === 'Prosecution Evidence', 'badge-info': data.status === 'Defense Evidence', 'badge-danger': data.status !== 'Pending' && data.status !== 'Arraignment' && data.status !== 'Pre-Trial' && data.status !== 'Prosecution Evidence' && data.status !== 'Defense Evidence'}">
                                                    <span v-if="data.status !== 'Pending' && data.status !== 'Arraignment' && data.status !== 'Pre-Trial' && data.status !== 'Prosecution Evidence' && data.status !== 'Defense Evidence'">Terminated:
                                                    </span> {{data.status}}
                                                </span>
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="{ path: `clients/${client.control_num}`}"><button
                                                    v-tooltip.bottom="'View Form'" class="btn btn-sm btn-success m-1"><small
                                                        style="font-size: 13px"><i class="material-icons">visibility</i></small></button></router-link>
                                            <router-link :to="{ path: 'interview-form/'}"><button v-tooltip.bottom="'Create New Form'"
                                                    class="btn btn-sm btn-info m-1" style="color: #fff" @click="$parent.clientInfo = client"><small
                                                        style="font-size: 13px"><i class="material-icons">assignment</i></small></button></router-link>
                                            <span v-show="clients[1].length !== 0">
                                                <span v-show="client.nature_request === 'Representation in Court/Quasi-Judicial Bodies' && $gate.isAdminAndSuperAdmin() && client.proof_of_indigency.length !==0">
                                                    <router-link v-show="checkControlNum(clients[1], client.control_num)"
                                                        :to="{ path: `clients/prepare-case/${client.control_num}`}"><button
                                                            v-tooltip.bottom="'Prepare Case'" class="btn btn-primary  btn-sm m-1"><small
                                                                style="font-size: 13px"><i class="material-icons">work</i></small></button></router-link>
                                                </span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="client in sortBy" :key="client.id" v-if="$parent.client_request === ''">
                                    <td><small style="font-size: 13px">{{ client.control_num }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.client_name }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.client_address }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.client_contact }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.nature_request }}</small></td>
                                    <td v-if="$gate.isStaffAndSuperAdmin()"><small style="font-size: 13px">Atty. {{
                                            client.assigned_to }}</small></td>
                                    <td><small style="font-size: 13px">{{ client.created_at | renderDate }}</small></td>
                                    <td>
                                        <small style="font-size: 13px"><span v-if="client.proof_of_indigency.length !== 0"
                                                class="badge badge-success">Complete</span></small>
                                        <small style="font-size: 13px"><span v-if="client.proof_of_indigency.length === 0"
                                                class="badge badge-warning">Incomplete</span></small>
                                    </td>
                                    <td><small style="font-size: 13px">
                                            <div class="form-group" v-show="client.nature_request !== 'Representation in Court/Quasi-Judicial Bodies' && client.proof_of_indigency.length !== 0">
                                                <small for="detained" class="form__label">{{client.status}}
                                                </small>
                                                <label class="m-2 switch">
                                                    <input type="checkbox" @click="clientStatus(client, $event)" class="access_code">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>

                                            <span v-show="clients[1].length !== 0">
                                                <small v-show="client.nature_request === 'Representation in Court/Quasi-Judicial Bodies' && client.proof_of_indigency.length !==0">
                                                    <span v-show="checkControlNum(clients[1], client.control_num)"
                                                        v-tooltip.bottom="'Case Unprepared'"><i class="material-icons">remove</i></span>
                                                </small>

                                                <small v-show="client.nature_request !== 'Representation in Court/Quasi-Judicial Bodies' && client.proof_of_indigency.length ===0">
                                                    <span v-show="checkControlNum(clients[1], client.control_num)"
                                                        v-tooltip.bottom="'Form Incomplete'"><i class="material-icons">remove</i></span>
                                                </small>
                                            </span>


                                            <span v-for="data in cases" :key="data.id" v-if="client.proof_of_indigency.length !== 0">
                                                <span class="badge" v-if="client.control_num === data.control_num"
                                                    v-show="client.nature_request === 'Representation in Court/Quasi-Judicial Bodies'"
                                                    :class="{'badge-success': data.status === 'Pending', 'badge-primary': data.status === 'Arraignment', 'badge-secondary': data.status === 'Pre-Trial', 'badge-warning': data.status === 'Prosecution Evidence', 'badge-info': data.status === 'Defense Evidence', 'badge-danger': data.status !== 'Pending' && data.status !== 'Arraignment' && data.status !== 'Pre-Trial' && data.status !== 'Prosecution Evidence' && data.status !== 'Defense Evidence'}">
                                                    <span v-if="data.status !== 'Pending' && data.status !== 'Arraignment' && data.status !== 'Pre-Trial' && data.status !== 'Prosecution Evidence' && data.status !== 'Defense Evidence'">Terminated:
                                                    </span> {{data.status}}
                                                </span>
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="{ path: `clients/${client.control_num}`}"><button
                                                    v-tooltip.bottom="'View Form'" class="btn btn-sm btn-success m-1"><small
                                                        style="font-size: 13px"><i class="material-icons">visibility</i></small></button></router-link>
                                            <router-link :to="{ path: 'interview-form/'}"><button v-tooltip.bottom="'Create New Form'"
                                                    class="btn btn-sm btn-info m-1" style="color: #fff" @click="$parent.clientInfo = client"><small
                                                        style="font-size: 13px"><i class="material-icons">assignment</i></small></button></router-link>
                                            <span v-show="clients[1].length !== 0">
                                                <span v-show="client.nature_request === 'Representation in Court/Quasi-Judicial Bodies' && $gate.isAdminAndSuperAdmin() && client.proof_of_indigency.length !==0">
                                                    <router-link v-show="checkControlNum(clients[1], client.control_num)"
                                                        :to="{ path: `clients/prepare-case/${client.control_num}`}"><button
                                                            v-tooltip.bottom="'Prepare Case'" class="btn btn-primary  btn-sm m-1"><small
                                                                style="font-size: 13px"><i class="material-icons">work</i></small></button></router-link>
                                                </span>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table><br>
                    </div>
                    <pagination :data="paginate" @pagination-change-page="paginateClients" :show-disabled="true">
                        <span slot="prev-nav">Prev</span>
	                    <span slot="next-nav">Next</span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                onGoing: false,
                orderBy: 'Order By',
                sortBy: {},
                clients: {},
                cases: {},
                paginate: {}
            }
        },
        methods: {
            loadClients() {
                axios.get('api/clients').then(({
                    data
                }) => {
                    this.paginate = data[0]
                    this.clients = data
                    this.sortBy = this.clients[0].data
                    this.cases = this.clients[2]
                    setTimeout(() => {
                        for (let i = 0; i < this.sortBy.length; i++) {
                            if (this.sortBy[i].status === 'On-Going') {
                                this.$el.querySelectorAll('.access_code')[i].checked = true
                            } else {
                                this.$el.querySelectorAll('.access_code')[i].checked = false
                            }
                        }
                    }, 1000)
                })
            },
            orderClient(data, order) {
                this.sortBy = _.orderBy(data, order, ['asc', 'desc'])
                this.orderBy = order.toLowerCase()
                    .split('_')
                    .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
                    .join(' ')
            },
            paginateClients(page = 1) {
                axios.get('api/clients?page=' + page).then((response) => {
                    this.paginate = response.data[0]
                    this.clients = response.data
                    this.sortBy = this.clients[0].data
                })
            },
            checkControlNum(id, control_num) {
                if (id.length == 0) {
                    return false
                } else {
                    for (let i = 0; i < id.length; i++) {
                        if (id[i].control_num === control_num) {
                            return true
                        }
                    }
                }
            },
            clientStatus(client, event) {
                if (client.status === 'On-Going') {
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, finish it!'
                    }).then((result) => {
                        if (result.value) {
                            this.onGoing = !this.onGoing

                            let clientToUpdate = new Form({
                                control_num: client.control_num,
                                status: 'Finished'
                            })
                            client.status = 'Finished'
                            clientToUpdate.post('api/client-status')
                            event.target.disabled = true
                            //  else {
                            //     let clientToUpdate = new Form({
                            //         control_num: client.control_num,
                            //         status: 'On-Going'
                            //     })
                            //     client.status = 'On-Going'
                            //     clientToUpdate.post('api/client-status')
                            // }
                        } else {
                            event.target.checked = true
                        }
                    })
                }
            },
        },
        mounted() {
            this.loadClients()
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
