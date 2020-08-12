/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
window.Fire = new Vue()
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import {Form, HasError, AlertError} from 'vform';
window.toast = toast;

window.Form = Form;
import moment from 'moment'
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', swal.stopTimer)
        toast.addEventListener('mouseleave', swal.resumeTimer)
    }
});

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: '#e1e814',
    failedColor: 'red',
    height: '10px'

})

// import { VuejsDatatableFactory } from 'vuejs-datatable';

// Vue.use( VuejsDatatableFactory );
import numeral from 'numeral';

var categoryThumb = "localhost:8000/uploads/Category/thumbnail"
var categoryPhotos = "localhost:8000/uploads/Category/photos"

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase()+ text.slice(1);
});

Vue.filter('firstChart', function(text){
    return text.charAt(0);
});

Vue.filter('up', function(text){
    return text.toUpperCase();
});

Vue.filter('currency', function(text){
    var number = numeral(text);

    return "₦" + number.format('0,0.00');

})

Vue.filter('myDate', function(created){
    return moment(created).format('MMMM Do YYYY, h:mma');
})

Vue.filter('timeAgo', function(created){
    return moment(created).startOf('hour').fromNow();
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('categories', require('./components/categories.vue').default);

Vue.component('room', require('./components/room.vue').default);

Vue.component('dashboard', require('./components/dashboard.vue').default);

Vue.component('loading', require('./components/loading.vue').default);

Vue.component('role', require('./components/role.vue').default);

Vue.component('user', require('./components/user.vue').default);

Vue.component('booking', require('./components/booking.vue').default);

Vue.component('notifications', require('./components/notifications.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
