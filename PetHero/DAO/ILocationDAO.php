<?php
namespace DAO;

use Model\Location as Location;

    interface ILocationDAO{
        public function Add(Location $location);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>