<?php
    namespace DAO;

    use \Connection\Connection as Connection;
    use \Connection\QueryType as QueryType;

    use \Inter\IOwnerDAO as IOwnerDAO;
    use \Model\Owner as Owner;
    use \DAO\UserDao as UserDao;
    

    class OwnerDAO implements IOwnerDAO{

        private $connection;
        private $tableName = 'Owner';

        private $userDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
        }

        public function GetAll(){
            $ownerList = array();

            $query = "CALL Owner_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $owner = new Owner();

                $owner->__fromDB($row["id"],$this->userDAO->Get($row["idUser"]));

                 array_push($ownerList,$owner);
            }
            return $ownerList;
        }

        public function Get($id){
            $owner = null;

            $query = "CALL Owner_GetById(?)";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $owner = new Owner();
                $owner->__fromDB($row["id"],$this->userDAO->Get($row["idUser"]));
            }
            return $owner;
        }

        public function Add(Owner $owner){
            $query = "CALL Owner_Add(?)";
            $parameters["idUser"] = $owner->getUser()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
            
        public function Delete($id){
            $query = "CALL Owner_Delete(?)";
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>