<?php
namespace Inter;

use Model\PersonalData as PersonalData;

    interface IPersonalData{
        public function Add(PersonalData $data);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>