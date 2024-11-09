<?php
namespace Controllers;
use \DAO\ImgPublicDAO as ImgPublicDAO;
use \DAO\ReviewDAO as ReviewDAO;
use \DAO\BookingDAO as BookingDAO;
use \Model\ImgPublic as ImgPublic;
use \Model\Publication as Publication;
use \Controllers\HomeController as HomeController;
use \Controllers\PetController as PetController;

    class PublicationController{
        private $publicDAO;
        private $reviewDAO;
        private $homeController;
        private $petController;
        private $bookingDAO;

        public function __construct(){
            $this->publicDAO = new ImgPublicDAO();
            $this->reviewDAO = new ReviewDAO();
            $this->homeController = new HomeController();
            $this->petController = new PetController();
            $this->bookingDAO = new BookingDAO();
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
?      💠 ValidateDAllPublications
¬          ► Verifica que las fechas no se superpongan con otros PUBLICATION.
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
*    $images: Lista de imagenes de la PUBLICATION.

* R: No Posee.
🐘 */ 
        public function Add($title,$description,$openD,$closeD,$remuneration,$images){
            $this->homeController->isLogged();
            $this->homeController->isKeeper();

                $public = new Publication();
                $logUser = $_SESSION["logUser"];

                if(($this->publicDAO->ValidateDAllPublications($openD, $closeD, $logUser))==0 && 
                ($closeD>DATE("Y-m-d") && $openD>DATE("Y-m-d") && $closeD>$openD)){                       //* VALIDA QUE LAS FECHAS SEAN DESPUES DE LA FECHA ACTUAL Y VALIDA QUE LA FECHA   
                $public->__fromRequest($openD, $closeD, $title, $description,0, $remuneration,$logUser);  //* DE FINALIZACION SEA DESPUES QUE LA DE INICIO//
                $imgPublic = new ImgPublic();
                $imgPublic->setPublication($public);

            $message = $this->publicDAO->NewPublication($imgPublic,$images);
            $this->homeController->ViewKeeperPanel($message);
        }else{
            $this->homeController->ViewAddPublication("Error: Las fechas ingresadas coinciden con otra publicacion suya o son invalidas");
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
                $public->setId($idPublic);
                $imgPublic = new ImgPublic();
                $imgPublic->setPublication($public);
            $public = $this->publicDAO->GetPublication($imgPublic);
            $reviewList = $this->reviewDAO->GetAllByPublic($public->getid()); 
            $canReview = 0;
                if(isset($_SESSION["logUser"])){
                $logUser = $_SESSION["logUser"];
                $canReview = $this->bookingDAO->CheckBookDone($logUser->getUsername(), $idPublic);
                }
            
            $ImgList = $this->publicDAO->GetAllByPublic($public->getid());
            require_once(VIEWS_PATH."PublicInd.php");
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                            DATES VALIDATIONS
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Valida fechas para posteriormente proceder al formulario de reserva.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 ValidateOnWeek
¬          ► Verifica que la fecha de inicio tenga 1 semana de anticipacion.
?      💠 ValidateDP
¬          ► Verifica que el rango de fechas esten dentro del PUBLICATION.
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
            $this->homeController->isLogged();
                if($startD<$finishD){    //* QUE LA FECHA DE INICIO SEA ANTES QUE LA DE FINALIZACION      
                    if($this->publicDAO->ValidateOnWeek($startD)==1){    
                        if($this->publicDAO->ValidateDP($startD, $finishD, $idPublic) == 1){
                            $this->petController->GetPetsByReservation($idPublic, $startD, $finishD);
                        }else{
                            $this->ViewPublication($idPublic, "Error: Las fechas ingresadas no entran en el rango de establecidas por el Keeper");
                        }
                    }else{
                        $this->ViewPublication($idPublic, "Error: Las reservas deben tener 1 semana de aniticipacion");
                    }
                }else{
                    $this->ViewPublication($idPublic, "Error: La fecha de finalizacion debe ser despues de la de inicio");}
            }
    }
?>