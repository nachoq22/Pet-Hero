<?php
    namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;
use \DAO\IReviewDAO as IReviewDAO;
use \DAO\PublicationDAO as PublicationDAO;
use \DAO\UserDAO as UserDAO;
use \Model\Review as Review;

    class ReviewDAO implements IReviewDAO{
        private $connection;
        private $tableName = 'Review';

        private $userDAO;
        private $publicDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->publicDAO = new PublicationDAO();
        }

        private function Add(Review $review){
            $query = "CALL Review_Add(?,?,?,?,?)";
            $parameters["createD"] = $review->getCreateD();
            $parameters["commentary"] = $review->getCommentary();
            $parameters["stars"] = $review->getStars();
            $parameters["idUser"] = $review->getUser()->getId();
            $parameters["idPublic"] = $review->getPublication()->getid();
            
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function NewReview(Review $review){
            $message = "Sucesful: Se ha publicado su review con exito!";
            try{
                $public = $this->publicDAO->Get($review->getPublication()->getid());
            $review->setPublication($public);
            $user = $this->userDAO->DGetByUsername($review->getUser()->getUsername());
            $review->setUser($user);
            $this->Add($review);
            }
            catch (Exception $e){
                $message="No se ha podido escribir la review, intente nuevamente";
            }
            $this->UpdatePopularity($public, $this->CalculateScore($public));
            return $message;
        }


        public function GetAll(){
            $reviewList = array();    

            $query = "CALL Review_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $review = new review();
                $review->__fromDB($row["idReview"],$row["createD"]
                                 ,$row["commentary"],$row["stars"]
                                 ,$this->publicDAO->Get($row["idPublic"])
                                 ,$this->userDAO->Get($row["idUser"]));
                array_push($reviewList,$review);
            }
            return $reviewList;
        }

        public function GetAllByPublic($idPublic){
            $reviewList = array();

            $query = "CALL Review_GetByPublic(?)";
            $parameters["idPublic"] = $idPublic;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $review = new Review();
                $review->__fromDB($row["idReview"],$row["createD"]
                ,$row["commentary"],$row["stars"]
                ,$this->publicDAO->Get($row["idPublic"])
                ,$this->userDAO->DGet($row["idUser"]));
                array_push($reviewList,$review);
            }
            return $reviewList;
        }
        
        public function Get($idReview){
            $review = null;
            $query = "CALL Review_GetById(?)";
            $parameters["idReview"] = $idReview;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $review = new Review();
    
                $review->__fromDB($row["idReview"],$row["createD"]
                                 ,$row["commentary"],$row["stars"]
                                 ,$this->publicDAO->Get($row["idPublic"])
                                 ,$this->userDAO->Get($row["idUser"]));
                }
            return $review;
        }

        public function Delete($idReview){
            $query = "CALL Review_Delete(?)";
            $parameters["idReview"] = $idReview;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        public function UpdatePopularity($public, $score){
            $query = "CALL Publication_UpdatePopularity(?,?)";
            $parameters["idPublic"] = $public->getid();
            $parameters["score"] = $score;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function CalculateScore($public){
            $reviewList = $this->GetAllByPublic($public->getid());
            $score = 0;
            $total = 0;
            foreach($reviewList as $review){
                $score += $review->getStars();
                $total += 1;
            }
            return round(($score/$total), 2);
        }
    }
?>