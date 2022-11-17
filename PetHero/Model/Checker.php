<?php
namespace Model;
use \Model\Booking as Booking;

    class Checker{
        private $idChecker;
        private $refCode;
        private $emisionD;
        private $closeD;
        private $payD;
        private $finalPrice;
        private Booking $booking;

        //CONSTRUCTORS
        public function __construct(){}

        public function __fromRequest($refCode,$emisionD, $closeD, $finalPrice, Booking $booking){
            $this->refCode = $refCode;
            $this->emisionD = $emisionD;
            $this->closeD = $closeD;
            $this->finalPrice = $finalPrice;
            $this->booking = $booking;
        }
        
        public function __fromDB($idChecker,$refCode, $emisionD, $closeD, $finalPrice, Booking $booking){
            $this->idChecker = $idChecker;
            $this->refCode = $refCode;
            $this->emisionD = $emisionD;
            $this->closeD = $closeD;
            $this->finalPrice = $finalPrice;
            $this->booking = $booking;
        }

        public function __fromDBP($idChecker,$refCode, $emisionD, $closeD,$payD, $finalPrice, Booking $booking){
            $this->idChecker = $idChecker;
            $this->refCode = $refCode;
            $this->emisionD = $emisionD;
            $this->closeD = $closeD;
            $this->payD = $payD;
            $this->finalPrice = $finalPrice;
            $this->booking = $booking;
        }

        //GETTERS
        public function getId(){
            return $this->idChecker;
        }   
        public function getRefCode(){
            return $this->refCode;
        }
        public function getEmissionDate(){
            return $this->emisionD;
        }
        public function getCloseDate(){
            return $this->closeD;
        }
        public function getPayDate(){
            return $this->payD;
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
        public function setRefCode($refCode){
            $this->refCode = $refCode;
        }
        public function setEmissionDate($emisionD){
            $this->emisionD = $emisionD;
        }
        public function setCloseDate($closeD){  
            $this->closeD = $closeD;
        }
        public function setPayD($payD){
            $this->payD = $payD;
        }
        public function setFinalPrice($finalPrice){
            $this->finalPrice = $finalPrice;
        }
        public function setBooking($booking){
            $this->booking = $booking;
        }
    }
?>