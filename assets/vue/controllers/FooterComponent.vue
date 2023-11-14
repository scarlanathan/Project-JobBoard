<template>

  <div class="container">

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 py-5 my-5 border-top">

      <div class="col mb-3">
        <a href="/" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        </a>
        <p class="text-body-secondary" style="padding-left: 10vh">© 2023</p>
      </div>
      <div class="col mb-3">
        <h5>Companies</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="/register" class="nav-link p-0 text-body-secondary">Companies Register</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">School partner</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Corporate partner</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Recruiters</a></li>
        </ul>
      </div>
      <div class="col mb-3">
        <h5>Jobs offer</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="/register" class="nav-link p-0 text-body-secondary">Register</a></li>
          <li class="nav-item mb-2"><a href="/recherche?key=" class="nav-link p-0 text-body-secondary">Search Jobs</a></li>
          <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Recruitment advice</a></li>
          <li class="nav-item mb-2"><a href="/recherche?key=stage" class="nav-link p-0 text-body-secondary">Internship jobs ads</a></li>
        </ul>
      </div>

      <div class="col mb-3">
        <h5>Pôle Epitech</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2"><a href="https://www.zeyu.site/" class="nav-link p-0 text-body-secondary">Zeyu Hou</a></li>
          <li class="nav-item mb-2"><a href="https://nathanhan.netlify.app/" class="nav-link p-0 text-body-secondary">Nathan Han</a></li>
          <li class="nav-item mb-2"><a href="/#contact" class="nav-link p-0 text-body-secondary">Contact Us</a></li>
          <li class="nav-item mb-2"><a href="about_us" class="nav-link p-0 text-body-secondary">About US</a></li>
        </ul>
      </div>

    </div>
  </div>
</template>
<script>
  export default {
    methods:{
      redirect(path){
        window.location.href = "/" + path;
      }
    }
  }

</script>