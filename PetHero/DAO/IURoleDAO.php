<?php
namespace DAO;

use \Model\UserRole as UserRole;
use \Model\User as User;

    interface IURoleDAO{
        public function GetAll();
        public function Get($id);
        //public function GetByUser($idUser);
        public function IsKeeper(UserRole $ur);
        public function Register(UserRole $ur);
        public function UtoKeeper(UserRole $ur);
        public function Delete($idRole);
    }
?>