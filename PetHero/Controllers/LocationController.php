<?php
namespace Controllers;

use \DAO\LocationDAO as LocationDAO;
use \Model\Location as Location;

    class LocationController
    {
        private $locationDAO;

        public function __construct(){
            $this->locationDAO = new LocationDAO();
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
            $this->locationDAO->Add($location);
            $locationList=$this->locationDAO->GetAll();
            require_once(VIEWS_PATH."Locationlist.php");
        } 
    }
?>
