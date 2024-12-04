<?php
namespace DAO;

use \Exception as Exception;
use Exceptions\DataBindingException;
use Exceptions\InvalidExtensionException;
use Exceptions\IsKeeperException;
use Exceptions\RegisterLocationException;
use Exceptions\RegisterPersonalDataException;
use Exceptions\UserDuplicateException;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\LocationDAO as LocationDAO;
use \DAO\PersonalDataDAO as PersonalDataDAO;
use \DAO\UserDAO as UserDAO;
use \DAO\RoleDAO as RoleDAO;

use \Model\UserRole as UserRole;

    class URoleDAO implements IURoleDAO{
        private $connection;
        //private $tableName = 'UserRole';

        private $locationDAO;
        private $dataDAO;
        private $userDAO;
        private $roleDAO;

//? ======================================================================
//!                           DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this -> locationDAO = new LocationDAO();
            $this -> dataDAO = new PersonalDataDAO();
            $this -> userDAO = new UserDAO();
            $this -> roleDAO = new RoleDAO();
        }


//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================    
        public function GetAll(){
            $userRoleList = array();

            $query = "CALL UR_GetAll()";
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $useRole = new UserRole();
                $useRole -> __fromDB($row["idUR"],$this -> userDAO -> DGet($row["idUser"])
                                   , $this -> roleDAO -> Get($row["idRole"]));
                array_push($userRoleList, $useRole);
            }
        return $userRoleList;
        }

        public function Get($idUR){
            $useRole = null;

            $query = "CALL UR_GetById(?)";
            $parameters["idUR"] = $idUR;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $useRole = new UserRole();
                $useRole -> __fromDB($row["idUR"], $this -> userDAO -> DGet($row["idUser"])
                              , $this -> roleDAO -> Get($row["idRole"]));
            }
        return $useRole;
        }
        
/*
*  D: Método que retorna el rol determinado del usuario que ingresemos
*  A: El ID de un usuario ya cargado en la base de datos
*  R: El rol correspondiente al usuario ingresado
🐘*/  
        // public function GetByUser($idUser){
        //     $useRole = null;

        //     $query = "CALL UR_GetByName(?)";
        //     $parameters["idUser"] = $idUser;
        //     $this -> connection = Connection::GetInstance();
        //     $resultBD = $this-> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

        //     foreach($resultBD as $row){
        //         $useRole = new UserRole();
        //         $useRole -> __fromDB($row["idUR"], $this -> userDAO -> DGet($row["idUser"])
        //                            , $this -> roleDAO -> Get($row["idRole"]));
        //     }
        // return $useRole;
        // }


