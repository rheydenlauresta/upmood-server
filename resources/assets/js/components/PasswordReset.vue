<template>
  <div class="bg">
    <div class="center">
        <div class="login reset">
          <img :src="base_url+'img/ic_upmood.png'" class="logo" alt="Upmood Logo"/>

          <h3>Forgot your Password</h3>
          <p>Enter your email address below and we'll get you back on track.</p>

          <div class="form">
              <form class="form-horizontal" method="POST" :action="base_url+'login'" @submit.prevent="submitReset">
                  <div class="form-group alert" :class="error.email ? 'has-error' : ''">
                    <i class="ic ic-warn"></i>
                    <p>Whoops!!<br><span class="msg">Username Already Used!!</span></p>
                  </div>
                  <div class="form-group alert notif" :class="warning.email ? 'has-notif' : ''">
                    <p>A password reset link has been sent. </p>
                    <span>x</span>
                  </div>
                  <input type="hidden" name="_token" :value="csrf">
                  <div class="form-group text-left" :class="error.email ? 'has-error' : ''">
                      <label for="email">Email Address</label>
                      <i class="ic ic-email"></i>
                      <input
                        id="email"
                        placeholder="Email@info.com"
                        type="email"
                        class="form-control"
                        name="email"
                        :class="error.email ? 'has-error' : ''"
                        required autofocus
                      >
                      <i class="ic ic-error"></i>
                  </div>

                  <div class="form-group">
                      <button type="submit" class="btn btn-block"> Request Reset Link </button>
                  </div>
                  <div class="form-group text-center">
                      <a class="btn-link" :href="base_url">Back to Sign In</a>
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
                error: {},
                warning: {},
            }
        },
        mounted() {
            
        },

        methods:{
          submitReset(){
              
          }
        }
    }
</script>
