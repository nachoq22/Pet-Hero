<?php
namespace DAO;

use \Model\Checker as Checker;
    interface ICheckerDAO{
        public function Add(Checker $Checker);
        public function Get($idChecker);
        public function GetByBook($idBook);
        public function GetAll();
        public function Delete($idChecker);
    }
?>