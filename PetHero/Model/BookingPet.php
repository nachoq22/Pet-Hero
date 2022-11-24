<?php
namespace Model;
use \Model\Booking as Booking;
use \Model\Pet as Pet;

    class BookingPet{
        private $idBP;
        private Booking $booking;
        private Pet $pet;

        public function __construct(){
            $this->booking = new Booking();
            $this->pet = new Pet();
        }
        
        public function __fromRequest(Booking $booking, Pet $pet){
            $this->booking = $booking;
            $this->pet = $pet;
        }

        public function __fromDB($idBP, Booking $booking,  Pet $pet){
            $this->idBP = $idBP;
            $this->booking = $booking;
            $this->pet = $pet;
        }

//SETTERS
        public function setId($idBP){
            $this->idBP = $idBP;
        }
        public function setBooking($booking){
            $this->booking = $booking;
        }
        public function setPet($pet){
            $this->pet = $pet;
        }
        
//GETTERS
        public function getId(){
            return $this->idBP;
        }
        public function getBooking(){
            return $this->booking;
        }
        public function getPet(){
            return $this->pet;
        }
    }
?>