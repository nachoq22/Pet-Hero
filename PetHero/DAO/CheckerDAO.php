<?php
namespace DAO;

require 'Lib/PHPMailer/Exception.php';
require 'Lib/PHPMailer/PHPMailer.php';
require 'Lib/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use Exceptions\RegisterCheckerException;

use \DAO\QueryType as QueryType;
use \DAO\Connection as Connection;

use \DAO\ICheckerDAO as ICheckerDAO;
use \DAO\BookingDAO as BookingDAO;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

use Model\Booking;
use Model\Checker;




    class CheckerDAO implements ICheckerDAO{
        private $connection;
        private $bookingDAO;

//? ======================================================================
//!                           DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this -> bookingDAO = new BookingDAO();
        }

//? ======================================================================
//!                             TOOL METHOD
//? ======================================================================
        private function GenRefCode(){
            $refCode = "";
            while(empty($refCode)){  
                $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
                $max = strlen($pattern) - 1;
                for($i = 0; $i < 20; $i++){
                    $refCode .= substr($pattern, mt_rand(0,$max), 1);
                    if(!empty($this->GetByRef($refCode))){
                        $refCode = "";
                    }
                }   
            }
            return $refCode;
        }

//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================
        public function Get($idChecker){
            $checker = null;

            $query = "CALL Checker_GetById(?)";
            $parameters["idChecker"] = $idChecker;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();
                if($row["payD"] != NULL){
                    $checker -> __fromDBP($row["idChecker"], $row["refCode"], $row["emisionD"]
                                  , $row["closeD"], $row["payD"] ,$row["finalPrice"]
                                  ,$this->bookingDAO->Get($row["idBook"]));
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bookingDAO->Get($row["idBook"]));
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
                                  ,$this->bookingDAO->Get($row["idBook"]));
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bookingDAO->Get($row["idBook"]));
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
                                  ,$this->bookingDAO->Get($row["idBook"]));
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bookingDAO->Get($row["idBook"]));
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
                                  ,$this->bookingDAO->Get($row["idBook"]));
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bookingDAO->Get($row["idBook"]));
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

//? ======================================================================
// !                          INSERT METHODS
//? ======================================================================
        private function Add(Checker $checker){
            $query = "CALL Checker_Add(?,?,?,?,?)";
            $parameters["refCode"] = $checker->getRefCode();
            $parameters["emisionD"] = $checker->getEmissionDate();
            $parameters["closeD"] = $checker->getCloseDate();
            $parameters["finalPrice"] = $checker->getFinalPrice();
            $parameters["idBook"] = $checker->getBooking()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××  
//¬         MÉTODO PARA CREAR UN CHECKER Y ACTUALIZAR UNA RESERVA
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Encargado de la creación del checker a partir de:
?    1) Obtención del 50% del monto total a pagar. 
?    2) Se genera un código de pago y establece la fecha actual 
?       y la fecha limite para el pago
?    3) Se establece la fecha actual y la fecha limite para el pago.
?    4) Se envía el mail correspondiente con el checker en formato PDF.
?    4) Se actualiza el estado de la reserva a la espera del pago.
* A: Checker parcialmente cargado.
* A2: INTEGER correspondiente a la respuesta del Keeper a la petición.
* R: String con el mensaje correspondiente al estado de la operación.

