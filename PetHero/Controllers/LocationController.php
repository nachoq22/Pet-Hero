<?php
namespace Controllers;

use \DAO\LocationDAO;
use \Model\Location as Location;

    class LocationController{
        private $locationDAO;
        private $homeController;
        public function __construct(){
            $this->locationDAO = new LocationDAO();
            $this->homeController = new HomeController();
        }

        public function showListView(){
            $locationList=$this->locationDAO->GetAll();
        }

        //AGREGAR UNA NUEVA UBICACION//
        public function Add($adress, $neighborhood, $city, $province, $country){
                $location = new Location();
                $location->__fromRequest($adress, $neighborhood, $city, $province, $country);
            $this->locationDAO->AddRet($location);
            $this->homeController->Index();
        } 
    }
?>