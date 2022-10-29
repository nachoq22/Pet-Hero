<?php
namespace DAO;

use \Model\User as User;

    interface IUserDAO{
        public function Register(User $user);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>