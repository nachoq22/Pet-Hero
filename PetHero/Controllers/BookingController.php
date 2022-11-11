<?php
namespace Controllers;

use \DAO\BookingPetDAO as BookingPetDAO;
use \Model\Booking as Booking;
use \Model\Publication as Publication;
use \Model\User as User;
use \Controllers\HomeController as HomeController;

    class BookingController{
        private $bpDAO;
        private $homeController;

        public function __construct(){
            $this->bpDAO = new BookingPetDAO();
            $this->homeController = new HomeController();
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
                    $this->bpDAO->NewBooking($book,$petsId);                                //Guarda nuestro booking
                    echo "fue un exito";
                }else{
                echo "El keeper cuidará a una mascota de otra especie en las fechas introducidas";
                }
            }else{
                echo "Sus mascotas deben ser de la misma especie";
            }
        }


    }
?>