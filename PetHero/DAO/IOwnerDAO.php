<?php
namespace DAO;

use \Model\Owner as Owner;

    interface IOwnerDAO{
        public function GetAll();
        public function Get($id);
        public function Register(Owner $owner);
        public function Delete($id);
    }
?>