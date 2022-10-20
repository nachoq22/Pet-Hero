<?php
    namespace DAO;

    use \Connection\Connection as Connection;
    use \Connection\QueryType as QueryType;

    use \Inter\ISizeDAO as ISizeDAO;
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

                $size->__fromDB($row["id"],$row["name"]);

                 array_push($sizeList,$size);
            }
            return $sizeList;
        }

        public function Get($id){
            $size = null;

            $query = "CALL Size_GetById(?)";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $size = new Size();
                $size->__fromDB($row["id"],$row["name"]);
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
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>