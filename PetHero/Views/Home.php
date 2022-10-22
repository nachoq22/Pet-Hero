<body>
    <div class="card rounded-pill border border-success">
        <div class="card-body">
        <h1>Bienvenido a pet hero, aqui podra buscar a un keeper adecuado para cuidar a su mascota asi como ofrecerse a cuidar otras mascotas!</h1> 
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <div id="list-example" class="list-group">
            <a class="list-group-item list-group-item-action" href="#list-item-1">Location List</a>
            <a class="list-group-item list-group-item-action" href="#list-item-2">Users List</a>
            <a class="list-group-item list-group-item-action" href="#list-item-3">Size List</a>
            <a class="list-group-item list-group-item-action" href="#list-item-4">Type List</a>
            </div>
        </div>
        <div class="col-10">
            <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
                <h4 id="list-item-1">Locations List</h4>
                    <div class="table-responsive ">
                        <table class="table border-primary ">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Adress</th>
                                    <th scope="col">Neighborhood</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Province</th>
                                    <th scope="col">Country</th>
                                </tr>
                            </thead>
                            <tbody> <?php foreach($locationList as $location){ ?>
                                <tr>
                                    <th scope="row"><?php echo $location->getId() ?></th>
                                    <td><?php echo $location->getAdress() ?></td>
                                    <td><?php echo $location->getNeighborhood() ?></td>
                                    <td><?php echo $location->getCity() ?></td>
                                    <td><?php echo $location->getProvince() ?></td>
                                    <td><?php echo $location->getCountry() ?></td>
                                </tr><?php }?>     
                            </tbody>
                        </table>
                    </div>
                <h4 id="list-item-2">List Users</h4>
                    <div class="table-responsive ">
                        <table class="table border-primary ">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Password</th>
                                </tr>
                            </thead>
                            <tbody> <?php foreach($userList as $user){ ?>
                                <tr>
                                    <th scope="row"><?php echo $user->getId() ?></th>
                                    <td><?php echo $user->getUsername() ?></td>
                                    <td><?php echo $user->getEmail() ?></td>
                                    <td><?php echo $user->getPassword() ?></td>
                                </tr><?php }?>     
                            </tbody>
                        </table>
                    </div>
                <h4 id="list-item-3">Size List</h4>
                    <div class="table-responsive ">
                        <table class="table border-primary ">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                </tr>
                            </thead>
                            <tbody> <?php foreach($sizeList as $size){ ?>
                                <tr>
                                    <th scope="row"><?php echo $size->getId() ?></th>
                                    <td><?php echo $size->getName() ?></td>
                                </tr><?php }?>     
                            </tbody>
                        </table>
                    </div>
                <h4 id="list-item-4">Pet Type List</h4>
                    <div class="table-responsive ">
                        <table class="table border-primary ">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                </tr>
                            </thead>
                            <tbody> <?php foreach($typeList as $type){ ?>
                                <tr>
                                    <th scope="row"><?php echo $type->getId() ?></th>
                                    <td><?php echo $type->getName() ?></td>
                                </tr><?php }?>     
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>