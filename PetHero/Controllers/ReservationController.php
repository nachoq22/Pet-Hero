<?php
namespace Controllers;
use \DAO\BookingDAO as BookingDAO;
use \Model\Booking as Booking;
use \Model\Publication as Publication;
use \Model\User as User;

    class ReservationController{
        private $bookDAO;

        public function __construct(){
            $this->bookDAO = new BookingDAO();
        }

        public function Add($startD,$finishD,$petsId){

            $publication = new Publication();
            $publication->setid(1);

            $user = new User();
            $user->setUsername("venus");
            $book = new Booking();

            $book->__fromRequest($startD,$finishD,"In Review",$publication,$user);

            var_dump($book);
            var_dump($petsId);
            //$this->bookDAO->NewBooking($book,$petsId);
        }
    }
?>