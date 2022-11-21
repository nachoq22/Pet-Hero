<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mr+Dafoe&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Exo:wght@900&display=swap');

        .body {
            background-color: #000000;
        }

        .parent {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(3, 1fr);
            grid-column-gap: 0px;
            grid-row-gap: 0px;
        }

        .div1 {
            grid-area: 1 / 1 / 2 / 5;
        }

        .div2 {
            grid-area: 2 / 3 / 4 / 5;
        }

        .div3 {
            grid-area: 2 / 1 / 3 / 2;
        }

        .div4 {
            grid-area: 2 / 2 / 3 / 3;
        }

        .div5 {
            grid-area: 3 / 2 / 4 / 3;
        }

        .div6 {
            grid-area: 3 / 1 / 4 / 2;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .caja {
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 500px;
            height: 500px;
            background: #CCC;
            overflow: hidden;
        }

        .box img {
            width: 100%;
            height: auto;
        }

        @supports(object-fit: cover) {
            .box img {
                height: 100%;
                object-fit: cover;
                object-position: center center;
            }
        }

        h1 {
            font-size: 30px;
            text-align: center;
            color: #fff;
            animation: glow 1s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px #291b52, 0 0 20px #291b52, 0 0 25px #291b52, 0 0 30px #291b52, 0 0 35px #291b52;
            }

            to {
                text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #291b52, 0 0 40px #291b52, 0 0 50px #291b52, 0 0 60px #291b52, 0 0 70px #291b52;
            }
        }

        .neon {
            color: #fff;
            text-shadow:
                0 0 5px #fff,
                0 0 10px #fff,
                0 0 20px #fff,
                0 0 40px #1e0953,
                0 0 80px #1e0953,
                0 0 90px #1e0953,
                0 0 100px #1e0953,
                0 0 150px #1e0953;
        }

        table.tableStyle {
            font-family: "Lucida Console", Monaco, monospace;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }

        table.tableStyle td,
        table.tableStyle th {
            border: 1px solid #281E4C;
            padding: 3px 2px;
        }

        table.tableStyle tbody td {
            font-size: 12px;
        }

        table.tableStyle thead {
            background: #59238C;
            background: -moz-linear-gradient(top, #825aa9 0%, #693997 66%, #59238C 100%);
            background: -webkit-linear-gradient(top, #825aa9 0%, #693997 66%, #59238C 100%);
            background: linear-gradient(to bottom, #825aa9 0%, #693997 66%, #59238C 100%);
            border-bottom: 2px solid #444444;
        }

        table.tableStyle thead th {
            font-size: 15px;
            font-weight: bold;
            color: #FFFFFF;
            text-align: center;
            border-left: 2px solid #D0E4F5;
        }

        table.tableStyle thead th:first-child {
            border-left: none;
        }

        table.tableStyle tfoot td {
            font-size: 14px;
        }

        table.tableStyle tfoot .links {
            text-align: right;
        }

        table.tableStyle tfoot .links a {
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }

        h2 {
            font-family: 'Mr Dafoe';
            margin: 0;
            font-size: 5.5em;
            margin-top: -0.6em;
            color: white;
            text-shadow: 0 0 0.05em #fff, 0 0 0.2em #fe05e1, 0 0 0.3em #fe05e1;
            transform: rotate(-7deg);
        }

        p {
            font-size: 20px;
            text-align: center;
            height: 20px;
            line-height: 20px;
            font-family: 'Niconne', cursive;
            font-weight: 700;
            text-shadow: 5px 5px 0px #eb452b,
        }
    </style>

    <div class="parent">

        <div class="div1">
            <h2>PET HERO</h2>
            <h1>Checker</h1>
            <table class="tableStyle">
                <thead>
                    <tr>
                        <th>Reference Code</th>
                        <th>Emision Date</th>
                        <th>Close Date</th>
                        <th>Pay Date</th>
                        <th>Checker Price</th>
                        <th>Final Price</th>
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
        <div class="div2">
            <div class="caja">
                <div class="box">
                    <img src="https://www.ocu.org/-/media/ta/images/qr-code.png?rev=2e1cc496-40d9-4e21-a7fb-9e2c76d6a288&hash=AF7C881FCFD0CBDA00B860726B5E340B&mw=960"
                        alt="Cargando imagen...">
                </div>
            </div>
        </div>
        <div class="div3">
            <H1>Keeper</H1>
            <p>Name:
                <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getName(); ?>
            </p>
            <p>Surname:
                <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getSurname(); ?>
            </p>
            <p>Dni:
                <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getDni(); ?>
            </p>
        </div>
        <div class="div4">
            <H1>Owner</H1>
            <p>Username:
                <?php echo $checker->getBooking()->getUser()->getUsername(); ?>
            </p>
            <p>Name:
                <?php echo $checker->getBooking()->getUser()->getData()->getName(); ?>
            </p>
            <p>Surname:
                <?php echo $checker->getBooking()->getUser()->getData()->getSurname(); ?>
            </p>
            <p>Dni:
                <?php echo $checker->getBooking()->getUser()->getData()->getDni(); ?>
            </p>
        </div>
        <div class="div5">
            <H1>Publication</H1>
            <p>Open Date:
                <?php echo $checker->getBooking()->getPublication()->getOpenDate(); ?>
            </p>
            <p>Close Date:
                <?php echo $checker->getBooking()->getPublication()->getCloseDate(); ?>
            </p>
            <p>Remuneration:
                <?php echo $checker->getBooking()->getPublication()->getRemuneration(); ?>
            </p>
            <p>Location:
                <?php echo $checker->getBooking()->getPublication()->getUser()->getData()->getLocation()->getCity(); ?>
            </p>
        </div>
        <div class="div6">
            <H1>Booking</H1>
            <p>Start Date:
                <?php echo $checker->getBooking()->getStartD(); ?>
            </p>
            <p>Finish Date:
                <?php echo $checker->getBooking()->getFinishD(); ?>
            </p>
            <p>Bookstate:
                <?php echo $checker->getBooking()->getBookState(); ?>
            </p>
            <p>Paycode:
                <?php if (!empty($checker->getBooking()->getPayCode())) {
                    echo $checker->getBooking()->getPayCode();
                } ?>
            </p>
        </div>
    </div>
</body>


<?php
$html = ob_get_clean();
$plantilla = '
                <!DOCTYPE html>
                        <html>
                        <head>
                            <title>Pet-Hero</title>
                        </head>    
                    <body style="margin: 0; padding: 0;">
                <div class="parent" style="display: grid;
                                    grid-template-columns: repeat(4, 1fr);
                                    grid-template-rows: repeat(3, 1fr);
                                    grid-column-gap: 0px;
                                    grid-row-gap: 0px; margin: 0;
                                    padding: 0;">
                    <div class="div1" style="grid-area: 1 / 1 / 2 / 5; margin: 0;
                    padding: 0;">
                        <h2 style="
                        @import url("https://fonts.googleapis.com/css2?family=Mr+Dafoe&display=swap");
                        font-family: "Mr Dafoe";
                        margin: 0;
                        font-size: 5.5em;
                        margin-top: -0.6em;
                        color: white;
                        text-shadow: 0 0 0.05em #fff, 0 0 0.2em #fe05e1, 0 0 0.3em #fe05e1;
                        transform: rotate(-7deg);">PET HERO</h2>
                        <h1 style="font-size: 30px;
                        text-align: center;
                        text-shadow: 0 0 0.05em #fff, 0 0 0.2em #480b41, 0 0 0.3em #480b41;"
                        >Checker</h1>
                        <table class="tableStyle" style="font-family: "Lucida Console", Monaco, monospace;
                                width: 100%;
                                text-align: center;
                                border-collapse: collapse;">
                            <thead style="background: #59238C;
                            background: -moz-linear-gradient(top, #825aa9 0%, #693997 66%, #59238C 100%);
                            background: -webkit-linear-gradient(top, #825aa9 0%, #693997 66%, #59238C 100%);
                            background: linear-gradient(to bottom, #825aa9 0%, #693997 66%, #59238C 100%);
                            border-bottom: 2px solid #444444;">
                                <tr>
                                    <th style="border: 1px solid #281E4C;
                                    padding: 3px 2px; font-size: 15px;
                                    font-weight: bold;
                                    color: #FFFFFF;
                                    text-align: center;
                                    border-left: 2px solid #D0E4F5;">Reference Code</th>
                                    <th style="border: 1px solid #281E4C;
                                    padding: 3px 2px; font-size: 15px;
                                    font-weight: bold;
                                    color: #FFFFFF;
                                    text-align: center;
                                    border-left: 2px solid #D0E4F5; ">Emision Date</th>
                                    <th style="border: 1px solid #281E4C;
                                    padding: 3px 2px; font-size: 15px;
                                    font-weight: bold;
                                    color: #FFFFFF;
                                    text-align: center;
                                    border-left: 2px solid #D0E4F5;">Close Date</th>
                                    <th style="border: 1px solid #281E4C;
                                    padding: 3px 2px; font-size: 15px;
                                    font-weight: bold;
                                    color: #FFFFFF;
                                    text-align: center;
                                    border-left: 2px solid #D0E4F5;">Pay Date</th>
                                    <th style="border: 1px solid #281E4C;
                                    padding: 3px 2px; font-size: 15px;
                                    font-weight: bold;
                                    color: #FFFFFF;
                                    text-align: center;
                                    border-left: 2px solid #D0E4F5;">Checker Price</th>
                                    <th style="border: 1px solid #281E4C;
                                    padding: 3px 2px; font-size: 15px;
                                    font-weight: bold;
                                    color: #FFFFFF;
                                    text-align: center;
                                    border-left: 2px solid #D0E4F5;">Final Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: 12px;">
                                        '.$checker->getRefCode().'
                                    </td>
                                    <td style="font-size: 12px;">
                                        '.$checker->getEmissionDate().'
                                    </td>
                                    <td style="font-size: 12px;">
                                        '.$checker->getCloseDate().'
                                    </td> 
                                    <td style="font-size: 12px;">';
                                    if (!empty($checker->getPayDate())) {
                                    $plantilla .= $checker->getPayDate();
                                        }
                                    $plantilla .= '</td>
                                    <td style="font-size: 12px;">
                                        '. $checker->getFinalPrice().'
                                    </td>
                                    <td style="font-size: 12px;">
                                        '.$checker->getFinalPrice() * 2 .'
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="div2" style="grid-area: 2 / 3 / 4 / 5; margin: 0;
                    padding: 0;">
                        <div class="caja" style=" display: flex;
                        flex-flow: column wrap;
                        justify-content: center;
                        align-items: center;">
                            <div class="box" style=" width: 500px;
                            height: 500px;
                            background: #CCC;
                            overflow: hidden;">
                                <img style="width: 100%;
                                height: auto; height: 100%;
                                object-fit: cover;
                                object-position: center center;" src="https://www.ocu.org/-/media/ta/images/qr-code.png?rev=2e1cc496-40d9-4e21-a7fb-9e2c76d6a288&hash=AF7C881FCFD0CBDA00B860726B5E340B&mw=960" alt="Cargando imagen...">
                            </div>
                        </div>
                    </div>
                    <div class="div3" style="grid-area: 2 / 1 / 3 / 2; margin: 0;
                    padding: 0;">
                        <H1 style="font-size: 30px;
                        text-align: center;
                        text-shadow: 0 0 0.05em #fff, 0 0 0.2em #480b41, 0 0 0.3em #480b41;" >Keeper</H1>
                        <p style="
                        font-size: 20px;
                        text-align: center;
                        height: 20px;
                        font-family:"Niconne", cursive;
                        ">Name:
                            '. $checker->getBooking()->getPublication()->getUser()->getData()->getName().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Surname:
                            '.$checker->getBooking()->getPublication()->getUser()->getData()->getSurname().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Dni:
                            '. $checker->getBooking()->getPublication()->getUser()->getData()->getDni().'
                        </p>
                    </div>
                    <div class="div4" style="grid-area: 2 / 2 / 3 / 3; margin: 0;
                    padding: 0;">
                        <H1 style="font-size: 30px;
                        text-align: center;
                        text-shadow: 0 0 0.05em #fff, 0 0 0.2em #480b41, 0 0 0.3em #480b41;" >Owner</H1>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Username:
                            '. $checker->getBooking()->getUser()->getUsername().'
                        </p>
                        <p>Name:
                            '.$checker->getBooking()->getUser()->getData()->getName().'
                        </p>
                        <p sstyle="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Surname:
                        '. $checker->getBooking()->getUser()->getData()->getSurname().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Dni:
                        '. $checker->getBooking()->getUser()->getData()->getDni().'
                        </p>
                    </div>
                    <div class="div5" style="grid-area: 3 / 2 / 4 / 3; margin: 0;
                    padding: 0;">
                        <H1 style="font-size: 30px;
                        text-align: center;
                        text-shadow: 0 0 0.05em #fff, 0 0 0.2em #480b41, 0 0 0.3em #480b41;" >Publication</H1>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family:"Niconne", cursive;">Open Date:
                        '. $checker->getBooking()->getPublication()->getOpenDate().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Close Date:
                        '. $checker->getBooking()->getPublication()->getCloseDate().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Remuneration:
                        '. $checker->getBooking()->getPublication()->getRemuneration().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Location:
                        '. $checker->getBooking()->getPublication()->getUser()->getData()->getLocation()->getCity().'
                        </p>
                    </div>
                    <div class="div6" style="grid-area: 3 / 1 / 4 / 2; margin: 0;
                    padding: 0;">
                        <H1 style="font-size: 30px;
                        text-align: center;
                        text-shadow: 0 0 0.05em #fff, 0 0 0.2em #480b41, 0 0 0.3em #480b41;" >Booking</H1>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Start Date:
                        '. $checker->getBooking()->getStartD().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Finish Date:
                        '.$checker->getBooking()->getFinishD().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Bookstate:
                        '. $checker->getBooking()->getBookState().'
                        </p>
                        <p style="font-size: 20px;
                        text-align: center;
                        height: 20px;
                        line-height: 20px;
                        font-family: "Niconne", cursive;">Paycode:';
                            if (!empty($checker->getBooking()->getPayCode())) {

                                $plantilla.= $checker->getBooking()->getPayCode();
                            }
                        $plantilla.= '   
                        </p>
                    </div>
                </div>
                <body>
                </html>'; 
//echo $html;

require_once('Lib/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

$dompdf = new Dompdf();

$option = $dompdf->getOptions();
$option->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($option);

$dompdf->loadHtml($plantilla);
$dompdf->setPaper("letter");

$dompdf->render();
$dompdf->stream("Checker".$checker->getRefCode().".pdf", array("Attachment" => false));
?>