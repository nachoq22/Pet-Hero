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
        $this->homeC->isLogged();    
                $book = new Booking();
                $book->setId($idBook);
                $check = new Checker();    
                $check->setBooking($book);
            $message = $this->checkDAO->NewChecker($check,$rta);
            $this->homeC->ViewKeeperPanel($message);
        }

        public function PayCheck($idBook,$payCode){
        $this->homeC->isLogged();    
            $book = new Booking();
            $book->setId($idBook);
            $book->setPayCode($payCode);
            $check = new Checker();    
            $check->setBooking($book);
            $message = $this->checkDAO->PayCheck($check);
        $this->homeC->ViewOwnerPanel($message);
        }
        
        public function ViewChecker($idBook){
        $this->homeC->isLogged();
            $checker = $this->checkDAO->GetByBook($idBook);
            require_once(VIEWS_PATH."ViewChecker.php");
        }
    }
?>