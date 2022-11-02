<body>
<form action="<?php echo FRONT_ROOT."/Reservation/Add" ?>" method="post" enctype="multipart/form-data" class="was-validated">
    <div class="row g-3">

        <div class="col-12">
            <div class="row g-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="startD" 
                               placeholder="San Francisco 1578" name="startD" required>
                        <label for="startD">Start Date</label>
                            <div class="invalid-feedback">
                                Please enter a date.
                            </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="finishD" 
                               placeholder="Pompeyita" name="finishD" required>
                        <label for="finishD">Finish Date</label>
                            <div class="invalid-feedback">
                                Please enter a date.
                            </div>
                    </div>
                </div>
            </div> 
        </div>    

        <div class="col-12">
            <div class="container marketing">
            <!-- Three columns of text below the carousel -->
                <div class="row">
                <?php   foreach ($petList as $pet) { ?>
                    <div class="col-4 mt-3">
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

        <div class="col-12">
            <div class="align-item-center">
                <button type="reset" class="btn btn-primary">Reset</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>


