<?php
    include("Head.php");
?>  
<header>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo  FRONT_ROOT?>">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo  FRONT_ROOT."/Home/ViewRegister"?>">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo  FRONT_ROOT."/Home/ViewLogin"?>">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo  FRONT_ROOT."/Home/ViewPersonalinfo"?>">Add Algo</a>
        </li>
        <li class="nav-item">
        <a class="btn btn-outline-success me-2" href="Home/ViewBeKeeper" type="button">Be a Keeper!</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ADDS Registers
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Add Location</a></li>
            <li><a class="dropdown-item" href="#">Add Size</a></li>
            <li><a class="dropdown-item" href="#">Add PetType</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
          </svg>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#signup" data-bs-toggle="modal" data-bs-target=".bs-modal-sm">Sign Up</a></li>
            <li><a class="dropdown-item" href="#">Login</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
</header>

  <!-- Modal -->
  <div class="modal fade bs-modal-sm" aria-hidden="true">
    <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item text-center">
            <a class="nav-link active" id="pills-login-tab" 
                data-bs-toggle="pill" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
          </li>
          <li class="nav-item text-center">
            <a class="nav-link" id="pills-signUp-tab" 
                data-bs-toggle="pill" href="#signUp" role="tab" aria-controls="signUp" aria-selected="false">Sign Up</a>
          </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
          <!--LOGIN TAB-->
          <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
            <div class="form px-4 pt-5">
              <input type="text" name="" class="form-control" placeholder="Username">
              <input type="text" name="" class="form-control" placeholder="Password">
              <button class="btn btn-dark btn-block">Login</button>
            </div>
          </div>
          <!--SIGNIN TAB-->
          <div class="tab-pane fade" id="pills-signin" role="tabpanel" aria-labelledby="pills-signUp-tab">
              <div class="form px-4 pt-5">
                <input type="text" name="" class="form-control" placeholder="Username">
                <input type="text" name="" class="form-control" placeholder="Email">
                <input type="text" name="" class="form-control" placeholder="Password">
                <button class="btn btn-dark btn-block">Sign Up</button>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
