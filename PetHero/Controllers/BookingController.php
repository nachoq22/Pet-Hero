<?php
namespace Controllers;

use \DAO\BookingPetDAO as BookingPetDAO;
use \Model\Booking as Booking;
use \Model\Publication as Publication;
use \Controllers\HomeController as HomeController;
use \Controllers\PetController as PetController;

    class BookingController{
        private $bpDAO;
        private $homeController;
        private $petController;

        public function __construct(){
            $this->bpDAO = new BookingPetDAO();
            $this->homeController = new HomeController();
            $this->petController = new PetController();
        }

//? ======================================================================
//!                         METHODS
//? ====================================================================== 

//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                       AGREGAR RESERVA
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el registro
*    de una nueva reserva. 

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 ValidateTypes
¬          ► Verifica que las mascotas entrantes son del mismo tipo.
?      💠 ValidateTypesOnBookings
¬          ► Verifica que las mascotas entrantes son compatible con cualquier 
¬            otro booking en la misma fecha.
?      💠 NewBooking
¬          ► Registra el Booking.
?      💠 ViewOwnerPanel
¬          ► Invocacion de HomeController para redireccion a "Owner Panel".
?      💠 GetPetsByReservation
¬          ► Recupera las mascotas para la reservasion

* A: $startD: Fecha de inicio del Booking.
*    $finishD: Fecha de fin del Booking.
*    $idPublic: id de la Publication
*    $petsId: Lista con id de Pets.

* R: No Posee.
🐘 */
        public function Add($startD,$finishD,$idPublic,$petsId){
            $this->homeController->isLogged();
            if($this->bpDAO->ValidateTypes($petsId)==1){
                $publication = new Publication();
                $publication->setid($idPublic);
                $logUser = $_SESSION["logUser"];
                $book = new Booking();
                $book->__fromRequest($startD,$finishD,"In Review",$publication,$logUser);
                if($this->bpDAO->ValidateTypesOnBookings($book, $petsId)==1){
                    $message = $this->bpDAO->NewBooking($book,$petsId);
                    $this->homeController->ViewOwnerPanel($message);
                }else{
                    $this->petController->GetPetsByReservation($idPublic, $startD, $finishD, "Error: Sus mascotas son incompatibles con las que cuidara el keeper en ese momento");
                }
            }else{
                $this->petController->GetPetsByReservation($idPublic, $startD, $finishD, "Error: Todas sus mascotas deben ser del mismo tipo");
            }
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                       CANCELAR RESERVA
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function CancelBook($idBook){
        $this->homeController->isLogged();
                $book = new Booking();
                $book->setId($idBook);
                $message = $this->bpDAO->CancelBook($book);
                $this->homeController->ViewOwnerPanel($message);
        }
    }
?>