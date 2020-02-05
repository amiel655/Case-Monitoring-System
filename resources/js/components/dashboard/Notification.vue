<template>
    <li class="nav-item dropdown" id="markasread">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <span v-if="unreadNotifications.length === 0">
                <i class="material-icons">
                    notifications
                </i>
            </span>

            <span v-if="unreadNotifications.length !== 0">
                <i class="material-icons" style="color: #fff">
                    notifications_active
                </i>
                <span class="badge badge-danger navbar-badge">{{unreadNotifications.length}}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span v-if="unreadNotifications.length === 1">
                <span class="dropdown-header">{{unreadNotifications.length}} Notification</span>
                <div class="dropdown-divider"></div>
            </span>
            <span v-if="unreadNotifications.length > 1">
                <span class="dropdown-header">{{unreadNotifications.length}} Notifications</span>
                <div class="dropdown-divider"></div>
            </span>
            <notification-item v-for="(unread, index) in unreadNotifications" :key="unread.id" :unread="unread" :index="index" :notif="unreadNotifications"></notification-item>
            <div v-if="unreadNotifications.length === 0">
                <p class="text-center" style="color: #fff">No Notification</p>
            </div>

        </div>
    </li>
</template>

<script>
    import NotificationItem from './Notification-Item.vue'
    export default {
        props: ['unread', 'userid'],
        components: {
            NotificationItem
        },
        data() {
            return {
                unreadNotifications: this.unread
            }
        },
        methods: {

        },
        mounted() {
            Echo.private('App.User.' + this.userid)
                .notification((notification) => {
                    let newUnreadNotifications = {
                        data: {
                            id: notification.id,
                            assigned_by: notification.assigned_by,
                            control_num: notification.control_num,
                            user: notification.control_num,
                            case_no: notification.case_no,
                            assigned_by_image: notification.assigned_by_image,
                            assigned_from: notification.assigned_from,
                            assigned_to: notification.assigned_to,
                            image: notification.image,
                            hearing_date: notification.hearing_date,
                            client_assigned_by_image: notification.client_assigned_by_image,
                            client_assigned_from: notification.client_assigned_from,
                            client_assigned_to: notification.client_assigned_to,
                            client_image: notification.client_image,
                        }
                    }
                    this.unreadNotifications.push(newUnreadNotifications)
                });

        }
    }

</script>
