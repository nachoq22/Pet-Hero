<?php
namespace Controllers;

use PDOException;
use Exceptions\RegisterBookingException;
use Exceptions\RegisterCheckerException;
use Exceptions\UpdateBookingException;
use Exceptions\UpdateCheckerException;
use Exceptions\CancelBookingException;

use \Controllers\PetController as PetController;
use \Controllers\HomeController as HomeController;

use \DAO\BookingPetDAO as BookingPetDAO;

use \Model\Booking as Booking;
use \Model\Publication as Publication;

    class BookingController{
        private $homeController;
        private $bpDAO;
        private $petController;

        public function __construct(){
            $this->homeController = new HomeController();
            $this->bpDAO = new BookingPetDAO();
            $this->petController = new PetController();
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                       AGREGAR RESERVA
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el registro
*    de una nueva reserva. 

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 NewBooking
¬          ► Registra el BOOKING.
?      💠 ViewOwnerPanel
¬          ► Invocación de HomeController para redireccion a "Owner Panel".
?      💠 GetPetsByReservation
¬          ► Recupera las mascotas para la reservasion

* A: $startD: Fecha de inicio del BOOKING.
*    $finishD: Fecha de fin del BOOKING.
*    $idPublic: id de la PUBLICATION
*    $petsId: Lista con id de PETS del OWNER.

* R: No Posee.
🐘 */
        // public function Add($startD,$finishD,$idPublic,$petsId){
        //     $this->homeController->isLogged();
        //     if($this->bpDAO->ValidateTypes($petsId)==1){
        //         $publication = new Publication();
        //         $publication->setid($idPublic);
        //         $logUser = $_SESSION["logUser"];
        //         $book = new Booking();
        //         $book->__fromRequest($startD,$finishD,"In Review",$publication,$logUser);
        //         if($this->bpDAO->ValidateTypesOnBookings($book, $petsId)==1){
        //             $message = $this->bpDAO->NewBooking($book,$petsId);
        //             $this->homeController->ViewOwnerPanel($message);
        //         }else{
        //             $this->petController->GetPetsByReservation($idPublic, $startD, $finishD, "Error: Sus mascotas son incompatibles con las que cuidara el keeper en ese momento");
        //         }
        //     }else{
        //         $this->petController->GetPetsByReservation($idPublic, $startD, $finishD, "Error: Todas sus mascotas deben ser del mismo tipo");
        //     }
        // }

        public function Add($startD,$finishD,$idPublic,$petsId){
            $this -> homeController -> isLogged();

            $publication = new Publication();
            $publication -> setId($idPublic);

            $logUser = $_SESSION["logUser"];

            $book = new Booking();
            $book -> __fromRequest($startD,$finishD,"In Review",$publication,$logUser);

            $message = "Successful: Se ha enviado solicitud de Reserva, a la espera de respuesta.";
            $success = false;

            try{

                $this -> bpDAO -> NewBooking($book,$petsId);
                $success = true;

            }catch(RegisterBookingException $rbe){
                $message = $rbe -> getMessage();
            }

            if($success){

                setcookie('message', $message, time() + 2,'/');
                header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewOwnerPanel');

            }else{
                
                $this -> petController -> GetPetsByReservation($idPublic, $startD, $finishD,$message);
            }
        }


//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                      CANCELAR RESERVA
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function CancelBook($idBook){
            $this->homeController->isLogged();

            $book = new Booking();
            $book -> setId($idBook);
            $message = "Successful: Reserva cancelada satisfactoriamente";
            $success = false;

            try{

                $this -> bpDAO -> CancelBook($book);
                $success = true;

            }catch(CancelBookingException $cbe){
                $message = $cbe -> getMessage();
            }
             
            setcookie('message', $message, time() + 2,'/');
            header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewOwnerPanel');
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                 RESPONDER PETICIÓN RESERVA
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la respuesta del KEEPER a una
*    solicitud de BOOKING.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 ProcessBookingRequest
¬          ► Recibe el BOOKING y la respuesta para tomar decisiones.
?      💠 ViewKeeperPanel
¬          ► Invocación de HomeController para redireccion a "Keeper Panel".

* A: $idBook: id de BOOKING que se asociara al CHECKER.
*    $rta: Respuesta del Keeper a la petición de BOOKING.

* R: No Posee.
🐘 */
        // public function ToResponse($idBook,$rta){
        //     $this->homeC->isLogged();    

        //     $book = new Booking();
        //     $book->setId($idBook);

        //     $check = new Checker();    
        //     $check->setBooking($book);

        //     $message = $this->checkDAO->NewChecker($check,$rta);
            
        //     $this->homeC->ViewKeeperPanel($message);
        // }

        public function ToResponse($idBook,$rta){
            $this -> homeController -> isLogged();    

            $book = new Booking();
            $book -> setId($idBook);

            $message = ($rta == 1) ? "Successful: Se ha creado el checker y actualizado la reserva."
                                   : "Successful: la reserva se ha cancelado con éxito";     
            
            try{

                $this -> bpDAO -> ProcessBookingRequest($book,$rta);

            }catch(RegisterBookingException $rbe){
                $message = $rbe -> getMessage();
            }catch(RegisterCheckerException $rce){
                $message = $rce -> getMessage();
            }catch(PDOException $pdoe){
                $message = "Error: ". $pdoe -> getMessage();
            }

            setcookie('message', $message, time() + 2,'/');
            header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewKeeperPanel');
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                        ACTUALIZACIÓN PAGO / CHECKER
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para comprobar
* D: el pago del CHECKER, actualizar la BOOKING y confirmarla.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 PayBooking
¬          ► Establece el Paycode en el BOOKING y la Fecha del Pago su CHECKER.
?      💠 ViewOwnerPanel
¬          ► Invocación de HomeController para redireccion a "Owner Panel".

* A: $idBook: id de BOOKING con CHECKER emitido.
*    $payCode: Código recibido al realizar el Pago.

* R: No Posee.
🐘 */        
        public function PayBooking($idBook,$payCode){
            $this -> homeController -> isLogged();

            $book = new Booking();
            $book -> setId($idBook);
            $book -> setPayCode($payCode);

            $message = "Successful: Su PayCode ha sido aceptado, reserva abonada.";  

            try{

                $this -> bpDAO -> PayBooking($book);

            }catch(UpdateBookingException $ube){
                $message = $ube -> getMessage();

            }catch(UpdateCheckerException $uce){
                $message = $uce -> getMessage();
            }

            setcookie('message', $message, time() + 2,'/');
            header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewOwnerPanel');
        }

        public function PayBookingCC($idBook, $name, $surname, $dni, $carNum, $ccv, $expDate){
            $this -> homeController -> isLogged();

            $book = new Booking();
            $book -> setId($idBook);
            $cc = array(
                'name' => $name,
                'surname' => $surname,
                'dni' => $carNum,
                'carNum' => $dni,
                'ccv' => $ccv,
                'expDate' => $expDate,
            );

            $message = "Successful: Su pago ha sido aceptado, reserva abonada.";

            try{

                $this -> bpDAO -> PayBookingCC($book, $cc);

            }catch(UpdateBookingException $ube){
                $message = $ube -> getMessage();

            }catch(UpdateCheckerException $uce){
                $message = $uce -> getMessage();
            }

            setcookie('message', $message, time() + 2,'/');
            header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewOwnerPanel');
        }
    }
?>