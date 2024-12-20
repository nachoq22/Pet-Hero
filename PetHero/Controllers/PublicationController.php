<?php
namespace Controllers;

use Exceptions\RegisterBookingException;
use Exceptions\RegisterPublicationException;
use PDOException;

use \Controllers\HomeController as HomeController;
use \Controllers\PetController as PetController;

use \DAO\ImgPublicDAO as ImgPublicDAO;
use \DAO\ReviewDAO as ReviewDAO;
use \DAO\BookingPetDAO as BookingPetDAO;

use \Model\ImgPublic as ImgPublic;
use \Model\Publication as Publication;

class PublicationController{
        private $publicDAO;
        private $reviewDAO;
        private $bpDAO;

        private $homeController;
        private $petController;

        public function __construct(){
            $this -> publicDAO = new ImgPublicDAO();
            $this -> reviewDAO = new ReviewDAO();
            $this -> bpDAO = new BookingPetDAO();
            $this -> homeController = new HomeController();
            $this -> petController = new PetController();
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                           REGISTRAR PUBLICACIÓN
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el registro
*    de una nueva PUBLICATION.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 isKeeper
¬          ► Verifica si un usuario que ha iniciado sesión es KEEPER.
?      💠 NewPublication
¬          ► Registra una nueva PUBLICATION.
?      💠 ViewKeeperPanel
¬          ► Invocación de HomeController para redireccion a "Keeper Panel".
?      💠 ViewAddPublication
¬          ► Invocación de HomeController para redireccion a "AddPublication".

* A: $title: Titulo de la PUBLICATION.
*    $description: Detalles adicionales de la PUBLICATION.
*    $openD: Fecha inicio de la PUBLICATION.
*    $closeD: Fecha fin de la PUBLICATION.
*    $remuneration: Costo x dia de la PUBLICATION.
*    $images: Lista de imágenes de la PUBLICATION.

* R: No Posee.
🐘 */ 
        public function Add($title, $description, $openD, $closeD, $remuneration, $images){
            $this -> homeController -> isLogged();
            $this -> homeController -> isKeeper();

            $logUser = $_SESSION["logUser"];
            $public = new Publication();
            $public -> __fromRequest($openD, $closeD, $title, $description, 0, $remuneration, $logUser); 
            $public -> setId(0); 

            $imgPublic = new ImgPublic();
            $imgPublic -> setPublication($public);

            $success = false;
            $message = "Successful: se ha guardado correctamente";

            try{
                $this -> publicDAO -> NewPublication($imgPublic, $images);
                $success = true;
            }catch(RegisterPublicationException $rpe){
                $message = $rpe -> getMessage();
            }

            setcookie('message', $message, time() + 2,'/');
            if($success){
                header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewKeeperPanel');
                exit;
            }else{
                header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewAddPublication');
                exit;
            }
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                       VIEW PUBLICACIÓN INDIVIDUAL
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Redirecciona hacia la vista de una PUBLICATION individual.

?      💠 GetPublication
¬          ► Obtiene toda la data de una PUBLICATION.
?      💠 GetAllByPublic
¬          ► Obtiene todas las REVIEW según una PUBLICATION.
?      💠 CheckBookDone
¬          ► Verifica si la BOOKING concluyo de manera Natural.
?      💠 GetAllByPublic
¬          ► Obtiene las IMG según una PUBLICATION.

* A: $idPublic: id de la PUBLICATION.
*    $message: mensaje derivado de ValidateDateFP para mostrar información.

* R: No Posee.
🐘 */         
        public function ViewPublication($idPublic, $message=""){
            $public = new Publication();
            $public -> setId($idPublic);

            $imgPublic = new ImgPublic();
            $imgPublic -> setPublication($public);
            $ImgList = $this -> publicDAO -> GetAllByPublic($public -> getId());

            $public = $this -> publicDAO -> GetPublication($imgPublic);
            $reviewList = $this -> reviewDAO -> GetAllByPublic($public -> getId()); 

            $badgeStats = $this -> bpDAO -> GetKeeperStats($public -> getUser() -> getUsername());
            $badgeVarietyTPets = $this -> bpDAO -> GetVarietyPetStats($public -> getUser() -> getUsername());
            $badgeBestTPet = $this -> bpDAO -> GetBestPetStats($public -> getUser() -> getUsername());
            $badges = array();
            array_push($badges,$badgeStats, $badgeVarietyTPets, $badgeBestTPet);

            $canReview = 0;

            if(isset($_SESSION["logUser"])){
                $logUser = $_SESSION["logUser"];

                $canReview = $this -> bpDAO -> CheckBookDone($logUser -> getUsername(), $idPublic);
            }

            require_once(VIEWS_PATH."PublicInd.php");
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                     VALIDADOR DE FECHAS PRE BOOKING
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Valida fechas para posteriormente proceder al formulario de reserva.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 ValidatePreBooking
¬          ► Realiza las validaciones dispuestas en las fechas para asentar
¬          un BOOKING, contrastando con lo establecido en PUBLICATION.
?      💠 GetPetsByReservation
¬          ► A traves del PETCONTROLLER, redireccionamos a AddBooking.
?      💠 ViewPublication
¬          ► Redireccionamos a PublicInd, remitiendo un mensaje a mostrar.

* A: $idPublic: id de la PUBLICATION.
*    $startD: Fecha que se cree que iniciara la BOOKING.
*    $finishD: Fecha que se cree que finalizara la BOOKING.

* R: No Posee.
🐘 */ 
        public function ValidateDateFP($idPublic, $startD, $finishD){
            $this -> homeController -> isLogged();
            $message = null;
            $success = false;

            try{
                $success = $this -> publicDAO -> ValidatePreBooking($startD, $finishD, $idPublic);
            }catch(RegisterBookingException $rbe){
                $message = $rbe -> getMessage();
            }

            if($success){
                $this->petController->GetPetsByReservation($idPublic, $startD, $finishD);
            }else {
                $this -> ViewPublication($idPublic, $message);
            }
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                     ACTUALIZAR PUBLICATION
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Actualiza los datos de la Publication.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 OnlineBookingsByPublication
¬          ► Verifica que la PUBLICATION a actualizar posea BOOKINGS online.
?      💠 UpdatePublication
¬          ► Actualiza los datos de la PUBLICATION.
?      💠 ViewKeeperPanel
¬          ► Redirecciona a KeeperPanel, mostrando el resultado de la
¬          operación con un mensaje.

* A: $idPublic: id de la PUBLICATION.
*    $startD: Fecha que se cree que iniciara la BOOKING.
*    $finishD: Fecha que se cree que finalizara la BOOKING.

* R: No Posee.
🐘 */         
        public function Update($idPublic, $title, $description, $openD, $closeD, $remuneration){
            $this -> homeController -> isLogged();
            $this -> homeController -> isKeeper();
            
            $logUser = $_SESSION["logUser"];
            $public = new Publication();
            $public -> __fromDB($idPublic,$openD, $closeD, $title, $description, 0, $remuneration, 1,$logUser);

            $message = "Error: Su PUBLICATION aun posee BOOKINGS online";

            try{
                if(! $this -> bpDAO -> OnlineBookingsByPublication($idPublic)){
                    $this -> publicDAO -> UpdatePublication($public);
                    $message = "Successful: Su PUBLICATION se ha actualizado correctamente";
                }
            }catch(RegisterPublicationException $rpe){
                $message = $rpe -> getMessage();
            }
            
            setcookie('message', $message, time() + 2,'/');
             header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewKeeperPanel');
        }


        public function Delete($idPublic){
            $this -> homeController -> isLogged();
            $this -> homeController -> isKeeper();

            $message = "Error: Su PUBLICATION no ha podido ser eliminada.";

            try{
                if(! $this -> bpDAO -> OnlineBookingsByPublication($idPublic)){
                    $this -> publicDAO -> DeletePublication($idPublic);
                    $message = "Successful: Su PUBLICATION se ha borrado correctamente";
                }
            }catch(PDOException $rpe){
                $message = $rpe -> getMessage();
            }

            setcookie('message', $message, time() + 2,'/');
            header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewKeeperPanel');
        }
    }
?>