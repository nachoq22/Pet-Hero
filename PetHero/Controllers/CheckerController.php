<?php
namespace Controllers;

use \DAO\CheckerDAO as CheckerDAO;
use \Controllers\HomeController as HomeController;
use \Model\Checker as Checker;
use \Model\Booking as Booking;

    class CheckerController{
        private $checkDAO;

        private $homeC;

        public function __construct(){
            $this->checkDAO = new CheckerDAO();
            $this->homeC = new HomeController();
        }

        public function ToResponse($idBook,$rta){
                $book = new Booking();
                $book->setId($idBook);
                $check = new Checker();    
                $check->setBooking($book);
            $this->checkDAO->NewChecker($check,$rta);
            $this->homeC->ViewKeeperPanel();
        }
    }
?>