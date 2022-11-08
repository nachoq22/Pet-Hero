<?php
namespace Controllers;
use \DAO\PublicationDAO as PublicationDAO;
use \DAO\ReviewDAO as ReviewDAO;
use \Model\Publication as Publication;
use \Model\User as User;
use \Model\Review as Review;

    class PublicationController{
        private $publicDAO;
        private $reviewDAO;

        public function __construct(){
            $this->publicDAO = new PublicationDAO();
            $this->reviewDAO = new ReviewDAO();
        }

        public function Add($title,$description,$openD,$closeD,$remuneration,$images){
            ///FALTA PROCESAR IMAGENES
            $public = new Publication();
            $user = new User();
            $user->setUsername("marsexpress");
            $public->__fromRequest($openD, $closeD, $title, $description,0, $remuneration,$user);
            $this->publicDAO->NewPublication($public);
        }

        public function ViewPublication($idPublic){
            $public = new Publication();
            $public = $this->publicDAO->Get($idPublic);
            $reviewList = $this->reviewDAO->GetAllByPublic($idPublic);
            //var_dump($public);
            require_once(VIEWS_PATH."PublicInd.php");
        }
    }
?>