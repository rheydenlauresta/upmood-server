<template>
  <div class="bg">
    <div class="center">
        <div class="login">
          <img :src="base_url+'img/ic_upmood.png'" class="logo" alt="Upmood Logo"/>
          <div class="form">
              <form method="post" class="form-horizontal" @submit.prevent="submitForm">
                  <input type="hidden" name="_token" :value="csrf">

                  <!-- Warning Alerts -->
                  <div class="form-group alert" v-bind:class="{'has-error': error}">
                    <i class="ic ic-warn"></i>
                    <p><span class="msg">Username/Password is invalid!</span></p>
                  </div>
                  <div class="form-group alert notif" :class="warning.email ? 'has-notif' : ''">
                    <p>A password reset link has been sent. </p>
                    <span>x</span>
                  </div>
                  <!-- Warning Alerts -->
                  
                  <div class="form-group text-left" :class="error.email ? 'has-error' : ''">
                      <label for="email">Email Address</label> <i class="ic ic-email"></i>
                      <input
                        id="email"
                        placeholder="Email@info.com"
                        type="email"
                        class="form-control"
                        name="email"
                        v-model="email"
                        :class="error.email ? 'has-error' : ''"
                        required autofocus
                      > <i class="ic ic-error"></i>
                  </div>
                  <div class="form-group text-left" :class="error.password ? 'has-error' : ''">
                      <label for="password">Password</label>
                      <i class="ic ic-password"></i>
                      <input
                        id="password"
                        placeholder="Enter Password"
                        type="password"
                        class="form-control"
                        name="password"
                        v-model="password"
                        required
                      >
                      <i class="ic ic-error"></i>
                      <span class="ic decrypt" v-if="password.length" @click="togglePassword">{{status}}</span>
                  </div>

                  <div class="form-group text-left">
                      <a class="btn-link" :href="base_url+ 'reset'">Can't remember password?</a>
                  </div>

                  <div class="form-group">
                      <button type="submit" class="btn btn-block"> Log In </button>
                  </div>
              </form>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                base_url: window.base_url,
                error: false,
                warning: [],
                email: '',
                password: '',
                status: 'show'
            }
        },
        mounted() {
          
        },

        methods:{
          togglePassword(){
            if(this.status === 'show'){
                $('#password').attr('type', 'text');
                this.status = 'hide';
            }else{
                $('#password').attr('type', 'password');
                this.status = 'show';
            }
          },

          submitForm(){

              let vue = this;

              axios.post(base_url + 'login',{
                email: this.email,
                password: this.password
              }).then(function(response){
                location.href = base_url+'dashboard';
              }).catch(function(e){
                  vue.error = true;
                  vue.password = '';
              })
          }

        }
    }
</script>
