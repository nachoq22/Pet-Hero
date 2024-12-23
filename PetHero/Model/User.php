<?php
namespace Model;
use \Model\PersonalData as PersonalData;

    class User{
        private $idUser;
        private $username;
        private $password;
        private $email;
        private PersonalData $data;

//CONSTRUCTORS
        function __fromDBnoKeeper($idUser,$username,$password,$email){
            $this->idUser = $idUser;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
        } 

        function __fromDBisKeeper($idUser,$username,$password,$email,PersonalData $data){
            $this->idUser = $idUser;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->data = $data;
        } 
    
        function __construct(){
            $this->data =  new PersonalData();
        } 

        function __fromRequest($username,$password,$email,PersonalData $data){
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->data = $data;
        } 

        function __fromRegister($username,$password,$email){
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
        } 

        function __fromLogin($username,$password){
            $this->username = $username;
            $this->password = $password;
        } 
    
//GETTER & SETTER
        public function getId(){
            return $this->idUser;
        }
        public function setId($idUser){
            $this->idUser = $idUser;
        }

        public function getUsername(){
            return $this->username;
        }
        public function setUsername($username){
            $this->username = $username;
        }

        public function getPassword(){
            return $this->password;
        }
        public function setPassword($password){
            $this->password = $password;
        }

        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
            $this->email = $email;
        }

        public function getData(): PersonalData{
            return $this->data;
        }
        public function setData(PersonalData $data){
            $this->data = $data;
        }

    }
?>