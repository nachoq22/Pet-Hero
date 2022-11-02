<body>
  <br>
<div class="container-fluid content-row">
<div class="row">

<div class="col-2 mt-3">
    <div class="card h-100" style="height: 170px;">
    <a href="../Home/ViewAddPet">
      <div class="card-body justify-content-center" style="display:flex; justify-content: center;" >
      <svg xmlns="http://www.w3.org/2000/svg" width="150" height="220" fill="currentColor" class="bi bi-plus-square; opacity-50" viewBox="0 0 16 16">
     <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
</svg>
      </div>
    </div>
    </a>
  </div>


  <?php
    foreach ($petList as $pet) { ?>
  <div class="col-2 mt-3" >
    <div class="card h-100">
    <img src="<?php echo $pet->getProfileIMG()?>" class="card-img-top" style="width: 100%; height: 10vw; object-fit: cover;" alt="...">
      <div class="card-body d-flex justify-content-center" style="height: 70px;">
      <h5 class="card-title"><?php echo $pet->getName() ?></h5>
      <!--<a href="../Pet/ViewPetProfile" class="stretched-link"></a>-->
      <form action="../Pet/ViewPetProfile">
      <input type="hidden" name="idPet" value=<?php echo $pet->getId() ?>>
      <button type="submit" class="stretched-link" style="border-left-width: 0px;border-top-width: 0px;border-right-width: 0px;height: 0px;padding-right: 0px;padding-left: 0px;border-bottom-width: 0px;padding-bottom: 0px;padding-top: 0px;"></button>
      </form>
    </div>
    </div>
    </div>
    <?php } ?>


  

</div> <!-- /.card-content -->
</div> <!-- /.card-content -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>