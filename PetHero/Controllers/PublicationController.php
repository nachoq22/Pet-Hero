<?php
namespace Controllers;
use \DAO\ImgPublicDAO as ImgPublicDAO;
use \DAO\ReviewDAO as ReviewDAO;
use \DAO\BookingDAO as BookingDAO;
use \Model\ImgPublic as ImgPublic;
use \Model\Publication as Publication;
use \Model\User as User;
use \Model\Review as Review;
use \Controllers\HomeController as HomeController;
use \Controllers\PetController as PetController;

    class PublicationController{
        private $publicDAO;
        private $reviewDAO;
        private $homeController;
        private $petController;
        private $bookingDAO;

        public function __construct(){
            $this->publicDAO = new ImgPublicDAO();
            $this->reviewDAO = new ReviewDAO();
            $this->homeController = new HomeController();
            $this->petController = new PetController();
            $this->bookingDAO = new BookingDAO();
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
            $this->homeController->ViewKeeperPanel("Publicacion creada exitosamente!");

        }

        public function ViewPublication($idPublic, $message=""){
            $public = new Publication();
            $public->setId($idPublic);
            $imgPublic = new ImgPublic();
            $imgPublic->setPublication($public);
            $public = $this->publicDAO->GetPublication($imgPublic);
            $reviewList = $this->reviewDAO->GetAllByPublic($public->getid());
            $canReview = $this->bookingDAO->CheckBookDone(1, $idPublic);
            $ImgList = $this->publicDAO->GetAllByPublic($public->getid());
            require_once(VIEWS_PATH."PublicInd.php");
        }

        public function ValidateDateFP($idPublic, $startD, $finishD){
            if($startD<$finishD){
                if($this->publicDAO->ValidateOnWeek($startD)==1){
                    if($this->publicDAO->ValidateDP($startD, $finishD, $idPublic) == 1){
                        $this->petController->GetPetsByReservation($idPublic, $startD, $finishD);
                    }else{
                        $this->ViewPublication($idPublic, "Las fechas ingresadas no entran en el rango de establecidas por el Keeper");
                    }
                }else{
                    $this->ViewPublication($idPublic, "Las reservas deben tener 1 semana de aniticipacion");
                }
            }else{
                $this->ViewPublication($idPublic, "La fecha de finalizacion debe ser despues de la de inicio");}
        }

    }
?>