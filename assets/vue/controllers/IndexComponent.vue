<template>
  <section class="py-5 text-center container h-100 d-flex flex-column justify-content-center">
    <div class="row py-lg-5" style="margin-top: -150px;">
      <div class="col-md-8 mx-auto">
        <h1 class="fw-light"></h1>
        <p class="display-5 mb-4 text-white font-weight-bold">Find the job of your dreams.</p>
      </div>
      <div class="input-group mb-3 row input-group-lg">
        <div class="col-lg-6 mt-3 input-group-lg w-75">
          <input v-model="key" @input="find" type="text" class="form-control" placeholder="Research jobs, key words" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="input-group-append col-lg-2 mt-3 input-group-lg">
          <button class="btn btn-primary" type="button" @click="redirect('recherche?key=' + this.key)">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
          </button>
        </div>
      </div>
      <div v-if="key" class="col-lg-6 w-75">
        <ul class="list-group">
          <li class="list-group-item cursor-pointer" v-for="res in uni_res" :key="res" @click="set_input(res)">{{ res }}</li>
        </ul>
      </div>
      <div class="blur d-flex flex-column justify-content-center" v-if="!key">
        <p class="lead text-white">Recent research activity</p>
        <ul class="d-flex flex-row flex-wrap gap-4">
          <li class="w-20 hotkey" v-for="res in top_job" :key="res" @click="set_input(res)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" style="margin-right: 2px; margin-bottom: 3px" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
            {{ res }}
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";


export default {
  data(){
    return {
      key: '',
      data: '',
      uni_res: '',
      top_job: '',
    }
  },
  mounted() {
    this.get_TopJob();
  },
  methods: {
    async find() {
      this.uni_res = '';
      let res = [];
      if (this.key) {
        try {
          const response = await axios.get('/api/get_ad_byname?key=' + this.key);
          for (let i = 0; i < response.data.length; i++) {
            res.push(response.data[i]["name_job"]);
          }
          this.uni_res = [...new Set(res)];
        } catch (error) {

        }
      }
    },
    set_input(res) {
      this.key = res;
      this.uni_res = '';
    },
    async get_TopJob() {
      this.top_job = '';
      let res = [];
      try {
        const response = await axios.get('/api/get_ad_byname');
        for (let i = 0; i < response.data.length; i++) {
          res.push(response.data[i]["name_job"]);
        }
        this.top_job = this.shuffleArray([...new Set(res)].slice(0, 8));
      } catch (error) {

      }
    },
    shuffleArray(array) {
      for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
      }
      return array;
    },
    redirect(path){
      window.location.href = "/" + path;
    }
  },


}

</script>