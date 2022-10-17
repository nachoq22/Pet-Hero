<?php
namespace Inter;

use \Model\Owner as Owner;
use Model\User as User;

    interface IOwnerDAO{
        public function Add(Owner $owner);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>