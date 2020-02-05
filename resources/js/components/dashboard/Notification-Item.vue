<template>
    <div>
        <div class="wrap">
            <a :href="'/clients/' + unread.data.control_num" class="dropdown-item" @click="markNotificationAsRead($event, 'assignedClient')"
                v-if="unread.data.assigned_by !== undefined && unread.data.case_no === undefined">
                <img :src="'./img/profile-picture/' + unread.data.assigned_by_image" v-if="unread.data.assigned_by_image !== undefined"
                    class="img-fluid img-circle img-border" style="width: 40px !important">
                <span class="pl-2" style="color: #fff">New Client</span>
                <br>
                <small>
                    <span style="color: #34cc7d">{{ unread.data.assigned_by }}</span>
                    assigned you a client
                </small><br>
                <!-- <p class="float-right text-muted text-sm pl-2">{{unread.created_at | fromNow}}</p> -->
            </a>
            <a :href="'cases/'" class="dropdown-item" @click="markNotificationAsRead($event, 'transferedCase')" v-if="unread.data.assigned_from === fullName">
                <img :src="'./img/profile-picture/' + unread.data.image" v-if="unread.data.image !== undefined" class="img-fluid img-circle img-border"
                    style="width: 40px !important">
                <img :src="'./img/profile-picture/profile-placeholder.jpg'" v-if="unread.data.image === undefined"
                    class="img-fluid img-circle img-border" style="width: 40px !important">
                <span class="pl-2" style="color: #fff">Transferred Case</span><br> <small><span style="color: #34cc7d">Case
                        {{ unread.data.case_no }}</span>
                    was transferred to <span style="color: #34cc7d">{{ unread.data.assigned_to }}</span></small><br>
                <!-- <p class="float-right text-muted text-sm pl-2">{{unread.created_at | fromNow}}</p> -->
            </a>
            <a :href="'/cases'" class="dropdown-item" @click="markNotificationAsRead($event, 'transferedCase')" v-if="unread.data.assigned_to === fullName">
                <img :src="'./img/profile-picture/' + unread.data.image" v-if="unread.data.image !== undefined" class="img-fluid img-circle img-border"
                    style="width: 40px !important">
                <img :src="'./img/profile-picture/profile-placeholder.jpg'" v-if="unread.data.image === undefined"
                    class="img-fluid img-circle img-border" style="width: 40px !important">
                <span class="pl-2" style="color: #fff">Transferred Case</span><br><small> <span style="color: #34cc7d">Case
                        {{ unread.data.case_no }}</span>
                    was transferred to you from <span style="color: #34cc7d">{{ unread.data.assigned_from }}</span></small><br>
                <!-- <p class="float-right text-muted text-sm pl-2">{{unread.created_at | fromNow}}</p> -->
            </a>
            <a :href="'clients/'" class="dropdown-item" @click="markNotificationAsRead($event, 'transferedClient')"
                v-if="unread.data.client_assigned_from === fullName">
                <img :src="'./img/profile-picture/' + unread.data.client_image" v-if="unread.data.client_image !== undefined"
                    class="img-fluid img-circle img-border" style="width: 40px !important">
                <img :src="'./img/profile-picture/profile-placeholder.jpg'" v-if="unread.data.client_image === undefined"
                    class="img-fluid img-circle img-border" style="width: 40px !important">
                <span class="pl-2" style="color: #fff">Transferred Client</span><br> <small>A Client
                    was transferred to <span style="color: #34cc7d">{{ unread.data.client_assigned_to }}</span></small><br>
                <!-- <p class="float-right text-muted text-sm pl-2">{{unread.created_at | fromNow}}</p> -->
            </a>
            <a :href="'clients/'" class="dropdown-item" @click="markNotificationAsRead($event, 'transferedClient')"
                v-if="unread.data.client_assigned_to === fullName">
                <img :src="'./img/profile-picture/' + unread.data.client_image" v-if="unread.data.client_image !== undefined"
                    class="img-fluid img-circle img-border" style="width: 40px !important">
                <img :src="'./img/profile-picture/profile-placeholder.jpg'" v-if="unread.data.client_image === undefined"
                    class="img-fluid img-circle img-border" style="width: 40px !important">
                <span class="pl-2" style="color: #fff">Transferred Client</span><br> <small>A Client
                    was transferred to you from <span style="color: #34cc7d">{{ unread.data.client_assigned_from }}</span></small><br>
                <!-- <p class="float-right text-muted text-sm pl-2">{{unread.created_at | fromNow}}</p> -->
            </a>
            <a :href="'/cases/' + unread.data.control_num" class="dropdown-item" @click="markNotificationAsRead($event, 'hearingDate')"
                v-if="unread.data.hearing_date !== undefined">
                <small>
                    <calendar-icon></calendar-icon> You have a hearing for tomorrow <span style="color: #34cc7d">{{unread.data.hearing_date}}</span>
                </small><br>
                <!-- <p class="float-right text-muted text-sm pl-2">{{unread.created_at | fromNow}}</p> -->
            </a>
        </div>
        <div class="dropdown-divider"></div>
    </div>
</template>

<script>
    export default {
        props: ['index', 'unread', 'notif'],
        data() {
            return {
                notifUrl: '',
                fullName: '',
                authUser: new Form({
                    id: '',
                    firstname: '',
                    middlename: '',
                    lastname: '',
                    username: '',
                    gender: '',
                    password: '',
                    type: '',
                    image: ''
                })
            }
        },
        methods: {
            loadProfile() {
                axios.get('api/profile').then(({
                    data
                }) => {
                    this.fullName = data.firstname + ' ' + data.lastname
                })
            },
            markNotificationAsRead(event, notifType) {
                event.preventDefault()
                if (this.unread.data.id === undefined) {
                    axios.get('api/markAsRead/' + this.notif[this.index].id).then(() => {
                        if (notifType === 'assignedClient') {
                            window.location.href = 'clients/' + this.unread.data.control_num
                        } else if (notifType === 'transferedCase') {
                            window.location.href = 'cases/'
                        } else if (notifType === 'transferedClient') {
                            window.location.href = 'clients/' + this.unread.data.client_control_num
                        } else if (notifType === 'hearingDate'){
                            window.location.href = 'cases/' + this.unread.data.control_num
                        }
                    })
                }
                if (this.notif[this.index].id === undefined) {
                    axios.get('api/markAsRead/' + this.unread.data.id).then(() => {
                        if (notifType === 'assignedClient') {
                            window.location.href = 'clients/' + this.unread.data.control_num
                        } else {
                            window.location.href = 'cases/'
                        }
                    })
                }

            }
        },
        mounted() {
            this.loadProfile();
            this.notifUrl = '/clients/' + this.unread.data.control_num
        }
    }

</script>
