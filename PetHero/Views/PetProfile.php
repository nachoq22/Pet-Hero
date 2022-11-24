<body>
<div class="card mx-auto" style="width: 50rem;">
  <img src="<?php echo $petaux->getProfileIMG()?>" class="card-img-top" style="width: 100%; height: 25vw; object-fit: cover;" alt="...">
  <div class="card-body">
    <h3 class="card-title"><?php echo $petaux->getName() ?></h3>
    <h4><?php echo $petaux->getBreed() ?></h4>
    <p>Tamaño: <?php echo $petaux->getSize()->getName() ?></p>
    <p class="card-text"><?php echo $petaux->getObservation() ?> </p>
    <h5>Plan vacunacion:</h5>
    <br>
    <img src="<?php echo $petaux->getVaccinationPlanIMG()?>" style="width: 100%; height: 25vw; object-fit: cover;" alt="">
  </div>
</div>
</body>
