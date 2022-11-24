<?php
namespace DAO;

use Model\PersonalData as PersonalData;

    interface IPersonalDataDAO{
        /*public function Add(PersonalData $data);*/
        public function AddRet(PersonalData $data);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>