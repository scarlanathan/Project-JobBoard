<template>
  <div class="d-flex flex-column justify-content-center w-100 align-items-center h-100 mt-3" id="register-app" style="background-image:url(Image/login.png)">
    <h1 class="h3 mb-3 fw-normal" style="margin-top: 30px; font-family:Verdanax">Please sign in</h1>
    <div class="d-flex flex-column gap-2 w-50"  style="height: 50vh">
      <div class="form-floating" style = "margin-top: 40px">
        <input v-model="email" class="form-control" placeholder="name@example.com" id="floatingInput">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" v-model="password" placeholder="Password" id="floatingPassword">
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" v-model="password_confirm" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="Recruteurs" v-model="checked_rh"> I am a company.
        </label>
      </div>
      <button @click="register" class="btn btn-primary" v-if="!isLoading">
        Register
      </button>
      <button class="btn btn-primary" type="button" disabled v-if="isLoading">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
      </button>
      <transition name="fade" mode="out-in">
        <p v-if="errorMessage" :class="error_class" ref="errorElement">{{ errorMessage }}</p>
      </transition>
      <div class="loading-blur" v-if="isLoading">
        <div class="spinner-border" role="status">

        </div>
        <transition name="fade" mode="out-in">
          <p v-if="errorMessage" :class="error_class" ref="errorElement">{{ errorMessage }}</p>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data(){
    return {
      email: '',
      password: '',
      password_confirm: '',
      errorMessage: '',
      isLoading: false,
      timeout: 4000,
      error_class: "alert alert-danger mt-5",
      checked_rh: '',
    }

  },
  mounted() {
    setInterval(()=>{
      if (this.isLoading){
        document.body.style.overflowY = "hidden";
      }else{
        document.body.style.overflowY = "auto";
      }
    },100)
  },
  methods: {
    async register(){
      this.errorMessage = '';
      this.isLoading = true;

      if (!this.email || !this.password || !this.password_confirm){
        this.errorMessage = 'Please fill in both fields.';
        this.isLoading = false;
        setTimeout(()=>{
          this.errorMessage = '';
        },this.timeout)
        return;
      }

      try {
        const response = await axios.post('/api/register',{
          email: this.email,
          password: this.password,
          password_confirm: this.password_confirm,
          is_hr: this.checked_rh.toString(),
        })

        this.error_class = "alert alert-success mt-5";
        let user_email = response.data["user_email"]
        this.errorMessage = "User : " + user_email + " register success ! " + "redirect to login ...";
        document.cookie = "user_email=" + user_email + "; expires=Thu, 01 Jan 2025 00:00:00 UTC; path=/";
        setTimeout(()=>{
          this.login();
        },this.timeout + 1000)

      } catch (error) {
        this.errorMessage = error.response.data.message || 'Register failed';
        this.isLoading = false;
        setTimeout(()=>{
          this.errorMessage = '';
        },this.timeout);
      }
    },
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
        this.errorMessage = "Login ...";
        const response = await axios.post('/api/login_check', {
          email: this.email,
          password: this.password
        });

        window.location.href = "/profile";

      } catch (error) {

      }
    }
  }
}

</script>