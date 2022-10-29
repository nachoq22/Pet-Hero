<?php
namespace DAO;

use \Model\User as User;

    interface IUserDAO{
        public function GetAll();
        public function Get($id);
        public function Login(User $user);
        public function AddRet(User $user);
        public function updateToKeeper(User $user);
        public function Delete($id);
    }
?>