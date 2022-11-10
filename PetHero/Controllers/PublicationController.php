<?php
namespace Controllers;
use \DAO\ImgPublicDAO as ImgPublicDAO;
use \DAO\PublicationDAO as PublicationDAO;
use \DAO\ReviewDAO as ReviewDAO;
use \Model\ImgPublic as ImgPublic;
use \Model\Publication as Publication;
use \Model\User as User;
use \Model\Review as Review;
use \Controllers\HomeController as HomeController;

    class PublicationController{
        private $publicDAO;
        private $reviewDAO;
        private $homeController;

        public function __construct(){
            $this->publicDAO = new ImgPublicDAO();
            $this->publicationDAO = new PublicationDAO();
            $this->reviewDAO = new ReviewDAO();
            $this->homeController = new HomeController();
        }

        public function Add($title,$description,$openD,$closeD,$remuneration,$images){
            ///FALTA PROCESAR IMAGENES

            $public = new Publication();
            $user = new User();
            $user->setUsername("marsexpress");
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
//PARA OBTENER LOS VALORES DE TMP_NAME
            foreach($images as $k1=> $v1){
                foreach($v1 as $k2 => $v2){
                    if(strcmp($k1,"tmp_name") == 0){
                        echo $images[$k1][$k2];
                    }
                }
            }
  */
            $this->publicDAO->NewPublication($imgPublic,$images);
            $this->homeController->ViewKeeperPanel("Publicacion creada exitosamente!");

        }

        public function ViewPublication($idPublic){
            $public = new Publication();
            $public = $this->publicationDAO->Get($idPublic);
            $reviewList = $this->reviewDAO->GetAllByPublic($idPublic);
            //var_dump($public);
            require_once(VIEWS_PATH."PublicInd.php");
        }
    }
?>