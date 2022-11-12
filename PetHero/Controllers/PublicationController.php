<?php
namespace Controllers;
use \DAO\ImgPublicDAO as ImgPublicDAO;
use \Model\ImgPublic as ImgPublic;
use \Model\Publication as Publication;
use \Model\User as User;

    class PublicationController{
        private $publicDAO;

        public function __construct(){
            $this->publicDAO = new ImgPublicDAO();
        }

        public function Add($title,$description,$openD,$closeD,$remuneration,$images){
                $public = new Publication();
                $user = new User();
                $user->setUsername("sculpordwarf");
                $public->__fromRequest($openD, $closeD, $title, $description,0, $remuneration,$user);
                $imgPublic = new ImgPublic();
                $imgPublic->setPublication($public);
//PARA VER COMPOSISION GENERAL
/*
            echo "ESTO ES LO QUE TIENE: <br>";          
                print_r($images);
                echo "<br>"; 
                $n = 0;
                $cant = COUNT($images["tmp_name"]);
 PARA OBTENER LOS VALORES DE TMP_NAME        
            foreach($images as $k1=> $v1){
                foreach($v1 as $k2 => $v2){
                    if(strcmp($k1,"tmp_name") == 0){
                        echo $images[$k1][$k2];
                    }
                }
            }
  */          
            $this->publicDAO->NewPublication($imgPublic,$images);
        }
    }
?>