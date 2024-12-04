<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\ILocationDAO as ILocationDAO;

use \Model\Location as Location;

    class LocationDAO implements ILocationDAO{
        private $connection;
        //private $tableName = 'Location';

//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================
        public function GetAll(){
            $locationList = array();

            $query = "CALL Location_GetAll()";
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $location = new Location();
                $location -> __fromDB($row["idLocation"] , $row["adress"]
                                    , $row["neighborhood"], $row["city"]
                                    , $row["province"], $row["country"]);

                array_push($locationList, $location);
            }
        return $locationList;
        }

        public function Get($id) : Location{
            $location = null;

            $query = "CALL Location_GetById(?)";
            $parameters["idLocation"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $location = new Location();
                $location -> __fromDB($row["idLocation"], $row["adress"]
                                    , $row["neighborhood"], $row["city"]
                                    , $row["province"], $row["country"]);
            }
        return $location;
        }

        public function GetByAll(Location $location) : Location{
            $locationN = null;

            $query = "CALL Location_GetByAll(?,?,?,?,?)";
            $parameters["adress"] = $location -> getAdress();
            $parameters["neighborhood"] = $location -> getNeighborhood();
            $parameters["city"] = $location -> getCity();
            $parameters["province"] = $location -> getProvince();
            $parameters["country"] = $location -> getCountry();
            $this->connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $locationN = new Location();
                $locationN -> __fromDB($row["idLocation"], $row["adress"]
                                     , $row["neighborhood"], $row["city"]
                                     , $row["province"], $row["country"]);
            }
        return $locationN;
        }

//? ======================================================================
// !                          INSERT METHODS
//? =======================================================================
        private function Add(Location $location){
            $query = "CALL Location_Add(?,?,?,?,?)";
            $parameters["adress"] = $location -> getAdress();
            $parameters["neighborhood"] = $location -> getNeighborhood();
            $parameters["city"] = $location -> getCity();
            $parameters["province"] = $location -> getProvince();
            $parameters["country"] = $location -> getCountry();
            $this -> connection = Connection::GetInstance();
            $this -> connection -> ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);    
        }

        public function AddRet(Location $location){
            $this -> Add($location);
            $location = $this -> GetByAll($location);
        return $location;    
        }
        
//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================
        public function Delete($id){
            $query = "CALL Location_Delete(?)";
            $parameters["idLocation"] = $id;
            $this -> connection = Connection::GetInstance();
            $this -> connection -> ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>