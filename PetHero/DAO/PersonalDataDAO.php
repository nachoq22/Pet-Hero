<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IPersonalDataDAO as IPersonalDataDAO;
use \DAO\LocationDAO as LocationDAO;
use \Model\PersonalData as PersonalData;

    class PersonalDataDAO implements IPersonalDataDAO{
        private $connection;
        private $tableName = 'PersonalData';

        private $locationDAO;

//DAO INJECTION
        public function __construct(){
            $this->locationDAO = new LocationDAO();
        }

//SELECT METHODS
        public function GetAll(){
            $dataList = array();

            $query = "CALL PersonalData_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $data = new PersonalData();
                $data->__fromDB($row["id"],$row["name"]
                               ,$row["surname"],$row["sex"]
                               ,$row["dni"]
                               ,$this->locationDAO->Get($row["idLocation"]));
                array_push($dataList,$data);
            }
            return $dataList;
        }

        public function Get($id){
            $data = null;

            $query = "CALL PersonalData_GetById(?)";
            $parameters["idData"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $data = new PersonalData();

                $data->__fromDB($row["idData"],$row["name"]
                               ,$row["surname"],$row["sex"]
                               ,$row["dni"],$this->locationDAO->Get($row["idLocation"]));
            }
            return $data;
        }

//INSERT METHODS
        public function Add(PersonalData $data){
            $query = "CALL PersonalData_Add(?,?,?,?,?)";
            $parameters["name"] = $data->getName();
            $parameters["surname"] = $data->getSurname();
            $parameters["sex"] = $data->getSex();
            $parameters["dni"] = $data->getDni();
            $parameters["idLocation"] = rand(1, 10);

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//INSERT METHODS
        public function Delete($id){
            $query = "CALL Location_Delete(?)";
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>