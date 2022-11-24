<?php
namespace Controllers;

use \DAO\ReviewDAO as ReviewDAO;
use \Model\Review as Review;
use \Model\Publication as Publication;
use \Model\User as User;
use \Controllers\PublicationController as PublicationController;

    class ReviewController{
        private $reviewDAO;
        private $publicationController;

        public function __construct(){
            $this->reviewDAO = new ReviewDAO();
            $this->publicationController = new PublicationController();
        }

        //FUNCION PARA AGREGAR UNA NUEVA REVIEW//
        public function Add($idPublic,$stars,$commentary){
            $public = new Publication();
                $public->setId($idPublic);
            $user = new User();
                $user->setUsername("venus");
            $review = new Review();
                $review->__fromRequest(DATE("Y-m-d"),$commentary,$stars,$public,$user);
            $message= $this->reviewDAO->NewReview($review);
            $this->publicationController->ViewPublication($idPublic, $message);
        }
    }
?>