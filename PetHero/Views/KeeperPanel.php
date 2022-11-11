<body>
<div class="container-fluid">
    <div class="row">
        
        <div class="col-sm-auto bg-light sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">
                <a class="d-block p-3 link-dark text-decoration-none" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
                    <i class="bi-bootstrap fs-1"></i>
                </a>
                <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center align-items-center" 
                        role="tablist" id="pills-tab" aria-orientation="vertical">
                    <li class="nav-item">
                        <a href="#" class="nav-link active py-3 px-2" type="button" role="tab" id="keeperData-tab"
                            data-bs-toggle="pill" data-bs-target="#keeperData" aria-controls="keeperData" 
                            aria-selected="true"    data-bs-placement="right">
                            <i class="bi bi-journal-text fs-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link py-3 px-2" type="button" role="tab" id="publicList-tab"
                            data-bs-toggle="pill" data-bs-target="#publicList" aria-controls="publicList" 
                            aria-selected="false"    data-bs-placement="right">
                            <i class="bi bi-file-earmark-richtext fs-1"></i>
                        </a>
                    </li>
                    <li class="nav-item"> 
                        <a href="#" class="nav-link py-3 px-2" type="button" role="tab" id="bookings-tab"
                            data-bs-toggle="pill" data-bs-target="#bookings" aria-controls="bookings" 
                            aria-selected="false"    data-bs-placement="right" >
                            <i class="bi bi-card-list fs-1"></i>
                        </a>
                    </li>
                    
<!--
                    <li>
                        <a href="#" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Products">
                            <i class="bi-heart fs-1"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Customers">
                            <i class="bi-people fs-1"></i>
                        </a>
                    </li>
-->
                </ul>
            </div>
        </div>
        


        <div class="col-sm p-3 min-vh-100">
            <!-- content -->
<!--KEEPER DATA CONTENT-->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="ownerData" role="keeperData" aria-labelledby="keeperData-tab" tabindex="0">
                    
                </div>  

<!--PUBLICLIST CONTENT-->                
                <div class="tab-pane" id="publicList" role="tabpanel" aria-labelledby="publicList-tab" tabindex="0">   
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
                                    </a>
                                </div>
                            </div>
                    <?php foreach ($publicList as $public) { ?>
                            <div class="col-2 mt-3" >
                                <div class="card h-100">
                                <?php foreach ($imgByPublic as $imgP) { ?> 
                                            <?php if ($imgP->getPublication()->getid() == $public->getid()) { ?> 
                                    <img src="<?php echo $imgP->getUrl()?>" class="card-img-top" 
                                    style="width: 100%; height: 10vw; object-fit: cover;" alt="...">
                                    <?php } ?>
                                        <?php } ?>
                                        <div class="card-body d-flex justify-content-center" style="height: 70px;">
                                            <h5 class="card-title"><?php echo $public->getTitle() ?></h5>
                                                <!--<a href="../Pet/ViewPetProfile" class="stretched-link"></a>-->
                                            <form action="../Pet/ViewPetProfile">
                                                <input type="hidden" name="idPet" value=<?php echo $public->getid() ?>>
                                                    <button type="submit" class="stretched-link" style="border-left-width: 0px;border-top-width: 0px;border-right-width: 0px;height: 0px;padding-right: 0px;padding-left: 0px;border-bottom-width: 0px;padding-bottom: 0px;padding-top: 0px;"></button>
                                            </form>
                                        </div>
                                </div>
                            </div>
                    <?php } ?>
                        </div> <!-- /.card-content -->
                    </div> <!-- /.card-content -->
                </div>

