<body>
  <div class="card rounded-pill border border-success">
        <div class="card-body">
        <h1 class="text-center">ADD FORMS</h1> 
        </div>
  </div>
<br>
  <div class="card rounded border border-5 border-primary">
        <div class="card-body">
        <h5 class="text-center">Location Form</h5> 
        </div>
  </div>

    <form action="<?php echo FRONT_ROOT."/Location/Add" ?>" method="post">
      <div class="mb-3">
          <label for="inputAdress" class="form-label">Adress</label>
          <input type="text" class="form-control" id="inputAdress" name="adress">
      </div>
      <div class="mb-3">
          <label for="inputNeighborhood" class="form-label">Neighborhood</label>
          <input type="text" class="form-control" id="inputNeighborhood" name="neighborhood">
      </div>
      <div class="mb-3">
        <label for="inputCity" class="form-label">City</label>
        <input type="text" class="form-control" id="inputCity" name="city">
      </div>
      <div class="mb-3">
        <label for="inputProvince" class="form-label">Province</label>
        <input type="text" class="form-control" id="inputProvince" name="province">
      </div>
      <div class="mb-3">
        <label for="inputCountry" class="form-label">Country</label>
        <input type="text" class="form-control" id="inputCountry" name="country">
      </div>
      <button type="reset" class="btn btn-primary">Reset</button>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

  <br>
  <div class="card rounded border border-5 border-primary">
        <div class="card-body">
        <h5 class="text-center">Size Form</h5> 
        </div>
  </div>

    <form action="<?php echo FRONT_ROOT."/Size/Add" ?>" method="post">
        <div class="mb-3">
            <label for="inputSizeName" class="form-label">Name</label>
            <input type="text" class="form-control" id="inputSizeName" name="name">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  
  <br>
  <div class="card rounded border border-5 border-primary">
        <div class="card-body">
        <h5 class="text-center">PetType Form</h5> 
        </div>
  </div>

    <form action="<?php echo FRONT_ROOT."/PetType/Add" ?>" method="post">
        <div class="mb-3">
            <label for="inputTypeName" class="form-label">Name</label>
            <input type="text" class="form-control" id="inputTypeName" name="name">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

  <br>
  <div class="card rounded border border-5 border-primary">
        <div class="card-body">
        <h5 class="text-center">Personal Data Form</h5> 
        </div>
  </div>

    <form action="<?php echo FRONT_ROOT."/Keeper/AddPersonalData" ?>" method="post">
      <div class="mb-3">
          <label for="inputName" class="form-label">Name</label>
          <input type="text" class="form-control" id="inputName" name="name">
      </div>
      <div class="mb-3">
          <label for="InputSurname" class="form-label">Surname</label>
          <input type="text" class="form-control" id="InputSurname" name="surname">
      </div>
      <div class="mb-3">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="sex" value="M">
          <label class="form-check-label" for="inlineRadio1">M</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="sex" value="F">
          <label class="form-check-label" for="inlineRadio2">F</label>
        </div>

        <!--<label for="inputSex" class="form-label">Sex</label>
        <input type="text" class="form-control" id="inputSex" name="sex">-->
      </div>
      <div class="mb-3">
        <label for="inputDNI" class="form-label">Dni</label>
        <input type="text" class="form-control" id="inputDNI" name="dni">
      </div>

      <button type="reset" class="btn btn-primary">Reset</button>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>