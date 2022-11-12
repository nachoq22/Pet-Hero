<body>
<?php if (!empty($message)){?>
    <div class="alert alert-danger" role="alert">
      <?php echo $message; ?>
    </div>
<?php } ?>

  <div class="row"> <!-- TITULO Y VALORACION -->
    <div class="col-2">
        
    </div>
    <div class="col-5">
        <h1><?php echo $public->getTitle() ?></h1>
        <h5>Valoracion: <?php echo $public->getPopularity() ?> ★</h5>
        <h6>Barrio: <?php echo $public->getUser()->getData()->getLocation()->getNeighborhood() ?> </h6>
    </div>
    <div class="col-5">
      
    </div>
  </div> <!-- TITULO Y VALORACION -->
  <div class="row"> <!-- CAROUSEL  -->
  <div class="col-2">
        
    </div> 
    <div class="col-7">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
  <?php foreach($ImgList as $img){ ?>
  <div class="carousel-item active">
      <img src="<?php echo $img->getUrl()?>" class="d-block w-100" alt="..." style="width: 100%; height: 30vw; object-fit: cover;">
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
  </div><!-- CAROUSEL  -->
  <br><br>



  <div class="row"> <!-- UBICACION Y KEEPER -->
        <div class="col-2">
        </div>
        <div class="col-4">
               <div class="row mt-3">
                      <div class="card">
                      <div class="card-body">
                      <h4 class="card-title"><img src="https://pbs.twimg.com/media/E0e2SE4XsAgxVdm.jpg" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white me-3">
                      <STRong><?php echo $public->getUser()->getData()->getName() ?>
                      <?php echo $public->getUser()->getData()->getSurname() ?></STRong></h4>
                      <h5 class="card-title"><i class="bi bi-geo-alt"></i><strong> <?php echo $public->getUser()->getData()->getLocation()->getCountry() ?>
                      , <?php echo $public->getUser()->getData()->getLocation()->getProvince() ?>,
                      <?php echo $public->getUser()->getData()->getLocation()->getCity() ?>, 
                      <?php echo $public->getUser()->getData()->getLocation()->getAdress() ?> </strong></h5>
                      </div>
                      </div>
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
          <div class="col-6"> <!-- UBICACION Y KEEPER -->
                        <?php if($public->getUser()->getUsername() != "planetar"){ ?>
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
                        </div>
                          <?php } ?>
            </div> <!-- UBICACION Y KEEPER -->
</div>

    <br><br><br>
    <div class="row mt-3">   <!-- Escribir Reseña -->
      <div class="col-2">  
        <?php if($canReview == 1){ ?>  
      </div>
      <div class="col-4">
        <div class="card">
          <div class="card-body">
          <div class="row">
            <div class="col">
              <p>Nachoq22</p>
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
                    <p class="clasificacion">
                      <input id="radio1" type="radio" name="estrellas" value="5" ><!--
                      --><label for="radio1"> ★</label><!--
                      --><input id="radio2" type="radio" name="estrellas" value="4"><!--
                      --><label for="radio2"> ★</label><!--
                      --><input id="radio3" type="radio" name="estrellas" value="3"><!--
                      --><label for="radio3"> ★</label><!--
                      --><input id="radio4" type="radio" name="estrellas" value="2"><!--
                      --><label for="radio4"> ★</label><!--
                      --><input id="radio5" type="radio" name="estrellas" value="1"><!--
                      --><label for="radio5"> ★</label>
                    </p>
                    </div>
                    </div>
                    <div class="form-floating mb-3">
                      <textarea class="form-control" id="review" placeholder="Come mucho" name="review" onkeypress="if (event.keyCode == 13) Send()" required></textarea>
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
  </div> <!-- Escribir Reseña -->
    <?php foreach ($reviewList as $review){?>
  <div class="row mt-3"> <!-- RESEÑAS -->
    <div class="col-2">   
    </div>
    <div class="col-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><?php echo $review->getUser()->getUsername() ?></h5>
        <h6 class="card-title"><?php echo $review->getStars()?> ★</h6>
        <p class="card-text"><?php echo $review->getCommentary()?></p>
      </div>
    </div>
    </div>
    <div class="col-6">
    </div>
  </div> <!-- RESEÑAS -->
  <?php } ?>


<br><br><br>


<script>function Send(){document.sendPayC.submit()}</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>