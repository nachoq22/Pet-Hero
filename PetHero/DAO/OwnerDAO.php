<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IOwnerDAO as IOwnerDAO;
use \DAO\LocationDAO as LocationDAO;
use \DAO\PersonalDataDAO as PersonalDataDAO;
use \DAO\UserDao as UserDao;
use \Model\Owner as Owner;

    class OwnerDAO implements IOwnerDAO{
        private $connection;
        private $tableName = 'Owner';

        private $userDAO;

//DAO INJECTION
        public function __construct(){
            $this->userDAO = new UserDAO();
        }

//SELECT METHODS
        public function GetAll(){
            $ownerList = array();

            $query = "CALL Owner_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $owner = new Owner();
                $owner->__fromDB($row["idOwner"],$this->userDAO->Get($row["idUser"]));
                array_push($ownerList,$owner);
            }
            return $ownerList;
        }

        public function Get($id){
            $owner = null;

            $query = "CALL Owner_GetById(?)";
            $parameters["idOwner"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $owner = new Owner();
                $owner->__fromDB($row["idOwner"],$this->userDAO->Get($row["idUser"]));
            }
            return $owner;
        }

        public function GetbyUser($username){
            $owner = null;
            $user = $this->userDAO->GetByUsername($username);

            $query = "CALL Owner_GetByIdUser(?)";
            $parameters["idUser"] = $user->getId();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $owner = new Owner();
                $owner->__fromDB($row["idOwner"],$user/*$this->userDAO->Get($row["idUser"])*/);
            }
            return $owner;
        }

//INSERT METHODS
        private function Add(Owner $owner){
            $query = "CALL Owner_Add(?)";
            $parameters["idUser"] = $owner->getUser()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function Register(Owner $owner){
            $user = $this->userDAO->AddRet($owner->getUser());
            $owner->setUser($user);
            $this->Add($owner);
        }

//DELETE METHODS
        public function Delete($id){
            $query = "CALL Owner_Delete(?)";
            $parameters["idOwner"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>