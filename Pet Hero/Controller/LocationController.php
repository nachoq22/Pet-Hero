<?php
namespace Controller;

use DAO\LocationDAO;
use \Inter\ILocationDAO as ILocationDAO;
use \Model\Location as Location;

    class LocationController{
       //private $IlocationDAO;
       private $locationDAO;

        public function __construct(){
            $this->locationDAO = new LocationDAO();
        }

        

    }






?>