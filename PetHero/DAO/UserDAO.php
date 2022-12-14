<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IUserDAO as IUserDAO;
use \DAO\PersonalDataDAO as PersonalDataDAO;
use \Model\User as User;

    class UserDAO implements IUserDAO{
        private $connection;
        private $tableName = 'User';

        private $dataDAO;

//======================================================================
// DAOs INJECTION
//======================================================================
        public function __construct(){
            $this->dataDAO = new PersonalDataDAO();
        }

//======================================================================
// SELECT METHODS
//======================================================================

        public function DefGetAll(){
            $userList = array();

            $query = "CALL User_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $user = new User();
                if($row["idData"]){
                    $user->__fromDBisKeeper($row["idUser"],$row["username"]
                                        ,$row["password"],$row["email"]
                                        ,$this->dataDAO->Get($row["idData"]));
                }
                $user->__fromDBnoKeeper($row["idUser"],$row["username"]
                                    ,$row["password"],$row["email"]);
                array_push($userList,$user);
            }
            return $userList;
        }


        public function DGet($id){
            $user = null;

            $query = "CALL User_GetById(?)";
            $parameters["idUser"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $user = new User();
                if($row["idData"]){
                    $user->__fromDBisKeeper($row["idUser"],$row["username"]
                                            ,$row["password"],$row["email"]
                                            ,$this->dataDAO->Get($row["idData"]));
                }
                $user->__fromDBnoKeeper($row["idUser"],$row["username"]
                    ,$row["password"],$row["email"]);
            }
            return $user;
        }


        public function DGetByUsername($username){
            $user = null;
    
            $query = "CALL User_GetByUsername(?)";
            $parameters["username"] = $username;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $user = new User();
                if($row["idData"] != NULL){
                    $user->__fromDBisKeeper($row["idUser"],$row["username"]
                                           ,$row["password"],$row["email"]
                                           ,$this->dataDAO->Get($row["idData"]));
                }
                $user->__fromDBnoKeeper($row["idUser"],$row["username"]
                    ,$row["password"],$row["email"]);
            }
        return $user;
        }
        
        public function Login(User $user){
            $rta = 0;

            $query = "CALL User_Login(?,?)";
            $parameters["username"] = $user->getUsername();
            $parameters["password"] = $user->getPassword();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $rta = $row["rta"];
            }
        return $rta;
        }

        public function IsUser(User $user){
            $rta = 0;
            $query = "CALL User_IsExist(?,?)";
            $parameters["userName"] = $user->getUsername();
            $parameters["email"] = $user->getEmail();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $rta = $row["rta"];
            }
        return $rta;
        }

//INSERT METHODS
        private function Add(User $user){
            $query = "CALL User_Add(?,?,?)";
            $parameters["username"] = $user->getUsername();
            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function AddRet(User $user){
            $this->Add($user);
            $userN = $this->DGetByUsername($user->getUsername());
        return $userN;
        }

//-----------------------------------------------------
// METHODS DEDICATED TO GIVING ROLE KEEPER
//-----------------------------------------------------
        private function AddHookData(User $user){
            $query = "CALL User_HookData(?,?)";
            $parameters["idUser"] = $user->getId();
            $parameters["idData"] = $user->getData()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function HookData(User $user){
                $userA = $this->DGetByUsername($user->getUsername());
                $user->setId($userA->getId());
            $this->AddHookData($user);
            $userN = $this->DGetByUsername($user->getUsername());
        return $userN;
        }
//-----------------------------------------------------
//-----------------------------------------------------
   
//DELETE METHODS
        public function Delete($id){
            $query = "CALL Location_Delete(?)";
            $parameters["idUser"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>