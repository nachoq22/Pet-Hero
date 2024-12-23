<?php
namespace DAO;

//use \Model\Checker as Checker;
use \Model\Booking as Booking;

    interface ICheckerDAO{
        //public function NewChecker(Checker $checker,$rta);
        public function NewChecker(Booking $booking,$rta);
        public function Get($idChecker);
        public function GetByBook($idBook);
        public function GetAll();
        public function Delete($idChecker);
    }
?>