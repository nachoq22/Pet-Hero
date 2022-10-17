<?php 
namespace Model;
    class Location{
        private $id;
        private $adress;
        private $neighborhood;
        private $city;
        private $province;
        private $country;

        public function getId(){
                return $this->id;
        }
        public function setId($id){
                $this->id = $id;
        return $this;
        }

        public function getAdress(){
                return $this->adress;
        }
        public function setAdress($adress){
                $this->adress = $adress;
        return $this;
        }

        public function getNeighborhood(){
                return $this->neighborhood;
        }
        public function setNeighborhood($neighborhood){
                $this->neighborhood = $neighborhood;
        return $this;
        }

        public function getCity(){
                return $this->city;
        }
        public function setCity($city){
                $this->city = $city;
        return $this;
        }

        public function getProvince(){
                return $this->province;
        }
        public function setProvince($province){
                $this->province = $province;
        return $this;
        }

        public function getCountry(){
                return $this->country;
        }
        public function setCountry($country){
                $this->country = $country;
        return $this;
        }

        function __fromDB($id,$adress,$neighborhood,$city,$province,$country){
            $this->id = $id;
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
    }
?>