<?php
namespace DAO;

use Model\Pet as Pet;

    interface IPetDAO{
        public function GetAll();
        public function Get($id);
        public function RegisterPet(Pet $pet,$fileP,$fileNameP,$fileV,$fileNameV);
        public function Delete($id);
    }
?>