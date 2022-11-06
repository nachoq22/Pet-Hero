<?php
namespace Controllers;

use \DAO\BookingPetDAO as BookingPetDAO;
use \Model\Booking as Booking;
use \Model\Publication as Publication;
use \Model\User as User;

    class BookingController{
        private $bpDAO;

        public function __construct(){
            $this->bpDAO = new BookingPetDAO();
        }

        public function Add($startD,$finishD,$petsId){
            $publication = new Publication();
            $publication->setid(1);

            $user = new User();
            $user->setUsername("venus");
            $book = new Booking();
            $book->__fromRequest($startD,$finishD,"In Review",$publication,$user);
            $this->bpDAO->NewBooking($book,$petsId);
            
        }
    }
?>