! REVISAR MÉTODO, DEMASIADO COMPLEJO Y ENGORROSO.
🐘*/      
        // public function NewChecker(Checker $checker,$rta){
        //     $message = "Successful: Se ha creado el checker y actualizado la reserva.";
       
        //         $bp = $this->bpDAO->GetByBook($checker->getBooking()->getId()); 
                
        //         try{
        //             if($rta == 1){
        //                 try{
        //                     //¬ SE OBTIENE EL 50% DEL MONTO TOTAL A PAGAR
        //                     $totally = $this->bpDAO->GetTotally($bp->getBooking());  
        //                 }catch(Exception $e){
        //                     $message = "Error: Ha ocurrido un error inesperado, intente mas tarde.";
        //                 return $message;
        //                 }

        //                 try{
        //                     //¬ SE SETEAN LAS FECHAS, SE GENERA UN CÓDIGO ÚNICO Y SE GUARDA EL CHECKER//
        //                     $openD = DATE("Y-m-d");
        //                     $closeD = DATE("Y-m-d",STRTOTIME($openD."+ 3 days"));
        //                     $refCode = $this->GenRefCode();
        //                     $checker->__fromRequest($refCode,$openD,$closeD,$totally,$bp->getBooking());  
        //                     $this->Add($checker);
        //                 }catch(Exception $e){
        //                     $message = "Error: No se ha podido generar el checker, intente mas tarde.";
        //                 return $message;
        //                 }

        //                 try{
        //                     //¬ SI EL OWNER USA ALGUNO DE ESTOS 2 MAILS, SE ENVÍA EL CHECKER POR MAIL
        //                     $message = $this->SendChecker($checker);
        //                     if(strcmp($checker->getBooking()->getUser()->getEmail(),"misaelflores4190@gmail.com")==0 
        //                     XOR strcmp($checker->getBooking()->getUser()->getEmail(),"ignaciorios_g@hotmail.com")==0){   
        //                         $this -> SendChecker($checker);
        //                     }
        //                 }catch(Exception $e){
        //                     $message = "Error: No se ha podido enviar el checker, intente mas tarde.";
        //                 return $message;
        //                 } 

        //                 //¬ SE ACTUALIZA EL ESTADO DE LA RESERVA
        //                 $this->bpDAO->NewState($bp->getBooking(),$rta);                     
        //             }else{
        //                 $this->bpDAO->NewState($bp->getBooking(),$rta);
        //                 $message = "Successful: la reserva se ha cancelado con exito";
        //             }
        //         }catch(Exception $e){
        //             $message = "Error: No se ha podido actualizar la reserva, intente mas tarde.";
        //         return $message;
        //         }  
        // return $message;   
        // }

        // public function NewChecker(Checker $checker,$rta){
        //     $bp = $this -> bpDAO -> GetByBook($checker -> getBooking() -> getId()); 
        //     $bpetList = $this -> bpDAO -> GetPetsByBook($bp -> getBooking() -> getId());
        //     $petsIDList = array();
        //     foreach($bpetList AS $bpet){
        //         array_push($petsIDList,$bpet -> getPet()->getId());
        //     }

        //     if($this -> bpDAO -> ValidateTypesOnBookings($bp -> getBooking(),$petsIDList) == 1){
        //         if($rta == 1){
        //             //¬ SE OBTIENE EL 50% DEL MONTO TOTAL A PAGAR
        //             //¬ REVISAR SI TRAIGO LISTA O UNO SOLO
        //             $totally = $this -> bpDAO -> GetTotally($bp -> getBooking());  
    
        //             //¬ SE SETEAN LAS FECHAS, SE GENERA UN CÓDIGO ÚNICO Y SE GUARDA EL CHECKER//
        //             $openD = DATE("Y-m-d");
        //             $closeD = DATE("Y-m-d",STRTOTIME($openD."+ 3 days"));
                    
        //             $refCode = $this->GenRefCode();
        //             $checker -> __fromRequest($refCode,$openD,$closeD,$totally, $bp -> getBooking()); 
                    
        //             try{
        //                 $this -> Add($checker);
        //             }catch(Exception $e){
        //                 throw new RegisterCheckerException("Error: No se ha podido generar el checker, intente mas tarde.");
        //             }
    
        //             try{
        //                 //¬ SI EL OWNER USA ALGUNO DE ESTOS 2 MAILS, SE ENVÍA EL CHECKER POR MAIL
        //                 $message = $this -> SendChecker($checker);
        //                 if(strcmp($checker -> getBooking() -> getUser() -> getEmail(), "misaelflores4190@gmail.com") == 0 
        //                    XOR 
        //                    strcmp($checker -> getBooking() -> getUser() -> getEmail(), "ignaciorios_g@hotmail.com") == 0){ 
    
        //                         $this -> SendChecker($checker);
    
        //                 }
        //             }catch(Exception $e){
        //                 throw new RegisterCheckerException("Error: No se ha podido enviar el checker, intente mas tarde.");
        //             } 
        //         }
        //     }else{
        //         $this->bpDAO->NewState($bp->getBooking(),0);
        //         throw new RegisterBookingException("Error: Sus mascotas son incompatibles con las que cuidara el keeper en ese momento");
        //     }

           
        //     //¬ SE ACTUALIZA EL ESTADO DE LA RESERVA
        //     $this->bpDAO->NewState($bp->getBooking(),$rta);
        // }


        public function NewChecker(Booking $booking, $totally){
            $refCode = $this -> GenRefCode();
            $openD = DATE("Y-m-d");
            $closeD = DATE("Y-m-d",STRTOTIME($openD."+ 3 days"));            

            $checker = new Checker();
            $checker -> __fromRequest($refCode, $openD, $closeD, $totally, $booking);

            $this -> Add($checker);

            try{
            //¬ SI EL OWNER USA ALGUNO DE ESTOS 2 MAILS, SE ENVÍA EL CHECKER POR MAIL
                $this -> SendChecker($checker);
                if(strcmp($checker -> getBooking() -> getUser() -> getEmail(), "misaelflores4190@gmail.com") == 0 
                   XOR 
                   strcmp($checker -> getBooking() -> getUser() -> getEmail(), "ignaciorios_g@hotmail.com") == 0){ 
                    
                    $this -> SendChecker($checker);
                    
                }
            }catch(Exception $e){
                throw new RegisterCheckerException("Error: No se ha podido enviar el checker, intente mas tarde.");
            }
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬             MÉTODOS PARA ACTUALIZAR UN CHECKER Y RESERVAR
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××× 
/*
* D: Encargado de la actualización de la fecha en que se pago el Checker.
!    Indispensable para la actualización completa de Checker y Reserva.
* A: Checker totalmente cargado.
* R: No posee.
🐘*/
        public function SetPayDChecker(Checker $checker){
            $query = "CALL Checker_SetPayD(?,?)";
            $parameters["idChecker"] = $checker->getEmissionDate(); //! ERROR?
            $parameters["payD"] = $checker->getPayDate();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

/*
* D: Encargado de la aplicación del método UpdatePayCode de BPDAO
*    y posterior evaluación de retorno para posteriormente aplicar
*    actualización de fecha de pago al checker.
!    Funcionalidad indispensable.
* A: Checker totalmente cargado.
* R: String con mensaje afirmativo o negativo según resultado de la operación.
🐘*/        
        // public function PayCheck(Checker $checker){
        //     $message = $this->bpDAO->UpdatePayCode($checker->getBooking());
        //     try{
        //         if(strpos($message,"Error") !== false){
        //             $dateN = DATE("Y-m-d");
        //             $checker->setPayD($dateN);
        //             $this->SetPayDChecker($checker);
        //         }
        //     }catch(Exception $e){
        //         $message = $message .", no se ha actualizado el checker.";
        //         return $message;
        //     }
        //     return $message;
        // }

//PASAR A BOOKING
        // public function PayCheck(Checker $checker){
        //     try{
        //         $this->bpDAO->UpdatePayCode($checker->getBooking());
                
        //         $dateN = DATE("Y-m-d");
        //         $checker->setPayD($dateN);
        //         $this->SetPayDChecker($checker);

        //     }catch(UpdateBookingException $ube){
        //         throw new UpdateCheckerException($ube -> getMessage() .", no se ha actualizado el checker.");
        //     }
        // }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                     MÉTODO PARA ENVIAR UN CHECKER
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××× 
/*
* D: Esta función tiene como objetivo principal enviar un correo electrónico 
*    con los detalles del "checker" a un destinatario específico. 
*    La información del checker se extrae de un objeto de la clase Checker y 
*    se formatea en un correo electrónico HTML personalizado.
*    El paso a paso es el siguiente:

?    1) Configuración del Servidor de Correo:
*    - Se establece el servidor de correo saliente en smtp.gmail.com.
*    - Se habilitan las credenciales de autenticación (correo electrónico y contraseña) 
*      para la cuenta de Gmail que se utilizará para enviar los correos.
*    - Se configura el puerto de conexión y se habilita la encriptaron TLS 
*      para garantizar la seguridad de la conexión.

?    2) Destinatario:
*    - Se obtiene la dirección de correo electrónico del destinatario a partir de la 
*      información contenida en el objeto $checker. Esta dirección probablemente esté asociada 
*      con el usuario que realizó la reserva.

?    3) Preparación del Contenido del Correo:
*    - Se crea una plantilla HTML con un diseño bien definido y atractivo.
*    - Se reemplazan los marcadores de posición en la plantilla con los datos específicos 
*      del checker, como el código de referencia, las fechas, los precios, los nombres de 
*      los involucrados, etc.
*    - Se configura el cuerpo del correo electrónico con la plantilla HTML y se establece un 
*      texto alternativo (para clientes de correo que no soportan HTML).

?    4) Envío del Correo:
*    - Se utiliza la librería PHPMailer para enviar el correo electrónico. Esta librería se 
*      encarga de gestionar la conexión al servidor SMTP, la autenticación y el envío del mensaje.

!    Funcionalidad indispensable.
~    Para mayores detalles, consultar documentación de la librería Ext 'PHPMailer'.
* A: Checker totalmente cargado.
* R: String con mensaje afirmativo o negativo según resultado de la operación.
🐘*/       

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

//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================
        public function Delete($idChecker){
            $query = "CALL Checker_Delete(?)";
            $parameters["idChecker"] = $idChecker;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>