//? ======================================================================
// !                          INSERT METHODS
//? ======================================================================
        private function Add(UserRole $ur){
            $query = "CALL UR_Add(?,?)";
            $parameters["idUser"] = $ur -> getUser() -> getId();
            $parameters["idRole"] = $ur -> getRole() -> getId();

            $this -> connection = Connection::GetInstance();
            $this -> connection -> ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        
//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================   
        public function Delete($id){
            $query = "CALL UR_Delete(?)";
            $parameters["idUR"] = $id;
            $this -> connection = Connection::GetInstance();
            $this -> connection -> ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }


//? ======================================================================
//!                           ESPECIAL METHODS
//? ======================================================================   
/*
*  D: Método que nos confirma que un usuario ingresado tenga el rol de Keeper
*  A: El usuario a saber si es Keeper
*  R: Retorna el usuario si se encuentra en la base de datos y posee el rol de Keeper
🐘*/  
        private function PRCIsKeeper($user){
            $rta = 0;

            $query = "CALL UR_IsKeeper(?)";
            $parameters["idUser"] = $user -> getId();
            $this->connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $rta = $row["rta"];
            }
        return $rta;
        }

        public function IsKeeper($userName){
            $user = $this -> userDAO -> DGetByUsername($userName);
            $rta = $this -> PRCIsKeeper($user);
        return $rta;    
        }


        // public function Register(UserRole $ur){
        //     $message= "Error: Y existe un usuarios con ese Username.";
        //     if(strlen($ur->getUser()->getUsername())<50 && strlen($ur->getUser()->getPassword())<50 
        //     && strlen($ur->getUser()->getEmail())<50){ 
        //         if(($this->userDAO->IsUser($ur->getUser()))==0){
        //         $message= "Sucessful: Se ha registrado satisfactoriamente.";
        //         try{
        //             $user = $this->userDAO->AddRet($ur->getUser());
        //             $ur->setUser($user);
        //             $ur->setRole($this->roleDAO->Get(1));
        //             $this->Add($ur);
                    
        //         }catch(Exception $e){
        //             $message = "Error: No se ha podido procesar su solicitud, reintente mas tarde.";
        //         return $message; 
        //         }
        //     }
        //     }else{
        //         $message = "Error: Alguno de los datos ingresados son invalidos, reintente con otros";
        //     }
        //     return $message; 
        // }

        public function Register(UserRole $ur){
            if(strlen($ur -> getUser() -> getUsername()) < 50 
                && strlen($ur -> getUser() -> getPassword()) < 50 
                && strlen($ur -> getUser() -> getEmail()) < 50){

                if(($this -> userDAO -> IsUser($ur -> getUser())) == 0){
                        $user = $this -> userDAO -> AddRet($ur -> getUser());
                        $ur -> setUser($user);
                        $ur -> setRole($this -> roleDAO -> Get(1));
                        $this -> Add($ur);
                    }else{
                        throw new UserDuplicateException("Error: El USER ya existe, inicie sesión");
                    }

            }else{
                throw new InvalidExtensionException("Error: Datos inválidos ingresados , reintente nuevamente");
            }
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××
//¬         MÉTODO QUE OTORGA ROL KEEPER
//* ×××××××××××××××××××××××××××××××××××××××××××××××××
/*
*  D: Método que actualizara el rol del usuario a Keeper.

?      💠 IsKeeper
¬          ► COMPRUEBA QUE EL USER NO POSEA EL ROLE KEEPER PREVIAMENTE.
?      💠 locationDAO -> AddRet
¬          ► REGISTRA Y RETORNA UN LOCATION.
?      💠 dataDAO -> AddRet
¬          ► REGISTRA Y RETORNA EL PERSONALDATA DE UN USER.
?      💠 userDAO -> HookData
¬          ► ENLAZA Y ACTUALIZA EL USER CON EL PERSONALDATA.
?      💠 roleDAO -> Get(2)
¬          ► OBTIENE EL ROLE COMPLETO, CORRESPONDIENTE a KEEPER.
?      💠 Add
¬          ► GUARDA LA NUEVA RELACIÓN ENTRE USER Y ROLE, LA CUAL ES KEEPER.

!      ❌ RegisterLocationException
¬          ► CUBRE EL ERROR OCURRIDO EN EL REGISTRO DE LOCATION.

!      ❌ RegisterPersonalDataException
¬          ► CUBRE EL ERROR OCURRIDO EN EL REGISTRO DE PERSONALDATA.

!      ❌ DataBindingException
¬          ► CUBRE EL ERROR OCURRIDO DURANTE EL ENLACE DEL USER CON PERSONALDATA

* A: Un Objeto USERROLE que contenga un USER.
* R: No Posee.
🐘 */
        // public function UtoKeeper(UserRole $ur){
        //     $userName = $ur->getUser()->getUsername();
        //     $message = "Error, ya posee el rol de keeper";
            
        //     if(empty($this->IsKeeper($userName))){   
        //         $message = "Sucessful: Ha obtenido el rol de keeper.";  
        //             try{
        //                 $location = $this->locationDAO->AddRet($ur->getUser()->getData()->getLocation());
        //                     $ur->getUser()->getData()->setLocation($location);  
        //             }catch(Exception $e){
        //                 $message = "Error: No se pudo registrar Localidad,por favor reintente.";
        //             return $message;    
        //             }
        //             try{           
        //                 $data = $this->dataDAO->AddRet($ur->getUser()->getData());
        //                     $ur->getUser()->setData($data);
                        
        //             }catch(Exception $e){
        //                 $message = "Error: No se pudo registrar Informacion Personal,por favor reintente.";
        //             return $message;  
        //             }   
        //             try{
        //                 $user = $this->userDAO->HookData($ur->getUser());
        //                     $ur->setUser($user);
        //                     $ur->setRole($this->roleDAO->Get(2));
        //                 $this->Add($ur); 
        //             }catch(Exception $e){
        //                 $message = "Error: No se pudo completar el upgrade, reintente en unos minutos.";
        //             return $message;
        //             }  
        //     } 
        // return  $message;
        // }

        public function UtoKeeper(UserRole $ur){
            if(empty($this -> IsKeeper($ur -> getUser() -> getUsername()))){   
                    try{

                        $location = $this -> locationDAO -> AddRet($ur -> getUser() -> getData() -> getLocation());
                        $ur -> getUser() -> getData() -> setLocation($location);  

                    }catch(Exception $e){
                        throw new RegisterLocationException("Error: No se pudo registrar Localidad,por favor reintente.");
                    }

                    try{          

                        $data = $this -> dataDAO -> AddRet($ur -> getUser() -> getData());
                        $ur -> getUser() -> setData($data);
                        
                    }catch(Exception $e){
                        throw new RegisterPersonalDataException("Error: No se pudo registrar Información Personal,por favor reintente."); 
                    }   

                    try{

                        $user = $this -> userDAO -> HookData($ur -> getUser());
                        $ur -> setUser($user);
                        $ur -> setRole($this -> roleDAO -> Get(2));
                        $this -> Add($ur); 

                    }catch(Exception $e){
                        throw new DataBindingException("Error: Fallo de vinculación, reintente en unos minutos.");
                    }  
            }else{
                throw new IsKeeperException("Error, ya posee el rol de keeper");
            } 
        }
    }
?>