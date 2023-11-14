<template>
  <main class="w-75" style="margin: 0 auto;">
    <div class="row g-5 mt-5">
      <div class="col-md-8">
        <h3 class="pb-4 mb-4 fst-italic border-bottom">
          Bienvenue Chez Pôle Epitech.
          <p class="lead mt-2">{{ companie_name }}</p>
        </h3>
        <form class="was-validated" novalidate>
          <div class="row g-3">
            <div class="col-12">
              <label for="username" class="form-label">Companie Name</label>
              <div class="input-group has-validation">
                <input v-model="companie_name" type="text" class="form-control" id="username" placeholder="Username" required>
                <div class="invalid-feedback">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input v-model="email" type="email" class="form-control" id="email" disabled>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input v-model="location" type="text" class="form-control" id="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your address.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Phone</label>
              <input v-model="phone" type="text" class="form-control" id="address" placeholder="06 12 12 13 14" required>
              <div class="invalid-feedback">
                Please enter your Phone.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Category Companie</label>
              <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Categorie : </label>
                <select class="form-select" id="inputGroupSelect01" v-model="categories">
                  <option v-for="c in all_categories" :value="c.id" :selected="categories === c.id">{{ c.name }}</option>
                </select>
              </div>
            </div>

            <div class="col-12">
              <label for="Cv" class="form-label">Information</label>
              <textarea v-model="info_companie" class="form-control" id="exampleFormControlTextarea1" rows="3" style="height: 50vh"></textarea>
            </div>
          </div>
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit" @click="update_companieProfile">Save</button>
        </form>
        <div class="loading-blur" v-if="isLoading">
          <div class="spinner-border" role="status"></div>
        </div>

      </div>
      <div class="col-md-4">
        <div class="position-sticky" style="top: 2rem;">

          <!--<div class="p-4 mb-3 bg-body-tertiary rounded">
            <h4 class="fst-italic">About</h4>
            <p class="mb-0">{{ info_companie }}</p>
          </div>-->

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
      companie_name:'',
      email:'',
      location:'',
      info_companie: '',
      phone:'',
      categories:'',
      isLoading: false,
      all_categories:'',
    }
  },
  watch:{
    categories: function(newVal) {
      this.categories = newVal;
    }
  },
  mounted() {
    this.get_user();
    this.get_companie_profile();
    this.get_all_categorie();
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
    async get_companie_profile(){
      this.isLoading = true;
      try {
        const response = await axios.get('/api/get_companie_profile');

        this.companie_name = response.data.username;
        this.info_companie = response.data.info_companie;
        this.location = response.data.location;
        this.phone = response.data.phone;
        this.categories = response.data.categories;

        this.isLoading = false;
      }catch (error){
        this.isLoading = false;
      }
    },
    async update_companieProfile(){

      this.isLoading = true;
      var scrollContainer = document.documentElement || document.body;
      scrollContainer.scrollTop = 0;
      try {
        const response = await axios.post('/api/update_companie_profile',{
          user_name: this.companie_name,
          location: this.location,
          info_companie: this.info_companie,
          phone: this.phone,
          categories: this.categories,
        })

        this.companie_name = response.data.username;
        this.info_companie = response.data.info_companie;
        this.location = response.data.location;
        this.phone = response.data.phone;
        this.categories = response.data.categories;
        this.isLoading = false;
      }catch (error){
        this.isLoading = false;
      }
    },
    async get_all_categorie(){
      this.isLoading = true;

      try {
        const response = await axios.get('/api/companies_categorie')

        this.all_categories = response.data;
        this.isLoading = false;
      }catch (error){
        this.isLoading = false;
      }
    },
  }
}
</script>