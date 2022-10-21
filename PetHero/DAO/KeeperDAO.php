<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;

    use \DAO\IKeeperDAO as IKeeperDAO;
    use \Model\Keeper as Keeper;
    use \DAO\UserDao as UserDAO;

    class KeeperDAO implements IKeeperDAO{

        private $connection;
        private $tableName = 'Keeper';

        private $userDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
        }

        public function GetAll(){
            $keeperList = array();

            $query = "CALL Keeper_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $keeper = new Keeper();

                $keeper->__fromDB($row["id"],$this->userDAO->Get($row["idUser"]));

                 array_push($keeperList,$keeper);
            }
            return $keeperList;
        }

        public function Get($id){
            $keeper = null;

            $query = "CALL Keeper_GetById(?)";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $keeper = new Keeper();
                $keeper->__fromDB($row["id"],$this->userDAO->Get($row["idUser"]));
            }
            return $keeper;
        }

        public function Add(Keeper $keeper){
            $query = "CALL Keeper_Add(?)";
            $parameters["idUser"] = $keeper->getUser()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
            
        public function Delete($id){
            $query = "CALL Keeper_Delete(?)";
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>