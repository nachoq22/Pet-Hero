<body>
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
                                <td><?php echo $checker->getRefCode()?></td>
                                <td><?php echo $checker->getEmissionDate()?></td>
                                <td><?php echo $checker->getCloseDate()?></td>
                                <td><?php if(!empty($checker->getPayDate())){echo $checker->getPayDate();}?></td>
                                <td><?php echo $checker->getFinalPrice()?></td>
                                <td><?php echo $checker->getFinalPrice() * 2?></td>
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
                                    <p class="featurette-heading fw-normal lh-1">Name: <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getName(); ?></p>
                                    <p class="featurette-heading fw-normal lh-1">Surname: <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getSurname(); ?> </p>
                                    <p class="featurette-heading fw-normal lh-1">Dni: <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getDni(); ?></p>
                                </div>
                            </div>
                            <div class="col">
                            <div class="p-3 border bg-dark">
                                <H1>Owner</H1>
                                <p class="featurette-heading fw-normal lh-1">Username: <?php echo $checker->getBooking()->getUser()->getUsername(); ?></p>
                                <p class="featurette-heading fw-normal lh-1">Name: <?php echo $checker->getBooking()->getUser()->getData()->getName(); ?></p>
                                <p class="featurette-heading fw-normal lh-1">Surname: <?php echo $checker->getBooking()->getUser()->getData()->getSurname(); ?> </p>
                                <p class="featurette-heading fw-normal lh-1">Dni: <?php echo $checker->getBooking()->getUser()->getData()->getDni(); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col gy-5">
                            <div class="p-3 border bg-dark">
                                <H1>Publication</H1>
                                <p class="featurette-heading fw-normal lh-1">Open Date: <?php echo $checker->getBooking()->getPublication()->getOpenDate(); ?> </p>
                                <p class="featurette-heading fw-normal lh-1">Close Date: <?php echo $checker->getBooking()->getPublication()->getCloseDate(); ?> </p>
                                <p class="featurette-heading fw-normal lh-1">Remuneration: <?php echo $checker->getBooking()->getPublication()->getRemuneration(); ?> </p>
                                <p class="featurette-heading fw-normal lh-1">Location: <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getLocation()->getCity(); ?> </p>
                                </div>
                            </div>
                            <div class="col gy-5">
                                <div class="p-3 border bg-dark">
                                <H1>Booking</H1>
                                <p class="featurette-heading fw-normal lh-1">Start Date: <?php echo $checker->getBooking()->getStartD(); ?></p>
                                <p class="featurette-heading fw-normal lh-1">Finish Date: <?php echo $checker->getBooking()->getFinishD(); ?> </p>
                                <p class="featurette-heading fw-normal lh-1">Bookstate: <?php echo $checker->getBooking()->getBookState(); ?></p>
                                <p class="featurette-heading fw-normal lh-1">Paycode: <?php if(!empty($checker->getBooking()->getPayCode())){echo $checker->getBooking()->getPayCode();} ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <img class="img-fluid" style="height: 450px; width: 450px;" 
                        src="https://www.ocu.org/-/media/ta/images/qr-code.png?rev=2e1cc496-40d9-4e21-a7fb-9e2c76d6a288&hash=AF7C881FCFD0CBDA00B860726B5E340B&mw=960" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<?php
$html = ob_get_clean();
//echo $html;

require_once ('Lib/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$option = $dompdf->getOptions();
$option->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($option);

$dompdf->loadHtml($html);
$dompdf->setPaper("letter");

$dompdf->render();
$dompdf->stream("myarchivito.pdf",array("Attachment" =>false));
?>