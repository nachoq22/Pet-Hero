<?php
namespace Controllers;

use \DAO\SizeDao;
use \Model\Size as Size;

    class SizeController
    {
        private $sizeDAO;

        public function __construct(){
            $this->sizeDAO = new SizeDao();
        }

        public function showListView(){
            $sizeList=$this->sizeDAO->GetAll();
        }

        public function Add($name)
        {
            //var_dump($adress);
            
            $size = new Size();

            $size->__fromRequest($name);
            /*$location->setAdress($adress);
            $location->setNeighborhood($neighborhood);
            $location->setCity($city);
            $location->setProvince($province);
            $location->setCountry($country);*/
            $this->sizeDAO->Add($size);
            $sizeList=$this->sizeDAO->GetAll();
            require_once(VIEWS_PATH."SizeList.php");
        } 
    }
?>
