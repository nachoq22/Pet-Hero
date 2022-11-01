<?php
namespace DAO;

use \Model\Keeper as Keeper;

  interface IKeeperDAO{
      public function GetAll();
      public function Get($id);
      public function UpdateUserToKeeper(Keeper $keeper);
      public function Delete($id);
  }
?>
