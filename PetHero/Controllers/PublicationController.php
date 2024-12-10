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
        // public function Add($title,$description,$openD,$closeD,$remuneration,$images){
        //     $this->homeController->isLogged();
        //     $this->homeController->isKeeper();

        //         $public = new Publication();
        //         $logUser = $_SESSION["logUser"];

        // if(($this->publicDAO->ValidateDAllPublications($openD, $closeD, $logUser))==0 && 
        //         ($closeD>DATE("Y-m-d") && $openD>DATE("Y-m-d") && $closeD>$openD)){                       //* VALIDA QUE LAS FECHAS SEAN DESPUES DE LA FECHA ACTUAL Y VALIDA QUE LA FECHA   
        //         $public->__fromRequest($openD, $closeD, $title, $description,0, $remuneration,$logUser);  //* DE FINALIZACION SEA DESPUES QUE LA DE INICIO//
        //         $imgPublic = new ImgPublic();
        //         $imgPublic->setPublication($public);

        //     $message = $this->publicDAO->NewPublication($imgPublic,$images);
        //     $this->homeController->ViewKeeperPanel($message);
        // }else{
        //     $this->homeController->ViewAddPublication("Error: Las fechas ingresadas coinciden con otra publicacion suya o son invalidas");
        // }
        // }

        public function Add($title, $description, $openD, $closeD, $remuneration, $images){
            $this -> homeController -> isLogged();
            $this -> homeController -> isKeeper();

            $logUser = $_SESSION["logUser"];
            $public = new Publication();
            $public -> __fromRequest($openD, $closeD, $title, $description, 0, $remuneration, $logUser); 

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
?      💠 ValidateOnWeek
¬          ► Verifica que la fecha de inicio tenga 1 semana de anticipacion.
?      💠 ValidateDP
¬          ► Verifica que el rango de fechas esten dentro del PUBLICATION.
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
        // public function ValidateDateFP($idPublic, $startD, $finishD){
        //     $this -> homeController -> isLogged();
        //     $message = null;

        //     if($startD < $finishD){    //* QUE LA FECHA DE INICIO SEA ANTES QUE LA DE FINALIZACION  
                    
        //         if($this->publicDAO->ValidateOnWeek($startD)==1){    
                       
        //             if($this->publicDAO->ValidateDP($startD, $finishD, $idPublic) == 1){
        //                 $this->petController->GetPetsByReservation($idPublic, $startD, $finishD);
        //             }else{
        //                  $this->ViewPublication($idPublic, "Error: Las fechas ingresadas no entran en el rango de establecidas por el Keeper");
        //             }
                    
        //         }else{
        //             $this->ViewPublication($idPublic, "Error: Las reservas deben tener 1 semana de aniticipacion");
        //         }
                
        //     }else{
        //         $this->ViewPublication($idPublic, "Error: La fecha de finalizacion debe ser despues de la de inicio");
        //     }
        // }
//? REVISAR URGENTE FLUJO, VALIDACION PARA BOOKING NO DEBERIA CAER EN PUBLICATIONCONTROLLER.
//? REVISAR URGENTE, LAS DIREVACIONES Y EXCEPECIONES DEBEN LLEGAR DE ADENTRO.
//? LAS VALIDACIONES DEBERIAN MOVERSE ADEMAS HACIA EL BOOKING, SALTANDOSE ESTA REVUELTADA.
        // public function ValidateDateFP($idPublic, $startD, $finishD){
        //     $this -> homeController -> isLogged();
        //     $message = null;
        //     $success = false;

        //     if($startD < $finishD){    //* QUE LA FECHA DE INICIO SEA ANTES QUE LA DE FINALIZACION  
                    
        //         if($this->publicDAO->ValidateOnWeek($startD)==1){    
                       
        //             if($this->publicDAO->ValidateDP($startD, $finishD, $idPublic) == 1){
        //                 $success = true;
        //             }else{
        //                 $message = "Error: Las fechas ingresadas no entran en el rango de establecidas por el Keeper";
        //             }
                    
        //         }else{
        //             $message = "Error: Las reservas deben tener 1 semana de aniticipacion";
        //         }
                
        //     }else{
        //         $message = "Error: La fecha de finalizacion debe ser despues de la de inicio";
        //     }

        //     if($success){
        //         $this->petController->GetPetsByReservation($idPublic, $startD, $finishD);
        //     }else {
        //         $this -> ViewPublication($idPublic, $message);
        //     }
        // }

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

            $message = "Successful: Su PUBLICATION se ha borrado correctamente";

            try{
                if(! $this -> bpDAO -> OnlineBookingsByPublication($idPublic)){
                    $this -> publicDAO -> Delete($idPublic);
                }
            }catch(PDOException $rpe){
                $message = $rpe -> getMessage();
            }
            
            setcookie('message', $message, time() + 2,'/');
            header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewKeeperPanel');
        }
    }
?>