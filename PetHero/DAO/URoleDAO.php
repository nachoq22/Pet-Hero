<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;
use \Exception as Exception;

use \DAO\LocationDAO as LocationDAO;
use \DAO\PersonalDataDAO as PersonalDataDAO;
use \DAO\UserDAO as UserDAO;
use \DAO\RoleDAO as RoleDAO;
use \Model\UserRole as UserRole;

    class URoleDAO implements IURoleDAO{
        private $connection;
        private $tableName = 'UserRole';

        private $locationDAO;
        private $dataDAO;
        private $userDAO;
        private $roleDAO;

//======================================================================
// DAOs INJECTION
//======================================================================
        public function __construct(){
            $this->locationDAO = new LocationDAO();
            $this->dataDAO = new PersonalDataDAO();
            $this->userDAO = new UserDAO();
            $this->roleDAO = new RoleDAO();
        }

//======================================================================
// SELECT METHODS
//======================================================================
        public function GetAll(){
            $urList = array();

            $query = "CALL UR_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $ur = new UserRole();
                $ur->__fromDB($row["idUR"],$this->userDAO->DGet($row["idUser"]),$this->roleDAO->Get($row["idRole"]));
                array_push($urList,$ur);
            }
            return $urList;
        }

        public function Get($idUR){
            $ur = null;

            $query = "CALL UR_GetById(?)";
            $parameters["idUR"] = $idUR;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $ur = new UserRole();
                $ur->__fromDB($row["idUR"],$this->userDAO->DGet($row["idUser"]),$this->roleDAO->Get($row["idRole"]));
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
                $ur->__fromDB($row["idUR"],$this->userDAO->DGet($row["idUser"]),$this->roleDAO->Get($row["idRole"]));
            }
            return $ur;
        }

        private function GetIsKeeper(UserRole $ur){
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

        public function IsKeeper(UserRole $ur){
                $user = $this->userDAO->DGetByUsername($ur->getUser()->getUsername());
                $ur->setUser($user);
            $rta = $this->GetIsKeeper($ur);
        return $rta;    
        }

//======================================================================
// INSERT METHODS
//======================================================================
        private function Add(UserRole $ur){
            $query = "CALL UR_Add(?,?)";
            $parameters["idUser"] = $ur->getUser()->getId();
            $parameters["idRole"] = $ur->getRole()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function Register(UserRole $ur){
            if((empty($ur) == false) ||  (empty($this->userDAO->DGetByUsername($ur->getUser()->getUsername()) == true))){
                $user = $this->userDAO->AddRet($ur->getUser());
                    $ur->setUser($user);
                    $ur->setRole($this->roleDAO->Get(1));
                $this->Add($ur);
            }
        }

//-----------------------------------------------------
// METHODS DEDICATED TO GIVING ROLE KEEPER
//-----------------------------------------------------
        public function UtoKeeper(UserRole $ur){
            $message = "Sucessful: Ha obtenido el rol de keeper.";  
                try{
                    $location = $this->locationDAO->AddRet($ur->getUser()->getData()->getLocation());
                        $ur->getUser()->getData()->setLocation($location);  
                }catch(Exception $e){
                    $message = "Error: No se pudo registrar Localidad,por favor reintente.";
                return $message;    
                }
                try{
                    $data = $this->dataDAO->AddRet($ur->getUser()->getData());
                        $ur->getUser()->setData($data);
                }catch(Exception $e){
                    $message = "Error: No se pudo registrar Informacion Personal,por favor reintente.";
                return $message;  
                }   
                try{
                    $user = $this->userDAO->HookData($ur->getUser());
                        $ur->setUser($user);
                        $ur->setRole($this->roleDAO->Get(2));
                    $this->Add($ur); 
                }catch(Exception $e){
                    $message = "Error: No se pudo completar el upgrade, reintente en unos minutos.";
                return $message;
                }   
        return  $message;
        }
//-----------------------------------------------------
//-----------------------------------------------------

//======================================================================
// DELETE METHODS
//======================================================================
        public function Delete($id){
            $query = "CALL UR_Delete(?)";
            $parameters["idUR"] = $id;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>