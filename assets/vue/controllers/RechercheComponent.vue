<template>
  <div class="d-flex bg-light flex-column">
    <div class="container pt-3 py-5">
      <div class="d-flex flex-column w-100 p-4">
        <h5>Job Category</h5>
        <div class="d-flex flex-row flex-wrap">
          <div class="form-check form-check-inline" v-for="category in this.all_category">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" :value="category" v-model="category_selected" @change="set_list_category">
            <label class="form-check-label" for="inlineCheckbox1">{{ category }}</label>
          </div>
        </div>
      </div>
      <div class="w-100 d-flex flex-row gap-4">
        <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary" style="width: 40vh;height: 100vh;overflow-y: auto;">
          <div class="list-group list-group-flush border-bottom scrollarea">
            <a class="list-group-item list-group-item-action py-3 lh-sm mt-2" aria-current="true" v-for="ad in this.ads" @click="show_ad(ad.id)" :class="{ 'active': this.show_ad_detail.id === ad.id }" v-show="arrHasOtherArr(this.category_selected,ad.categories)">
              <div class="d-flex w-100 align-items-center justify-content-between">
                <strong class="mb-1">{{ ad.job_name + " (" + ad.type_contrat + ")" }}</strong>
              </div>
              <small>{{ ad.public_date }}</small>
              <div class="col-10 mb-1 small" style="height: 6vh; overflow: hidden;" v-html="ad.description"></div>
            </a>
          </div>
        </div>
        <div class="w-100" style="height: 100vh;overflow-y: auto;">
          <div class="col bg-white" v-if="show_ad_detail">
            <div class="w-100 d-flex flex-row gap-lg-3" style="background: #fcfcfc">
              <h1 class="pb-4 mb-4 fst-italic mt-md-5">{{ this.show_ad_detail.companie_name }}</h1>
              <button class="btn btn-primary h-25 mt-md-5" @click="send_user_candidate" v-if="!is_companie && is_user">Simplified application</button>
              <button class="btn btn-primary h-25 mt-md-5 " @click="open_form_candidate" v-if="!is_companie && !is_user">Send anonymous</button>
              <br>
              <div class="d-flex flex-column w-50 mt-4" v-if="form_candidate">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">@</span>
                  </div>
                  <input type="text" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" v-model="candidate_email">
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Phone" aria-label="Phone" aria-describedby="basic-addon1" v-model="candidate_phone">
                </div>
                <div class="input-group">
                  <label for="Message" class="form-label">Message</label>
                  <textarea class="form-control" aria-label="Content" v-model="candidate_content"></textarea>
                </div>
                <div class="col-12 d-flex flex-column justify-content-center align-content-center gap-4">
                  <div class="w-100">
                    <label for="Cv" class="form-label mt-3">CurriculumVitae</label>
                    <div class="input-group mb-3 mt-2">
                      <label class="input-group-text" for="inputGroupFile01">Upload</label>
                      <input ref="file" type="file" class="form-control" id="inputGroupFile01" @change="cvChange">
                    </div>
                  </div>
                </div>
                <div class="col-12 d-flex flex-column justify-content-center align-content-center gap-4">
                  <div class="w-100">
                    <label for="lm" class="form-label">Cover Letter</label>
                    <div class="input-group mb-3">
                      <textarea class="form-control" aria-label="Content" v-model="candidate_lettre"></textarea>
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary mt-4" @click="send_user_candidate_anonymous">Apply</button>
              </div>
            </div>
            <article class="blog-post bg-white-90">
              <h1 class="link-body-emphasis mb-1 font-weight-bold text-break">{{ show_ad_detail.job_name }}</h1>
              <h6 class="blog-post-meta font-weight-bold">{{ show_ad_detail.public_date }}</h6>
              <br>
              <p v-html="show_ad_detail.description"></p>
              <hr>
              <h2 class="font-weight-bold ">Description Company</h2>
              <h6 class="font-weight-bold">Email : {{ show_ad_detail.email_companie }}</h6>
              <h6 class="font-weight-bold">Phone : {{ show_ad_detail.phone_companie }}</h6>
              <h6 class="font-weight-bold">Location : {{ show_ad_detail.companie_location }}</h6>
              <h6 class="font-weight-bold text-break word-break">Information Company :</h6>
              <p>{{ show_ad_detail.info_companie }}</p>
              <hr>
              <h3 class="font-weight-bold">About the job</h3>
              <h6 class="font-weight-bold">Start Date : {{show_ad_detail.start_date}}</h6>
              <h6 class="font-weight-bold">Type Job : {{show_ad_detail.type_job}}</h6>
              <h6 class="font-weight-bold">Type Contract : {{show_ad_detail.type_contrat}}</h6>
              <h6 class="font-weight-bold">Salary : {{show_ad_detail.salary}}</h6>
              <h6 class="font-weight-bold">Work Time : {{show_ad_detail.work_time}}</h6>
            </article>
            <br>
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
      ads:"",
      isLoading:false,
      all_category:[],
      show_ad_detail:'',
      list_categoroy:[],
      default_ad_id:'',
      category_selected:[],
      is_companie:false,
      is_user:false,
      form_candidate: false,
      candidate_email:'',
      candidate_content:'',
      candidate_cv:'',
      candidate_lettre:'',
      candidate_phone:''
    }
  },
  mounted() {
    this.GetUser();
    this.get_ads();
  },
  methods:{
    async GetUser(){
      try {
        const response = await axios.get('/api/get_user');
        this.user_email = response.data.user_email
        let role = response.data.user_role;
        if(response.data.user_email){
          if (role.includes("ROLE_COMPAINE")){
            this.is_companie = true;
            this.is_user = false;
          }else {
            this.is_companie = false;
            this.is_user = true;
          }
        }else {
          this.is_user = false;
          this.is_companie = false;
        }

      }catch (error){

      }
    },
    async get_ads(){
      this.isLoading = true;
      try {
        let url = window.location.href;
        let url_param = new URL(url);
        let key = url_param.searchParams.get("key");
        const response = await axios.get('/api/recherche_job?key=' + key);
        this.ads = response.data
        //await this.show_ad(response.data[0].id);
        this.isLoading = false;
        this.get_all_job_categories();
      }catch (error){
        this.isLoading = false;
      }

    },
    get_all_job_categories(){
      let category_array = [];
      for (let i = 0;i < this.ads.length;i++){
        let categories = this.ads[i].categories;
        for (let x = 0;x < categories.length;x++){
          category_array.push(categories[x]);
        }
      }

      this.all_category = this.unique(category_array);
      if (this.category_selected === [] || this.category_selected.length <= 0){
        this.category_selected = this.unique(category_array);
      }

    },
    unique (arr) {
      return Array.from(new Set(arr))
    },
    async show_ad(id){
      this.isLoading = true;
      try {
        const response = await axios.get('/api/recherche_job_byid?id=' + id);
        this.show_ad_detail = response.data
        this.isLoading = false;
      }catch (error){
        this.isLoading = false;
      }
    },
    async set_list_category(){
      await this.get_ads();
    },
    arrHasOtherArr(arr, arr1) {
      return arr1.some(item => arr.includes(item));
    },
    async send_user_candidate(){
      this.isLoading = true;
      try {
        const response = await axios.post('/api/set_user_candidate',{
          ad_id:this.show_ad_detail.id
        })

        setTimeout(()=>{
          this.isLoading = false;
          alert("Candidate Success");
        },2000)

      }catch (error){
        console.log(error);
        this.isLoading = false;
      }
    },
    open_form_candidate(){
      this.form_candidate = !this.form_candidate;
    },
    async send_user_candidate_anonymous() {
      this.isLoading = true;
      try {
        const response = await axios.post('/api/set_anonymous_candidate',{
          pdf:this.candidate_cv,
          phone:this.candidate_phone,
          lm:this.candidate_lettre,
          email:this.candidate_email,
          ad_id:this.show_ad_detail.id,
          content:this.candidate_content
        },{
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        alert("Candidate Success");
        this.isLoading = false;
        this.form_candidate = false;
      } catch (error) {

        this.isLoading = false;
      }
    },
    cvChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.candidate_cv = file;
      }
    },
  }

}
</script>