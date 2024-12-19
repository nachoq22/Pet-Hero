<!-- MENSAJE DEL SISTEMA -->
<!-- <?php if (!empty($message)){?>
  <div class="alert alert-light" role="alert">
    <?php echo $message; ?>
  </div>
<?php }?> -->

<body>
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
<form action="<?php if($public == NULL){ echo FRONT_ROOT."/Publication/Add"; } else {echo FRONT_ROOT."/Publication/Update";} ?>" 
    method="post" enctype="multipart/form-data" class="was-validated">
    <div class="row g-3 mb-3">
        <div class="col">       
            <div class="form-floating mb-3">
                <?php if($public != NULL){?> 
                    <input type="hidden" name="idPublic" id="idPublic" value="<?php echo $public -> getId()?>"> 
                <?php } ?>
                <input type="text" class="form-control" id="title" 
                placeholder="<?php if($public != NULL){ echo $public -> getTitle(); } ?>" 
                name="title" value="<?php if($public != NULL){ echo $public -> getTitle(); } ?>" required>
                <label for="title">Title</label>
                    <div class="invalid-feedback">
                        Please enter a Title.
                    </div>
                </div>
      
                <div class="form-floating">
                    <textarea class="form-control" id="description" 
                    placeholder="<?php if($public != NULL){echo $public -> getDescription(); } ?>"
                    value="" 
                    name="description" style="height: 140px" required><?php if($public != NULL){echo $public -> getDescription(); } ?></textarea>
                    <label for="description">Description</label>
                        <div class="invalid-feedback">
                            Please enter a Description.
                        </div>
                    </div>
         </div>
                
        <div class="col">
            <div class="row g-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="openD" 
                                placeholder="<?php if($public != NULL){echo $public -> getOpenDate(); } ?>" 
                                value="<?php if($public != NULL){echo $public -> getOpenDate(); } ?>" 
                                name="openD" required>
                        <label for="openD">Opening Date</label>
                            <div class="invalid-feedback">
                                Please enter a valid date.
                            </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="closeD" 
                                placeholder="<?php if($public != NULL){echo $public -> getCloseDate(); } ?>" 
                                value="<?php if($public != NULL){echo $public -> getCloseDate(); } ?>" 
                                name="closeD" required>
                        <label for="closeD">Closing Date</label>
                            <div class="invalid-feedback">
                                Please enter a valid date.
                            </div>
                    </div>
                </div>
            </div> 
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="remuneration" 
                        placeholder="<?php if($public != NULL){echo $public -> getRemuneration(); } ?>" 
                        value="<?php if($public != NULL){echo $public -> getRemuneration(); } ?>" 
                        name="remuneration" required>
                <label for="remuneration">Remuneration</label>
                    <div class="invalid-feedback">
                        Please enter a Valid Remuneration.
                    </div>
            </div>
            
            <?php if($public == NULL){?>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="images[]" required multiple>
                <label class="input-group-text" for="inputGroupFile02"><i class="bi bi-images"></i></label>
                    <div class="invalid-feedback">
                        Please enter images for Publication.
                    </div>
            </div>   
            <?php } ?>
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
