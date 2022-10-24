<?php
namespace DAO;

use Model\Pet as Pet;

    interface IPetDAO{
        public function GetAll();
        public function Get($id);

        public function Add(Pet $pet);
        public function Delete($id);
    }
?>