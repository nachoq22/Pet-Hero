<?php
namespace Model;

use  \Model\User as User;
use  \Model\Role as Role;

    class UserRole{
        private $idUserRole;
        private User $user;
        private Role $role;

//CONSTRUCTORS       
        public function __fromDB($idUserRole,User $user,Role $role){
            $this->idUserRole =$idUserRole;
            $this->user = $user;
            $this->role = $role;
        }

//GETTERS & SETTERS
        public function __construct(){}

        public function __fromRequest(User $user,Role $role){
            $this->user = $user;
            $this->role = $role;
        }


        public function getIdUserRole(){
            return $this->idUserRole;
        }
        public function setIdUserRole($idUserRole){
                $this->idUserRole = $idUserRole;
        }

        public function getUser(){
            return $this->user;
        }
        public function setUser(User $user){
                $this->user = $user;
        }


        public function getRole(): Role{
            return $this->role;
        }
        public function setRole(Role $role){
                $this->role = $role;
        }
    }
?>
