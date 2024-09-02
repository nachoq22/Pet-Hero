<?php
namespace Model;

use \Model\Publication as Publication;
use \Model\User as User;

    class Booking {
        private $idBook;
        private $startD;
        private $finishD;
        private $bookState;
        private $payCode;
        private Publication $publication;
        private User $user;


//? CONSTRUCTORS
        public function __construct(){}

        public function __fromRequest($startD, $finishD, $bookState, Publication $publication, User $user){
            $this->startD = $startD;
            $this->finishD = $finishD;
            $this->bookState = $bookState;
            $this->publication = $publication;
            $this->user = $user;
        }

        public function __fromDB($idBook, $startD, $finishD, $bookState, $payCode, Publication $publication, User $user){
            $this->idBook = $idBook;
            $this->startD = $startD;
            $this->finishD = $finishD;
            $this->bookState = $bookState;
            $this->payCode = $payCode;
            $this->publication = $publication;
            $this->user = $user;
        }

        public function __fromDBWithoutPC($idBook, $startD, $finishD, $bookState, Publication $publication, User $user){
            $this->idBook = $idBook;
            $this->startD = $startD;
            $this->finishD = $finishD;
            $this->bookState = $bookState;
            $this->publication = $publication;
            $this->user = $user;
        }

//? GETTERS & SETTERS
        public function getId(){
            return $this->idBook;
        }
        public function setId($idBook){
                $this->idBook = $idBook;
        }

        public function getStartD(){
            return $this->startD;
        }
        public function setStartD($startD){
                $this->startD = $startD;
        }

        public function getFinishD(){
            return $this->finishD;
        }
        public function setFinishD($finishD){
                $this->finishD = $finishD;
        }

        public function getBookState(){
            return $this->bookState;
        }
        public function setBookState($bookState){
                $this->bookState = $bookState;
        }

        public function getPayCode(){
            return $this->payCode;
        }

        public function setPayCode($payCode){
                $this->payCode = $payCode;
        }

        public function getPublication(): Publication{
            return $this->publication;
        }
        public function setPublication(Publication $publication){
                $this->publication = $publication;
        }

        public function getUser(): User{
            return $this->user;
        }
        public function setUser(User $user){
                $this->user = $user;
        }
    }
?>