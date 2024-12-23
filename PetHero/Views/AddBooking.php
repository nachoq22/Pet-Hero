<body>
<?php if (!empty($message)){?>
    <div class="alert alert-danger" role="alert">
      <?php echo $message; ?>
    </div>
<?php } ?>

<form action="<?php echo FRONT_ROOT."/Booking/Add" ?>" method="post" enctype="multipart/form-data" class="was-validated">
    <div class="row g-3">

        <div class="col-12">
            <div class="row g-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="startD" 
                               placeholder="<?php echo $startD ?>" name="startD" value="<?php echo $startD ?>" readonly required>
                        <label for="startD">Start Date</label>
                            <div class="invalid-feedback">
                                Please enter a date.
                            </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="finishD" 
                               placeholder="<?php echo $finishD ?>" name="finishD" value="<?php echo $finishD ?>" readonly required>
                        <label for="finishD">Finish Date</label>
                            <div class="invalid-feedback">
                                Please enter a date.
                            </div>
                    </div>
                </div>
            </div> 
        </div>    
        <input type="hidden" name="idPublic" value="<?php echo $idPublic ?>">
        <div class="col-12">
            <div class="container marketing">
            <!-- Three columns of text below the carousel -->
                <div class="row">
                <?php   foreach ($petList as $pet) { ?>
                    <div class="col-3 mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="petsId[]" value=<?php echo $pet->getId()?> checked>
                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                            </div>
                        <img class="bd-placeholder-img rounded-circle" src="<?php echo $pet->getProfileIMG()?>" width="140" height="140" 
                        role="img" focusable="false"></img>
                        <h2 class="fw-normal"><?php echo $pet->getName()?></h2>
                        <p><?php echo $pet->getObservation()?></p> 
                    </div>
                <?php } ?><!-- /.col-lg-4 --><!-- /.col-lg-4 -->
                </div><!-- /.row -->
            </div>
        </div>
    </div>
    <div class="row g-3">
        <button type="reset" class="btn btn-primary">Reset</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>


