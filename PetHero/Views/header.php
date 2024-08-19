<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between  border-bottom">
    <?php if(!isset($_SESSION['logUser'])){?>
    <ul class="nav col-12 col-md-auto mb-2 justify-content-start mb-md-0">
        <li> <a class="nav-link px-2 link-dark" href="<?php echo  FRONT_ROOT ?>"><h4 class="card-title"><img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426443508-FEPA6TY38ZQVWWQ240QJ/Throw_Ball.gif%C3%A7" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white me-3"></a></li>
    </ul>
<?php }else{
    if(isset($_SESSION['logUser'])){
        if(isset($_SESSION["isKeeper"])){?>
      <ul class="nav col-12 col-md-auto mb-2 justify-content-start mb-md-0">
        <li> <a class="nav-link px-2 link-dark" href="<?php echo  FRONT_ROOT ?>"><i class="bi bi-house-door"></i></a></li>
        <li> <a class="btn btn-outline-info" href="<?php echo FRONT_ROOT."/Home/ViewOwnerPanel"?>" type="button"><i class="bi bi-person-square"></i></a></li>
        <li> <a class="btn btn-outline-warning" href="<?php echo FRONT_ROOT."/Home/ViewKeeperPanel"?>" type="button"><i class="bi bi-person-square"></i></a></li>
        <li> <a class="btn btn-outline-success" href="<?php echo FRONT_ROOT."/Home/ViewPanelChatHome"?>" type="button"><i class="bi bi-chat-text"></i></a></li>

      </ul>
<?php }else{?>
      <ul class="nav col-12 col-md-auto mb-2 justify-content-start mb-md-0">
        <li> <a class="nav-link px-2 link-dark" href="<?php echo  FRONT_ROOT ?>"><i class="bi bi-house-door"></i></a></li>
        <li><a href="<?php echo FRONT_ROOT."/Home/ViewBeKeeper"?>" class="nav-link px-2 link-success">Be Keeper</a></li>
        <li> <a class="btn btn-outline-success" href="<?php echo FRONT_ROOT."/Home/ViewOwnerPanel"?>" type="button"><i class="bi bi-person-square"></i></a></li>
        <li> <a class="btn btn-outline-success" href="<?php echo FRONT_ROOT."/Home/ViewPanelChatHome"?>" type="button"><i class="bi bi-chat-text"></i></a></li>
      </ul>
      <?php }
          }
      }?>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <form class="w-100 me-3" role="search" action="<?php echo FRONT_ROOT."/Home/Search" ?>" method="post" class="was-validated">
          <div class="p-1 bg-light rounded rounded-pill shadow-sm">
            <div class="input-group">
              <input type="search" placeholder="What're you searching for?" aria-describedby="button-addon1" name="seach" class="form-control border-0 bg-light" required>
              <div class="input-group-append">
                <button id="button-addon1" type="submit" class="btn btn-link text-danger"><i class="bi bi-search"></i></button>
              </div>
            </div>
          </div>
        </form>
      </ul>

      <?php if(!isset($_SESSION['logUser'])){?>
      <div class="flex-shrink-0 dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				      <i class="bi bi-person-circle"></i>
            </a>

          <ul class="dropdown-menu text-small shadow" id="menuProfile">
               <li><a class="dropdown-item" id="signUpItem" data-bs-toggle="modal" data-bs-target=".bs-modal" role="button">Sign Up</a></li>
              <li><a class="dropdown-item" id="loginItem" data-bs-toggle="modal" data-bs-target=".bs-modal" role="button">Login</a></li>
          </ul> 
      </div>
      <?php }else{
        if(isset($_SESSION['logUser'])){
          if(isset($_SESSION["isKeeper"])){?>
            <div class="flex-shrink-0 dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                  </a>
                <ul class="dropdown-menu text-small shadow" id="menuProfile">
                    <li><a class="dropdown-item" href="<?php echo FRONT_ROOT."/Home/ViewOwnerPanel"?>">Owner Panel</a></li>    
                    <li><a class="dropdown-item" href="<?php echo FRONT_ROOT."/Home/ViewKeeperPanel"?>">Keeper Panel</a></li>     
                    <li><a class="dropdown-item" href="<?php echo FRONT_ROOT."/Home/Logout"?>">Logout</a></li>
                </ul>
            </div>
          <?php }else{?>
            <div class="flex-shrink-0 dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                  </a>
                <ul class="dropdown-menu text-small shadow" id="menuProfile">
                    <li><a class="dropdown-item" href="<?php echo FRONT_ROOT."/Home/ViewOwnerPanel"?>">Owner Panel</a></li>      
                    <li><a class="dropdown-item" href="<?php echo FRONT_ROOT."/Home/Logout"?>">Logout</a></li>
                </ul>
            </div>
            <?php }
            }
        }?>
    </header>
</div>


<!-- Modal -->
<div class="modal fade bs-modal" aria-hidden="true" id="modalLoginRegister">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow">

      <!--NAV TABS-->
      <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
        <li class="nav-item text-center">
          <a class="nav-link" id="pills-login-tab" data-bs-toggle="pill" href="#pills-login" role="tab" aria-controls="login"><h6>Login</h6></a>
        </li>
        <li class="nav-item text-center">
          <a class="nav-link" id="pills-signUp-tab" data-bs-toggle="pill" href="#pills-signUp" role="tab" aria-controls="signUp"><h6>Sign Up</h6></a>
        </li>
      </ul>


      <div class="tab-content" id="pills-tabContent">

        <!--SIGNUP TAB-->
        <div class="tab-pane fade" id="pills-signUp" role="tabpanel" aria-labelledby="pills-signUp-tab">
          <form action="<?php echo FRONT_ROOT."/User/Register" ?>" method="post" class="was-validated">
			<div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" placeholder="Jorge" name="username" required>
                	<label for="username">Username</label>
                    <div class="invalid-feedback">
                            Please enter your Username.
                    </div>
            </div>
			<div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="Jorge" name="email" required>
                	<label for="email">Email</label>
                    <div class="invalid-feedback">
                            Please enter your Email.
                    </div>
            </div>
			<div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" placeholder="Jorge" name="password" required>
                	<label for="password">Password</label>
                    <div class="invalid-feedback">
                            Please enter your Password.
                    </div>
            </div>
			<div class="d-flex">
				<button type="submit" class="w-50 mb-2 btn btn-sm rounded-3 btn-primary">Sign up</button>
				<button type="reset" class="w-50 mb-2 btn btn-sm rounded-3 btn-primary">Reset</button>
			</div>
          </form>
        </div>

        <!--LOGIN TAB-->
        <div class="tab-pane fade" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
          <form action="<?php echo FRONT_ROOT."/User/Login" ?>" method="post" class="was-validated">
		  <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" placeholder="Jorge" name="username" required>
                	<label for="username">Username</label>
                    <div class="invalid-feedback">
                            Please enter your Username.
                    </div>
            </div>
			<div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" placeholder="Jorge" name="password" required>
                	<label for="password">Password</label>
                    <div class="invalid-feedback">
                            Please enter your Password.
                    </div>
            </div>
			<div class="d-flex">
				<button type="submit" class="w-50 mb-2 btn btn-sm rounded-3 btn-primary">Login</button>
				<button type="reset" class="w-50 mb-2 btn btn-sm rounded-3 btn-primary">Reset</button>
			</div>
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