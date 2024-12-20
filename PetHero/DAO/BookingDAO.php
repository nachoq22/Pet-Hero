<?php
namespace DAO;

use PHPMailer\PHPMailer\Exception;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IBookingDAO as IBookingDAO;
use \DAO\PublicationDAO as PublicationDAO;
use \DAO\UserDAO as UserDAO;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

use \Model\Booking as Booking;
use \Checker\Booking as Checker;

    class BookingDAO implements IBookingDAO{
        private $connection;
        private $tableName = 'Booking';

        private $publicDAO;
        private $userDAO;
        
//? ======================================================================
//!                         DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this->publicDAO = new PublicationDAO();
            $this->userDAO = new UserDAO();
        }

//? ======================================================================
//!                         GET METHODS
//? ======================================================================
        public function GetAll(){
            $bookList = array();    

            $query = "CALL Booking_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();
                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                           ,$row["finishD"],$row["bookState"]
                                           ,$this->publicDAO->Get($row["idPublic"])
                                           ,$this->userDAO->DGet($row["idUser"]));
                array_push($bookList,$booking);
            }
        return $bookList;
        }


        public function GetAllByPublication($idPublic){
            $bookList = array();    

            $query = "CALL Booking_GetAllByPublication(?);";
            $parameters["idPublic"] = $idPublic;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();
                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                           ,$row["finishD"],$row["bookState"]
                                           ,$this->publicDAO->Get($row["idPublic"])
                                           ,$this->userDAO->DGet($row["idUser"]));
                array_push($bookList,$booking);
            }
        return $bookList;
        }        


//* TODAS LAS BOOKINGS DE UN USUARIO.
        public function GetAllByUser($idUser){
            $bookList = array();

            $query = "CALL Booking_GetByUser(?);";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                           ,$row["finishD"],$row["bookState"]
                                           ,$this->publicDAO->Get($row["idPublic"])
                                           ,$this->userDAO->DGet($row["idUser"]));
                array_push($bookList,$booking);
            }
        return $bookList;
        }

/*
*  D: Recupero todos los Bookings según el username de un User(OWNER).
!     Requerido por GetAllBooksByUsername de BookingPetDAO.
*  A: Username del Owner.
*  R: El listado de Bookings del username proporcionado.
🐘*/ 
        public function GetAllByUsername($username){
            $user = $this->userDAO->DGetByUsername($username);
            $bookList = $this->GetAllByUser($user->getId());
        return $bookList;
        }

//* TODAS LAS BOOKINGS DE UN KEEPER SEGUN USERNAME.
/*
* D: Recupero todos los Bookings donde el dueño de la PUBLICATION
*    (KEEPER) coincida con el USERNAME suministrado.
!    Requerido por GetAllBooksByKeeper de BookingPetDAO.
* A: Username del Keeper.
* R: El listado de Bookings del username proporcionado.
🐘*/ 
        public function GetAllByKeeper($username){
            $matches = array();
                $bookings = $this->GetAll();
            foreach($bookings as $book){
                if($book->getPublication()->getUser()->getUsername() == $username){
                    array_push($matches,$book);
                }
            }
        return $matches;
        }

/*
* D: Recupera un Booking segun ID.
!     Requerido por el metodo GetPetsByBook de BookingPetDAO.
* A: ID del Booking a filtrar.
* R: Booking filtrado.
🐘*/          
        public function Get($idBook){
            $booking = null;

            $query = "CALL Booking_GetById(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                ,$row["finishD"],$row["bookState"]
                                ,$this->publicDAO->Get($row["idPublic"])
                                ,$this->userDAO->DGet($row["idUser"]));
                }
            return $booking;
        }

//* UNA BOOKING SEGUN USUARIO.
        public function GetByUser($idUser){
            $booking = NULL;

            $query = "CALL Booking_GetByUser(?);";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                ,$row["finishD"],$row["bookState"]
                                ,$this->publicDAO->Get($row["idPublic"])
                                ,$this->userDAO->DGet($row["idUser"]));
            }
            return $booking;
        }

/*
* D: Método interno que obtiene el costo a abonar a partir de la
*     la remuneración establecida por Publication y la diferencia
*     de Dias entre finishD y startD. Por lo tanto, resumiendo:

?          CostoTotal = duracionDiasDeReserva * remuneracion

* A: Una reserva que provee las fechas de inicio y final, como
*     la Publicacion con la remuneracion.
* R: Valor a abonar, el cual se suministrara al Checker.
🐘*/
        public function GetBookDayDiff(Booking $book){
            $bookingDayDiff = 0;

            $query = "CALL Booking_GetBookigDayDiff(?,?)";
            $parameters["starD"] = $book->getStartD();
            $parameters["finishD"] = $book->getFinishD();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bookingDayDiff = $row["bookingDayDiff"];
            }
        return $bookingDayDiff;
        }
        
