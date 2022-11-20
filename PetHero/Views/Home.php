<body>
	<?php if (!empty($message)) { ?>
		<?php if (strpos($message, "Error") !== false) { ?>
			<div class="alert alert-danger" role="alert">
				<?php echo $message; ?>
			</div>
		<?php } else { ?>
			<div class="alert alert-success" role="alert">
				<?php echo $message; ?>
			</div>
		<?php } ?>
	<?php } ?>

	<div class="container-fluid">
		<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active" data-bs-interval="10000">
					<img src="Views\Img\IMGPublic\11223344-IMGPublic20221115213311.jpg"
						class="d-block w-100" style="width: 100%; height: 40vw; object-fit: cover;" alt="...">
				</div>
				<div class="carousel-item" data-bs-interval="2000">
					<img src="https://cdn.redcanina.es/wp-content/uploads/2019/05/27123116/casas-para-perros-redcanina.jpg"
						class="d-block w-100" style="width: 100%; height: 40vw; object-fit: cover;" alt="...">
				</div>
                <div class="carousel-item" data-bs-interval="2000">
					<img src="https://static1.laverdad.es/www/multimedia/201707/21/media/cortadas/perretes-ksGC-U40396701700H5H-624x385@La%20Verdad.jpg"
						class="d-block w-100" style="width: 100%; height: 40vw; object-fit: cover;" alt="...">
				</div>
                
		
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
	</div>



	<div class="container px-4 py-5" id="custom-cards">
    <h2 class="pb-2 border-bottom">With best rating</h2>

    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-3 py-2">
    <?php foreach ($publicList as $public) { ?>
    <div class="col">
    <div class="card text-bg-dark" >
    <?php foreach ($imgByPublic as $imgP) { 
					if ($imgP->getPublication()->getid() == $public->getid()) { ?> 
        <img src="<?php echo $imgP->getUrl(); ?>" class="card-img" alt="..." style="width: 100%; height: 28vw; object-fit: cover;">
        <?php } 
                } ?>
    <div class="card-img-overlay" style="background-color: rgba(211,211,211,0.37);">
        <h5 class="card-title"><?php echo $public->getTitle() ?></h5>

    <p class ="card-text"><small><?php echo $public->getPopularity()." ☆☆☆☆☆"?>
   <br><?php echo $public->getUser()->getData()->getLocation()->getCity();
   echo ", ".$public->getUser()->getData()->getLocation()->getNeighborhood(); ?></small></p> 


        <ul class="card-footer"><strong>
							<li class="d-flex align-items-center me-3">
								<i class="bi bi-calendar-date me-2" width="1em" height="1em"></i>
								<small>
									<?php echo $public->getOpenDate() ?>
								</small>
							</li>
							<li class="d-flex align-items-center">
								<i class="bi bi-calendar-date me-2" width="1em" height="1em"></i>
								<small>
									<?php echo $public->getCloseDate() ?>
								</small>
							</li>
						</ul>
                        <p class="card-footer"><i class="bi bi-currency-dollar me-1" width="1em" height="1em"></i>
								<small>
									<strong>
										<?php echo $public->getRemuneration() ?>
									</strong>
								</small>
                        </p>
                        </strong>
                        <form action="<?php echo FRONT_ROOT."/Publication/ViewPublication"?>" method="post">
      								<input type="hidden" name="idPublic" value=<?php echo $public->getId() ?>>
      								<button type="submit" class="stretched-link" style="border-left-width: 0px;border-top-width: 0px;border-right-width: 0px;height: 0px;padding-right: 0px;padding-left: 0px;border-bottom-width: 0px;padding-bottom: 0px;padding-top: 0px;"></button>
                                </form>
            
    </div>
    </div>
    </div>
    <?php } ?>
    </div>

        
 <!-- <?php /*   Viejas publicaiones      
		<div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-3 py-2">
			<?php foreach ($publicList as $public) { ?>
			<div class="col">
				<?php foreach ($imgByPublic as $imgP) { 
					if ($imgP->getPublication()->getid() == $public->getid()) { ?> 
				<div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" 
				    style=" background-image: url('<?php echo $imgP->getUrl(); ?>'); 
					background-size: cover;
					background-repeat: no-repeat;
					background-position: center center;
					width: 100%;">
					<?php } 
                } ?>
					<div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
						<h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">
							<?php echo $public->getTitle() ?>
						</h3>

						<ul class="d-flex list-unstyled mt-auto">
							<li class="d-flex align-items-center me-3">
								<i class="bi bi-calendar-date me-2" width="1em" height="1em"></i>
								<small>
									<?php echo $public->getOpenDate() ?>
								</small>
							</li>
							<li class="d-flex align-items-center">
								<i class="bi bi-calendar-date me-2" width="1em" height="1em"></i>
								<small>
									<?php echo $public->getCloseDate() ?>
								</small>
							</li>
						</ul>

						<ul class="d-flex list-unstyled mt-auto">
							<li class="me">
								<img src="https://pbs.twimg.com/media/E0e2SE4XsAgxVdm.jpg" alt="Bootstrap" width="32"
									height="32" class="rounded-circle border border-white me-3">
							</li>
							<li class="d-flex align-items-center me-3">
								<i class="bi bi-map me-1" width="1em" height="1em"></i>
								<small>
									<?php echo $public->getUser()->getData()->getLocation()->getCity() ?>
								</small>
							</li>
							<li class="d-flex align-items-center me-3" 
							    style="color: #fff;
								text-shadow:
								0 0 7px #fff,
								0 0 10px #fff,
								0 0 21px #fff,
								0 0 42px #0fa,
								0 0 82px #0fa,
								0 0 92px #0fa,
								0 0 102px #0fa,
								0 0 151px #0fa;">
								<i class="bi bi-currency-dollar me-1" width="1em" height="1em"></i>
								<small>
									<strong>
										<?php echo $public->getRemuneration() ?>
									</strong>
								</small>
								<form action="<?php echo FRONT_ROOT."/Publication/ViewPublication"?>" method="post">
      								<input type="hidden" name="idPublic" value=<?php echo $public->getId() ?>>
      								<button type="submit" class="stretched-link" style="border-left-width: 0px;border-top-width: 0px;border-right-width: 0px;height: 0px;padding-right: 0px;padding-left: 0px;border-bottom-width: 0px;padding-bottom: 0px;padding-top: 0px;"></button>
                                </form>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
*/ ?> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
crossorigin="anonymous">
</script>
</body>




