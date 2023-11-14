<template>
  <div class="bg-light">
  <div class="container pt-3 py-5">
    <div class="d-flex flex-row">
      <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary bg-white" style="width: 40vh;height: 100vh;overflow-y: auto;">
          <p class="fs-5 fw-semibold bg-white" style="padding-top: 20px;padding-bottom: 20px">Advertisements</p>
        <div class="list-group list-group-flush border-bottom scrollarea">
          <a class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true" v-for="ad in this.ads" @click="get_adById(ad.id)" :class="{ 'active': this.ad_show_id === ad.id }">
            <div class="d-flex w-100 align-items-center justify-content-between">
              <strong class="mb-1">{{ ad.name_job + " (" + ad.type_contrat + ")" }}</strong>
            </div>
            <small>{{ ad.public_date }}</small>
            <div class="col-10 mb-1 small" style="height: 10vh;overflow: hidden;" v-html="ad.description"></div>
          </a>
        </div>
      </div>
      <div class="w-100" style="max-height: 100vh;">
        <div class="w-100 position-relative d-flex justify-content-end">
          <button class="btn btn-primary mt-4 mb-4" @click="show_from_add">Add Advertisements</button>
        </div>

        <div style="background: darkgray;height:88%;width: 100%;overflow-y: auto;" class="p-4" v-if="show_formAdd">
          <FormAdComponent></FormAdComponent>
        </div>

        <div style="background: white;height:88%;width: 100%;overflow-y: auto;" class="p-4" v-if="ad_show">
          <div class="mb-3">
            <label for="basic-url" class="form-label">Company Name : </label>
            <div class="input-group">
              <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" :value="companie_name" disabled>
            </div>
          </div>
          <div class="mb-3">
            <label for="basic-url" class="form-label">Company Email : </label>
            <div class="input-group">
              <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" :value="companie_email" disabled>
            </div>
          </div>
          <div class="mb-3">
            <label for="basic-url" class="form-label">Job Title : </label>
            <div class="input-group">
              <input v-model="job_name" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
            </div>
          </div>
          <div class="mb-3 d-flex flex-row gap-4 justify-start">
            <div class="d-flex flex-column">
              <label for="basic-url" class="form-label">Start Date : </label>
              <div class="input-group">
                <input v-model="start_date" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
              </div>
            </div>
            <!--
            <div class="d-flex flex-column">
              <label for="basic-url" class="form-label">End Date : </label>
              <div class="input-group">
                <input v-model="end_date" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4">
              </div>
            </div>
            -->
            <div class="d-flex flex-column">
              <label for="basic-url" class="form-label">Job Categorie : </label>
              <div class="input-group">
                <select class="form-select" id="inputGroupSelect01" v-model="categorie">
                  <option v-for="category in this.all_job_categories" :value="category.name">{{ category.name }}</option>
                </select>
                <button class="btn btn-outline-secondary" type="button" @click="add_job_category">Add Category</button>
              </div>
            </div>
            <div class="d-flex flex-row" v-for="ca in this.job_categories">
              <p class="lead mt-3">{{ ca.name }}</p>
              <button class="btn" @click="delete_job_category(ca.id)">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Type Contrat : </label>
            <select class="form-select" id="inputGroupSelect01" v-model="type_contrat">
              <option value="CDI">CDI</option>
              <option value="CDD">CDD</option>
              <option value="Stage">Stage</option>
              <option value="Apprenticeship">Apprentissage</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Type Job : </label>
            <select class="form-select" id="inputGroupSelect01" v-model="type_job">
              <option value="Remote Work">Teleworking</option>
              <option value="Work at the office">Office</option>
              <option value="Hybrid">Hybrid</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="basic-url" class="form-label">Salary : </label>
            <div class="input-group">
              <input type="text" class="form-control" id="basic-url" placeholder="Brut salary per year" aria-describedby="basic-addon3 basic-addon4" v-model="salary">
            </div>
          </div>
          <div class="mb-3">
            <label for="basic-url" class="form-label">Work Time : </label>
            <div class="input-group">
              <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" v-model="work_time">
            </div>
          </div>
          <div class="mb-3">
            <label for="basic-url" class="form-label">Description : </label>
            <textarea class="form-control" aria-label="With textarea" style="min-height: 40vh;" v-model="description"></textarea>
          </div>
          <button class="btn btn-primary w-100" @click="update_ad(ad_show.id)">Update</button>
          <button class="btn btn-danger w-100 mt-2" @click="delete_ad(ad_show.id)">Delete</button>
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
<script setup>
  import FormAdComponent from "./FormAdComponent.vue";
