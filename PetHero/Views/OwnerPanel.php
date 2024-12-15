<body>

<!-- <?php if (!empty($message)){ 
    if(strpos($message, "Error") !== false){?>
    <div class="alert alert-danger" role="alert">
      <?php echo $message; ?>
    </div>
<?php }else{ ?>
<div class="alert alert-success" role="alert">
      <?php echo $message; ?>
    </div>
<?php } ?>
<?php } ?> -->

<?php if (isset($_COOKIE['message'])) { 
            if(strpos($_COOKIE['message'],"Error") !== false) { ?>
                <div class="alert alert-danger alert-dismissible fade show " role="alert">
    <?php    }else{ ?>
                <div class="alert alert-success alert-dismissible fade show " role="alert">    
                    <?php } echo $_COOKIE['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
                </div>
    <?php } setcookie('message', '', time() - 3600,'/'); ?>

<!--
<div class="container-fluid">
    <div class="row">
        
        <div class="col-sm-auto bg-light sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">
            <a class="d-block p-3 link-dark text-decoration-none" title="" data-bs-toggle="tooltip"
                        data-bs-placement="right" data-bs-original-title="Icon-only">
                        <img class="img-fluid" style="height: 90px; width: fit-content;"
                            src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426438102-68EK89NNSIVWSHHSFT73/Pug_walking.gif?format=500w"
                            alt="">
                    </a>
                
                <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center align-items-center" 
                        role="tablist" id="pills-tab" aria-orientation="vertical">
                    <li class="nav-item">
                        <a href="#" class="nav-link active py-3 px-2" type="button" role="tab" id="ownerData-tab"
                            data-bs-toggle="pill" data-bs-target="#ownerData" aria-controls="ownerData" 
                            aria-selected="true"    data-bs-placement="right">
                            <i class="bi bi-journal-text fs-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link py-3 px-2" type="button" role="tab" id="petList-tab"
                            data-bs-toggle="pill" data-bs-target="#petList" aria-controls="petList" 
                            aria-selected="false"    data-bs-placement="right">
                            <i class="bi bi-twitter fs-1"></i>
                        </a>
                    </li>
                    <li class="nav-item"> 
                        <a href="#" class="nav-link py-3 px-2" type="button" role="tab" id="bookings-tab"
                            data-bs-toggle="pill" data-bs-target="#bookings" aria-controls="bookings" 
                            aria-selected="false"    data-bs-placement="right" >
                            <i class="bi bi-card-list fs-1"></i>
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>
        -->
        <div class="col-sm p-3 min-vh-100">
            <!-- content -->
<hr>

<!--PETLIST CONTENT-->                
                 <h2><strong>Your Pets</strong></h2>
                    <div class="container-fluid content-row">
                        <div class="row">
                            <div class="col-2 mt-3">
                                <div class="card h-100" style="height: 170px;">
                                    <a href="<?php echo FRONT_ROOT."/Home/ViewAddPet"?>">
                                        <div class="card-body justify-content-center" style="display:flex; justify-content: center;" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="220" fill="currentColor" class="bi bi-plus-square; opacity-50" viewBox="0 0 16 16">
                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                    <?php foreach ($petList as $pet) { ?>
                            <div class="col-2 mt-3" >
                                <div class="card h-100">
                                    <img src="<?php echo $pet->getProfileIMG()?>" class="card-img-top" 
                                    style="width: 100%; height: 10vw; object-fit: cover;" alt="...">
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
                    <br>
                    <hr>
                

<!--BOOKING CONTENT-->
                <h2><strong>Your Pets's Booking</strong></h2>
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Publication Info</th>
                                <th>Status</th>
                                <th>Pets</th>
                                <th>Checker</th>
                                <th>PayCode Input</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bookList as $book) { ?> 
                            <tr>
                                <td>
                                    <div class="row"> 
                                        <div class="col-2">
                                        <?php foreach ($imgList as $img) { ?> 
                                            <?php if ($img->getPublication()->getId() == $book->getPublication()->getId()) { ?> 
                                            <img src="<?php echo '../'.$img->getUrl()?>" class="rounded-circle" alt="" 
                                            style="width: 45px; height: 45px"/>
                                            <?php } ?>
                                        <?php } ?>
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
                                              (STRCMP($book->getBookState(),"Out of Term") == 0) XOR
                                              (STRCMP($book->getBookState(),"Finalized") == 0)) { ?>    
                                        <span class="badge rounded-pill text-bg-danger"><?php echo $book->getBookState()?></span>
                                    <?php } ?>

                                    <?php if ((STRCMP($book->getBookState(),"In progress") == 0) XOR
                                              (STRCMP($book->getBookState(),"Waiting Start") == 0)) { ?>    
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
                                        <?php 
                                        if ((STRCMP($book->getBookState(),"Awaiting Payment") == 0) XOR
                                            (STRCMP($book->getBookState(),"Canceled") == 0) XOR
                                            (STRCMP($book->getBookState(),"Expired") == 0) XOR
                                            (STRCMP($book->getBookState(),"Out of Term") == 0) XOR
                                            (STRCMP($book->getBookState(),"Finalized") == 0) XOR
                                            (STRCMP($book->getBookState(),"Waiting Start") == 0) XOR
                                            (STRCMP($book->getBookState(),"In Progress") == 0)) { ?>
                                        <div class="container-fluid d-flex">
                                            <form action="<?php echo FRONT_ROOT . "/Checker/ViewChecker" ?>"
                                                method="post">
                                                <input type="hidden" class="visually-hidden" name="idBook" value=<?php echo $book->getId(); ?>>
                                                <button class="btn btn-outline-warning" type="submit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <?php } ?>
                                </td>
                                <td>
                                <?php if(STRCMP($book->getBookState(),"Awaiting Payment") == 0){?>   
                                    <!-- <form action="<?php echo FRONT_ROOT."/Checker/PayCheck" ?>" method="post" name="sendPayC"> -->
                                    <div>
                                        <form action="<?php echo FRONT_ROOT."/Booking/PayBooking" ?>" method="post" name="sendPayC">
                                            <div class="form-floating mb-3">   
                                                <input type="hidden" name="idBook" value=<?php echo $book->getId() ?>>  
                                                <input type="number" class="form-control" id="payCode" 
                                                        placeholder="San Antonio" name="payCode" onkeypress="if (event.keyCode == 13) Send()" style="width: 60%" required>
                                                <label for="payCode">PayCode</label>
                                                    <div class="invalid-feedback">
                                                        Please enter a PayCode.
                                                    </div>
                                                </div>
                                        </form>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CardPayment">
                                        <i class="bi bi-credit-card"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="CardPayment" tabindex="-1" role="dialog" aria-labelledby="CardPaymentTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Card Payment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post" class="needs-validation" novalidate>
                                                
                                                <label for="cardType">Select your card:</label>
                                                    <select name="cardType" id="cardType" class="form-control">
                                                        <option value="visa">Visa</option>
                                                        <option value="masterCard">MasterCard</option>
                                                    </select>
                                                    <br>
                                                <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="cardNumber">Card Number</label>
                                                    <input type="number" class="form-control" id="cardNumber" placeholder="1234 4567 8910 1112">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="securitycode">Security code</label>
                                                    <input type="password" class="form-control" id="securitycode" placeholder="cvv" style="width: 44%;">
                                                </div>
                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Pay</button>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>

                                    </div>

                                    

                                <?php } if(STRCMP($book->getBookState(),"Waiting Start") == 0){?>
                                        <form action="<?php echo FRONT_ROOT."/Booking/CancelBook"?>" method="post" onsubmit="return Confirm()">
                                        <input type="hidden" name="idBook" value=<?php echo $book->getId() ?>>
                                        <button class="btn btn-outline-danger me-2" type="submit">Cancel Booking</button>
                                        </form>
                                    <!--MODAL CON INFO DEL BOOKING?-->
                                <?php } if((STRCMP($book->getBookState(),"Canceled") == 0) XOR 
                                            (STRCMP($book->getBookState(),"Expired") == 0) XOR
                                            (STRCMP($book->getBookState(),"Declined") == 0) XOR
                                            (STRCMP($book->getBookState(),"Out of Term") == 0) XOR
                                            (STRCMP($book->getBookState(),"Finalized") == 0)){ ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script>function Send(){document.sendPayC.submit()}</script>
<script>
    function Confirm(){
        return confirm("Do you want to cancel the booking?");
    }

    const signUpItem = document.getElementById("CardPayment")
    signUpItem.addEventListener('click', (e) => {
    document.getElementById("pills-signUp-tab").click()
  })
  
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>