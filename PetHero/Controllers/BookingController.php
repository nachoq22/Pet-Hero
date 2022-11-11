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
            if($this->bpDAO->ValidateTypes($petsId)==1){  
                $publication = new Publication();
                $publication->setid($idPublic);
                $user = new User();
                $user->setUsername("venus");
                $book = new Booking();
                $book->__fromRequest($startD,$finishD,"In Review",$publication,$user);
                if($this->bpDAO->ValidateTypesOnBookings($book, $petsId)==1){
                    $this->bpDAO->NewBooking($book,$petsId);
                    echo "fue un exito";
                }else{
                echo "El keeper cuidará a una mascota de otra especie en las fechas introducidas";
                }
            }else{
                echo "Sus mascotas deben ser de la misma especie";
            }
            /*$this->bpDAO->NewBooking($book,$petsId);
            $this->homeController->ViewOwnerPanel("Su reserva se ha realizado con exito");*/
        }


    }
?>