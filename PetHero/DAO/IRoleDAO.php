<?php
namespace DAO;

use \Model\Role as Role;

    interface IRoleDAO{
        public function GetAll();
        public function Get($id);
        public function GetByName($name);
        public function Add(Role $role);
        public function Delete($idRole);
    }
?>