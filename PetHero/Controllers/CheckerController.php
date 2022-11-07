<?php
namespace Controllers;

use \DAO\CheckerDAO as CheckerDAO;
use \Model\Checker as Checker;
use \Model\Booking as Booking;

    class CheckerController{
        private $checkDAO;
        private $bookDAO;

        public function __construct(){
            $this->checkDAO = new CheckerDAO();
        }

        public function ToResponse($idBook,$rta){
                $book = new Booking();
                $book->setId($idBook);
            $check = new Checker();    
            $check->setBooking($book);
            $this->checkDAO->NewChecker($check,$rta);
        }
    }
?>