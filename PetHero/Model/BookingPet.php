<?php
    namespace Model;

    class BookingPet {
        private $idBookingPet;
        private Booking $booking;
        private Pet $pet;

        public function __construct(){}
        
        public function __fromRequest(Booking $booking, Pet $pet){
            $this->booking = $booking;
            $this->pet = $pet;
        }

        public function __fromBD($id, Booking $booking,  Pet $pet){
            $this->id = $id;
            $this->booking = $booking;
            $this->pet = $pet;
        }

        //SETTERS
        public function setId($id){
            $this->id = $id;
        }
        public function setBooking($booking){
            $this->booking = $booking;
        }
        public function setPet($pet){
            $this->pet = $pet;
        }
        //GETTERS
        public function getId(){
            return $this->id;
        }
        public function getBooking(){
            return $this->booking;
        }
        public function getPet(){
            return $this->pet;
        }
    }
?>