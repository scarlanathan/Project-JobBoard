<template>
  <div class="mb-3">
    <label for="basic-url" class="form-label">Name : </label>
    <div class="input-group">
      <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 basic-addon4" :value="companie_name" disabled>
    </div>
  </div>
  <div class="mb-3">
    <label for="basic-url" class="form-label">Email : </label>
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
      <label for="basic-url" class="form-label">Job Categories : </label>
      <div class="input-group">
        <select class="form-select" id="inputGroupSelect01" v-model="categorie">
          <option v-for="category in this.all_job_categories" :value="category.name">{{ category.name }}</option>
        </select>
      </div>
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
      <input type="text" class="form-control" id="basic-url" placeholder="Hour/Week" aria-describedby="basic-addon3 basic-addon4" v-model="work_time">
    </div>
  </div>
  <div class="mb-3">
    <label for="basic-url" class="form-label">Description : </label>
    <textarea class="form-control" aria-label="With textarea" style="min-height: 40vh;" v-model="description"></textarea>
  </div>
  <button class="btn btn-primary w-100" @click="send_ad">Save</button>
</template>
<script>
  import axios from "axios";

  export default {
    data(){
      return{
        start_date:'',
        end_date:'',
        type_contrat:'',
        type_job:'',
        salary:'',
        work_time:'',
        description:'',
        isLoading:false,
        job_name:'',
        all_job_categories:'',
        companie_name:'',
        companie_email:'',
        categorie:'',
      }
    },
    mounted() {
      this.get_user();
      this.get_companie_info();
      this.get_all_categories();
    },
    methods:{
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
      async send_ad(){
        this.isLoading = true;
        try {
          const response = axios.post('/api/create_ad',{
            start_date:this.start_date,
            end_date:this.end_date,
            type_contrat:this.type_contrat,
            type_job:this.type_job,
            salary:this.salary,
            work_time:this.work_time,
            description:this.description,
            job_name:this.job_name,
            categorie:this.categorie
          });
          this.isLoading = false;
          location.href = "/advertisements";
        }catch (error){
          this.isLoading = false;
          console.log(error)
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
    }
  }
</script>