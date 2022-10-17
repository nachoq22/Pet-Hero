<?php
    namespace Models;

    class Location
    {
        private $id;
        private $adress;
        private $neighborhood;
        private $city;
        private $province;
        private $country;

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getAdress()
        {
            return $this->adress;
        }
        
        public function setAdress($adress)
        {
            $this->adress = $adress;
        }

        public function setNeighborhood()
        {
            return $this->neighborhood;
        }

        public function getNeighborhood($neighborhood)
        {
            $this->neighborhood = $neighborhood;
        }

        public function getCity()
        {
            return $this->city;
        }

        public function setCity($city)
        {
            $this->city = $city;
        }

        public function getProvince()
        {
            return $this->province;
        }

        public function setProvince($province)
        {
            $this->province = $province;
        }

        public function getCountry()
        {
            return $this->country;
        }

        public function setCountry($country)
        {
            $this->country = $country;
        }


    }



?>