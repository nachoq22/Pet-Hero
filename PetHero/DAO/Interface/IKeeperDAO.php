<?php
namespace Inter;

use Model\Keeper as Keeper;
use Model\User as User;

  interface IKeeperDAO{
      public function Add(Keeper $keeper);
      public function GetAll();
      public function Get($id);
      public function Delete($id);
  }
?>
