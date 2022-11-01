<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IURDAO as IURDAO;
use \DAO\LocationDAO as LocationDAO;
use \DAO\PersonalDataDAO as PersonalDataDAO;
use \DAO\UserDAO as UserDAO;
use \DAO\RoleDAO as RoleDAO;

use \Model\UserRole as UserRole;

    class URDAO implements IURDAO{
        private $connection;
        private $tableName = 'UserRole';

        private $locationDAO;
        private $dataDAO;
        private $userDAO;
        private $roleDAO;

//DAO INJECTION
        public function __construct(){
            $locationDAO = new LocationDAO();
            $dataDAO = new PersonalDataDAO();
            $userDAO = new UserDAO();
            $roleDAO = new RoleDAO();
        }

//SELECT METHODS
        public function GetAll(){
            $urList = array();

            $query = "CALL UR_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $ur = new UserRole();
                $ur->__fromDB($row["idUR"],$this->userDAO->Get($row["idUser"]),$this->roleDAO->Get($row["idRole"]));
                array_push($urList,$ur);
            }
            return $urList;
        }

        public function Get($id){
            $ur = null;

            $query = "CALL UR_GetById(?)";
            $parameters["idUR"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $ur = new UserRole();
                $ur->__fromDB($row["idUR"],$this->userDAO->Get($row["idUser"]),$this->roleDAO->Get($row["idRole"]));
            }
            return $ur;
        }

        public function GetbyUser($idUser){
            $ur = null;

            $query = "CALL UR_GetByName(?)";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $ur = new UserRole();
                $ur->__fromDB($row["idUR"],$this->userDAO->Get($row["idUser"]),$this->roleDAO->Get($row["idRole"]));
            }
            return $ur;
        }

        public function IsKeeper(UserRole $ur){
            $rta = 0;
            $query = "CALL UR_IsKeeper(?)";
            $parameters["idUser"] = $ur->getUser()->getId();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $rta = $row["rta"];
            }
        return $rta;
        }

//INSERT METHODS
        private function Add(UserRole $ur){
            $query = "CALL UR_Add(?,?)";
            $parameters["idUser"] = $ur->getUser()->getId();
            $parameters["idRole"] = $ur->getRole()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function Register(UserRole $ur){
                $user = $this->userDAO->AddRet($ur->getUser());
            $ur->setUser($user);
            $ur->setRole($this->roleDAO->Get(1));
            $this->Add($ur);
        }

        public function UtoKeeper(UserRole $ur){
            $location = $this->locationDAO->AddRet($ur->getUser()->getData()->getLocation());
                $ur->getUser()->getData()->setLocation($location);
            $data = $this->dataDAO->AddRet($ur->getUser()->getData());
                $ur->getUser()->setData($data);
            $user = $this->userDAO->HookData($ur->getUser());
                $ur->setUser($user);
            $ur->setRole($this->roleDAO->Get(2));
            $this->Add($ur);   
        }

//DELETE METHODS
        public function Delete($id){
            $query = "CALL UR_Delete(?)";
            $parameters["idUR"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>