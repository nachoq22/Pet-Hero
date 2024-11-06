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

/*
!                           ╔═══════════╗
!                           ║  Métodos  ║
!                           ╚═══════════╝
*/
/*
?                       ╔═══════════════════╗
?                       ║  Agregar Reserva  ║
?                       ╚═══════════════════╝
*/
        public function Add($startD,$finishD,$idPublic,$petsId){
            $this->homeController->isLogged();
            if($this->bpDAO->ValidateTypes($petsId)==1){                 //Checkea si las mascotas de nuestro booking tienen todas el mismo pet Type
                $publication = new Publication();
                $publication->setid($idPublic);
                $logUser = $_SESSION["logUser"];
                $book = new Booking();
                $book->__fromRequest($startD,$finishD,"In Review",$publication,$logUser);
                if($this->bpDAO->ValidateTypesOnBookings($book, $petsId)==1){               //Checkea si el tipo de mascota de nuestro booking es compatible con cualquier otro booking en la misma fecha
                    $message = $this->bpDAO->NewBooking($book,$petsId);                                //Guarda nuestro booking
                    $this->homeController->ViewOwnerPanel($message);
                }else{
                    $this->petController->GetPetsByReservation($idPublic, $startD, $finishD, "Error: Sus mascotas son incompatibles con las que cuidara el keeper en ese momento");  //Continuar en Petcontroller el message
                }
            }else{
                $this->petController->GetPetsByReservation($idPublic, $startD, $finishD, "Error: Todas sus mascotas deben ser del mismo tipo");
            }
        }

        //FUNCION PARA CANCELAR UNA RESERVA//
        public function CancelBook($idBook){
        $this->homeController->isLogged();
                $book = new Booking();
                $book->setId($idBook);
                $message = $this->bpDAO->CancelBook($book);
                $this->homeController->ViewOwnerPanel($message);
        }
    }
?>