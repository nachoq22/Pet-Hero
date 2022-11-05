<body>
<form action="<?php echo FRONT_ROOT."/Pet/Add" ?>" method="post" enctype="multipart/form-data" class="was-validated">
	<div class="container-fluid">
				<div class="row g-3">
					<div class="col">
					<div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" placeholder="Jorge" name="name" required>
                        <label for="name">Pet Name</label>
                            <div class="invalid-feedback">
                                Please enter your pet's name.
                            </div>
                    </div>
					</div>
					<div class="col">
					<div class="form-floating mb-3">
                        <input type="text" class="form-control" id="breed" placeholder="Jorge" name="breed" required>
                        <label for="breed">Pet Breed</label>
                            <div class="invalid-feedback">
                                Please enter your pet's breed.
                            </div>
                    </div>
					</div>
				</div>

                <div class="row g-3">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="petType" name="type" required>
                                <option selected disabled value="">Open to select...</option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Hedgehog">Hedgehog</option>
                                <option value="Groundhog">Groundhog</option>
                                <option value="Meerkat">Meerkat</option>
                                <option value="Cacatuos">Cacatuos</option>
                            </select>
                            <label for="petType">Pet Type</label>
                                <div class="invalid-feedback">
                                    Select the Type of Pet.
                                </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="petSize" name="size" required>
                                <option selected disabled value="">Open to select...</option>
                                <option value="Little">Little</option>
                                <option value="Little-Medium">Little medium</option>
                                <option value="Medium">Medium</option>
                                <option value="Medium-Big">Medium Big</option>
                                <option value="Big">Big</option>
                                <option value="ExtraBig">Extra Big</option>
                            </select>
                            <label for="petSize">Pet Size</label>
                                <div class="invalid-feedback">
                                    Select the Size of your Pet
                                </div>
                            </div>
                    </div>
                </div>

                <div class="row g-3">
                <div class="form-floating mb-3">
                        <textarea class="form-control" id="observation" placeholder="Come mucho" name="observation" required></textarea>
                        <label for="observation">Observation</label>
                            <div class="invalid-feedback">
                                Enter any observation, special care or details.
                            </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="ImagenP" name="ImagenP" required>
                            <label class="input-group-text" for="ImagenP"><i class="bi bi-images"></i></label>
                                <div class="invalid-feedback">
                                    Enter your pet's profile picture.
                                </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="ImagenV" name="ImagenV" required>
                            <label class="input-group-text" for="ImagenV"><i class="bi bi-images"></i></label>
                                <div class="invalid-feedback">
                                    Enter a photo of your pet's vaccination plan
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                        <button type="reset" class="btn btn-primary">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                </div>
	</div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>