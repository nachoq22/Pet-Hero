<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\ICheckerDAO as ICheckerDAO;
use \DAO\BookingPetDAO as BookingPetDAO;
use Exception;
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
// TOOLS METHODS
//======================================================================
        private function GenRefCode(){
            $refCode = "";
            while(empty($refCode)){  
                $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
                $max = strlen($pattern)-1;
                for($i = 0; $i < 20; $i++){
                    $refCode .= substr($pattern, mt_rand(0,$max), 1);
                    if(!empty($this->GetByRef($refCode))){
                        $refCode = "";
                    }
                }   
            }
            return $refCode;
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
                if($row["payD"] != NULL){
                    $checker->__fromDBP($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["payD"] ,$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
            }
        return $checker;
        }

        public function GetByBook($idBook){
            $checker = null;

            $query = "CALL Checker_GetByBooking(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();
                if($row["payD"] != NULL){
                    $checker->__fromDBP($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["payD"] ,$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
            }
        return $checker;
        }

        public function GetByRef($refCode){
            $checker = null;

            $query = "CALL Checker_GetByRef(?)";
            $parameters["refCode"] = $refCode;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $checker = new Checker();
                if($row["payD"] != NULL){
                    $checker->__fromDBP($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["payD"] ,$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
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
                if($row["payD"] != NULL){
                    $checker->__fromDBP($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["payD"] ,$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
                }
                $checker->__fromDB($row["idChecker"],$row["refCode"],$row["emisionD"]
                                  ,$row["closeD"],$row["finalPrice"]
                                  ,$this->bpDAO->GetByBook($row["idBook"])->getBooking());
            array_push($checkerList,$checker);
            }
        return $checkerList;    
        }

//======================================================================
// INSERT METHODS
//======================================================================
        private function Add(Checker $checker){
            $query = "CALL Checker_Add(?,?,?,?,?)";
            $parameters["refCode"] = $checker->getRefCode();
            $parameters["emisionD"] = $checker->getEmissionDate();
            $parameters["closeD"] = $checker->getcloseDate();
            $parameters["finalPrice"] = $checker->getFinalPrice();
            $parameters["idBook"] = $checker->getBooking()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
//-----------------------------------------------------
// METHOD TO CREATE A CHECKER AND UPDATE A BOOKING
//-----------------------------------------------------      
        public function NewChecker(Checker $checker,$rta){
            $message = "Successful: Se ha creado el checker y actualizado la reserva.";
                   
                $bp = $this->bpDAO->GetByBook($checker->getBooking()->getId()); 
                
                try{
                    if($rta == 1){
                        try{

                        $totally = $this->bpDAO->GetTotally($bp->getBooking());
                        }catch(Exception $e){
                                $message = "Error: Ha ocurrido un error inesperado, intente mas tarde.";
                            return $message;
                        }
                        try{
                            $openD = DATE("Y-m-d");
                            $closeD = DATE("Y-m-d",STRTOTIME($openD."+ 3 days"));
                            $refCode = $this->GenRefCode();
                            $checker->__fromRequest($refCode,$openD,$closeD,$totally,$bp->getBooking());
                            $this->Add($checker);
                        }catch(Exception $e){
                                $message = "Error: No se ha podido generar el checker, intente mas tarde.";
                            return $message;
                        }      
                        $this->bpDAO->NewState($bp->getBooking(),$rta);
                    }else{
                        $this->bpDAO->NewState($bp->getBooking(),$rta);
                    }
                }catch(Exception $e){
                    $message = "Error: No se ha podido actualizar la reserva, intente mas tarde.";
                return $message;
                }  
        return $message;   
        }

//-----------------------------------------------------
// METHOD TO UPDATE A CHECKER AND BOOKING
//-----------------------------------------------------  
        private function SetPayDChecker(Checker $checker){
            $query = "CALL Checker_Add(?)";
            $parameters["idChecker"] = $checker->getEmissionDate();
            $parameters["payD"] = $checker->getPayDate();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function PayCheck(Checker $checker){
            $message = $this->bpDAO->UpdatePayCode($checker->getBooking());
            try{
                if(strpos($message,"Error") !== false){
                    $dateN = DATE("Y-m-d");
                    $checker->setPayD($dateN);
                    $this->SetPayDChecker($checker);
                }
            }catch(Exception $e){
                $message = $message .", no se ha actualizado el checker.";
                return $message;
            }
            return $message;
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