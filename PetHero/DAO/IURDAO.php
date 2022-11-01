<?php
namespace DAO;

use \Model\UserRole as UserRole;
use \Model\User as User;

    interface IURDAO{
        public function GetAll();
        public function Get($id);
        public function GetbyUser($idUser);
        public function IsKeeper(UserRole $ur);
        public function Register(User $ur);
        public function UtoKeeper(UserRole $ur);
        public function Delete($idRole);
    }
?>