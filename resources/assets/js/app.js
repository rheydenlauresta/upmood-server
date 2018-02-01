
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
Vue.component('usersprofile-component', require('./components/UsersProfile.vue'));
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
      	var wrapper_width = parseInt($(".messages-wrapper").css('width').replace('px',''));
        var nav = parseInt($(".messages-nav").css('width').replace('px',''));
        var list = parseInt($(".messages-list").css('width').replace('px',''));
        var new_width = wrapper_width - (nav + list);
        $(".messages-content").css('width',new_width + "px");
      }
});

$(document)
.one('focus.autoExpand', 'textarea.autoExpand', function(){
    var savedValue = this.value;
    this.value = '';
    this.baseScrollHeight = this.scrollHeight;
    this.value = savedValue;
})
.on('input.autoExpand', 'textarea.autoExpand', function(){
    var minRows = this.getAttribute('data-min-rows')|0, rows;
    this.rows = minRows;
    rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 16);
    this.rows = minRows + rows;
});

$(document).on('click keyup change',".bootstrap-tagsinput > input",function(){

    if($(this).val().length){
        var input = $(this).val();

        $(".suggestion-row").each(function(index){
            var name = $(this).children('.suggestion-content').children('.suggestion-name').html();
            var email = $(this).children('.suggestion-content').children('.suggestion-email').html(); 

            if (name.indexOf(input) >= 0){
              $(this).show();
            }
            else if (email.indexOf(input) >= 0){
              $(this).show();
            }
            else{
              $(this).hide();
            }
        });

        $(".compose-suggestion").show();
    }
    else{
        $(".compose-suggestion").hide();
    }
});

$(document).on('keyup change',".contact-search-input",function(){
    if(true){
        var input = $(this).val();

        $(".contact-row").each(function(index){
            var name = $(this).children('.contact-content').children('.contact-name').html();
            var email = $(this).children('.contact-content').children('.contact-email').html(); 

            if (name.indexOf(input) >= 0){
              $(this).show();
            }
            else if (email.indexOf(input) >= 0){
              $(this).show();
            }
            else{
              $(this).hide();
            }
        });

        $(".contact-wrapper").show();
    }
    else{
        $(".contact-wrapper").hide();
    }
});

$(document).on('blur',".bootstrap-tagsinput > input",function(){
    $(".compose-suggestion").hide();
});