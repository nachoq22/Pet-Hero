<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;
    
use \DAO\IPetTypeDAO as IPetTypeDAO;
use \Model\PetType as PetType;

    class PetTypeDAO implements IPetTypeDAO{
        private $connection;
        private $tableName = 'PetType';

//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================
        public function GetAll(){
            $typeList = array();

            $query = "CALL PetType_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $type = new PetType();
                $type->__fromDB($row["idType"],$row["name"]);
                array_push($typeList,$type);
            }
            return $typeList;
        }

        public function Get($idType){
            $type = null;

            $query = "CALL PetType_GetById(?)";
            $parameters["idType"] = $idType;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $type = new PetType();
                $type->__fromDB($row["idType"],$row["name"]);
            }
            return $type;
        }

        public function GetbyName($name){
            $type = null;

            $query = "CALL PetType_GetByName(?)";
            $parameters["name"] = $name;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $type = new PetType();
                $type->__fromDB($row["idType"],$row["name"]);
            }
            return $type;
        }

//? ======================================================================
// !                          INSERT METHODS
//? ======================================================================
        public function Add(PetType $type){
            $query = "CALL PetType_Add(?)";
            $parameters["name"] = $type->getName();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================
        public function Delete($idType){
            $query = "CALL PetType_Delete(?)";
            $parameters["idType"] = $idType;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>