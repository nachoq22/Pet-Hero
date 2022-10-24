<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\ISizeDAO as ISizeDAO;
use \Model\Size as Size;

    class SizeDao implements ISizeDAO{

        private $connection;
        private $tableName = 'Size';

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

        public function Get($id){
            $size = null;

            $query = "CALL Size_GetById(?)";
            $parameters["idSize"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $size = new Size();
                $size->__fromDB($row["idSize"],$row["name"]);
            }
            return $size;
        }

        public function Add(Size $size){
            $query = "CALL Size_Add(?)";
            $parameters["name"] = $size->getName();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
            
        public function Delete($id){
            $query = "CALL Size_Delete(?)";
            $parameters["idSize"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>