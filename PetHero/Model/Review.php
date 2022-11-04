<?php
    namespace Model;

    class Review {
        private $idReview;
        private $date;
        private $commentary;
        private $stars;
        private User $user;
        private Publication $publication;

        
        //CONSTRUCTORS
        public function __construct() {
        }

        public function __fromRequest($date, $commentary, $stars, User $user, Publication $publication) {
            $this->date = $date;
            $this->commentary = $commentary;
            $this->stars = $stars;
            $this->user = $user;
            $this->publication = $publication;
        }
        public function __fromDB($id, $date, $commentary, $stars, User $user, Publication $publication){
            $this->id = $id;
            $this->date = $date;
            $this->commentary = $commentary;
            $this->stars = $stars;
            $this->user = $user;
            $this->publication = $publication;
        }

        //GETTER & SERTTER
        public function getId() {
            return $this->id;
        }
        public function getDate() {
            return $this->date;
        }
        public function getcommentary() {
            return $this->commentary;
        }
        public function getStars() {
            return $this->stars;
        }
        public function getUser() {
            return $this->user;
        }
        public function getPublication() {
            return $this->publication;
        }
        public function setId() {
            return $this->id;
        }
        public function setDate() {
            return $this->date;
        }
        public function setcommentary() {
            return $this->commentary;
        }
        public function setStars() {
            return $this->stars;   
        }
        public function setUser() {
            return $this->user;
        }
        public function setPublication() {
            return $this->publication;
        }

    }
?>