<?php 
namespace Model;
    class Location{
        private $idLocation;
        private $adress;
        private $neighborhood;
        private $city;
        private $province;
        private $country;

//CONSTRUCTORS
        function __fromDB($id,$adress,$neighborhood,$city,$province,$country){
                $this->idLocation = $id;
                $this->adress = $adress;
                $this->neighborhood = $neighborhood;
                $this->city = $city;
                $this->province = $province;
                $this->country = $country;
            } 
        
        function __construct(){} 

        function __fromRequest($adress,$neighborhood,$city,$province,$country){
            $this->adress = $adress;
            $this->neighborhood = $neighborhood;
            $this->city = $city;
            $this->province = $province;
            $this->country = $country;
        } 

//GETTER & SERTTER
        public function getId(){
                return $this->idLocation;
        }
        public function setId($id){
                $this->idLocation = $id;
        }

        public function getAdress(){
                return $this->adress;
        }
        public function setAdress($adress){
                $this->adress = $adress;
        }

        public function getNeighborhood(){
                return $this->neighborhood;
        }
        public function setNeighborhood($neighborhood){
                $this->neighborhood = $neighborhood;
        }

        public function getCity(){
                return $this->city;
        }
        public function setCity($city){
                $this->city = $city;
        }

        public function getProvince(){
                return $this->province;
        }
        public function setProvince($province){
                $this->province = $province;
        }

        public function getCountry(){
                return $this->country;
        }
        public function setCountry($country){
                $this->country = $country;
        }
    }
?>