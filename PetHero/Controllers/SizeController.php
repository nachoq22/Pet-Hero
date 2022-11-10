<?php
namespace Controllers;

use \DAO\SizeDao;
use \Model\Size as Size;

    class SizeController{
        private $sizeDAO;

        public function __construct(){
            $this->sizeDAO = new SizeDao();
        }

        public function showListView(){
            $sizeList=$this->sizeDAO->GetAll();
        }

        public function Add($name){
            $size = new Size();
            $size->__fromRequest($name);
            $this->sizeDAO->Add($size);
            $sizeList=$this->sizeDAO->GetAll();
            require_once(VIEWS_PATH."home.php");
        } 
    }
?>
