<template>
  <div class="d-flex flex-column justify-content-center w-100 align-items-center h-100 mt-3" id="login-app" style="background-image:url(Image/login.png)" >
    <h1 class="h3 mb-3 fw-normal" style="margin-top: 30px; font-family:Verdanax">Login please</h1>
    <div class="d-flex flex-column gap-2 w-50" style="height: 50vh">
      <div class="form-floating" style = "margin-top: 40px">
        <input v-model="email" class="form-control" placeholder="name@example.com" id="floatingInput">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" v-model="password" placeholder="Password" id="floatingPassword">
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-check text-start my-3">
        <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
          Remember me
        </label>
      </div>
      <button @click="login" class="btn btn-primary">
        Login
        <span v-if="isLoading">Loading...</span>
      </button>
      <transition name="fade" mode="out-in">
        <p v-if="errorMessage" class="alert alert-danger" ref="errorElement">{{ errorMessage }}</p>
      </transition>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {

  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
      isLoading: false,
      timeout: 4000,
      user_email_register: '',
    };
  },
  mounted() {
    this.user_email_register = this.GetCookieByName("user_email");
    if (this.user_email_register){
      this.email = this.user_email_register
      this.DeleteCookieByName("user_email");
    }
  },
  methods: {

    async login() {

      this.errorMessage = '';
      this.isLoading = true;

      if (!this.email || !this.password) {
        this.errorMessage = 'Please fill in both fields.';
        this.isLoading = false;
        setTimeout(()=>{
          this.errorMessage = '';
        },this.timeout)
        return;
      }

      try {
        const response = await axios.post('/api/login_check', {
          email: this.email,
          password: this.password
        });

        this.isLoading = false;
        window.location.href = "/";
      } catch (error) {

        this.errorMessage = error.response.data.message || 'Login failed';
        this.isLoading = false;
        setTimeout(()=>{
          this.errorMessage = '';
        },this.timeout);
      }
    },
    GetCookieByName(cookie_name){
      let match = document.cookie.match(new RegExp('(^| )' + cookie_name + '=([^;]+)'));
      if (match) return match[2];
    },
    DeleteCookieByName(cookie_name){
      document.cookie = cookie_name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
  }
};

</script>