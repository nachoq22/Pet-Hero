<?php
namespace DAO;

use \Model\UserRole as UserRole;

    interface IURDAO{
        public function GetAll();
        public function Get($id);
        public function GetbyUser($idUser);
        public function IsKeeper(UserRole $ur);
        public function Register(UserRole $ur);
        public function UtoKeeper(UserRole $ur);
        public function Delete($idRole);
    }
?>