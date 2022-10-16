<?php 
namespace Model;
    class Location{
        private $id;
        private $adress;
        private $neighborhood;
        private $city;
        private $province;
        private $country;

        /**
         * Get the value of id
         */
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         */
        public function setId($id): self
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of adress
         */
        public function getAdress()
        {
                return $this->adress;
        }

        /**
         * Set the value of adress
         */
        public function setAdress($adress): self
        {
                $this->adress = $adress;

                return $this;
        }

        /**
         * Get the value of neighborhood
         */
        public function getNeighborhood()
        {
                return $this->neighborhood;
        }

        /**
         * Set the value of neighborhood
         */
        public function setNeighborhood($neighborhood): self
        {
                $this->neighborhood = $neighborhood;

                return $this;
        }

        /**
         * Get the value of city
         */
        public function getCity()
        {
                return $this->city;
        }

        /**
         * Set the value of city
         */
        public function setCity($city): self
        {
                $this->city = $city;

                return $this;
        }

        /**
         * Get the value of province
         */
        public function getProvince()
        {
                return $this->province;
        }

        /**
         * Set the value of province
         */
        public function setProvince($province): self
        {
                $this->province = $province;

                return $this;
        }

        /**
         * Get the value of country
         */
        public function getCountry()
        {
                return $this->country;
        }

        /**
         * Set the value of country
         */
        public function setCountry($country): self
        {
                $this->country = $country;

                return $this;
        }

        function __fromDB($id,$adress,$neighborhood,$city,$province,$country)
        {
            $this->id = $id;
            $this->adress = $adress;
            $this->neighborhood = $neighborhood;
            $this->city = $city;
            $this->province = $province;
            $this->country = $country;
        } 

        function __construct(){} 

        function __fromRequest($adress,$neighborhood,$city,$province,$country)
        {
            $this->adress = $adress;
            $this->neighborhood = $neighborhood;
            $this->city = $city;
            $this->province = $province;
            $this->country = $country;
        } 
    }



?>