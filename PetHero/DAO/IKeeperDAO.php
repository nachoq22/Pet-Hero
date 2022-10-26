<?php
namespace DAO;

use \Model\Keeper as Keeper;

  interface IKeeperDAO{
      public function Add(Keeper $keeper);
      public function GetAll();
      public function Get($id);
      public function Delete($id);
  }
?>
