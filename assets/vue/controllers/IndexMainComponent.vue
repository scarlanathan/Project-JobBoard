<template>
  <div class="px-4 pt-5 my-5 text-center border-bottom bg-light">
    <h1 class="display-4 fw-bold text-body-emphasis">Pôle Epitech! Goodbye to the FC Chômage</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">More than 14 000 companies searching for resume on Pôle Epitech.</p>
      <p class="lead mb-4">We will help you be apparent to the recruiters.</p>
      <p>Our latest study indicates that recruiters consider the resume search their number 1 tool for finding candidates! Publish your CV on Pôle Epitech today to be sure to be visible to recruiters who use our resume library every day.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
        <button @click="redirect('recherche?key=')" type="button" class="btn btn-primary btn-lg px-4">Apply a Job</button>
      </div>
    </div>
    <div class="overflow-hidden" style="max-height: 45vh;">
      <div class="container px-5">
        <img src="images/cvex.jpg" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
      </div>
    </div>
  </div>
  <div class="bg-light" id="contact">
    <div class="container col-xl-10 col-xxl-8 px-4">
      <div class="row align-items-center g-lg-5 py-5 pt-5">
        <div class="col-lg-7 text-center text-lg-start">
          <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Need help? Contact us!</h1>
          <p class="col-lg-10 fs-4">Experiment recruitment at ease with our services.</p><p class="col-lg-10 fs-4"> Are you a customer? Need help?</p><p class="col-lg-10 fs-4">Send us a message right here!</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
          <div class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" v-model="contact_email">
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" placeholder="Name" v-model="contact_name">
              <label for="floatingInput">User name</label>
            </div>
            <div class="form-floating mb-3">
              <textarea type="text" class="form-control" id="floatingInput" placeholder="Message" style="height: 200px" v-model="contact_content"></textarea>
              <label for="floatingInput">Message</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" @click="send_contact" :disabled="contact_message">Submit your message</button>
            <hr class="my-4">
            <small class="text-body-secondary" v-if="!contact_message">By clicking Submit, you agree to the terms of use.</small>
            <div class="alert-success" v-if="contact_message">Thanks for your feedback {{ contact_email }}.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div style="background: #efeae4; padding-bottom: 15vh">
    <div class="container px-4 py-5" id="hanging-icons">
      <h2 class="pb-2 border-bottom">Explore our articles for more advice</h2>
      <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
        <div class="col d-flex align-items-start">
          <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
            <svg class="bi bg-black" width="1em" height="1em"><use xlink:href="#toggles2"></use></svg>
          </div>
          <div class="rounded" style="background: #f8f5f3; padding: 3vh">
            <h3 class="fs-3 text-body-emphasis">Resume of the moment</h3>
            <p>Depuis 5 ans, plusieurs tendances se sont succédées. La première vague a été le CV design marqué par l’arrivée des couleurs, de la fantaisie et des polices différentes. Si ce type de CV a tout à fait sa place dans ...</p>
            <a @click="redirect('advice#resumeofthemoment')" class="btn btn-primary">See more</a>
          </div>
        </div>
        <div class="col d-flex align-items-start">
          <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
            <svg class="bi bg-black" width="1em" height="1em"><use xlink:href="#cpu-fill"></use></svg>
          </div>
          <div class="rounded" style="background: #f8f5f3; padding: 3vh">
            <h3 class="fs-3 text-body-emphasis">Find your way</h3>
            <p>Votre parcours est unique, comme vous. Que ce soit pour découvrir un métier auquel vous n’auriez jamais pensé, ou trouver l’entreprise où vous épanouir, on vous accompagne. Notre objectif ? Que vos ...</p>
            <a @click="redirect('advice#findyourway')" class="btn btn-primary">See more</a>
          </div>
        </div>
        <div class="col d-flex align-items-start">
          <div class="icon-square text-body-emphasis bg-body-secondary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
            <svg class="bi bg-black" width="1em" height="1em"><use xlink:href="#tools"></use></svg>
          </div>
          <div class="rounded" style="background: #f8f5f3; padding: 3vh">
            <h3 class="fs-3 text-body-emphasis">Prepare yourself</h3>
            <p>Entrer sur le marché du travail, c’est parfois un saut dans l’inconnu. Alors rien de mieux donc que d’échanger avec des professionnels lors de nos évènements physiques et virtuels pour élargir...</p>
            <a @click="redirect('advice#prepareyourself')" class="btn btn-primary">See more</a>
          </div>
        </div>
      </div>
    </div>

    <div class="px-4 my-5 text-center">
      <img class="d-block mx-auto mb-4" src="Image/PoleEpitech.png" alt="" width="300" height="300">
      <h1 class="display-5 fw-bold text-body-emphasis">Pôle Epitech</h1>
      <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">More than 10 000 offers, from stage to first employment.</p>
      </div>
    </div>
  </div>


<div class="container col-xxl-8 px-4 py-5 my-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5" style="background-image: url('Image/ufiinqivfn8ig30anqpe.webp');background-size: auto auto;filter: brightness(1.5); padding:20vh; background-repeat: no-repeat ">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="https://upload.wikimedia.org/wikipedia/fr/6/68/Logo_JO_d%27%C3%A9t%C3%A9_-_Paris_2024.svg" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Paris JO 2024 Official Partner</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <button type="button" class="btn btn-primary btn-lg px-4 me-md-2" @click="redirect('recherche?key=JO')">Apply</button>
        </div>
      </div>
    </div>
  </div>

</template>
<script>
  import axios from "axios";

  export default {
    data(){
      return{
        contact_email:'',
        contact_name:'',
        contact_content:'',
        contact_message:false
      }
    },
    methods:{
      async send_contact(){
        try {
          const response = await axios.post('/api/contact',{
            email:this.contact_email,
            username:this.contact_name,
            content:this.contact_content
          })
          this.contact_message = response.data.message
        }catch (error){
          console.log(error)
        }
      },
      redirect(path){
        window.location.href = "/" + path;
      }
    }
  }
</script>