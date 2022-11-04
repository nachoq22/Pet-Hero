<?php
namespace DAO;
    
 use \Model\Review as Review;

    interface IReviewDAO{
        public function Add(Review $review);
        public function Get($idReview);
        public function GetAll();
        public function Delete($idReview);
    }
?>