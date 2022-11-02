<body>
<form action="<?php echo FRONT_ROOT."/User/AddPublication" ?>" method="post" enctype="multipart/form-data" class="was-validated">
    <div class="row g-3">

        <div class="col-6">
            <div class="row g-3">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="openD" 
                               placeholder="San Francisco 1578" name="openD" required>
                        <label for="openD">Opening Date</label>
                            <div class="invalid-feedback">
                                Please enter a valid date.
                            </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="closeD" 
                               placeholder="Pompeyita" name="closeD" required>
                        <label for="closeD">Closing Date</label>
                            <div class="invalid-feedback">
                                Please enter a valid date.
                            </div>
                    </div>
                </div>
            </div> 

            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="remuneration" 
                       placeholder="San Antonio" name="remuneration" required>
                <label for="remuneration">Remuneration</label>
                    <div class="invalid-feedback">
                        Please enter a Valid Remuneration.
                    </div>
            </div>

            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" required>
                <label class="input-group-text" for="inputGroupFile02"><i class="bi bi-images"></i></label>
                    <div class="invalid-feedback">
                        Please enter images for Publication.
                    </div>
            </div>
                 

<!-- PARA REVISAR
            <div class="form-floating mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" name="remuneration" required>
                    <span class="input-group-text">0.00</span>
                        <div class="invalid-feedback">
                            Please enter a Valid Remuneration.
                        </div>
                </div>
            </div>
-->
        </div>

        <div class="col-6">       
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="title" placeholder="Jorge" name="title" required>
                        <label for="name">Title</label>
                            <div class="invalid-feedback">
                                Please enter a Title.
                            </div>
                    </div>
      
                    <div class="form-floating">
                        <textarea class="form-control" id="description" placeholder="Nitales" name="description" style="height: 140px" required></textarea>
                        <label for="description">Description</label>
                            <div class="invalid-feedback">
                                Please enter a Description.
                            </div>
                    </div>
                </div>       
        <div class="col-12">
            <button type="reset" class="btn btn-primary">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
