<?php
namespace Model;

use \Model\Location as Location;

    class PersonalData{
        private $idData;
        private $name;
        private $surname;
        private $sex;
        private $dni;
        private Location $location;

//CONSTRUCTORS
        function __fromDB($idData,$name,$surname,$sex,$dni,Location $location){
            $this->idData = $idData;
            $this->name = $name;
            $this->surname = $surname;
            $this->sex = $sex;
            $this->dni = $dni;
            $this->location = $location;
        } 
    
        function __construct(){
            $this->location = new Location();
        } 

        function __fromRequest($name,$surname,$sex,$dni,Location $location){
            $this->name = $name;
            $this->surname = $surname;
            $this->sex = $sex;
            $this->dni = $dni;
            $this->location = $location;
        } 

//GETTER & SERTTER
        public function getId(){
            return $this->idData;
        }
        public function setId($idData){
            $this->idData = $idData;
        }

        public function getName(){
            return $this->name;
        }
        public function setName($name){
            $this->name = $name;
        }

        public function getSurname(){
            return $this->surname;
        }
        public function setSurname($surname){
            $this->surname = $surname;
        }

        public function getSex(){
            return $this->sex;
        }
        public function setSex($sex){
            $this->sex = $sex;
        }

        public function getDni(){
            return $this->dni;
        }
        public function setDni($dni){
            $this->dni = $dni;
        }

        public function getLocation(): Location{
            return $this->location;
        }
        public function setLocation(Location $location){
            $this->location = $location;
        }
    }
?>