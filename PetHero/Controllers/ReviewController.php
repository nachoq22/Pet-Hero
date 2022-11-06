<?php
namespace Controllers;

use \DAO\ReviewDAO as ReviewDAO;
use \Model\Review as Review;
use \Model\Publication as Publication;
use \Model\User as User;

    class ReviewController{
        private $reviewDAO;

        public function __construct(){
            $this->reviewDAO = new ReviewDAO();
        }

        public function Add($idPublic,$commentary,$stars){
            $public = new Publication();
                $public->setId($idPublic);
            $user = new User();
                $user->setUsername("venus");
            $review = new Review();
                $review->__fromRequest(DATE("Y-m-d"),$commentary,$stars,$public,$user);
            $this->reviewDAO->NewReview($review);

        }
    }
?>