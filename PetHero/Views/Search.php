<body>
<div class="container px-4 py-5" id="custom-cards">
    <h2 class="pb-2 border-bottom">Publicaciones encontradas</h2>
	
    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-3 py-2">
      
<?php foreach($publicList as $public){?>
	  <div class="col">   
		<div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" 
					style=" background-image: url('https://cdn.bhdw.net/im/paisaje-arte-digital-papel-pintado-80890_w635.webp');
					background-size: cover;
					background-repeat: no-repeat;
					background-position: center center;
					width: 100%;">
			<div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
				<h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold"><?php echo $public->getTitle()?></h3>
				
				<ul class="d-flex list-unstyled mt-auto">
					<li class="d-flex align-items-center me-3">
						<i class="bi bi-calendar-date me-2" width="1em" height="1em"></i>
						<small><?php echo $public->getOpenDate()?></small>
					</li>
					<li class="d-flex align-items-center">
						<i class="bi bi-calendar-date me-2" width="1em" height="1em"></i>
						<small><?php echo $public->getCloseDate()?></small>
					</li>
				</ul>
				
				<ul class="d-flex list-unstyled mt-auto">
					<li class="me">
						<img src="https://pbs.twimg.com/media/E0e2SE4XsAgxVdm.jpg" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white me-3">
					</li>
					<li class="d-flex align-items-center me-3">
						<i class="bi bi-map me-1" width="1em" height="1em"></i>
						<small><?php echo $public->getUser()->getData()->getLocation()->getCity()?></small>
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
						<small><strong><?php echo $public->getRemuneration()?></strong></small>
						<form action="<?php echo FRONT_ROOT."/Publication/ViewPublication"?>" method="post">
      <input type="hidden" name="idPet" value=<?php echo $public->getId() ?>>
      <button type="submit" class="stretched-link" style="border-left-width: 0px;border-top-width: 0px;border-right-width: 0px;height: 0px;padding-right: 0px;padding-left: 0px;border-bottom-width: 0px;padding-bottom: 0px;padding-top: 0px;"></button></form>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>