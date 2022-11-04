<?php
    namespace Model;

    class Booking {
        private $idBooking;
        private $openDate;
        private $closeDate;
        private $payState;
        private $payCode;
        private Publication $publication;
        private User $user;


        //CONSTRUCTORS
        public function __construct(){}

        public function __fromRequest($openDate, $closeDate, $payState, $payCode, Publication $publication, User $user){
            $this->openDate = $openDate;
            $this->closeDate = $closeDate;
            $this->payState = $payState;
            $this->payCode = $payCode;
            $this->publication = $publication;
            $this->user = $user;
        }

        public function __fromBD($idBooking, $openDate, $closeDate, $payState, $payCode, Publication $publication, User $user)
        {
            $this->idBooking = $idBooking;
            $this->openDate = $openDate;
            $this->closeDate = $closeDate;
            $this->payState = $payState;
            $this->payCode = $payCode;
            $this->publication = $publication;
            $this->user = $user;
        }
    


        //GETTER & SERTTER
        public function getidBooking()
        {
            return $this->idBooking;
        }
        public function getOpenDate()
        {
            return $this->openDate;
        }
        public function getCloseDate()
        {
            return $this->closeDate;
        }
        public function getPayState()
        {
            return $this->payState;
        }
        public function getPayCode()
        {
            return $this->payCode;
        }
        public function getPublication()
        {
            return $this->publication;
        }
        public function getUser()
        {
            return $this->user;
        }

    }

?>