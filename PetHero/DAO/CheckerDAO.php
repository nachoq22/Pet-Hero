<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\ICheckerDAO as ICheckerDAO;
use \DAO\BookingPetDAO as BookingPetDAO;
use \Model\Checker as Checker;

    class CheckerDAO implements ICheckerDAO{
        private $connection;
        private $tableName = 'Checker';
        private $bpDAO;

//======================================================================
// DAOs INJECTION
//======================================================================
        public function __construct(){
            $this->bpDAO = new BookingPetDAO();
        }

//======================================================================
// SELECT METHODS
//======================================================================
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
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
            }
        return $checker;
        }

        public function GetByBook($idBook){
            $query = "CALL Checker_GetByBooking(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();
                $checker->__fromDB($row["idchecker"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($resultBD["idBook"])->getBooking());
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
                                  ,$this->bpDAO->GetByBook($resultBD["idBook"])->getBooking());
                array_push($checkerList,$checker);
            }
        return $checkerList;    
        }

//======================================================================
// INSERT METHODS
//======================================================================
        public function Add(Checker $Checker){
            $query = "CALL Checker_Add(?,?,?,?)";
            $parameters["emisionD"] = $Checker->getEmissionDate();
            $parameters["closeD"] = $Checker->getcloseDate();
            $parameters["finalPrice"] = $Checker->getFinalPrice();
            $parameters["idBook"] = $Checker->getBooking()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//-----------------------------------------------------
// METHOD TO CREATE A CHECKER AND UPDATE A BOOKING
//-----------------------------------------------------      
        public function NewChecker(Checker $checker,$rta){
                $bp = $this->bpDAO->GetByBook($checker->getBooking()->getId()); 
            if($rta == 1){
                    $totally = $this->bpDAO->GetTotally($bp->getBooking());         
                    $openD = DATE("Y-m-d");
                    $closeD = DATE("Y-m-d",STRTOTIME($openD."+ 3 days"));
                    $checker->__fromRequest($openD,$closeD,$totally,$bp->getBooking());
                $this->Add($checker);
                $this->bpDAO->NewState($bp->getBooking(),$rta);
            }else{
                $this->bpDAO->NewState($bp->getBooking(),$rta);
            }
        }

//======================================================================
// DELETE METHODS
//====================================================================== 
        public function Delete($idChecker){
            $query = "CALL Checker_Delete(?)";
            $parameters["idChecker"] = $idChecker;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>