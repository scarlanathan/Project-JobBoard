<template>
  <div class="container pt-3 py-5">
  <div class="d-flex flex-row">
    <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary" style="width: 40vh;height: 100vh;overflow-y: auto;">
      <a href="/" class="d-flex flex-column align-items-center flex-shrink-0 p-3 link-body-emphasis text-decoration-none border-bottom">
        <span class="fs-5 fw-semibold">Advertisements</span>
      </a>
      <div class="list-group list-group-flush border-bottom scrollarea">
        <div class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true" v-for="candidate in this.candidate_user">
          <div class="d-flex w-100 align-items-center justify-content-between">
            <strong class="mb-1">{{ candidate.ad_name}}</strong>
          </div>
          <ul class="list-group">
            <p class="lead">Candidate User</p>
            <li class="list-group-item" v-for="user in candidate.user_profile" @click="open_profile(user.profile_id)">{{ user.email }}</li>
          </ul>
          <ul class="list-group">
            <p class="lead">Candidate Anonymous</p>
            <li class="list-group-item" v-for="user in candidate.user_anonymous" @click="open_profile_anonymous(user.profile_id)">{{ user.email }}</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="w-100" style="max-height: 100vh;">
      <div class="d-flex flex-column" v-if="is_user">
        <label for="username" class="form-label">User_name : {{user_name}}</label>
        <label for="Information User" class="form-label">Information User : {{info_user}}</label>
        <label for="Location" class="form-label">Location : {{location}}</label>
        <div class="w-100" v-if="cv_path">
          <iframe v-bind:src="cv_path" style="width:100%;height: 600px;margin: 0 auto;"></iframe>
        </div>
      </div>
      <div class="d-flex flex-column" v-if="is_anonymous">
        <label for="username" class="form-label">User_name : {{anonymous_email}}</label>
        <label for="username" class="form-label">Letter Motivation : {{anonymous_lm}}</label>
        <label for="username" class="form-label">Phone : {{anonymous_phone}}</label>
        <label for="username" class="form-label">Content : {{anonymous_content}}</label>
        <div class="w-100">
          <iframe :src="pdfUrl" style="width:100%;height: 600px;margin: 0 auto;"></iframe>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="loading-blur" v-if="isLoading">
    <div class="spinner-border" role="status">

    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  data(){
    return{
      isLoading:false,
      candidate_user: '',
      user_name:'',
      info_user:'',
      cv_path:'',
      location:'',
      is_user:false,
      is_anonymous:false,
      pdfUrl:null,
      anonymous_email:'',
      anonymous_phone:'',
      anonymous_lm:'',
      anonymous_content:''
    }
  },
  mounted() {
    this.get_candidate_user();
  },
  methods:{
    async get_candidate_user(){
      this.isLoading = true;
      try {
        const response = await axios.get('/api/get_user_candidate');
        this.candidate_user = response.data;
        this.isLoading = false;
      }catch (error){
        this.isLoading = false;
        console.log(error)
      }
    },
    async open_profile(id){
      this.isLoading = true;
      this.is_user = true;
      this.is_anonymous = false;
      try {
        const response = await axios.get('/api/get_user_profilebyid?id=' + id);
        this.user_name = response.data.username
        this.info_user = response.data.info_user
        this.cv_path = "uploads/cv/" + response.data.cv_path
        this.location = response.data.location

        this.isLoading = false;
      }catch (error){
        console.log(error)
        this.isLoading = false;
      }
    },
    async open_profile_anonymous(id){
      this.isLoading = true;
      this.is_user = false;
      this.is_anonymous = true;
      try {
        const response = await axios.get('/api/get_profile_anonymous?id=' + id);

        this.anonymous_email = response.data.email;
        this.anonymous_content = response.data.content;
        this.anonymous_phone = response.data.phone;
        this.anonymous_lm = response.data.lm;
        await this.get_anonymous_cv(id);
        this.isLoading = false;
      } catch (error) {
        console.error('Error fetching data:', error);
        this.isLoading = false;
      }
    },
    async get_anonymous_cv(id){
      this.isLoading = true;

      try {
        const response = await axios.get('/api/get_profile_anonymous_cv?id=' + id, {
          responseType: 'blob'
        });
        const blob = new Blob([response.data], { type: 'application/pdf' });
        this.pdfUrl = URL.createObjectURL(blob);

        this.isLoading = false;
      } catch (error) {
        console.error('Error fetching data:', error);
        this.isLoading = false;
      }
    }
  }
}

</script>