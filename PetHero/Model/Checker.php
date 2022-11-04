<?php
    namespace Model;

    class Checker{
        private $id;
        private $emisionDate;
        private $finishDate;
        private $finalPrice;
        private Booking $booking;

        //CONSTRUCTORS
        public function __construct(){}

        public function __fromRequest($emisionDate, $finishDate, $finalPrice, Booking $booking)
        {
            $this->emisionDate = $emisionDate;
            $this->finishDate = $finishDate;
            $this->finalPrice = $finalPrice;
            $this->booking = $booking;
        }
        public function __fromDB($id, $emisionDate, $finishDate, $finalPrice, Booking $booking)
        {
            $this->id = $id;
            $this->emisionDate = $emisionDate;
            $this->finishDate = $finishDate;
            $this->finalPrice = $finalPrice;
        }

        //GETTERS
        public function getId()
        {
            return $this->id;
        }   
        public function getEmissionDate()
        {
            return $this->emisionDate;
        }
        public function getFinishDate()
        {
            return $this->finishDate;
        }
        public function getFinalPrice()
        {
            return $this->finalPrice;
        }
        public function getBooking()
        {
            return $this->booking;
        }

        //SETTERS
        public function setId($id)
        {
            $this->id = $id;
        }
        public function setEmissionDate($emisionDate)
        {
            $this->emisionDate = $emisionDate;
        }
        public function setFinishDate($finishDate)
        {  
            $this->finishDate = $finishDate;
        }
        public function setFinalPrice($finalPrice)
        {
            $this->finalprice = $finalPrice;
        }
        public function setBooking($booking)
        {
            $this->booking = $booking;
        }
    


    }

?>