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

    public function Register($username,$password){
        require_once(VIEWS_PATH."home.php");
    }

    

    }
?>