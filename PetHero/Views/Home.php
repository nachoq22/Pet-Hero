<body>
    <!-- <?php if (!empty($message)) { ?>
        <?php if (strpos($message, "Error") !== false) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php } ?>
    <?php } ?> -->

    <?php if (isset($_COOKIE['message'])) { 
            if(strpos($_COOKIE['message'],"Error") !== false) { ?>
                <div class="alert alert-danger alert-dismissible fade show " role="alert">
    <?php    }else{ ?>
                <div class="alert alert-success alert-dismissible fade show " role="alert">    
                    <?php } echo $_COOKIE['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
                </div>
    <?php } setcookie('message', '', time() - 3600,'/'); ?>

    <div class="container-fluid" style="width:80%; padding-top: 20px;">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="https://www.hogarmania.com/archivos/201907/pasear-perro-XxXx80.jpg" class="d-block w-100" style="width: 100%; height: 30vw; object-fit: cover;" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="https://cdn.wamiz.fr/cdn-cgi/image/format=auto,quality=80,width=1200,height=900,fit=cover/article/main-picture/61fbe5bedab81812941910.png" class="d-block w-100" style="width: 100%; height: 30vw; object-fit: cover;" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="https://images.ctfassets.net/gxwgulxyxxy1/4gwMDV1dxGvZRwguxSUBfS/4868ea3358b99376cde22e23debba570/southeast-petfriendly-beach-holidays.jpg" class="d-block w-100" style="width: 100%; height: 30vw; object-fit: cover;" alt="...">
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
                    <div class="card text-bg-dark">
                        <?php foreach ($imgByPublic as $imgP) {
                            if ($imgP->getPublication()->getid() == $public->getid()) { ?>
                                <img src="<?php echo $imgP->getUrl(); ?>" class="card-img" alt="..." style="width: 100%; height: 28vw; object-fit: cover;">
                        <?php }
                        } ?>
                        <div class="card-img-overlay" style="background-color: rgba(211,211,211,0.37);">
                            <h5 class="card-title"><?php echo $public->getTitle() ?></h5>

                            <p class="card-text"><small><?php echo $public->getPopularity() . " ☆☆☆☆☆" ?>
                                    <br><?php echo $public->getUser()->getData()->getLocation()->getCity();
                                        echo ", " . $public->getUser()->getData()->getLocation()->getNeighborhood(); ?></small></p>


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
                            <form action="<?php echo FRONT_ROOT . "/Publication/ViewPublication" ?>" method="post">
                                <input type="hidden" name="idPublic" value=<?php echo $public->getId() ?>>
                                <button type="submit" class="stretched-link" style="border-left-width: 0px;border-top-width: 0px;border-right-width: 0px;height: 0px;padding-right: 0px;padding-left: 0px;border-bottom-width: 0px;padding-bottom: 0px;padding-top: 0px;"></button>
                            </form>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>
</body>