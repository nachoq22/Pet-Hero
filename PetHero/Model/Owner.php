<?php
namespace Model;
use \Model\User as User;

    class Owner{
        private $idOwner;
        private User $user;


//CONSTRUCTORS
        function __fromDB($idOwner,User $user){
            $this->idOwner = $idOwner;
            $this->user = $user;
        } 
    
        function __construct(){} 

        function __fromRequest(User $user){
            $this->user = $user;
        } 

//GETTER & SERTTER
        public function getId(){
            return $this->idOwner;
        }
        public function setId($idOwner){
            $this->idOwner = $idOwner;
        }

        public function getUser(): User{
                return $this->user;
        }
        public function setUser(User $user){
            $this->user = $user;
        }
    }
?>