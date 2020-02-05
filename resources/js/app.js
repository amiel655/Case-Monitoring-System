/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
require('froala-editor/js/froala_editor.pkgd.min')
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import swal from 'sweetalert2';
import VueRouter from 'vue-router';
import {
    Form,
    HasError,
    AlertError
} from 'vform';
import Gate from './Gate';
import Vuelidate from 'vuelidate';
import VueFroala from 'vue-froala-wysiwyg';
import VTooltip from 'v-tooltip';
import vSelect from 'vue-select';

let routes = [{
        path: "/dashboard",
        component: require("./components/dashboard/Dashboard.vue")
    },
    {
        path: "/developer",
        component: require("./components/Developer.vue")
    },
    {
        path: "/profile",
        component: require("./components/dashboard/Profile.vue")
    },
    {
        path: "/interview-form/",
        component: require("./components/dashboard/staff/InterviewForm.vue")
    },
    {
        path: "/clients",
        component: require("./components/dashboard/Clients.vue")
    },
    {
        path: "/clients/:id",
        name: "client-form",
        component: require("./components/dashboard/Client-Form.vue")
    },
    {
        path: "/reports/individual-performance-report",
        component: require("./components/dashboard/Individual-Performance-Report.vue")
    },
    {
        path: "/reports/individual-report-cicl",
        component: require("./components/dashboard/Individual-Report-CICL.vue")
    },
    {
        path: "/reports/inquest-report",
        component: require("./components/dashboard/Inquest-Report.vue")
    },
    {
        path: "/reports/list-detainees-represented-court",
        component: require("./components/dashboard/List-Detainees-Represented-Court.vue")
    },
    {
        path: "/reports/list-favorable-decision-dispositions",
        component: require("./components/dashboard/List-Favorable-Decision-Dispositions.vue")
    },
    {
        path: "/reports/document-notarized",
        component: require("./components/dashboard/Document-Notarized.vue")
    },
    {
        path: "/reports/report-victims-cases-handled",
        component: require("./components/dashboard/Report-Victims-Cases-Handled.vue")
    },
    {
        path: "/reports/monthly-inventory-cases",
        component: require("./components/dashboard/Monthly-Inventory-Cases.vue")
    },
    {
        path: "/reports/monthly-inventory-client-served",
        component: require("./components/dashboard/Monthly-Inventory-Client-Served.vue")
    },
    {
        path: "/users",
        component: require("./components/dashboard/super-admin/Users.vue")
    },
    {
        path: "/calendar",
        component: require("./components/Calendar.vue")
    },
    {
        path: "/clients/prepare-case/:id",
        component: require("./components/dashboard/Prepare-Case.vue")
    },
    {
        path: "/cases",
        component: require("./components/dashboard/Case-Monitoring.vue")
    },
    {
        path: "/cases/:id",
        component: require("./components/dashboard/Case.vue")
    },
    {
        path: "/audit",
        component: require("./components/dashboard/Audit.vue")
    },
    {
        path: "*",
        component: require("./components/NotFound.vue")
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.Vue = require('vue');
window.Form = Form;
window.swal = swal;
window.toast = toast;
window.Fire = new Vue();
window.moment = moment;

Vue.prototype.$gate = new Gate(window.user);

Vue.use(VueRouter);
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
});
Vue.use(Vuelidate);
Vue.use(VueFroala);
Vue.use(VTooltip);
Vue.directive('v-tooltip', VTooltip)

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('v-select', vSelect);

Vue.filter('renderDate', (date) => {
    return moment(date).format('MMMM Do YYYY');
});

Vue.filter('fromNow', (date) => {
    return moment(date).startOf('hour').fromNow()
});

Vue.filter('auditDate', (date) => {
    return moment(date).format('MMMM Do YYYY, h:mm:ss a')
});

Vue.filter('month', (date) => {
    return moment(date).format('MMMM')
});

Vue.filter('capitalize', (string) => {
    if (!string) return ''
    string = string.toString()
    return string.charAt(0).toUpperCase() + string.slice(1)
});

Vue.filter('auditType', (string) => {
    string = string.replace('App\\', '').replace(/([A-Z])/g, ' $1').trim()
    return string.charAt(0).toUpperCase() + string.slice(1)
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue')
);

Vue.component(
    'male-icon',
    require('./components/Male-Icon.vue')
);

Vue.component(
    'female-icon',
    require('./components/Female-Icon.vue')
);

Vue.component(
    'view-icon',
    require('./components/View-Icon.vue')
);

Vue.component(
    'court-icon',
    require('./components/Court-Icon.vue')
);

Vue.component(
    'dashboard-icon',
    require('./components/Dashboard-Icon.vue')
);

Vue.component(
    'calendar-icon',
    require('./components/Calendar-Icon.vue')
);

Vue.component(
    'clients-icon',
    require('./components/Clients-Icon.vue')
);

Vue.component(
    'users-icon',
    require('./components/Users-Icon.vue')
);

Vue.component(
    'management-icon',
    require('./components/Management-Icon.vue')
);

Vue.component(
    'profile-icon',
    require('./components/Profile-Icon.vue')
);

Vue.component(
    'interview-form-icon',
    require('./components/Interview-Form-Icon.vue')
);

Vue.component(
    'crime-icon',
    require('./components/Crime-Icon.vue')
);

Vue.component(
    'nature-req-icon',
    require('./components/Nature-Request-Icon.vue')
);

Vue.component(
    'case-already-exist-icon',
    require('./components/Case-Already-Exist-Icon.vue')
);

Vue.component(
    'audit-icon',
    require('./components/Audit-Icon.vue')
);

Vue.component(
    'profile-reports',
    require('./components/dashboard/Profile-Reports.vue')
);

Vue.component(
    'empty',
    require('./components/Empty.vue')
);

Vue.component(
    'notification',
    require('./components/dashboard/Notification.vue')
);

Vue.component(
    'notification-item',
    require('./components/dashboard/Notification-Item.vue')
);

Vue.component('example-component', require('./components/ExampleComponent.vue'));


const app = new Vue({
    el: '#app',
    router,
    data: {
        search: '',
        searchResults: '',
        clientInfo: {},
        is_confirmed: false,
        client_request: ''
    },
    methods: {
        searching: _.debounce(() => {
            Fire.$emit('searching');
        }, 1000),
        clearClientInfo: () => {
            if (Object.keys(app.clientInfo).length !== 0) {
                app.clientInfo = {}
                document.location.reload()
            }
        },
        clearClientRequest: () => {
                app.client_request = ''
        }
    }
});
