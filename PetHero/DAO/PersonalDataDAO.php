<?php
    namespace DAO;

    use \Connection\Connection as Connection;
    use \Connection\QueryType as QueryType;

    use \Inter\IPersonalData as IPersonalData;
    use \Model\PersonalData as PersonalData;
    use \DAO\LocationDAO as LocationDAO;
    use \Model\Location as Location;

    class PersonalDataDAO implements IPersonalData{

        private $connection;
        private $tableName = 'PersonalData';

        private $locationDAO;

        public function __construct(){
            $this->locationDAO = new LocationDAO();
        }


        public function GetAll(){
            $dataList = array();

            $query = "CALL PersonalData_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $data = new PersonalData();

                $data->__fromDB($row["id"],$row["name"]
                ,$row["surname"],$row["sex"]
                ,$row["dni"],$this->locationDAO->Get($row["idLocation"]));

                 array_push($dataList,$data);
            }
            return $dataList;
        }

        public function Get($id){
            $data = null;

            $query = "CALL PersonalData_GetById(?)";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $data = new PersonalData();

                $data->__fromDB($row["id"],$row["name"]
                ,$row["surname"],$row["sex"]
                ,$row["dni"],$this->locationDAO->Get($row["idLocation"]));
            }
            return $data;
        }

        public function Add(PersonalData $data){
            $query = "CALL PersonalData_Add(?,?,?,?,?)";
            $parameters["name"] = $data->getName();
            $parameters["surname"] = $data->getSurname();
            $parameters["sex"] = $data->getSex();
            $parameters["dni"] = $data->getDni();
            
            /*$idLocation = $this->locationDAO->Add($data->getLocation());*/

            /*$parameters["idLocation"] = $idLocatrion; */

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
            
        public function Delete($id){
            $query = "CALL Location_Delete(?)";
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>