<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IReviewDAO as IReviewDAO;
use \DAO\PublicationDAO as PublicationDAO;
use \DAO\UserDAO as UserDAO;

use \Model\Review as Review;
use PDOException;
use PHPMailer\PHPMailer\Exception;

    class ReviewDAO implements IReviewDAO{
        private $connection;
        private $tableName = 'Review';

        private $userDAO;
        private $publicDAO;

//? ======================================================================
//!                           DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->publicDAO = new PublicationDAO();
        }

//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================        
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
                                 ,$this->userDAO->DGet($row["idUser"]));
                array_push($reviewList,$review);
            }
        return $reviewList;
        }

/*
*  D: Método que retorna todas las reviews segun un publicacion
!     Se utiliza en la funcion CalculateScore()
*  A: un id de una publicacion
*  R: Retorna una lista de reviews con el id de la publicacion ingresada
🐘*/ 
        public function GetAllByPublic($idPublic){
            $reviewList = array();

            $query = "CALL Review_GetByPublic(?)";
            $parameters["idPublic"] = $idPublic;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $review = new Review();
                $review->__fromDB($row["idReview"],$row["createD"],$row["commentary"],$row["stars"]
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
                                 ,$this->userDAO->DGet($row["idUser"]));
                }
        return $review;
        }

//? ======================================================================
// !                          INSERT METHODS
//? ======================================================================
        private function Add(Review $review){
            $query = "CALL Review_Add(?,?,?,?,?)";
            $parameters["createD"] = $review->getCreateD();
            $parameters["commentary"] = $review->getCommentary();
            $parameters["stars"] = $review->getStars();
            $parameters["idUser"] = $review->getUser()->getId();
            $parameters["idPublic"] = $review->getPublication()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××
//¬         MÉTODO PARA REGISTRAR UNA RESEÑA
//* ×××××××××××××××××××××××××××××××××××××××××××××××××
/*
*  D: Método que recibe una review, la asigna a la publicacion correspondiente y
*     llama al metodo para actualizar el puntaje de la publicacion
!     Se utiliza en la funcion CalculateScore()
*  A: Un objeto REVIEW.
*  R: No posee.
🐘*/
        public function NewReview(Review $review){
            $public = $this -> publicDAO -> Get($review -> getPublication() -> getId());
            $review -> setPublication($public);
            $user = $this -> userDAO -> DGetByUsername($review -> getUser() -> getUsername());
            $review -> setUser($user);

            $this -> Add($review);
            $this -> UpdatePopularity($public, $this -> CalculateScore($public));
        }

//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================      
        public function Delete($idReview){
            $query = "CALL Review_Delete(?)";
            $parameters["idReview"] = $idReview;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

/*
*  D: Metodo que actualiza el puntaje de una publicacion, sumandole una nueva valoracion
!     Metodo utilizado en NewReview() debido a que esta modificará el puntaje de la publicacion ya establecido
*  A: Una publicacion y un numero de puntaje
*  R: No posee.
🐘*/        
        public function UpdatePopularity($public, $score){
            $query = "CALL Publication_UpdatePopularity(?,?)";
            $parameters["idPublic"] = $public->getid();
            $parameters["score"] = $score;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

/*
*  D: Método que calculará el puntaje de una publicación, sumando todas las "estrellas" y dividiéndola por el total.
*  A: La publicación de la cual se realizará el calculo.
*  R: El puntaje calculado.
🐘*/  
        public function CalculateScore($public){
            $reviewList = $this -> GetAllByPublic($public->getid());
            $score = 0;
            $total = 0;
            $avgScore = 0;
            foreach($reviewList as $review){
                $score += $review -> getStars();
                $total += 1;
            }

            if($total != 0){
                $avgScore = round($score / $total,2);
            }
        return $avgScore;
        }
    }
?>