<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\ISizeDAO as ISizeDAO;

use \Model\Size as Size;

    class SizeDAO implements ISizeDAO{
        private $connection;
        //private $tableName = 'Size';

//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================     
        public function GetAll(){
            $sizeList = array();

            $query = "CALL Size_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $size = new Size();
                $size->__fromDB($row["idSize"],$row["name"]);
                array_push($sizeList,$size);
            }
            return $sizeList;
        }

        public function Get($idSize){
            $size = null;

            $query = "CALL Size_GetById(?)";
            $parameters["idSize"] = $idSize;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $size = new Size();
                $size->__fromDB($row["idSize"],$row["name"]);
            }
            return $size;
        }

/*
*  D: Método que retorna el objeto size según el nombre (little, medium, big, etc)
*  A: String con el name que se busca
*  R: Retorna un objeto size con el mismo name que se ingresó
🐘*/  
        public function GetByName($name){
            $size = null;

            $query = "CALL Size_GetByName(?)";
            $parameters["name"] = $name;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $size = new Size();
                $size->__fromDB($row["idSize"],$row["name"]);
            }
            return $size;
        }

//? ======================================================================
// !                          INSERT METHODS
//? ======================================================================
        public function Add(Size $size){
            $query = "CALL Size_Add(?)";
            $parameters["name"] = $size->getName();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================   
        public function Delete($idSize){
            $query = "CALL Size_Delete(?)";
            $parameters["idSize"] = $idSize;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>