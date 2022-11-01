<?php
namespace Model;
use \Model\User as User;

    class Keeper{
        private $idKeeper;
        private User $user;

//CONSTRUCTORS
        function __fromDB($idKeeper,User $user){
            $this->idKeeper = $idKeeper;
            $this->user = $user;
        } 
    
        function __construct(){} 

        function __fromRequest(User $user){
            $this->user = $user;
        } 

//GETTER & SERTTER
        public function getId(){
            return $this->idKeeper;
        }
        public function setId($idKeeper){
            $this->idKeeper = $idKeeper;
        }

        public function getUser(): User{
            return $this->user;
        }
        public function setUser(User $user){
            $this->user = $user;
        }
    }
?>