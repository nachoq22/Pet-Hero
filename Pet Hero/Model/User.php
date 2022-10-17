<?php
namespace Model;
use \Model\PersonalData as PersonalData;

    class User{
        private $idUser;
        private $name;
        private $surname;
        private $sex;
        private $dni;
        private PersonalData $data;

//CONSTRUCTORS
        function __fromDB($idUser,PersonalData $data){
            $this->idUser = $idUser;
            $this->data = $data;
        } 
    
        function __construct(){} 

        function __fromRequest(PersonalData $data){
            $this->data = $data;
        } 
    
//GETTER & SERTTER
        public function getId(){
            return $this->idUser;
        }
        public function setId($idUser){
            $this->idUser = $idUser;
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

        public function getData(): PersonalData{
            return $this->data;
        }
        public function setData(PersonalData $data){
                $this->data = $data;
        }
    }
?>