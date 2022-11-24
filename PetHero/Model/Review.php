<?php
    namespace Model;

    class Review {
        private $idReview;
        private $createD;
        private $commentary;
        private $stars;
        private Publication $publication;
        private User $user;

//CONSTRUCTORS
        public function __construct() {
        }

        public function __fromRequest($createD, $commentary, $stars,Publication $publication ,User $user) {
            $this->createD = $createD;
            $this->commentary = $commentary;
            $this->stars = $stars;
            $this->publication = $publication;
            $this->user = $user;
        }
        public function __fromDB($idReview, $createD, $commentary, $stars,Publication $publication ,User $user){
            $this->idReview = $idReview;
            $this->createD = $createD;
            $this->commentary = $commentary;
            $this->stars = $stars;
            $this->publication = $publication;
            $this->user = $user;
        }

//GETTER & SETTERS
        public function getId(){
                return $this->idReview;
        }
        public function setId($idReview){
                $this->idReview = $idReview;

                return $this;
        }

        public function getCreateD(){
                return $this->createD;
        }
        public function setCreateD($createD){
                $this->createD = $createD;
        }

        public function getCommentary(){
                return $this->commentary;
        }
        public function setCommentary($commentary){
                $this->commentary = $commentary;
        }

        public function getStars(){
                return $this->stars;
        }
        public function setStars($stars){
                $this->stars = $stars;
        }

        public function getPublication(): Publication{
                return $this->publication;
        }
        public function setPublication(Publication $publication){
                $this->publication = $publication;
        }

        public function getUser(): User {
                return $this->user;
        }
        public function setUser(User $user){
            $this->user = $user;
        }
    }
?>