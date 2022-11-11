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

        public function EnterPaycode($idBook,$payCode){
            $book = new Booking();
            $book->setId($idBook);
            $book->setPayCode($payCode);
            $message = $this->checkDAO->UpdatePayCode($book);
            $this->homeC->ViewOwnerPanel($message);
        }
    }
?>