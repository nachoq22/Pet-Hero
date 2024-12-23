<!-- MENSAJE DEL SISTEMA -->
<body>
<!-- <?php if (!empty($message)){?>
  <div class="alert alert-light" role="alert">
    <?php echo $message; ?>
  </div>
<?php }?> -->

<?php if (isset($_COOKIE['message'])) { 
            if(strpos($_COOKIE['message'],"Error") !== false) { ?>
                <div class="alert alert-danger alert-dismissible fade show " role="alert">
    <?php    }else{ ?>
                <div class="alert alert-success alert-dismissible fade show " role="alert">    
                    <?php } echo $_COOKIE['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
                </div>
    <?php } setcookie('message', '', time() - 3600,'/'); ?>

<!-- FORMULARIO -->
<form action="<?php echo FRONT_ROOT."/User/BeKeeper" ?>" method="post" enctype="multipart/form-data" class="was-validated">
    <div class="row g-3">

        <div class="col">
            <div class="row g-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="address" 
                               placeholder="San Francisco 1578" name="address" required>
                        <label for="address">Address</label>
                            <div class="invalid-feedback">
                                Please enter a Address.
                            </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="neighborhood" 
                               placeholder="Pompeyita" name="neighborhood" required>
                        <label for="neighborhood">Neighborhood</label>
                            <div class="invalid-feedback">
                                Please enter a Neighborhood.
                            </div>
                    </div>
                </div>
            </div>           
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="city" 
                       placeholder="San Antonio" name="city" required>
                <label for="city">City</label>
                    <div class="invalid-feedback">
                        Please enter a City.
                    </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="province" 
                       placeholder="Utah" name="province" required>
                <label for="province">Province</label>
                    <div class="invalid-feedback">
                        Please enter a Province.
                    </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="country" 
                       placeholder="Qatar" name="country" required>
                <label for="country">Country</label>
                    <div class="invalid-feedback">
                        Please enter a Country.
                    </div>
            </div>
        </div>

        <div class="col">
            <div class="row g-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" placeholder="Jorge" name="name" required>
                        <label for="name">Name</label>
                            <div class="invalid-feedback">
                                Please enter a Name.
                            </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="surname" placeholder="Nitales" name="surname" required>
                        <label for="surname">Surname</label>
                            <div class="invalid-feedback">
                                Please enter a Surname.
                            </div>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="sexM" value="M" required>
                    <label class="form-check-label" for="sexM"><i class="bi bi-gender-male"></i></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="sexF" value="F" required>
                    <label class="form-check-label" for="sexF"><i class="bi bi-gender-female"></i></label>
                </div>
                    
            </div>
            <div class="form-floating mb-3">
                <input type="number" min="1" step="1" class="form-control" id="dni" placeholder="66114488" name="dni"  required>
                <label for="dni">DNI</label>
                    <div class="invalid-feedback">
                        Please enter a DNI.
                    </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <button type="reset" class="btn btn-primary">Reset</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<!-- FORMULARIO -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>