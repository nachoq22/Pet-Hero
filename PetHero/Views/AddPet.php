<body>
<form action="<?php echo FRONT_ROOT."/Pet/Add" ?>" method="post">
      <div class="mb-3">
          <label for="inputName" class="form-label">Pet´s name</label>
          <input type="text" class="form-control" id="inputAdress" name="name">
      </div>

      <div class="mb-3">
          <label for="inputPetType" class="form-label">Pet Type</label>
          <select name="petType" class="form-control" id="inputpetType" name="petType">
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
            <option value="hedgehog">Hedgehog</option>
            <option value="groundhog">Groundhog</option>
            <option value="meerkat">Meerkat</option>
            <option value="cacatuos">Cacatuos</option>
            </select>
      </div>

      <div class="mb-3">
          <label for="inputBreed" class="form-label">Breed</label>
          <input type="text" class="form-control" id="inputBreed" name="breed">
      </div>

      <div class="mb-3">
          <label for="inputSize" class="form-label">Size</label>
          <select name="size" class="form-control" id="inputsize" name="size">
            <option value="little">Little</option>
            <option value="littleMedium">Little medium</option>
            <option value="Medium">Medium</option>
            <option value="BigMedium">Big medium</option>
            <option value="Big">Big</option>
            <option value="ExtraBig">Extra Big</option>
            </select>
      </div>

      <div class="mb-3">
        <label for="inputCity" class="form-label">{Imagen de perfil}</label>
        <input type="file" id="avatar" name="profileIMG" accept="image/png, image/jpeg">
    </div>

      
        <br><br>
      <div class="mb-3">
        <label for="inputProvince" class="form-label">Plan de vacunacion</label>
        <input type="file" id="avatar" name="vaccinationPlanIMG" accept="image/png, image/jpeg">
    </div>

      
        <br><br>
      <div class="mb-3">
        <label for="inputCountry" class="form-label">Observacion (Contanos mas sobre tu mascota, o comentanos algun cuidado especial que requiera)</label>
        <input type="text" class="form-control" id="inputCountry" name="observation">
      </div>
      <button type="reset" class="btn btn-primary">Reset</button>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>