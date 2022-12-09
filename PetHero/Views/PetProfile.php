<body>
	<section style="background-color: #eee;">
		<div class="container py-5">
			<div class="row">
				<div class="col-lg-4">
					<div class="card mb-4">
							<img src="<?php echo $petaux->getProfileIMG(); ?>"
								alt="avatar" class="img-fluid" >
					</div>
				</div>
				<div class="col-lg-8">
					<div class="card mb-4">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Name</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $petaux->getName(); ?></p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Breed</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $petaux->getBreed(); ?></p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Observation</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $petaux->getObservation(); ?></p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Type</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $petaux->getType()->getName(); ?></p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-3">
									<p class="mb-0">Size</p>
								</div>
								<div class="col-sm-9">
									<p class="text-muted mb-0"><?php echo $petaux->getSize()->getName(); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg">
				<img src="<?php echo $petaux->getVaccinationPlanIMG(); ?>"
				alt="avatar" class="img-fluid" >
				</div>		
			</div>
		</div>
	</section>
</body>