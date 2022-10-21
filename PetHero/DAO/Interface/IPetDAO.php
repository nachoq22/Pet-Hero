<?php
namespace Inter;

use Model\Pet as Pet;

    interface IPetDAO{
        public function Add(Pet $pet);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>