<!--TARJETA ALTERNATIVA
    <div class="card border-info mb-3" style="max-width: 18rem;" style="width: 18rem;">
        <img src="https://static.tokkobroker.com/pictures/34932906127141585208188762234073879326298067045523632263203776275920444811073.jpg" 
        class="card-img-top" alt="...">
        <div class="card-body">
            <div class="div-flex">
                <h5 class="card-title">Juan Carlos</h5>
                <p class="card-text" style="font-size: small"><strong>★ 4,9</strong></p>
            </div>
            <p class="card-text">Amante de los perros, ubicado en Playa grande, casa amplia con patio </p>
            <p class="card-text"><strong>$1500</strong> por noche</p>
        </div>
    </div>
-->


<!-- LISTA PARA MOSTRAR PARA ADMIN
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
                            <tbody> <?php foreach ($locationList as $location) { ?>
                                <tr>
                                    <th scope="row"><?php echo $location->getId() ?></th>
                                    <td><?php echo $location->getAdress() ?></td>
                                    <td><?php echo $location->getNeighborhood() ?></td>
                                    <td><?php echo $location->getCity() ?></td>
                                    <td><?php echo $location->getProvince() ?></td>
                                    <td><?php echo $location->getCountry() ?></td>
                                </tr><?php } ?>     
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Surname</th>
                                    <th scope="col">Sex</th>
                                    <th scope="col">Dni</th>
                                    <th scope="col">Adress</th>
                                    <th scope="col">Neighborhood</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Province</th>
                                    <th scope="col">Country</th>
                                </tr>
                            </thead>
                            <tbody> <?php foreach ($userList as $user) { ?>
                                <tr>
                                    <th scope="row"><?php echo $user->getId() ?></th>
                                    <td><?php echo $user->getUsername() ?></td>
                                    <td><?php echo $user->getEmail() ?></td>
                                    <td><?php echo $user->getPassword() ?></td>
                                    <?php if ($user->getData() != NULL) { ?>
                                    <td><?php echo $user->getData()->getName() ?></td>
                                    <td><?php echo $user->getData()->getSurname() ?></td>
                                    <td><?php echo $user->getData()->getSex() ?></td>
                                    <td><?php echo $user->getData()->getDni() ?></td>

                                    <td><?php echo $user->getData()->getLocation()->getAdress() ?></td>
                                    <td><?php echo $user->getData()->getLocation()->getNeighborhood() ?></td>
                                    <td><?php echo $user->getData()->getLocation()->getCity() ?></td>
                                    <td><?php echo $user->getData()->getLocation()->getProvince() ?></td>
                                    <td><?php echo $user->getData()->getLocation()->getCountry() ?></td>
                                    <?php } ?>
                                </tr><?php } ?>     
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
                            <tbody> <?php foreach ($sizeList as $size) { ?>
                                <tr>
                                    <th scope="row"><?php echo $size->getId() ?></th>
                                    <td><?php echo $size->getName() ?></td>
                                </tr><?php } ?>     
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
                            <tbody> <?php foreach ($typeList as $type) { ?>
                                <tr>
                                    <th scope="row"><?php echo $type->getId() ?></th>
                                    <td><?php echo $type->getName() ?></td>
                                </tr><?php } ?>     
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div> -->
