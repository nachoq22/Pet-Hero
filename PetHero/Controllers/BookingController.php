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
/**
* La función Agregar en PHP verifica y valida los tipos de mascotas para una reserva antes de crear una 
* nueva reserva y mostrar los mensajes correspondientes.

* @param startD: Este parámetro en la función Agregar parece representar la fecha de inicio de una reserva. 
* Probablemente se utiliza para especificar la fecha en la que debe comenzar una reserva.

* @param finishD: Fecha de finalización de la reserva.

* @param idPublic: Es el ID de la publicación para la cual se está realizando la reserva.

* @param petsId: El parámetro petsId en la función Agregar se utiliza para pasar un arreglo de IDs de mascotas 
* que están asociadas con la reserva. Este arreglo se utiliza luego para validar si todas las mascotas en la reserva 
* tienen el mismo tipo de mascota y para verificar la compatibilidad con otras reservas en el mismo rango de fechas.
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