<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IKeeperDAO as IKeeperDAO;
use \DAO\LocationDAO as LocationDAO;
use \DAO\PersonalDataDAO as PersonalDataDAO;
use \DAO\UserDao as UserDAO;
use \Model\Keeper as Keeper;

    class KeeperDAO implements IKeeperDAO{
        private $connection;
        private $tableName = 'Keeper';

        private $userDAO;
        private $dataDAO;
        private $locationDAO;

//DAO INJECTION
        public function __construct(){
            $this->locationDAO = new LocationDAO();
            $this->dataDAO = new PersonalDataDAO();
            $this->userDAO = new UserDAO();
        }

//SELECT METHODS
        public function GetAll(){
            $keeperList = array();

            $query = "CALL Keeper_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $keeper = new Keeper();

                $keeper->__fromDB($row["idKeeper"],$this->userDAO->Get($row["idUser"]));

                 array_push($keeperList,$keeper);
            }
            return $keeperList;
        }

        public function Get($id){
            $keeper = null;

            $query = "CALL Keeper_GetById(?)";
            $parameters["idKeeper"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $keeper = new Keeper();
                $keeper->__fromDB($row["idKeeper"],$this->userDAO->Get($row["idUser"]));
            }
            return $keeper;
        }

        public function GetbyUser($username){
            $keeper = null;
            $user = $this->userDAO->GetByUsername($username);

            $query = "CALL Keeper_GetByIdUser(?)";
            $parameters["idUser"] = $user->getId();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $owner = new Keeper();
                $owner->__fromDB($row["idKeeper"],$user/*$this->userDAO->Get($row["idUser"])*/);
            }
            return $keeper;
        }

//INSERT METHODS
        private function Add(Keeper $keeper){
            $query = "CALL Keeper_Add(?)";
            $parameters["idUser"] = $keeper->getUser()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function UpdateUserToKeeper(Keeper $keeper){
            $location = $this->locationDAO->AddRet($keeper->getUser()->getData()->getLocation());
                $keeper->getUser()->getData()->setLocation($location);
            $data = $this->dataDAO->AddRet($keeper->getUser()->getData());
                $keeper->getUser()->setData($data);
            $user = $this->userDAO->UpdateToKeeper($keeper->getUser());
                $keeper->setUser($user);
            $this->Add($keeper);    
        }
        
//DELETE METHODS
        public function Delete($id){
            $query = "CALL Keeper_Delete(?)";
            $parameters["idKeeper"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>