<?php
namespace DAO;

use \Model\Owner as Owner;

    interface IOwnerDAO{
        public function Add(Owner $owner);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>