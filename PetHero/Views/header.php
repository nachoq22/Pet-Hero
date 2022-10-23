<?php
include("Head.php");
?>
<header>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?php echo  FRONT_ROOT ?>">Home</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?php echo  FRONT_ROOT . "/Home/ViewRegister" ?>">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="Home/ViewRegister">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Location/Add">Add Algo</a>
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
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
              </svg>
            </a>

            <!-- DROPDOWN -->
            <ul class="dropdown-menu" id="menuProfile">
              <li><a class="dropdown-item" id="signUpItem" data-bs-toggle="modal" data-bs-target=".bs-modal-sm">Sign Up</a></li>
              <li><a class="dropdown-item" id="loginItem" data-bs-toggle="modal" data-bs-target=".bs-modal-sm">Login</a></li>
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
<div class="modal fade bs-modal-sm" aria-hidden="true" id="modalLoginRegister">
  <div class="modal-dialog modal-sm">

    <div class="modal-content">

      <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
        <li class="nav-item text-center">
          <a class="nav-link" id="pills-login-tab" data-bs-toggle="pill" href="#pills-login" role="tab" aria-controls="login">Login</a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" id="pills-signUp-tab" data-bs-toggle="pill" href="#pills-signUp" role="tab" aria-controls="signUp">Sign Up</a>
        </li>
      </ul>

      <div class="tab-content" id="pills-tabContent">
        <!--LOGIN TAB-->
        <div class="tab-pane fade " id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
          <form>
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="form1Example1" class="form-control" />
              <label class="form-label" for="form1Example1">Email address</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="form1Example2" class="form-control" />
              <label class="form-label" for="form1Example2">Password</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
              <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                  <label class="form-check-label" for="form1Example3"> Remember me </label>
                </div>
              </div>

              <div class="col">
                <!-- Simple link -->
                <a href="#!">Forgot password?</a>
              </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
          </form>


        </div>

        <!--SIGNIN TAB-->
        <div class="tab-pane fade" id="pills-signUp" role="tabpanel" aria-labelledby="pills-signUp-tab">
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
  <input type="hidden" id="currentTab" />
</div>

<script>
  const menu =  document.getElementById("menuProfile")
  let isLogged=false;
  if(isLogged){
    const item1 =  `<li><a class="dropdown-item" id="signUpItem" data-bs-toggle="modal" data-bs-target=".bs-modal-sm">Profile</a></li>
    <li><a class="dropdown-item" id="signUpItem" data-bs-toggle="modal" data-bs-target=".bs-modal-sm">Cerrar Session</a></li>
    `
    menu.innerHTML = item1
  }else{
    const signUpItem = document.getElementById("signUpItem")
  signUpItem.addEventListener('click', (e) => {
    document.getElementById("pills-signUp-tab").click()
  })



  const loginItem = document.getElementById("loginItem")
  loginItem.addEventListener('click', (e) => {
    document.getElementById("pills-login-tab").click()
  })
  }
  
</script>