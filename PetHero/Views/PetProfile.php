<?php
var_dump($petaux);
?>

<body>
<div class="card mx-auto" style="width: 50rem;">
  <img src="..\Views\Img\IMGPet\Profile\your-name20221031201430.jpg" class="card-img-top" style="width: 100%; height: 25vw; object-fit: cover;" alt="...">
  <div class="card-body">
    <h3 class="card-title"><?php echo $petaux->getName() ?></h3>
    <h4>Raza</h4>
    <p>Tamaño: size</p>
    <p class="card-text">Descripcion del animalDescripcion del animalDescripcion del animalDescripcion del animalDescripcion del animalDescripcion del animalDescripcion del animalDescripcion del animalDescripcion del animalDescripcion del animalDescripcion del animal</p>
    <h5>Plan vacunacion:</h5>
    <img src="..\Views\Img\IMGPet\VaccinationPlan\your-name20221031201430.jpg" alt="">
  </div>
</div>
</body>

<?
