<?php
namespace Model;
use \Model\Booking as Booking;

    class Checker{
        private $idChecker;
        private $emisionD;
        private $closeD;
        private $finalPrice;
        private Booking $booking;

        //CONSTRUCTORS
        public function __construct(){}

        public function __fromRequest($emisionD, $closeD, $finalPrice, Booking $booking)
        {
            $this->emisionD = $emisionD;
            $this->closeD = $closeD;
            $this->finalPrice = $finalPrice;
            $this->booking = $booking;
        }
        public function __fromDB($idChecker, $emisionD, $closeD, $finalPrice, Booking $booking)
        {
            $this->idChecker = $idChecker;
            $this->emisionD = $emisionD;
            $this->closeD = $closeD;
            $this->finalPrice = $finalPrice;
            $this->booking = $booking;
        }

        //GETTERS
        public function getId(){
            return $this->idChecker;
        }   
        public function getEmissionDate(){
            return $this->emisionD;
        }
        public function getCloseDate(){
            return $this->closeD;
        }
        public function getFinalPrice(){
            return $this->finalPrice;
        }
        public function getBooking(){
            return $this->booking;
        }

        //SETTERS
        public function setId($idChecker){
            $this->idChecker = $idChecker;
        }
        public function setEmissionDate($emisionD){
            $this->emisionD = $emisionD;
        }
        public function setCloseDate($closeD){  
            $this->closeD = $closeD;
        }
        public function setFinalPrice($finalPrice){
            $this->finalPrice = $finalPrice;
        }
        public function setBooking($booking){
            $this->booking = $booking;
        }
    }
?>