//? ======================================================================
//!                           INSERT METHODS
//? ======================================================================
        private function Add(Booking $booking){
            $idLastP = 0;

            $query = "CALL Booking_Add(?,?,?,?,?)";
            $parameters["startD"] = $booking->getStartD();
            $parameters["finishD"] = $booking->getFinishD();
            $parameters["bookState"] = $booking->getBookState();
            $parameters["idPublic"] = $booking->getPublication()->getid();
            $parameters["idUser"] = $booking->getUser()->getId();  
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $idLastP = $row["LastID"];
            }
        return $idLastP; 
        }


/*
* D: Método que trabaja conjunto a 'Add' para registrar un Booking.
*    Realizando:
*       💠 Recuperación de la Publication vinculada.
*       💠 Recuperación del User que solicita la Booking.
* A: Una reserva que provee el ID de la Publication y el USERNAME
*        del user correspondiente.
* R: Se retorna el Booking registrado con datos completos.
🐘*/
        public function AddRet(Booking $booking){
                $public = $this->publicDAO->Get($booking->getPublication()->getId());
                $user = $this->userDAO->DGetByUsername($booking->getUser()->getUsername());
                $booking->setPublication($public);
                $booking->setUser($user);
            $idNBook = $this->Add($booking);
            $booking = $this->Get($idNBook);
        return $booking;    
        }      

