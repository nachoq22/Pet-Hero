<header>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?php echo  FRONT_ROOT ?>"><i class="bi bi-house-door"></i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-link">
            <a class="btn btn-outline-success me-2" href="<?php echo FRONT_ROOT."/Home/ViewBeKeeper"?>"><i class="bi bi-person-badge"></i></a>
          </li>
          <li class="nav-link">
            <a class="btn btn-outline-danger me-2" href="<?php echo FRONT_ROOT."/Home/ViewAddPublication"?>" type="button"><i class="bi bi-file-earmark-easel"></i></a>
          </li>
          <li class="nav-link">
            <a class="btn btn-outline-warning me-2" href="<?php echo FRONT_ROOT."/Pet/GetPetsByReservation"?>" type="button"><i class="bi bi-pencil-square"></i></a>
          </li>
          <li class="nav-link">
            <a class="btn btn-dark me-2" href="<?php echo FRONT_ROOT."/Pet/ViewPetList"?>" type="button"><i class="bi bi-bug-fill"></i></a>
          </li>
          <li class="nav-link">
            <a class="btn btn-outline-primary me-2" href="<?php echo FRONT_ROOT."/Home/ViewOwnerPanel"?>" type="button"><i class="bi bi-person-rolodex"></i></a>
          </li>
          <li class="nav-link">
            <a class="btn btn-outline-info me-2" href="<?php echo FRONT_ROOT."/Home/ViewKeeperPanel"?>" type="button"><i class="bi bi-person-rolodex"></i></a>
          </li>
          <li class="nav-link">
            <a class="btn btn-outline-primary me-2" href="<?php echo FRONT_ROOT."/Home/Logout"?>" type="button"><i class="bi bi-person-rolodex"></i></a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              ADDS Registers
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo FRONT_ROOT."/Home/ViewAddTemplates"?>">Add Location</a></li>
              <li><a class="dropdown-item" href="#">Add Size</a></li>
              <li><a class="dropdown-item" href="#">Add PetType</a></li>
            </ul>
          </li>

<!-- DROPDOWN -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				      <i class="bi bi-person-circle"></i>
            </a>

          <ul class="dropdown-menu" id="menuProfile">
               <li><a class="dropdown-item" id="signUpItem" data-bs-toggle="modal" data-bs-target=".bs-modal-sm">Sign Up</a></li>
              <li><a class="dropdown-item" id="loginItem" data-bs-toggle="modal" data-bs-target=".bs-modal-sm">Login</a></li>
          </ul> 
          </li>

        </ul>

        <form class="d-flex" role="search" action="<?php echo FRONT_ROOT."/Home/Search" ?>" method="post" class="was-validated">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="seach" required>
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

      <!--NAV TABS-->
      <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
        <li class="nav-item text-center">
          <a class="nav-link" id="pills-login-tab" data-bs-toggle="pill" href="#pills-login" role="tab" aria-controls="login">Login</a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" id="pills-signUp-tab" data-bs-toggle="pill" href="#pills-signUp" role="tab" aria-controls="signUp">Sign Up</a>
        </li>
      </ul>


      <div class="tab-content" id="pills-tabContent">

        <!--SIGNUP TAB-->
        <div class="tab-pane fade" id="pills-signUp" role="tabpanel" aria-labelledby="pills-signUp-tab">
          <form action="<?php echo FRONT_ROOT."/user/Register" ?>" method="post">
            <div class="mb-3">
              <label for="inputUsername" class="form-label">Username</label>
              <input type="text" class="form-control" id="inputUsername" name="username">
            </div>
            <div class="mb-3">
              <label for="inputEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="inputEmail" name="email">
            </div>
            <div class="mb-3">
              <label for="inputPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="inputPassword" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-primary">Reset</button>
          </form>
        </div>

        <!--LOGIN TAB-->
        <div class="tab-pane fade" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
          <form action="<?php echo FRONT_ROOT."/User/Login" ?>" method="post">
            <div class="mb-3">
              <label for="inputUsername" class="form-label">Username</label>
              <input type="username" class="form-control" id="inputUsername" name="username">
            </div>
            <div class="mb-3">
              <label for="inputPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="inputPassword" name="password">
            </div>

            <!-- PARA PROBAR SI MANTIENE SESIONES VIEJAS
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>-->

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>

        
      </div>
    </div>
  </div>
 <!-- <input type="hidden" id="currentTab" />  NO SE QUE HACE,NO TOCAR-->
</div>

<script>
  const menu =  document.getElementById("menuProfile")

  //En caso de no estarlo mantiene los originales en el HTML de arriba y dispara MODAL --NO TOCAR
    const signUpItem = document.getElementById("signUpItem")
    signUpItem.addEventListener('click', (e) => {
    document.getElementById("pills-signUp-tab").click()
  })

  const loginItem = document.getElementById("loginItem")
  loginItem.addEventListener('click', (e) => {
    document.getElementById("pills-login-tab").click()
  })
</script>