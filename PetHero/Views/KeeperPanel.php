<body>
    <?php if (!empty($message)) {
        if (strpos($message, "Error") !== false) { ?>
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
        <div class="row">

            <div class="col-sm-auto bg-light sticky-top">
                <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">
                    <a class="d-block p-3 link-dark text-decoration-none" title="" data-bs-toggle="tooltip"
                        data-bs-placement="right" data-bs-original-title="Icon-only">
                        <img class="img-fluid" style="height: 90px; width: fit-content;"
                            src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif"
                            alt="">
                    </a>
                    <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center align-items-center"
                        role="tablist" id="pills-tab" aria-orientation="vertical">
                        <li class="nav-item">
                            <a href="#" class="nav-link active py-3 px-2" type="button" role="tab" id="keeperData-tab"
                                data-bs-toggle="pill" data-bs-target="#keeperData" aria-controls="keeperData"
                                aria-selected="true" data-bs-placement="right">
                                <i class="bi bi-journal-text fs-1"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link py-3 px-2" type="button" role="tab" id="publicList-tab"
                                data-bs-toggle="pill" data-bs-target="#publicList" aria-controls="publicList"
                                aria-selected="false" data-bs-placement="right">
                                <i class="bi bi-file-earmark-richtext fs-1"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link py-3 px-2" type="button" role="tab" id="bookings-tab"
                                data-bs-toggle="pill" data-bs-target="#bookings" aria-controls="bookings"
                                aria-selected="false" data-bs-placement="right">
                                <i class="bi bi-card-list fs-1"></i>
                            </a>
                        </li>

                        <!--
                    <li>
                        <a href="#" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Products">
                            <i class="bi-heart fs-1"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Customers">
                            <i class="bi-people fs-1"></i>
                        </a>
                    </li>
-->
                    </ul>
                </div>
            </div>



            <div class="col-sm p-3 min-vh-100">
                <!-- content -->
                <!--KEEPER DATA CONTENT-->
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="keeperData" role="tabpanel"
                        aria-labelledby="keeperData-tab" tabindex="0">
                        <div class="row">

                        
                        <div class="col-4 mt-3"></div>
                        <div class="col-4 mt-3">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $keeper->getUsername()?></h4>
                                    <p class="card-text">Keeper</p>
                                    <h5 class="card-title"><?php echo $keeper->getData()->getName()?> <?php echo $keeper->getData()->getSurname()?></h5>
                                    <h6 class="card-title">DNI: <?php echo $keeper->getData()->getDNI()?></h6>
                                    <p class="card-text"><small class="text-muted"></small><?php echo $keeper->getData()->getLocation()->getCountry()?>, <?php echo $keeper->getData()->getLocation()->getProvince()?>
                                    <br><?php echo $keeper->getData()->getLocation()->getCity()?>, <?php echo $keeper->getData()->getLocation()->getNeighborhood()?>, <?php echo $keeper->getData()->getLocation()->getAdress()?></p>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-4 mt-3"></div>
                        </div>
                    </div>

                    <!--PUBLICLIST CONTENT-->
                    <div class="tab-pane" id="publicList" role="tabpanel" aria-labelledby="publicList-tab" tabindex="0">
                        <div class="container-fluid content-row">
                            <div class="row">
                                <div class="col-2 mt-3">
                                    <div class="card h-100" style="height: 170px;">
                                        <a href="<?php echo FRONT_ROOT . "/Home/ViewAddPublication" ?>">
                                            <div class="card-body justify-content-center"
                                                style="display:flex; justify-content: center;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="220"
                                                    fill="currentColor" class="bi bi-plus-square; opacity-50"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                    <path
                                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php foreach ($publicList as $public) { ?>
                                <div class="col-2 mt-3">
                                    <div class="card text-bg-dark h-100">
                                        <?php foreach ($imgByPublic as $imgP) { ?>
                                        <?php if ($imgP->getPublication()->getid() == $public->getid()) { ?>
                                        <img src="<?php echo '../' . $imgP->getUrl(); ?>" class="card-img-top"
                                            style="width: 100%; height: 260px; object-fit: cover; border-radius: 7px;"
                                            alt="...">
                                        <?php } ?>
                                        <?php } ?>
                                        <div class="card-img-overlay" style="background-color: rgba(211,211,211,0.37);">
                                            <h5 class="card-title">
                                                <?php echo $public->getTitle() ?>
                                            </h5>

                                            <p class="card-text"><small>
                                                    <?php echo $public->getPopularity() . " ☆☆☆☆☆" ?>
                                                    <br>
                                                    <?php echo $public->getUser()->getData()->getLocation()->getCity();
                                    echo ", " . $public->getUser()->getData()->getLocation()->getNeighborhood(); ?>
                                                </small></p> <p class="card-footer"><i class="bi bi-currency-dollar me-1"
                                                width="1em" height="1em"></i>
                                            <small>
                                                <strong>
                                                    <?php echo $public->getRemuneration() ?>
                                                </strong>
                                            </small>
                                            </p>
                                            </strong>
                                            <form action="<?php echo FRONT_ROOT . "/Publication/ViewPublication" ?>"
                                                method="post">
                                                <input type="hidden" name="idPublic" value=<?php echo $public->getId()
                                                    ?>>
                                                <button type="submit" class="stretched-link"
                                                    style="border-left-width: 0px;border-top-width: 0px;border-right-width: 0px;height: 0px;padding-right: 0px;padding-left: 0px;border-bottom-width: 0px;padding-bottom: 0px;padding-top: 0px;"></button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div> <!-- /.card-content -->
                        </div> <!-- /.card-content -->
                    </div>

                    <!--BOOKING CONTENT-->
                    <div class="tab-pane" id="bookings" role="tabpanel" aria-labelledby="bookings-tab" tabindex="0">
                        <table class="table align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th>Publication Info</th>
                                    <th>Status</th>
                                    <th>Pets</th>
                                    <th>Checker</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookList as $book) { ?>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-2">
                                                <?php foreach ($imgList as $img) { ?>
                                                <?php if ($img->getPublication()->getId() == $book->getPublication()->getId()) { ?>
                                                <img src="<?php echo "../" . $img->getUrl() ?>" class="rounded-circle"
                                                    alt="" style="width: 45px; height: 45px" />
                                                <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="ms-3">
                                                            <p class="fw-bold mb-1">Start Date</p>
                                                            <p class="text-muted mb-0">
                                                                <?php echo $book->getStartD() ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="ms-3">
                                                            <p class="fw-bold mb-1">Finish Date</p>
                                                            <p class="text-muted mb-0">
                                                                <?php echo $book->getFinishD() ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "In Review"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Awaiting Payment"
                                            ) == 0)
                                    ) { ?>
                                        <span class="badge rounded-pill text-bg-warning">
                                            <?php echo $book->getBookState() ?>
                                        </span>
                                        <?php } ?>

                                        <?php if (
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Canceled"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Expired"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Declined"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Out of Term"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Finalized"
                                            ) == 0)
                                    ) { ?>
                                        <span class="badge rounded-pill text-bg-danger">
                                            <?php echo $book->getBookState() ?>
                                        </span>
                                        <?php } ?>

                                        <?php if (
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Waiting Start"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "In Progress"
                                            ) == 0)
                                    ) { ?>
                                        <span class="badge rounded-pill text-bg-success">
                                            <?php echo $book->getBookState() ?>
                                        </span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <div class="row">
                                            <?php foreach ($bPetsList as $pet) { ?>
                                            <?php if ($pet->getBooking()->getId() == $book->getId()) { ?>
                                            <div class="col-2">
                                                <div class="container-fluid d-flex">

                                                    <form action="<?php echo FRONT_ROOT . "/Pet/ViewPetProfile" ?>"
                                                        method="post">
                                                        <input type="hidden" name="idPet" value=<?php echo
                                                $pet->getPet()->getId() ?>>
                                                        <button type="submit"
                                                            style="border-left-width: 0px;border-top-width: 0px;border-right-width: 0px;height: 0px;padding-right: 0px;padding-left: 0px;border-bottom-width: 0px;padding-bottom: 0px;padding-top: 0px;"><img
                                                                src="<?php echo $pet->getPet()->getProfileIMG() ?>"
                                                                class="rounded-circle" alt=""
                                                                style="width: 45px; height: 45px;" /></button>
                                                    </form>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </div>
                                    </td>

                                    <td>
                                        <?php if (
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Awaiting Payment"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Canceled"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Expired"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Out of Term"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Finalized"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Waiting Start"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "In Progress"
                                            ) == 0)
                                    ) { ?>
                                        <div class="container-fluid d-flex">
                                            <form action="<?php echo FRONT_ROOT . "/Checker/ViewChecker" ?>"
                                                method="post">
                                                <input type="hidden" class="visually-hidden" name="idBook" value=<?php
                                        echo $book->getId() ?>>
                                                <button class="btn btn-outline-warning" type="submit"><i
                                                        class="bi bi-pencil-square"></i></button>
                                            </form>
                                        </div>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if ((STRCMP($book->getBookState(), "In Review") == 0)) { ?>
                                        <div class="container-fluid d-flex">
                                            <form action="<?php echo FRONT_ROOT . "/Checker/ToResponse" ?>"
                                                method="post">
                                                <input type="hidden" class="visually-hidden" name="idBook" value=<?php
                                        echo $book->getId() ?>>
                                                <input type="hidden" class="visually-hidden" name="rta" value="1">
                                                <button class="btn btn-outline-success" type="submit"><i
                                                        class="bi bi-check-square"></i></button>
                                            </form>
                                            <form action="<?php echo FRONT_ROOT . "/Checker/ToResponse" ?>"
                                                method="post">
                                                <input type="hidden" class="visually-hidden" name="idBook" value=<?php
                                        echo $book->getId() ?>>
                                                <input type="hidden" class="visually-hidden" name="rta" value="0">
                                                <button class="btn btn-outline-danger" type="submit"><i
                                                        class="bi bi-x-square"></i></button>
                                            </form>
                                        </div>
                                        <?php }
                                    if (STRCMP($book->getBookState(), "Waiting Start") == 0) { ?>
                                        <form action="<?php echo FRONT_ROOT . "/Booking/CancelBook" ?>" method="post"
                                            onsubmit="return Confirm()">
                                            <input type="hidden" name="idBook" value=<?php echo $book->getId() ?>>
                                            <button class="btn btn-outline-danger me-2" type="submit">Cancel
                                                Booking</button>
                                        </form>
                                        <!--MODAL CON INFO DEL BOOKING?-->
                                        <?php }
                                    if (
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Canceled"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Expired"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Declined"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Out of Term"
                                            ) == 0) xor
                                        (
                                            STRCMP(
                                                $book->getBookState(),
                                                "Finalized"
                                            ) == 0)
                                    ) { ?>
                                        
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script>
        function Confirm() {
            return confirm("Do you want to cancel the booking?");
        }
    </script>
</body>
<!--
<div class="modal fade" id="checkerModal" tabindex="-1" aria-labelledby="checkerModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Checker Information</h1>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-octagon-fill"></i>
        </button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="row">
                    <h1 class="text-center">Checker</h1>
                    <table class="table table-borderless ">
                        <thead>
                            <tr>
                                <th scope="col">Reference Code</th>
                                <th scope="col">Emision Date</th>
                                <th scope="col">Close Date</th>
                                <th scope="col">Pay Date</th>
                                <th scope="col">Checker Price</th>
                                <th scope="col">Final Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $checker->getRefCode() ?>
                                </td>
                                <td>
                                    <?php echo $checker->getEmissionDate() ?>
                                </td>
                                <td>
                                    <?php echo $checker->getCloseDate() ?>
                                </td>
                                <td>
                                    <?php if (!empty($checker->getPayDate())) {
                                        echo $checker->getPayDate();
                                    } ?>
                                </td>
                                <td>
                                    <?php echo $checker->getFinalPrice() ?>
                                </td>
                                <td>
                                    <?php echo $checker->getFinalPrice() * 2 ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <hr class="featurette-divider">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div class="p-3 border bg-dark">
                                    <H1>Keeper</H1>
                                    <p class="featurette-heading fw-normal lh-1">Name:
                                        <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getName(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Surname:
                                        <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getSurname(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Dni:
                                        <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getDni(); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3 border bg-dark">
                                    <H1>Owner</H1>
                                    <p class="featurette-heading fw-normal lh-1">Username:
                                        <?php echo $checker->getBooking()->getUser()->getUsername(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Name:
                                        <?php echo $checker->getBooking()->getUser()->getData()->getName(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Surname:
                                        <?php echo $checker->getBooking()->getUser()->getData()->getSurname(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Dni:
                                        <?php echo $checker->getBooking()->getUser()->getData()->getDni(); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col gy-5">
                                <div class="p-3 border bg-dark">
                                    <H1>Publication</H1>
                                    <p class="featurette-heading fw-normal lh-1">Open Date:
                                        <?php echo $checker->getBooking()->getPublication()->getOpenDate(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Close Date:
                                        <?php echo $checker->getBooking()->getPublication()->getCloseDate(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Remuneration:
                                        <?php echo $checker->getBooking()->getPublication()->getRemuneration(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Location:
                                        <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getLocation()->getCity(); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col gy-5">
                                <div class="p-3 border bg-dark">
                                    <H1>Booking</H1>
                                    <p class="featurette-heading fw-normal lh-1">Start Date:
                                        <?php echo $checker->getBooking()->getStartD(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Finish Date:
                                        <?php echo $checker->getBooking()->getFinishD(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Bookstate:
                                        <?php echo $checker->getBooking()->getBookState(); ?>
                                    </p>
                                    <p class="featurette-heading fw-normal lh-1">Paycode:
                                        <?php if (!empty($checker->getBooking()->getPayCode())) {
                                            echo $checker->getBooking()->getPayCode();
                                        } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <img class="img-fluid" style="height: 450px; width: 450px;"
                            src="https://www.ocu.org/-/media/ta/images/qr-code.png?rev=2e1cc496-40d9-4e21-a7fb-9e2c76d6a288&hash=AF7C881FCFD0CBDA00B860726B5E340B&mw=960"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sucess">Download Checker PDF</button>
      </div>
    </div>
  </div>
</div>
                                    -->