//? ======================================================================
//!                          UPDATE METHODS
//? ======================================================================
//* ACTUALIZA ESTADO DE BOOKING.
        public function UpdateST(Booking $booking){
            $query = "CALL Booking_UpdateST(?,?)";
            $parameters["idBook"] = $booking->getId();
            $parameters["bookState"] = $booking->getBookState();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//* ACTUALIZA PAYCODE DE BOOKING.
        public function UpdateCode(Booking $booking){
            $query = "CALL Booking_UpdateCode(?,?)";
            $parameters["idBook"] = $booking->getId();
            $parameters["payCode"] = $booking->getPayCode();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

/*
* D: Método que conjunto a 'UpdateST' actualiza el estado del Booking 
*     según las condiciones:
?      💠 Live
¬          ► In process 
?      💠 Before
¬          ► In Review (luego de crear la reserva)
¬          ► Awaiting Payment (luego de aceptar la reserva)
¬          ► Confirmed
?      💠 Death
¬          ► Canceled (Cancelado mediante botón después de pago y antes 
¬            de que arranque la reserva)
¬          ► Declined
¬          ► Rechazed
¬          ► Expired (No hay respuesta de keeper luego de 3 dias de 
¬            creado la reserva)
¬          ► Out of Term (se vence el checker)
¬          ► Finalized
* A: Una Booking a la cual se le actualiza y asienta el cambio de ESTADO.
* R: No Posee.
🐘*/
        public function UpdateStSwtich(Booking $book,$stateNum){
            switch($stateNum){
                case 0:
                    $book->setBookState("Declined");
                    $this->UpdateST($book);
                    break;
                case 1:
                    $book->setBookState("Awaiting Payment");
                    $this->UpdateST($book);
                    break;
                case 2:
                    $book->setBookState("Waiting Start");
                    $this->UpdateST($book);
                    break;
                case 3:
                    $book->setBookState("Canceled");
                    $this->UpdateST($book);
                    break;
                case 4:
                    $book->setBookState("In Progress");
                    $this->UpdateST($book);
                    break;
                case 5:
                    $book->setBookState("Expired");
                    $this->UpdateST($book);
                    break;
                case 6:
                        $book->setBookState("Out of Term");
                    $this->UpdateST($book);
                    break;
                case 7:
                    $book->setBookState("Finalized");
                    $this->UpdateST($book);
                    break;
            }
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬    MÉTODOS QUE SE IMPLEMENTARÁN EN CADA PANEL DE PROPIETARIO Y TENEDOR PARA LA 
//¬    ACTUALIZACIÓN DE ESTADOS AUTOMÁTICOS SEGÚN SITUACIONES PARTICULARES.
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××

/*
* D: Método de actualización continua, donde recupera todas las reservas existentes
*       para realizar cambios sobre sus correspondientes estados según: 
?      💠 UpdateToExpired
¬          ► CHEQUEA SI UN KEEPER NO RESPONDIÓ A UNA RESERVA EN UN MÁXIMO 
¬            DE 3 DIAS ANTES DE COMENZAR EL BOOKING, PROCEDE A CAMBIAR 
¬            ESTADO A EXPIRED,MURIENDO LÓGICAMENTE EL BOOKING.
?      💠 UpdateToInP
¬          ► CHEQUEA SI UN BOOKING COINCIDE SU FECHA DE INICIO CON LA 
¬            ACTUAL,PROCEDE A CAMBIAR ESTADO A IN PROGRESS.
?      💠 UpdateToFinalized
¬          ► CHEQUEA SI UN BOOKING COINCIDE SU FECHA DE FIN CON LA ACTUAL,
¬            PROCEDE A CAMBIAR ESTADO A FINALIZED, MURIENDO EL BOOKING. 
* A: No posee.
* R: No Posee.
🐘 */
        public function UpdateAllStates(){
            $bookisList = $this->GetAll();
            if(!EMPTY($bookisList)){
                $this->UpdateToExpired($bookisList);
                $this->UpdateToInP($bookisList);
                $this->UpdateToFinalized($bookisList);
            }
        }

/*
* D: Método interno que comprueba si un Keeper no respondio a la solicitud de
*        reserva en un maximo de 3 dias antes de la startD del Booking.
*        Se comprueba si el estado anterior es consistente al flujo establecido.
*        Se procede a cambiar el estado a 'EXPIRED',provocando muerte logica.
* A: Recibe las Booking disponibles en la BDD.
* R: No Posee.
🐘*/
        private function UpdateToExpired($bookList){
            foreach($bookList as $book){
                if(STRCMP($book->getBookState(),"In Review") == 0){
                    $cutD = DATE("Y-m-d",STRTOTIME($book->getStartD()."- 3 days"));
                    if($cutD == DATE("Y-m-d")){
                        $this->UpdateStSwtich($book,5);
                    }
                }   
            }
        }

/*
* D: Método interno que comprueba si el startD de un Booking coincide con la
*        FECHA ACTUAL. Se comprueba si el estado anterior es consistente al 
*        flujo establecido, se procederá a cambiar el estado a 'IN PROGRESS'.
* A: Recibe las Booking disponibles en la BDD.
* R: No Posee.
🐘 */
        private function UpdateToInP($bookList){
            foreach($bookList as $book){
                if(STRCMP($book->getBookState(),"Waiting Start") == 0){
                    if($book->getStartD() == DATE("Y-m-d")){
                        $this->UpdateStSwtich($book,4);
                    }
                }   
            }
        }

/*
* D: Método que comprueba si el finishD de un Booking coincide con la
*        FECHA ACTUAL. Se comprueba si el estado anterior es consistente al 
*        flujo establecido, se procederá a cambiar el estado a 'FINALIZED'.
*        Dando muerte lógica al Booking.
* A: Recibe las Booking disponibles en la BDD.
* R: No Posee.
🐘*/   
        private function UpdateToFinalized($bookList){
            foreach($bookList as $book){
                if(STRCMP($book->getBookState(),"In Progress") == 0){
                    $cutD = DATE("Y-m-d",STRTOTIME($book->getFinishD()."+ 1 days"));
                    if($cutD == DATE("Y-m-d")){
                        $this->UpdateStSwtich($book,7);
                    }
                }  
            }
        }

/*
* D: Método que recupera los Bookings con estado 'Waiting Start'
*        o 'In Progress', notando que son aquellos que coinciden con
*        la FECHA ACTUAL TRANSITADA.
!        Este método es invocado desde 'BOOKINGPETDAO'.
?        Es utilizado por el Keeper.
* A: Booking que suministra startD,finishD y idPublic para realizar
*        el filtro de las Bookings correctas
* R: Lista de Bookings filtradas que coinciden con la fecha actual.
🐘 */  
        public function GetAllMatchingDatesByPublic(Booking $booking){
            $bookingList = array();    
            $query = "CALL Booking_CheckRange(?,?,?)";
            $parameters["starD"] = $booking->getStartD();
            $parameters["finishD"] = $booking->getFinishD();
            $parameters["idPublic"] = $booking->getPublication()->getId();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
            foreach($resultBD as $row){
                $booking = new Booking();
                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                  ,$row["finishD"],$row["bookState"]
                                  ,$this->publicDAO->Get($row["idPublic"])
                                  ,$this->userDAO->DGet($row["idUser"]));
                array_push($bookingList,$booking);
            }
            return $bookingList;
        }


/*
* D: Metodo encargado de comprobar que el Owner ha concluido su
*       Booking de MANERA NATURAL para poder dejar una Review.
* A: Username correspondiente al owner que contrato el servicio.
* A2: ID de la Publication relacionada al Booking
* R: True en caso de permitir review, falso caso contrario.
🐘 */ 
        public function CheckBookDone($username, $idPublic){
            $canReview = 0;
            $user = $this -> userDAO -> DGetByUsername($username);
            $bookingList = $this -> GetAllByUser($user -> getId());
            
            foreach($bookingList as $book){
                if($book -> getPublication() -> getId() == $idPublic){

                    if(strcmp($book -> getBookState(), "Finalized") == 0){

                        $canReview = 1;
                        
                    return $canReview;
                    }
                }
            }   
        return $canReview;
        }

//? ======================================================================
//!                         DELETE METHODS
//? ====================================================================== 
//* Borra una Booking segun ID.
        public function Delete($idBooking){
            $query = "CALL booking_Delete(?)";
            $parameters["idbooking"] = $idBooking;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }


        public function OnlineBookingsByPublication($idPublic){
            $haveOnline = false;

            $booksXPublication = $this -> GetAllByPublication($idPublic);

            if(! empty($booksXPublication)){
                $haveOnline = !empty(array_filter($booksXPublication, function ($book){
                    $onlineState = ["In Review", "Awaiting Payment", "Waiting Start", "In Progress"];
                    return in_array($book -> getBookState(), $onlineState); 
                }));
            }

        return $haveOnline;
        }

        public function GetKeeperStats($username){
            $bookingList = $this -> GetAllByKeeper($username);
            $alias =  "Existiendo";
            $finalizadas = 0;
            $canceladas = 0;
            $expiradas = 0;

            foreach ($bookingList as $booking) {
                if ($booking -> getBookState() === 'Finalized') {
                    $finalizadas++;
                } elseif ($booking -> getBookState() === 'Canceled') {
                    $canceladas++;
                } elseif ($booking -> getBookState() === 'Expired') {
                    $expiradas++;
                }
            }

            $total_reservas = count($bookingList);

            if ($total_reservas > 0) {
                $tasa_finalizacion = ($finalizadas / $total_reservas) * 100;
                $tasa_cancelacion = ($canceladas / $total_reservas) * 100;
                $tasa_expiracion = ($expiradas / $total_reservas) * 100;


            // Lógica para asignar el alias basado en las tasas calculadas
            if ($tasa_finalizacion > 80 && $tasa_cancelacion < 10 && $tasa_expiracion < 5) {
                $alias = "Superestrella";
            } else if ($tasa_finalizacion > 60 && $tasa_cancelacion < 20 && $tasa_expiracion < 10) {
                $alias = "Confiado";
            } else if ($tasa_finalizacion > 40 && $tasa_cancelacion < 30 && $tasa_expiracion < 15) {
                $alias = "Constante";
            } else {
                $alias = "En desarrollo";
            }
        }
            return $alias;
        }

        public function SendVoucher(Booking $booking){
            $mail = new PHPMailer(true);
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
                $mail->addAddress($booking->getUser()->getEmail());     //Add a recipient
                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                //$mail->isHTML(true);  
                
                $plantilla = '
                <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        h1, h2 {
            text-align: center;
            color: #444;
        }
        .header-info {
            text-align: left;
            margin-bottom: 20px;
        }
        .header-info p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <h1>Pet Hero</h1>
        <h2>Comprobante de Pago</h2>

        <div class="header-info">
            <p><strong>Nombre de Usuario (Owner):</strong>'. $booking->getUser()->getUsername() .'</p>
            <p><strong>Fecha del Pago:</strong>'. date("Y-m-d") .'</p>
        </div>

        <div class="footer">
            <p><strong>Su reserva ya esta confirmada y abonada, la fecha de inicio es '. $booking->getStartD() .'</strong></p>
            <p><strong>y la fecha de finalizacion es '. $booking->getFinishD() .'</strong></p>
            <p>Gracias por confiar en Pet Hero.</p>
        </div>
    </div>
</body>
</html>';           
                $mail->CharSet = 'UTF-8';                                //Set email format to HTML
                $mail->Subject = 'Checker Disponible Pet Hero';
                $mail->isHTML(true);
                $mail->Body    = $plantilla;
                $mail->AltBody = 'Checker correspondiente a su reserva';
                $mail->send();
        }
    }
?>