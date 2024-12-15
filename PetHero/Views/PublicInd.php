<!-- MENSAJE DEL SISTEMA -->
<body>
<?php if (!empty($message)){?>
    <div class="alert alert-danger alert-dismissible fade show " role="alert">
      <?php echo $message; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<br>

  <div class="row">
  <div class="col-2"></div>
  <div class="col-2">
  <?php if(!empty($logUser)){       
            if($public->getUser()->getUsername() == $logUser->getUsername()){  ?>
            <div class="alert alert-primary" role="alert" style="width: 55%;">
            <i class="bi bi-person"></i> Tu Publicacion
            </div>
      <?php }} ?> 
  </div>
  </div>

  <div class="row"> <!-- TITULO Y VALORACION -->
    <div class="col-2">  
    </div>
    <div class="col-5">
    
        <h1><?php echo $public->getTitle() ?></h1>
        <h5>Valoracion: <?php echo $public->getPopularity() ?> ★</h5>
        <h6>Barrio: <?php echo $public->getUser()->getData()->getLocation()->getNeighborhood() ?> </h6>
    </div>
    <div class="col-5">
      <br>

      <!-- ENVIAR MENSAJE AL KEEPER DE LA PUBLICACION -->
      <?php if(!empty($logUser)){  
      if($public->getUser()->getUsername() != $logUser->getUsername()){  ?>
        <form action="<?php echo FRONT_ROOT."/Chat/AddChat"?>" method="post">
        <input type="hidden" value="<?php echo $public->getUser()->getId()?>" id="idKeeper" name="idKeeper"> 
        <button type="submit" class="btn btn-outline-success" href="<?php echo FRONT_ROOT."/Chat/AddChat"?>" type="button">
        <i class="bi bi-chat-right-text-fill"></i> Send Message</form>
        <?php }} ?>
        <!-- ENVIAR MENSAJE AL KEEPER DE LA PUBLICACION -->
         <!-- DROPDOWN PARA QUE EL DUEÑO DE LA PUBLICACION PUEDA EDITAR O BORRARLA -->
        <?php if(!empty($logUser)){       
      if($public->getUser()->getUsername() == $logUser->getUsername()){  ?>
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-gear"></i>
        </button>
        <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Editar</a></li>
        <li><a class="dropdown-item" href="#">Eliminar</a></li>
        </ul>
      <?php }} ?>
      <!-- DROPDOWN PARA QUE EL DUEÑO DE LA PUBLICACION PUEDA EDITAR O BORRARLA -->
    </div>
  </div> <!-- TITULO Y VALORACION -->



  <div class="row"> <!-- CAROUSEL DE IMAGENES  -->
  <div class="col-2">  
    </div> 
    <div class="col-7">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
  <?php foreach($ImgList as $img){ ?>
  <div class="carousel-item active">
      <img src="<?php echo "../".$img->getUrl()?>" class="d-block w-100" alt="..." style="width: 100%; height: 30vw; object-fit: cover;">
    </div>
    <?php } ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    </div>
    <div class="col-3">
      
    </div>
  </div><!-- CAROUSEL DE IMAGENES  -->
  <br><br>



  <div class="row"> <!-- UBICACION, KEEPER Y DESCRIPCION -->
        <div class="col-2">
        </div>
        <div class="col-4">
               <div class="row mt-3">
                      <div class="card">
                      <div class="card-body">
                      <h4 class="card-title"><img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426443508-FEPA6TY38ZQVWWQ240QJ/Throw_Ball.gif%C3%A7" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white me-3">
                      <STRong><?php echo $public->getUser()->getData()->getName() ?>
                      <?php echo $public->getUser()->getData()->getSurname() ?></STRong></h4>
                      <?php foreach ($badges as $badget) {
                             switch($badget) {
                              case"Dog":
                                ?><h6>🐕 Este usuario tiene gran experiencia con perros</h6><?php
                                break;
                              case"Cat":
                                ?><h6>🐈 Este usuario tiene gran experiencia con gatos</h6><?php
                                break;
                              case"Groundhog":
                                ?><h6>🦘 Este usuario tiene gran experiencia con marmotas</h6><?php
                                break;
                              case"Hedgehog":
                                ?><h6>🦔 Este usuario tiene gran experiencia con erizos</h6><?php
                                break;
                              case"Meerkat":
                                ?><h6>🦥 Este usuario tiene gran experiencia con suricatas</h6><?php
                                break;
                              default:
                              ?><?php
                             }
                             ?>  
                        <?php } ?>
                      <h5 class="card-title"><i class="bi bi-geo-alt"></i><strong> <?php echo $public->getUser()->getData()->getLocation()->getCountry() ?>
                      , <?php echo $public->getUser()->getData()->getLocation()->getProvince() ?>,
                      <?php echo $public->getUser()->getData()->getLocation()->getCity() ?>, 
                      <?php echo $public->getUser()->getData()->getLocation()->getAdress() ?> </strong></h5>
                      </div>
                      </div>
                  </div>
                  <div class="badgets" style="margin: 5px;">
                  <?php foreach ($badges as $badget) {
                             switch($badget) {
                              case"Constante":
                              case"Zookeeper aficionado":
                                ?><span class="badge rounded-pill text-bg-primary"><?php echo $badget ?></span>
                                <?php
                                break;
                              case"Confiable":
                              case"Dúo zoonamico":
                                ?><span class="badge rounded-pill text-bg-info"><?php echo $badget ?></span>
                                <?php
                                break;
                              case"Superestrella":
                              case"Zoonogamo":
                                ?><span class="badge rounded-pill text-bg-success"><?php echo $badget ?></span>
                                <?php
                                break;
                              case"Dog":
                                ?><span class="badge rounded-pill text-bg-warning"><?php echo "Amante de los perros" ?></span>
                                <?php
                                break;
                              case"Cat":
                                ?><span class="badge rounded-pill text-bg-warning"><?php echo "Amante de los gatos" ?></span>
                                <?php
                                break;
                              case"Groundhog":
                                ?><span class="badge rounded-pill text-bg-warning"><?php echo "Amante de los Marmota" ?></span>
                                <?php
                                break;
                              case"Hedgehog":
                                ?><span class="badge rounded-pill text-bg-warning"><?php echo "Amante de los erizos" ?></span>
                                <?php
                                break;
                              case"Meerkat":
                                ?><span class="badge rounded-pill text-bg-warning"><?php echo "Amante de los suricata" ?></span>
                                <?php
                                break;
                                break;
                              default:
                              ?><span class="badge rounded-pill text-bg-secondary"><?php echo $badget ?></span>
                                <?php
                             }
                             ?>  
                        <?php } ?>
                  </div>

                  <div class="row mt-3"> <!-- DESCRIPCION -->
                          <div class="container-fluid">
                          <div class="card w-100">
                          <div class="card-body">
                          <p class="card-text"><?php echo $public->getDescription() ?><?php echo $public->getDescription() ?><?php echo $public->getDescription() ?><?php echo $public->getDescription() ?></p>
                          </div>
                          </div>
                          </div>
                  </div> <!-- DESCRIPCION -->
</div>
          <div class="col-3"> <!-- FORMULARIO FECHAS -->
                    <i class="bi bi-calendar-date me-2" width="1em" height="1em"> <?php echo $public->getOpenDate() ?></i>   
                    <i class="bi bi-arrow-right">&nbsp;&nbsp;</i>
                    <i class="bi bi-calendar-date me-2" width="1em" height="1em"> <?php echo $public->getCloseDate() ?></i>
                          <br><br>
                        <?php if(!empty($logUser)){ 
                        if($public->getUser()->getUsername() != $logUser->getUsername()){ ?>
                        <div class="card border-success mb-3" style="max-width: 24rem;">
                        <div class="card-header bg-transparent border-success"><strong>$<?php echo $public->getRemuneration() ?> por noche</strong></div>
                        <div class="card-body text-success">
                        <form action="<?php echo FRONT_ROOT."/Publication/ValidateDateFP" ?>" method="post">
                        <input type="hidden" name="idPublic" value=<?php echo $public->getid() ?>>
                        <p class="card-text"> Ingrese el dia que le gustaria dejar a su mascota</p> <!-- mandar id de public -->
                        <input type="date" id="" name="startD" required >
                        <br><br>
                        <p class="card-text"> Ingrese el dia para ir a buscar su mascota</p> <!-- mandar id de public -->
                        <input type="date" id="" name="finishD" required >
                        </div>
                        <div class="card-footer bg-transparent border-success"><button type="submit" class="btn btn-primary">Comprobar disponibilidad</button></div></form>
                        </div> 
                        </div> <!-- FORMULARIO FECHAS -->
                          <?php }} else{ ?>
                            <div class="alert alert-warning" role="alert">
                            Inicia sesion o registrate para reservar con este Keeper
                            </div>
                         <?php  } ?>
            </div> <!-- UBICACION, KEEPER Y DESCRIPCION -->
</div>

    <br><br><br>
    <div class="row"><div class="col-2"></div>
      <div class="col-4"><h3 style="margin-left: 20px;">Reviews</h3></div>
    </div>
    <div class="row mt-3">   <!-- ESCRIBIR REVIEW -->
      <div class="col-2">  
        <?php if($canReview == 1){ ?>  
      </div>
      <div class="col-4">
        <div class="card" style="margin: 20px;">
          <div class="card-body">
          <div class="row">
            <div class="col">
              <p>Escribe tu reseña</p> 
            </div>
            <div class="col">
              <style>#form {
                width: 250px;
                margin: 0 auto;
                height: 50px;
              }
              #form p {
                text-align: center;
              }
              #form label {
                font-size: 20px;
              }
              input[type="radio"] {
                display: none;
              }
              label {
                color: grey;
              }
              .clasificacion {
                direction: rtl;
                unicode-bidi: bidi-override;
              }
              label:hover,
              label:hover ~ label {
                color: orange;
              }
              input[type="radio"]:checked ~ label {
                color: orange;
              }</style>
              <form action="<?php echo FRONT_ROOT."/Review/Add" ?>" method="post" name="sendPayC">
                <div class="form-floating mb-3">
                    <input type="hidden" name="idPublic" value=<?php echo $public->getid() ?>>     
                    <p class="clasificacion"><!--
                      --><input id="radio1" type="radio" name="stars" value="5" ><!--  CALIFICAR A LA PUBLICAION ★
                      --><label for="radio1"> ★</label><!--
                      --><input id="radio2" type="radio" name="stars" value="4"><!-- ★★
                      --><label for="radio2"> ★</label><!--
                      --><input id="radio3" type="radio" name="stars" value="3"><!-- ★★★
                      --><label for="radio3"> ★</label><!--
                      --><input id="radio4" type="radio" name="stars" value="2"><!-- ★★★★
                      --><label for="radio4"> ★</label><!--
                      --><input id="radio5" type="radio" name="stars" value="1"><!-- CALIFICAR A LA PUBLICAION ★★★★★
                      --><label for="radio5"> ★</label>
                    </p>
                    </div>
                    </div>
                    <div class="form-floating mb-3">
                      <textarea class="form-control" rows="1" id="review" placeholder="Come mucho" name="commentary" onkeypress="if (event.keyCode == 13) Send()" required></textarea>
                      <label for="review">review</label>
                      <div class="invalid-feedback">
                        Enter any observation, special care or details.
                      </div>
                    </div>
                    </div>
                </form>
            </div>
          </div>
      </div>
      <?php } ?>
    <div class="col-6">
    </div>
  </div> <!-- ESCRIBIR REVIEW -->

  <!-- RESEÑAS -->
    <?php if(!empty($reviewList)) { foreach ($reviewList as $review){?>
  <div class="row mt-3"> 
    <div class="col-2">   
    </div>
    <div class="col-6">
    <div class="card" style="margin: 20px;">
      <div class="card-body">
        <h5 class="card-title"><?php echo $review->getUser()->getUsername() ?></h5>
        <h6 class="card-title"><?php echo $review->getStars()?> ★</h6>
        <p class="card-text"><?php echo $review->getCommentary()?></p>
      </div>
    </div>
    </div>
    <div class="col-4">
    </div>
  </div> 
  <?php }} else { ?>
    <div class="row">
      <div class="col-2"></div>
      <div class="col-6">
      <div class="alert alert-dark" role="alert" style="margin: 20px;">
      Aun no hay comentarios
      </div>
      </div>

    </div>
<?php } ?>
  <!-- RESEÑAS -->

<br><br><br>


<script>function Send(){document.sendPayC.submit()}</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>