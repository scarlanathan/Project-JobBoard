<template>
  <table class="table w-75" style="margin: 0 auto;">
    <button class="btn btn-primary button-message" @click="new_message = true" v-show="!new_message">New Message</button>
    <thead>
      <tr>
        <th scope="col">User</th>
        <th scope="col">Company</th>
        <th scope="col">Object</th>
        <th scope="col">Date</th>
      </tr>
    </thead>
    <tbody class="table-group-divider mx-auto">
    <tr v-for="message in messages" :key="message.id">
      <th @click="show_content(message.id)">{{ message.user }}</th>
      <th @click="show_content(message.id)">{{ message.companie }}</th>
      <th @click="show_content(message.id)">{{ message.objet }}</th>
      <th @click="show_content(message.id)">{{ message.date.date }}</th>
      <th><button  class="btn btn-danger" @click="delete_message(message.id)">X</button></th>
    </tr>
    </tbody>
  </table>
  <div class="needs-validation send-message bottom-1-m" v-if="new_message">
    <button class="button-close btn btn-danger" @click="new_message = false">
      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
      </svg>
    </button>
    <div class="row g-3">
      <div class="col-12">
        <label for="username" class="form-label">To : </label>
        <div class="input-group has-validation">
          <input type="text" class="form-control" id="username" placeholder="you@example.com" required v-model="send_email">
        </div>
      </div>
      <div class="col-12">
        <label for="email" class="form-label">Objet</label>
        <input type="email" class="form-control" id="email" placeholder="Objet" v-model="send_objet">
      </div>

      <div class="col-12">
        <label for="address" class="form-label">Content</label>
        <textarea class="form-control" aria-label="With textarea" v-model="send_content"></textarea>
      </div>


    </div>
    <button class="w-100 btn btn-primary  mt-5" type="submit" @click="send_message">Send</button>
  </div>
  <div class="loading-blur" v-if="isLoading">
    <div class="spinner-border" role="status">

    </div>
  </div>
  <div class="box-content" v-if="content_show" :style="top_style">
    <div class="info-message">
      <button class="button-close btn btn-danger" @click="content_show = false">
      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
      </svg>
      </button>
      <div class="h-100 p-5 text-bg-dark rounded-3 container" v-if="message" style="transform: translate(0%,35%)">
        <p>User : {{ message.user }}</p>
        <p>Company : {{ message.companie }}</p>
        <p>0bject : {{message.objet}}</p>
        <label>Message :</label>
        <div class="chat" ref="chatWindow" style="overflow-y: scroll;height: 200px">
          <p>{{message.content}}</p>
          <p>{{message.date}}</p>
        </div>

      </div>
    </div>
  </div>
</template>
<script>
  import axios from "axios";

  export default {
    data(){
      return {
        new_message:false,
        message: '',
        isLoading:false,
        content_show:false,
        top_style:'',
        date:'',
        send_email:'',
        send_objet:'',
        send_content:'',
        user_delete:'',
        companie_delete:'',
        user_role:'',
        show:false
      };
    },
    mounted() {
      this.get_all_message();
      setInterval(()=>{
        if (this.new_message || this.content_show){
          document.body.style.overflowY = "hidden"
        }else{
          document.body.style.overflowY = "auto";
        }
      },100)
    },
    methods:{
      async get_all_message(){
        this.isLoading = true;
        try {
          const response = await axios.get('/api/get_user_messages');
          this.messages = response.data
          this.isLoading = false;
        }catch (error){
          this.isLoading = false;
        }
      },
      async show_content(message_id){
        this.content_show = true;
        this.top_style = "top:" + document.documentElement.scrollTop + "px;";
        try{
          this.isLoading = true;
          const response = await axios.get('/api/get_message_byid?id='+message_id);
          this.message = response.data;
          this.isLoading = false;
        }catch (error){
          this.isLoading = false;
        }
      },
      async send_message(message_id){
        this.content_show = true;
        this.top_style = "top:" + document.documentElement.scrollTop + "px;";
        try{
          this.isLoading = true;
          const response = await axios.post('/api/send_message',{
            email:this.send_email,
            objet:this.send_objet,
            content:this.send_content
          });

          this.isLoading = false;
          location.reload()
        }catch (error){
          this.isLoading = false;
        }
      },
      async delete_message(id){
        this.isLoading = true;
        try{
          const response = await axios.post('/api/delete_message',{
            message_id:id,
            isUserDelete:this.user_delete,
            isCompanieDelete:this.companie_delete,
            roles:this.user_role,
          });
          if (this.user_role.length === 2 && this.message.companie_delete === 1 || (this.user_role.length === 1 && this.message.user_delete === 1))
            this.show = false;
          else
            this.show = true
          this.isLoading = false;
          location.reload();
        }catch(error){
          console.log(error);
          this.isLoading = false;
        }
      },
    }
  }
</script>