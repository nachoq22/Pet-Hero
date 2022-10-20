<?php
namespace Controllers;

use \DAO\LocationDAO;
use \Model\Location as Location;

    class LocationController{
        private $locationDAO;

        public function __construct(){
            $this->locationDAO = new LocationDAO();
        }

        public function showListView(){
        }

        public function Add($adress, $neighborhood, $city, $province, $country)
        {
            //var_dump($adress);
            $location = new Location();
            $location->setAdress($adress);
            $location->setNeighborhood($neighborhood);
            $location->setCity($city);
            $location->setProvince($province);
            $location->setCountry($country);
            $this->locationDAO->Add($location);
            //require_once(VIEWS_PATH."prueba.php");
        } 
    }
?>