</script>
<script>
  import axios from "axios";

  export default {
    data(){
      return {
        show_formAdd:false,
        ads:'',
        ad_show:'',
        start_date:'',
        end_date:'',
        public_date:'',
        type_contrat:'',
        type_job:'',
        salary:'',
        work_time:'',
        description:'',
        isLoading:false,
        job_name:'',
        ad_show_id:'',
        job_categories:'',
        categorie:'',
        all_job_categories:'',
        companie_name:'',
        companie_email:'',
      }
    },
    mounted() {
      this.get_user();
      this.get_companie_info();
      this.get_ads();
      this.get_all_categories();
    },
    methods:{
      show_from_add(){
        this.show_formAdd = !this.show_formAdd;
        this.ad_show = false;
      },
      async get_user(){
        this.isLoading = true;
        try {
          const response = await axios.get('/api/get_user');

          this.companie_email = response.data.user_email;
          this.isLoading = false;
        }catch (error){
          this.isLoading = false;
        }
      },
      async get_companie_info(){
        this.isLoading = true;
        try {
          const response = await axios.get('/api/get_companie_profile');
          this.companie_name = response.data.username;
          this.isLoading = false;
        }catch (error){
          console.log(error)
          this.isLoading = false;
        }
      },
      async get_ads(){
        this.isLoading = true;
        try {
          const response = await axios.get('/api/get_ad');
          this.ads = response.data;
          //await this.get_adById(response.data[0].id);
          this.isLoading = false;
        }catch (error){
          console.log(error)
          this.isLoading = false;
        }
      },
      async get_adById(id){
        this.show_formAdd = false;
        this.isLoading = true;
        try{
          const response = await axios.get('/api/get_ad_byid?id=' + id);
          this.ad_show = response.data;
          this.ad_show_id = response.data.id;
          this.job_name = response.data.name_job;
          this.start_date = response.data.start_date;
          this.end_date = response.data.end_date;
          this.type_contrat = response.data.type_contrat;
          this.type_job = response.data.type_job;
          this.description = response.data.description;
          this.work_time = response.data.work_time;
          this.salary = response.data.salary;
          this.job_categories = response.data.categories;
          this.public_date = response.data.public_date;
          this.isLoading = false;
        }catch (error){
          console.log(error);
          this.isLoading = false;
        }
      },
      async update_ad(id){
        this.isLoading = true;
        try{
          const response = await axios.post('/api/update_ad',{
            ad_id:id,
            start_date:this.start_date,
            end_date:this.end_date,
            type_contrat:this.type_contrat,
            type_job:this.type_job,
            salary:this.salary,
            work_time:this.work_time,
            description:this.description,
            job_name:this.job_name,
          });

          this.isLoading = false;
        }catch (error){
          console.log(error);
          this.isLoading = false;
        }
      },

      async delete_ad(id){
        this.isLoading = true;
        try{
          const response = await axios.post('/api/delete_ad',{
            ad_id:id,
          });
          this.isLoading = false;
          location.reload();
        }catch (error){
          console.log(error);
          this.isLoading = false;
        }
      },
      async get_all_categories(){
        this.isLoading = true;
        try{
          const response = await axios.get('/api/job_categories');
          this.isLoading = false;
          this.all_job_categories = response.data
        }catch (error){
          console.log(error);
          this.isLoading = false;
        }
      },
      async delete_job_category(category_id){
        this.isLoading = true;
        try{
          const response = await axios.post('/api/delete_job_category',{
            "ad_id":this.ad_show_id,
            "category_id":category_id
          });

          await this.get_adById(this.ad_show_id);
          this.isLoading = false;
        }catch (error){
          console.log(error);
          this.isLoading = false;
        }
      },
      async add_job_category(){
        this.isLoading = true;
        try{
          const response = await axios.post('/api/add_job_category',{
            "ad_id":this.ad_show_id,
            "category_name":this.categorie
          });
          await this.get_adById(this.ad_show_id);
          this.isLoading = false;
        }catch (error){
          console.log(error);
          this.isLoading = false;
        }
      },
    }
  }
</script>