<?php
namespace Model;

    class PetType{
        private $idType;
        private $name;

//CONSTRUCTORS
        function __fromDB($idType,$name){
            $this->idType = $idType;
            $this->name = $name;
        } 

        function __construct(){} 

        function __fromRequest($name){
            $this->name = $name;
        } 
        
//GETTER & SERTTER
        public function getId(){
            return $this->idType;
        }
        public function setId($idType){
            $this->idType = $idType;
        }

        public function getName(){
            return $this->name;
        }
        public function setName($name){
            $this->name = $name;
        }
    }
?>