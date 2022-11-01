<body>
  <br>
<div class="container-fluid content-row">
<div class="row-fluid">
  <?php
    foreach ($petList as $pet) { ?> 
  <div class="col-2" >
    <div class="card h-100">
    <img src="<?php $pet->getProfileIMG()?>" class="card-img-top" style="width: 100%; height: 10vw; object-fit: cover;" alt="...">
      <div class="card-body d-flex justify-content-center" style="height: 70px;">
      <h5 class="card-title"><?php echo $pet->getName() ?></h5>  
      <a href="../Pet/ViewPetProfile" class="stretched-link"></a>
    </div>
    </div>
    </div>
    <?php } ?>
    

  <!--
  <div class="col-2">
    <div class="card h-100" style="height: 244px;">
    <a href="../Home/ViewAddPet">
      <div class="card-body justify-content-center" style="display:flex; justify-content: center;" >
      <svg xmlns="http://www.w3.org/2000/svg" width="150" height="240" fill="currentColor" class="bi bi-plus-square; opacity-50" viewBox="0 0 16 16">
     <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
</svg>
      </div>
    </div>
    </a>
  </div>
  <div class="col-2" >
    <div class="card h-100">
    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Labrador_Retriever_%281210559%29.jpg" class="card-img-top" style="width: 100%; height: 10vw; object-fit: cover;" alt="...">
      <div class="card-body d-flex justify-content-center" style="height: 70px;">
      <h5 class="card-title">Lucky</h5>  
      <a href="../Pet/ViewPetProfile" class="stretched-link"></a>
    </div>
    </div>
  </div>
-->
  <!--
  

                    <div class="table-responsive ">
                        <table class="table border-primary ">
                            <thead>
                                <tr>
                                <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">breed</th>
                                    <th scope="col">size</th>
                                    <th scope="col">observation</th>
                                    <th scope="col">profileIMG</th>
                                    <th scope="col">VacunationIMG</th>
                                </tr>
                            </thead>
                            <tbody> <?php /* foreach($petList as $pet){ ?>
                                <tr>
                                    <th scope="row"><?php echo $pet->getId() ?></th>
                                    <td><?php echo $pet->getName() ?></td>
                                    <td><?php echo $pet->getBreed() ?></td>
                                    <td><?php echo $pet->getSize()->getName() ?></td>
                                    <td><?php echo $pet->getObservation() ?></td>
                                    <td><img src="<?php echo $pet->getProfileIMG() ?>"> </td>
                                    <td><img src="<?php echo $pet->getVaccinationPlanIMG() ?> "></td>
                                </tr><?php } */ ?>     
                            </tbody>
                        </table>
                    </div>
                              -->

  
    
    


  <!--
  <div class="col-2">
    <div class="card h-100">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Stray_calico_cat_near_Sagami_River-01.jpg/640px-Stray_calico_cat_near_Sagami_River-01.jpg" class="card-img-top" style="width: 100%; height: 10vw; object-fit: cover;" alt="...">
      <div class="card-body d-flex justify-content-center" style="height: 70px;">
      <h5>Michi</h5>

    </div>
    </div>
  </div>
  <div class="col-2">
    <div class="card h-100">
    <img src="https://www.purina-latam.com/sites/g/files/auxxlc391/files/styles/social_share_large/public/01_%C2%BFQu%C3%A9-puedo-hacer-si-mi-gato-est%C3%A1-triste-.png?itok=w67Nhubc" class="card-img-top" style="width: 100%; height: 10vw; object-fit: cover;" alt="">
      <div class="card-body d-flex justify-content-center" style="height: 70px;">
        <h5>Gaston</h5>
      </div>
    </div>
  </div>
  <div class="col-2">
  <div class="card h-100">
    <img src="https://www.ngenespanol.com/wp-content/uploads/2018/08/%C2%BFCu%C3%A1l-es-el-lagarto-m%C3%A1s-grande-del-planeta-1280x720.jpg" class="card-img-top" style="width: 100%; height: 10vw; object-fit: cover;" alt="...">
      <div class="card-body d-flex justify-content-center" style="height: 70px;">
      <h5 class="card-title">Reinaldo</h5>  
    </div>
    </div>
  </div>
  <div class="col-2">
  <div class="card h-100">
    <img src="data:image/jpeg;base64,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" class="card-img-top" style="width: 100%; height: 10vw; object-fit: cover;" alt="...">
      <div class="card-body d-flex justify-content-center" style="height: 70px;">
      <h5 class="card-title">Rick</h5>  
    </div>
    </div>
  </div> 
  -->
  
</div> <!-- /.card-content -->
</div> <!-- /.card-content -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>