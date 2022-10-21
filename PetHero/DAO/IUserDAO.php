<?php
namespace DAO;

use \Model\User as User;

    interface IUserDAO{
        public function Add(User $user);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>