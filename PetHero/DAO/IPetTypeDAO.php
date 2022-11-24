<?php
namespace DAO;

use Model\PetType as PetType;

    interface IPetTypeDAO{
        public function Add(PetType $type);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>