<!--BOOKING CONTENT-->
                <div class="tab-pane" id="bookings" role="tabpanel" aria-labelledby="bookings-tab" tabindex="0">
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Publication Info</th>
                                <th>Status</th>
                                <th>Pets</th>
                                <th>Checker</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bookList as $book) { ?> 
                            <tr>
                                <td>
                                    <div class="row"> 
                                        <div class="col-2">

                                            <img src="" class="rounded-circle" alt="" 
                                            style="width: 45px; height: 45px"/>
                         
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="ms-3">
                                                    <p class="fw-bold mb-1">Start Date</p>
                                                    <p class="text-muted mb-0"><?php echo $book->getStartD()?></p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="ms-3">
                                                    <p class="fw-bold mb-1">Finish Date</p>
                                                    <p class="text-muted mb-0"><?php echo $book->getFinishD()?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ((STRCMP($book->getBookState(),"In Review") == 0) XOR 
                                              (STRCMP($book->getBookState(),"Awaiting Payment") == 0)) { ?>    
                                        <span class="badge rounded-pill text-bg-warning"><?php echo $book->getBookState()?></span>
                                    <?php } ?>

                                    <?php if ((STRCMP($book->getBookState(),"Canceled") == 0) XOR 
                                              (STRCMP($book->getBookState(),"Expired") == 0) XOR
                                              (STRCMP($book->getBookState(),"Declined") == 0) XOR
                                              (STRCMP($book->getBookState(),"Out of Term ") == 0) XOR
                                              (STRCMP($book->getBookState(),"Finalized") == 0)) { ?>    
                                        <span class="badge rounded-pill text-bg-danger"><?php echo $book->getBookState()?></span>
                                    <?php } ?>

                                    <?php if ((STRCMP($book->getBookState(),"Waiting Start") == 0) XOR 
                                              (STRCMP($book->getBookState(),"In progress") == 0)) { ?>    
                                        <span class="badge rounded-pill text-bg-success"><?php echo $book->getBookState()?></span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <div class="row">
                                        <?php foreach ($bPetsList as $pet) { ?>   
                                            <?php if ($pet->getBooking()->getId() == $book->getId()) { ?>           
                                            <div class="col-2">
                                                    <img src="<?php echo $pet->getPet()->getProfileIMG()?>" class="rounded-circle" alt="" 
                                                    style="width: 45px; height: 45px;"/>
                                            </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </td>

                                <td>
                                    <a class="btn btn-outline-warning me-2" href="<?php echo FRONT_ROOT."/Checker/GetById"?>" type="button"><i class="bi bi-pencil-square"></i></a>
                                </td>

                                <td>
                                    <?php if ((STRCMP($book->getBookState(),"In Review") == 0)){ ?>         
                                <div class="container-fluid d-flex">
                                    <form action="<?php echo FRONT_ROOT."/Checker/ToResponse" ?>" method="post">
                                        <input type="hidden" class="visually-hidden" name="idBook" value= <?php echo $book->getId()?>>
                                        <input type="hidden" class="visually-hidden" name="rta" value="1" >
                                        <button class="btn btn-outline-success" type="submit"><i class="bi bi-check-square"></i></button>
                                    </form>
                                    <form action="<?php echo FRONT_ROOT."/Checker/ToResponse" ?>" method="post">
                                        <input type="hidden" class="visually-hidden" name="idBook" value= <?php echo $book->getId()?>>
                                        <input type="hidden" class="visually-hidden" name="rta" value="0" >
                                        <button class="btn btn-outline-danger" type="submit"><i class="bi bi-x-square"></i></button>
                                    </form>
                                </div>
                                    <?php } if(STRCMP($book->getBookState(),"Waiting Start") == 0){?>
                                        <a class="btn btn-outline-danger me-2" href="<?php echo FRONT_ROOT."/Checker/GetById"?>" type="button">Cancelar Reserva</a>
                                    <!--MODAL CON INFO DEL BOOKING?-->
                                    <?php } if((STRCMP($book->getBookState(),"Canceled") == 0) XOR 
                                              (STRCMP($book->getBookState(),"Expired") == 0) XOR
                                              (STRCMP($book->getBookState(),"Declined") == 0) XOR
                                              (STRCMP($book->getBookState(),"Out of Term ") == 0) XOR
                                              (STRCMP($book->getBookState(),"Finalized") == 0)){ ?>
                                    <a class="btn btn-outline-info me-2" href="<?php echo FRONT_ROOT."/Checker/GetById"?>" type="button"><i class="bi bi-file-spreadsheet"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>        
                        <?php } ?>
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>