<?php
namespace Model;

    class Size{
        private $idSize;
        private $name;

//CONSTRUCTORS
        function __fromDB($idSize,$name){
            $this->idSize = $idSize;
            $this->name = $name;
        } 
    
        function __construct(){} 

        function __fromRequest($name){
            $this->name = $name;
        } 

//GETTER & SERTTER
        public function getId(){
                return $this->idSize;
        }

        public function setId($idSize){
                $this->idSize = $idSize;
        }

        public function getName(){
            return $this->name;
        }
        public function setName($name){
            $this->name = $name;
        }
    }
?>