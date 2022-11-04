<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;
    use \DAO\IReviewDAO as IReviewDAO;
    use \Model\Review as Review;

    class ReviewDAO implements IReviewDAO
    {
        private $connection;
        private $tableName = 'Review';

        private function Add(Review $review)
        {
            $query = "CALL review_Add(?,?,?,?,?)";
            $parameters["date"] = $review->getDate();
            $parameters["commentary"] = $review->getCommentary();
            $parameters["stars"] = $review->getStars();
            $parameters["user"] = $review->getUser();
            $parameters["publication"] = $review->getPublication();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        private function GetAll()
        {
            $reviewList = array();    

            $query = "CALL review_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $review = new review();
                $review->__fromDB($row["idReview"],$row["date"]
                ,$row["commentary"],$row["stars"],$row["user"]
                ,$row["publication"]);

                array_push($reviewList,$review);
            }
            return $reviewList;

        }
        public function Delete($idReview){
            $query = "CALL review_Delete(?)";
            $parameters["idReview"] = $idReview;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }


    }


?>