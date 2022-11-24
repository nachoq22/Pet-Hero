<?php
namespace DAO;
    
 use \Model\Review as Review;

    interface IReviewDAO{
        public function NewReview(Review $review);
        public function Get($idReview);
        public function GetAllByPublic($idPublic);
        public function GetAll();
        public function Delete($idReview);
    }
?>