<?php
namespace DAO;

use Model\Location as Location;

    interface ILocationDAO{
        public function AddRet(Location $location);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>