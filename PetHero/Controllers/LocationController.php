<?php
namespace Controllers;

use \DAO\LocationDAO;
use \Model\Location as Location;

    class LocationController 
    {
        private $locationDAO;
        private $homeController;
        public function __construct(){
            $this->locationDAO = new LocationDAO();
            $this->homeController = new HomeController();
        }

        public function showListView(){
            $locationList=$this->locationDAO->GetAll();
        }

        public function Add($adress, $neighborhood, $city, $province, $country)
        {
            //var_dump($adress);
            
            $location = new Location();

            $location->__fromRequest($adress, $neighborhood, $city, $province, $country);
            /*$location->setAdress($adress);
            $location->setNeighborhood($neighborhood);
            $location->setCity($city);
            $location->setProvince($province);
            $location->setCountry($country);*/
            $this->locationDAO->AddRet($location);
            $this->homeController->Index();
        } 
    }
?>