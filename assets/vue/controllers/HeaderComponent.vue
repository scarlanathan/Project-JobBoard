<template>
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
        <img src="Image/PoleEpitech.png" width="50" height="50" aria-label="Bootstrap" alt="">
      </a>
      <ul class="nav col-12 col-lg-4 me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/about_us" class="nav-link px-2 link-secondary">About us</a></li>
        <li><a href="/recherche?key=" class="nav-link px-2 link-secondary">Jobs</a></li>
        <li><a href="/advice" class="nav-link px-2 link-secondary">Advice</a></li>
      </ul>
      <div class="d-flex flex-row gap-2 pointer user-dropdown" v-if="user_email" @click="controller_dropdown">
        <img src="images/149071.png" width="40" height="40" aria-label="Bootstrap" alt="">
        <p class="lead align-middle mb-0 mt-1">{{ this.user_email }}</p>
        <transition name="my-fade" mode="out-in">
          <ul class="user-dropdown-item p-0" v-if="dropdown">
            <li class="lead" @click="redirect('profile')">Profile</li>
            <li class="lead" @click="redirect('advertisements')" v-if="is_companie">Advertisements</li>
            <li class="lead" @click="redirect('candidates')" v-if="is_companie">Candidates</li>
            <li class="lead" @click="redirect('messages')">Messages</li>
            <li class="lead" @click="logout">Logout</li>
          </ul>
        </transition>
      </div>
      <div class="col-md-3 text-end" v-show="!user_email">
        <button type="button" class="btn btn-outline-primary me-2" @click="redirect('login')">Login</button>
        <button type="button" class="btn btn-outline-primary me-2" @click="redirect('register')">Register</button>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data(){
    return {
      user_email: null,
      dropdown: false,
      is_companie:false,
    }
  },
  mounted() {
    this.GetUser();
  },
  methods:{
    async GetUser(){
      try {
        const response = await axios.get('/api/get_user');
        this.user_email = response.data.user_email
        let role = response.data.user_role;
        if (role.includes("ROLE_COMPAINE")){
          this.is_companie = true;
        }
      }catch (error){

      }
    },
    GetCookieByName(cookie_name){
      let match = document.cookie.match(new RegExp('(^| )' + cookie_name + '=([^;]+)'));
      if (match) return match[2];
    },
    DeleteCookieByName(cookie_name){
      document.cookie = cookie_name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    },
    async logout(){
      try {
        const response = await axios.post('/api/logout_check');

        if (response.data.logout){
          location.href = "/";
        }
      }catch (error){

      }
    },
    controller_dropdown(){
      this.dropdown = !this.dropdown;
    },
    redirect(path){
      window.location.href = "/" + path;
    }
  }
};
</script>