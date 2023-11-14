<template>
  <main class="w-75" style="margin: 0 auto;">
    <div class="row g-5 mt-5">
      <div class="col-md-8">
        <h3 class="pb-4 mb-4 fst-italic border-bottom">
          Welcome to Pôle Epitech.
          <p class="lead mt-2">{{ user_name }}</p>
        </h3>
        <div class="needs-validation">
          <div class="row g-3">
            <div class="col-12">
              <label for="username" class="form-label">Name</label>
              <div class="input-group has-validation">
                <input v-model="user_name" type="text" class="form-control" id="username" placeholder="Name SURNAME" required="">
                <div class="invalid-feedback">
                  Your name is required.
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input v-model="email" type="email" class="form-control" id="email" placeholder="you@example.com" disabled>
              <div class="invalid-feedback">
                Please enter a valid email address.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input v-model="location" type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
              <div class="invalid-feedback">
                Please enter your address.
              </div>
            </div>

            <div class="col-12 d-flex flex-column justify-content-center align-content-center gap-4">
              <div class="w-50">
                <label for="Cv" class="form-label">C.V</label>
                <div class="input-group mb-3 mt-4">
                  <label class="input-group-text" for="inputGroupFile01">Upload</label>
                  <input v-on:change="chage_cv" ref="file" type="file" class="form-control" id="inputGroupFile01">
                </div>
              </div>
              <div class="w-100" v-if="cv_path">
                <iframe v-bind:src="cv_path" style="width:100%;height: 600px;margin: 0 auto;"></iframe>
              </div>
              <div class="w-100" v-else>
                <img src="images/cv_upload.png" style="width:100%;height: auto;margin: 0 auto;">
              </div>
            </div>

            <div class="col-12">
              <label for="Cv" class="form-label">Introduce yourself</label>
              <textarea v-model="info_user" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
          </div>
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit" @click="update_userProfile">Save</button>
        </div>
        <div class="loading-blur" v-if="isLoading">
          <div class="spinner-border" role="status">

          </div>
        </div>

      </div>
      <div class="col-md-4">
        <div class="position-sticky" style="top: 2rem;">
          <div class="p-4 mb-3 bg-body-tertiary rounded">
            <h4 class="fst-italic">About</h4>
            <p class="mb-0">{{ info_user }}</p>
          </div>

          <div>
            <h4 class="fst-italic">Recent posts</h4>
            <ul class="list-unstyled">
              <li>
                <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="#">
                  <svg class="bd-placeholder-img" width="100%" height="96" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"></rect></svg>
                  <div class="col-lg-8">
                    <h6 class="mb-0">Example blog post title</h6>
                    <small class="text-body-secondary">January 15, 2023</small>
                  </div>
                </a>
              </li>
            </ul>
          </div>

          <div class="p-4">
            <h4 class="fst-italic">Archives</h4>
            <ol class="list-unstyled mb-0">
              <li><a href="#">March 2021</a></li>
              <li><a href="#">February 2021</a></li>
              <li><a href="#">January 2021</a></li>
              <li><a href="#">December 2020</a></li>
              <li><a href="#">November 2020</a></li>
              <li><a href="#">October 2020</a></li>
              <li><a href="#">September 2020</a></li>
              <li><a href="#">August 2020</a></li>
              <li><a href="#">July 2020</a></li>
              <li><a href="#">June 2020</a></li>
              <li><a href="#">May 2020</a></li>
              <li><a href="#">April 2020</a></li>
            </ol>
          </div>
        </div>
      </div>

    </div>
  </main>

</template>
<script>
  import axios from "axios";
  export default {
    data(){
      return {
        email:'',
        user_name:'',
        location:'',
        user_email:'',
        cv_path:null,
        info_user:'',
        isLoading:false,
      }
    },
    mounted() {
      this.get_user();
      this.get_user_pofile();
      setInterval(()=>{
        if (this.isLoading){
          document.body.style.overflowY = "hidden";
        }else{
          document.body.style.overflowY = "auto";
        }
      },100)

    },
    methods:{
      async get_user(){
        this.isLoading = true;
        try {
          const response = await axios.get('/api/get_user');

          this.email = response.data.user_email;
          this.isLoading = false;
        }catch (error){
          this.isLoading = false;
        }
      },
      async get_user_pofile(){
        try {
          this.isLoading = true;
          const response = await axios.get('/api/get_user_profile');

          this.user_name = response.data.username;
          this.info_user = response.data.info_user;
          if (response.data.cv_path){
            this.cv_path = "uploads/cv/" + response.data.cv_path;
          }
          this.location = response.data.location;
          setTimeout(()=>{
            this.isLoading = false;
          },1000)

        }catch (error){
          this.isLoading = false;
        }
      },
      async chage_cv(event){
        const file = event.target.files[0];
        const formData = new FormData();
        formData.append("file",file);
        try {
          this.isLoading = true;
          const response = await axios.post("/api/upload_cv", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          });
          this.isLoading = false;
          this.cv_path = "uploads/cv/" + response.data.message;
        } catch (error) {
          this.isLoading = false;
        }
      },
      async update_userProfile(){
        this.isLoading = true;
        var scrollContainer = document.documentElement || document.body;
        scrollContainer.scrollTop = 0;
        try {
          const response = await axios.post('/api/update_user_profile',{
            user_name: this.user_name,
            location: this.location,
            info_user: this.info_user,
          })

          this.user_name = response.data.user_name;
          this.info_user = response.data.info_user;
          this.location = response.data.location;
          this.isLoading = false;
        }catch (error){
          this.isLoading = false;
        }
      },
    }
  }
</script>