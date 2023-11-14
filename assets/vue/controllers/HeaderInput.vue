<template>
  <div class="w-50 mt-4">
    <div class="input-group mb-3">
      <input v-model="key" @input="find" type="text" class="form-control" placeholder="Rechercher emplois, mots clés, entreprises" aria-label="Rechercher emplois, mots clés, entreprises" aria-describedby="basic-addon2">
      <input type="text" class="form-control" placeholder="Saisir un lieu ou “télétravail" aria-label="Saisir un lieu ou “télétravail" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button">Rechercher</button>
      </div>
    </div>
    <div v-if="key" class="col-md-8 mx-auto">
      <ul class="list-group">
        <li class="list-group-item cursor-pointer" v-for="res in uni_res" :key="res" @click="set_input(res)">{{ res }}</li>
      </ul>
    </div>
  </div>

</template>
<script>
import axios from "axios";

export default {
  data(){
    return {
      key: '',
      data: '',
      uni_res: '',
    }
  },
  methods:{
    async find(){
      this.uni_res = '';
      let res = [];
      if (this.key){
        try {
          const response = await axios.get('/api/job_categories?key=' + this.key);
          for (let i = 0;i < response.data.length;i++){
            res.push(response.data[i]["name"]);
          }
          this.uni_res = [...new Set(res)];
        }catch (error){
          console.log(error);
        }
      }
    },
    set_input(res){
      this.key = res;
      this.uni_res = '';
    }
  }
}
</script>