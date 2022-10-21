<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;
    
    use \DAO\IPetTypeDAO as IPetTypeDAO;
    use \Model\PetType as PetType;

    class PetTypeDAO implements IPetTypeDAO{

        private $connection;
        private $tableName = 'PetType';

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

        public function Get($id){
            $type = null;

            $query = "CALL PetType_GetById(?)";
            $parameters["idType"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $type = new PetType();
                $type->__fromDB($row["idType"],$row["name"]);
            }
            return $type;
        }

        public function Add(PetType $type){
            $query = "CALL PetType_Add(?)";
            $parameters["name"] = $type->getName();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
            
        public function Delete($id){
            $query = "CALL PetType_Delete(?)";
            $parameters["idType"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>