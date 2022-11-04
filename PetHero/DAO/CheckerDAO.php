<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\ICheckerDAO as ICheckerDAO;
use \DAO\BookingDAO as BookingDAO;
use \Model\Checker as Checker;

    class CheckerDAO implements ICheckerDAO{
        private $connection;
        private $tableName = 'Checker';

        private $bookDAO;

        public function __construct(){
            $this->bookDAO = new BookingDAO();
        }

        public function Add(Checker $Checker){
            $query = "CALL Checker_Add(?,?,?,?)";
            $parameters["emisionD"] = $Checker->getEmissionDate();
            $parameters["close"] = $Checker->getcloseDate();
            $parameters["finalPrice"] = $Checker->getFinalPrice();
            $parameters["idBook"] = $Checker->getBooking()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function Get($idChecker){
            $checker = null;
            $query = "CALL Checker_GetById(?)";
            $parameters["idChecker"] = $idChecker;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();

                $checker->__fromDB($row["idchecker"],$row["emisionD"]
                ,$row["closeD"],$row["finalPrice"]
                ,$this->bookDAO->Get($row["idBook"]));
            }
            return $checker;
        }

        public function GetAll(){
            $checkerList = array();    

            $query = "CALL Checker_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();

                $checker->__fromDB($row["idchecker"],$row["emisionD"]
                ,$row["closeD"],$row["finalPrice"]
                ,$this->bookDAO->Get($row["idBook"]));

                array_push($checkerList,$checker);
            }
            return $checkerList;    
        }
        
        public function Delete($idChecker){
            $query = "CALL Checker_Delete(?)";
            $parameters["idChecker"] = $idChecker;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

    }

?>