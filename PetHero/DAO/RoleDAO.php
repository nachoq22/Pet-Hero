<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IRoleDAO as IRoleDAO;
use \Model\Role as Role;

    class RoleDAO implements IRoleDAO{
        private $connection;
        private $tableName = 'Role';

//SELECT METHODS
        public function GetAll(){
            $roleList = array();

            $query = "CALL Role_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $role = new Role();
                $role->__fromDB($row["idRole"],$row["name"],$row["description"]);
                array_push($roleList,$role);
            }
            return $roleList;
        }

        public function Get($idRole){
            $role = null;

            $query = "CALL Role_GetById(?)";
            $parameters["idRole"] = $idRole;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $role = new Role();
                $role->__fromDB($row["idRole"],$row["name"],$row["description"]);
            }
            return $role;
        }

        public function GetbyName($name){
            $role = null;

            $query = "CALL Role_GetByName(?)";
            $parameters["name"] = $name;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $role = new Role();
                $role->__fromDB($row["idRole"],$row["name"],$row["description"]);
            }
            return $role;
        }

//INSERT METHODS
        public function Add(Role $role){
            $query = "CALL Role_Add(?,?)";
            $parameters["name"] = $role->getName();
            $parameters["description"] = $role->getDescription();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//DELETE METHODS
        public function Delete($idRole){
            $query = "CALL Role_Delete(?)";
            $parameters["idRole"] = $idRole;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>