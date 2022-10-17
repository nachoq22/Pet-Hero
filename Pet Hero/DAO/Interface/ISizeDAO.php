<?php
namespace Inter;

use Model\Size as Size;

    interface ISizeDAO{
        public function Add(Size $size);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
?>