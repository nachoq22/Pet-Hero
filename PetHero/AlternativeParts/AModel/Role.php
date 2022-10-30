<?php
namespace Model;

    class Role {
        private $idRole;
        private $name;
        private $description;

//CONSTRUCTORS        
        public function __fromDB($idRole,$name,$description){
            $this->idRole = $idRole;
            $this->name = $name;
            $this->description = $description;
        }
        public function __construct(){}
        public function __fromRequest($name,$description){
            $this->name = $name;
            $this->description = $description;
        }

//GETTERS & SETTERS
        public function getIdRole(){
            return $this->idRole;
        }
        public function setIdRole($idRole){
            $this->idRole = $idRole;
        }

        public function getName(){
            return $this->name;
        }
        public function setName($name){
            $this->name = $name;
        }

        public function getDescription(){
                return $this->description;
        }
        public function setDescription($description){
                $this->description = $description;
        }
    } 
?>