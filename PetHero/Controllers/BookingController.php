<?php
namespace Controllers;

use \DAO\BookingPetDAO as BookingPetDAO;
use \Model\Booking as Booking;
use \Model\Publication as Publication;
use \Model\User as User;
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

        public function Add($startD,$finishD,$idPublic,$petsId){
            if($this->bpDAO->ValidateTypes($petsId)==1){                 //Checkea si las mascotas de nuestro booking tienen todas el mismo pet Type
                $publication = new Publication();
                $publication->setid($idPublic);
                $user = new User();
                $user->setUsername("venus");
                $book = new Booking();
                $book->__fromRequest($startD,$finishD,"In Review",$publication,$user);
                if($this->bpDAO->ValidateTypesOnBookings($book, $petsId)==1){               //Checkea si el tipo de mascota de nuestro booking es compatible con cualquier otro booking en la misma fecha
                    $message = $this->bpDAO->NewBooking($book,$petsId);                                //Guarda nuestro booking
                    $this->homeController->ViewOwnerPanel($message);
                }else{
                    $this->petController->GetPetsByReservation($idPublic, $startD, $finishD, "Sus mascotas son incompatibles con las que cuidara el keeper en ese momento");  //Continuar en Petcontroller el message
                }
            }else{
                $this->petController->GetPetsByReservation($idPublic, $startD, $finishD, "Todas sus mascotas deben ser del mismo tipo");
            }
        }


    }
?>