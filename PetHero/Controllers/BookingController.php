<?php
namespace Controllers;

use \DAO\BookingPetDAO as BookingPetDAO;
use \Model\Booking as Booking;
use \Model\Publication as Publication;
use \Model\User as User;

    class BookingController{
        private $bpDAO;
        private $homeC;

        public function __construct(){
            $this->bpDAO = new BookingPetDAO();
            $this->homeC = new HomeController();
        }

        public function Add($startD,$finishD,$petsId){
            $publication = new Publication();
            $publication->setid(4);

            $user = new User();
            $user->setUsername("venus");
            $book = new Booking();
            $book->__fromRequest($startD,$finishD,"In Review",$publication,$user);
            $this->bpDAO->NewBooking($book,$petsId);
        }
        public function EnterPaycode($idBook,$payCode){
            $book = new Booking();
            $book->setId($idBook);
            $book->setPayCode($payCode);
            $message = $this->bpDAO->UpdatePayCode($book);
            $this->homeC->ViewOwnerPanel($message);
        }

        public function CancelBook($idBook){
            $book = new Booking();
            $book->setId($idBook);
            $message = $this->bpDAO->CancelBook($book);
            $this->homeC->ViewOwnerPanel($message);
        }
    }
?>