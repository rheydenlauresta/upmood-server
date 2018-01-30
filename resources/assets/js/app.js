
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import router from './router';

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('main-header', require('./components/Header.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('passwordreset', require('./components/PasswordReset.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('users-component', require('./components/Users.vue'));
Vue.component('messages-component', require('./components/Messages.vue'));

const app = new Vue({
   el: '#app',
   router: router,
});

$(document).ready(function(){
	$('.scrollbar-outer').scrollbar();
});

$(window).on('resize', function(){
      if ($(".messages-wrapper").length){
      	var wrapper_width = $(".messages-wrapper").css('width').replace('px','');
        var nav = $(".messages-nav").css('width').replace('px','');
        var list = $(".messages-list").css('width').replace('px','');
        var new_width = parseInt(wrapper_width) - (parseInt(nav) + parseInt(list));
        $(".messages-content").css('width',new_width + "px");

        var nav_height = $(".messages-nav").css('height');
        $(".messages-content").css('height',nav_height);
      }
});