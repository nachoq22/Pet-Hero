<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\ICheckerDAO as ICheckerDAO;
use \DAO\BookingPetDAO as BookingPetDAO;
use \Model\Checker as Checker;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Lib/PHPMailer/Exception.php';
require 'Lib/PHPMailer/PHPMailer.php';
require 'Lib/PHPMailer/SMTP.php';

    class CheckerDAO implements ICheckerDAO{
        private $connection;
        private $tableName = 'Checker';
        private $bpDAO;

//======================================================================
// DAOs INJECTION
//======================================================================
        public function __construct(){
            $this->bpDAO = new BookingPetDAO();
        }

//======================================================================
// TOOLS METHODS
//======================================================================
        private function GenRefCode(){
            $refCode = "";
            while(empty($refCode)){  
                $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
                $max = strlen($pattern)-1;
                for($i = 0; $i < 20; $i++){
                    $refCode .= substr($pattern, mt_rand(0,$max), 1);
                    if(!empty($this->GetByRef($refCode))){
                        $refCode = "";
                    }
                }   
            }
            return $refCode;
        }

//======================================================================
// SELECT METHODS
//======================================================================
        public function Get($idChecker){
            $checker = null;

            $query = "CALL Checker_GetById(?)";
            $parameters["idChecker"] = $idChecker;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();
                if($row["payD"] != NULL){
                    $checker->__fromDBP($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["payD"] ,$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
            }
        return $checker;
        }

        public function GetByBook($idBook){
            $checker = null;

            $query = "CALL Checker_GetByBooking(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();
                if($row["payD"] != NULL){
                    $checker->__fromDBP($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["payD"] ,$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
            }
        return $checker;
        }

        public function GetByRef($refCode){
            $checker = null;

            $query = "CALL Checker_GetByRef(?)";
            $parameters["refCode"] = $refCode;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();
                if($row["payD"] != NULL){
                    $checker->__fromDBP($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["payD"] ,$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
            }
        return $checker;
        }



        public function GetAll(){
            $checkerList = array();    

            $query = "CALL Checker_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();
                if($row["payD"] != NULL){
                    $checker->__fromDBP($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["payD"] ,$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
            array_push($checkerList,$checker);
            }
        return $checkerList;    
        }

        public function GetAllByBooks($bookList){
            $checkerList = array();
            foreach($bookList as $book){
                $checker = new Checker();
                $checkerAux = $this->GetByBook($book->getId());
                if(!empty($checkerAux)){
                    $checker = $checkerAux;
                    array_push($checkerList,$checker);
                }
            }
        return $checkerList;    
        }

//======================================================================
// INSERT METHODS
//======================================================================
        private function Add(Checker $checker){
            $query = "CALL Checker_Add(?,?,?,?,?)";
            $parameters["refCode"] = $checker->getRefCode();
            $parameters["emisionD"] = $checker->getEmissionDate();
            $parameters["closeD"] = $checker->getcloseDate();
            $parameters["finalPrice"] = $checker->getFinalPrice();
            $parameters["idBook"] = $checker->getBooking()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
//-----------------------------------------------------
// METHOD TO CREATE A CHECKER AND UPDATE A BOOKING
//-----------------------------------------------------      
        public function NewChecker(Checker $checker,$rta){
            $message = "Successful: Se ha creado el checker y actualizado la reserva.";
       
                $bp = $this->bpDAO->GetByBook($checker->getBooking()->getId()); 
                
                try{
                    if($rta == 1){
                        try{

                        $totally = $this->bpDAO->GetTotally($bp->getBooking());             //SE OBTIENE EL 50% DEL MONTO TOTAL A PAGAR//
                        }catch(Exception $e){
                                $message = "Error: Ha ocurrido un error inesperado, intente mas tarde.";
                            return $message;
                        }
                        try{
                            $openD = DATE("Y-m-d");
                            $closeD = DATE("Y-m-d",STRTOTIME($openD."+ 3 days"));
                            $refCode = $this->GenRefCode();
                            $checker->__fromRequest($refCode,$openD,$closeD,$totally,$bp->getBooking());     //SE SETEAN LAS FECHAS, SE GENERA UN CODIGO UNICO Y SE GUARDA EL CHECKER//
                            $this->Add($checker);
                        }catch(Exception $e){
                                $message = "Error: No se ha podido generar el checker, intente mas tarde.";
                            return $message;
                        }
                        try{
                            if(strcmp($checker->getBooking()->getUser()->getEmail(),"misaelflores4190@gmail.com")==0 
                            XOR strcmp($checker->getBooking()->getUser()->getEmail(),"ignaciorios_g@hotmail.com")==0){   //SI EL OWNER USA ALGUNO DE ESTOS 2 MAILS, SE ENVIA EL CHECKER POR MAIL//
                               $message = $this->SendChecker($checker);
                            }
                        }catch(Exception $e){
                            $message = "Error: No se ha podido enviar el checker, intente mas tarde.";
                            return $message;
                        }      
                        $this->bpDAO->NewState($bp->getBooking(),$rta);                     //SE ACTUALIZA EL ESTADO DE LA RESERVA//
                    }else{
                        $this->bpDAO->NewState($bp->getBooking(),$rta);
                        $message = "Successful: la reserva se ha cancelado con exito";
                    }
                }catch(Exception $e){
                    $message = "Error: No se ha podido actualizar la reserva, intente mas tarde.";
                return $message;
                }  
        return $message;   
        }

//-----------------------------------------------------
// METHOD TO UPDATE A CHECKER AND BOOKING
//-----------------------------------------------------  
        private function SetPayDChecker(Checker $checker){
            $query = "CALL Checker_SetPayD(?,?)";
            $parameters["idChecker"] = $checker->getEmissionDate();
            $parameters["payD"] = $checker->getPayDate();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function PayCheck(Checker $checker){
            $message = $this->bpDAO->UpdatePayCode($checker->getBooking());
            try{
                if(strpos($message,"Error") !== false){
                    $dateN = DATE("Y-m-d");
                    $checker->setPayD($dateN);
                    $this->SetPayDChecker($checker);
                }
            }catch(Exception $e){
                $message = $message .", no se ha actualizado el checker.";
                return $message;
            }
            return $message;
        }
//-----------------------------------------------------
//-----------------------------------------------------  

        private function SendChecker(Checker $checker){
            $mail = new PHPMailer(true);
            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;    
                $email = 'petHero25112022@gmail.com';                        //Enable SMTP authentication
                $mail->Username   = $email;                     //SMTP username
                $mail->Password   = 'cwomuwndpbenfvlw';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                //Recipients
                $mail->setFrom($email, 'Pet Hero');
                $mail->addAddress($checker->getBooking()->getUser()->getEmail());     //Add a recipient
                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                //$mail->isHTML(true);  
                
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
                $mail->CharSet = 'UTF-8';                                //Set email format to HTML
                $mail->Subject = 'Checker Disponible Pet Hero';
                $mail->isHTML(true);
                $mail->Body    = $plantilla;
                $mail->AltBody = 'Checker correspondiente a su reserva';
                $mail->send();
                $message = "Successful: El checker ha sido enviado a la casilla de correo correspondiente";
            } catch (Exception $e) {
                $message = "Error: No se ha podido enviar el checker";
                return $message;
             }
             return $message;
        }

//======================================================================
// DELETE METHODS
//====================================================================== 
        public function Delete($idChecker){
            $query = "CALL Checker_Delete(?)";
            $parameters["idChecker"] = $idChecker;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>