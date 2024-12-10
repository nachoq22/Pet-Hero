<?php
namespace Controllers;

use Exceptions\UpdateCheckerException;
// use Exceptions\RegisterBookingException;
// use Exceptions\RegisterCheckerException;

use \Controllers\HomeController as HomeController;

use \DAO\CheckerDAO as CheckerDAO;

use \Model\Booking as Booking;
use \Model\Checker as Checker;

    class CheckerController{
        private $checkDAO;
        private $homeC;

        public function __construct(){
            $this->checkDAO = new CheckerDAO();
            $this->homeC = new HomeController();
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                             CREACIÓN CHECKER
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para la emision
*    de un CHECKER para pago.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 NewChecker
¬          ► Registra un nuevo CHECKER si cumple con algunas condiciones.
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

        // public function ToResponse($idBook,$rta){
        //     $this->homeC->isLogged();    

        //     $book = new Booking();
        //     $book->setId($idBook);

        //     $check = new Checker();    
        //     $check->setBooking($book);

        //     $message = ($rta == 1) ? "Successful: Se ha creado el checker y actualizado la reserva."
        //                            : "Successful: la reserva se ha cancelado con exito";     
            
        //     try{

        //         $this->checkDAO->NewChecker($check,$rta);

        //     }catch(RegisterBookingException $rce){
        //         $message = $rce -> getMessage();
        //     }catch(RegisterCheckerException $rce){
        //         $message = $rce -> getMessage();
        //     }



        //     setcookie('message', $message, time() + 2,'/');
        //     header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewKeeperPanel');
        // }



//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                        ACTUALIZACIÓN PAGO CHECKER
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para la emision
*    de un CHECKER para pago.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 PayCheck
¬          ► Establece el Paycode en el BOOKING y la Fecha del Pago su CHECKER.
?      💠 ViewOwnerPanel
¬          ► Invocación de HomeController para redireccion a "Owner Panel".

* A: $idBook: id de BOOKING con CHECKER emitido.
*    $payCode: Código recibido al realizar el Pago.

* R: No Posee.
🐘 */        
        // public function PayCheck($idBook,$payCode){
        //     $this->homeC->isLogged();   

        //     $book = new Booking();
        //     $book->setId($idBook);
        //     $book->setPayCode($payCode);

        //     $check = new Checker();    
        //     $check->setBooking($book);

        //     $message = "Successful: Su comprobante ha sido aceptado";    

        //     try{
        //         //$this->checkDAO->PayCheck($check);
        //     }catch(UpdateCheckerException $uce){
        //         $message = $uce -> getMessage();
        //     }

        //     setcookie('message', $message, time() + 2,'/');
        //     header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewOwnerPanel');
        // }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                         VISTA PREVIA CHECKER PDF
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function ViewChecker($idBook){
        $this -> homeC -> isLogged();
        $checker = $this -> checkDAO -> GetByBook($idBook);
        require_once(VIEWS_PATH."ViewChecker.php");
        }
    }
?>