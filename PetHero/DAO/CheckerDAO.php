<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;

    use \DAO\ICheckerDAO as ICheckerDAO;
    use \Model\Checker as Checker;
    use \Model\Booking as Booking;

    class CheckerDAO implements ICheckerDAO
    {
        private $connection;
        private $tableName = 'Checker';

        private $id;
        private $emisionDate;
        private $finishDate;
        private $finalPrice;
        private Booking $booking;

        public function Add(Checker $Checker)
        {
            $query = "CALL Checker_Add(?,?,?,?)";
            $parameters["emisionDate"] = $Checker->getEmissionDate();
            $parameters["finishDate"] = $Checker->getFinishDate();
            $parameters["finalPrice"] = $Checker->getFinalPrice();
            $parameters["booking"] = $Checker->getBooking();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
        public function Get($id){
            $checker = null;
            $query = "CALL checker_GetById(?)";
            $parameters["idChecker"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();

                $checker->__fromDB($row["idchecker"],$row["emisionDate"]
                ,$row["finishDate"],$row["finalPrice"]
                ,$row["booking"]);

            }
            return $checker;
        }
        public function GetAll()
        {
            $CheckerList = array();    

            $query = "CALL Checker_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $Checker = new Checker();
                $Checker->__fromDB($row["booking"],$row["checker"]);

                array_push($CheckerList,$Checker);
            }
            return $CheckerList;

        }
        public function Delete($idChecker){
            $query = "CALL Checker_Delete(?)";
            $parameters["idChecker"] = $idChecker;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

    }

?>