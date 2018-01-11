
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('main-header', require('./components/Header.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('passwordreset', require('./components/PasswordReset.vue'));

const app = new Vue({
    el: '#app',
});
