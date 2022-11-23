<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IPublicationDAO as IPublicationDAO;
use \DAO\UserDAO as UserDAO;
use \Model\Publication as Publication;

    class PublicationDAO implements IPublicationDAO{
        private $connection;
        private $tableName = 'Publication';

        private $userDAO;

//======================================================================
// DAOs INJECTION
//======================================================================
        public function __construct(){
            $this->userDAO = new UserDAO();
        }

//======================================================================
// SELECT METHODS
//======================================================================
        public function GetAll(){
            $publicList = array();    

            $query = "CALL Publication_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $public = new Publication();
                $public->__fromDB($row["idPublic"],$row["openD"]
                                        ,$row["closeD"],$row["title"]
                                        ,$row["description"],$row["popularity"]
                                        ,$row["remuneration"]
                                        ,$this->userDAO->DGet($row["idUser"]));
                array_push($publicList,$public);
            }
            return $publicList;
        }

        public function GetAllByUser($idUser){
            $publicList = array();

            $query = "CALL Publication_GetByUser(?)";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $public = new Publication();
                $public->__fromDB($row["idPublic"],$row["openD"]
                                        ,$row["closeD"],$row["title"]
                                        ,$row["description"],$row["popularity"]
                                        ,$row["remuneration"]
                                        ,$this->userDAO->DGet($row["idUser"]));
                array_push($publicList,$public);                        
            }
        return $publicList;
        }

        public function GetAllByUsername($username){
                $user = $this->userDAO->DGetByUsername($username);
            $publicList = $this->GetAllByUser($user->getId());
        return $publicList;
        }

        public function Get($idPublic){
            $public = null;

            $query = "CALL Publication_GetById(?)";
            $parameters["idPublic"] = $idPublic;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $public = new Publication();
                $public->__fromDB($row["idPublic"],$row["openD"]
                                        ,$row["closeD"],$row["title"]
                                        ,$row["description"],$row["popularity"]
                                        ,$row["remuneration"]
                                        ,$this->userDAO->DGet($row["idUser"]));
            }
        return $public;
        }

        public function GetByUser($idUser){
            $public = NULL;

            $query = "CALL Publication_GetByUser(?)";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $public = new Publication();
                $public->__fromDB($row["idPublic"],$row["openD"]
                                        ,$row["closeD"],$row["title"]
                                        ,$row["description"],$row["popularity"]
                                        ,$row["remuneration"]
                                        ,$this->userDAO->DGet($row["idUser"]));
            }
        return $public;
        }

        public function GetByUsername($username){
            $user = $this->userDAO->DGetByUsername($username);
            $public = $this->GetByUser($user->getId());
        $public;
        }

//======================================================================
// INSERT METHODS
//======================================================================
        public function Add(Publication $public){
            $idLastP = 0;

            $query = "CALL publication_Add(?,?,?,?,?,?,?)";
            $parameters["openD"] = $public->getOpenDate();
            $parameters["closeD"] = $public->getCloseDate();
            $parameters["title"] = $public->getTitle();
            $parameters["description"] = $public->getDescription();
            $parameters["popularity"] = $public->getPopularity();
            $parameters["remuneration"] = $public->getRemuneration();
            $parameters["idUser"] = $public->getUser()->getId();
    
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $idLastP = $row["LastID"];
            }
        return $idLastP;
        }
        
//-----------------------------------------------------
// METHOD DEDICATED TO CREATING A PUBLICATION
//-----------------------------------------------------
        public function NewPublication(Publication $public){
                $user = $this->userDAO->DGetByUsername($public->getUser()->getUsername());
                $public->setUser($user);
            $idLastP = $this->Add($public);
            $publicN = $this->Get($idLastP);

        return $publicN;
        }
        
//======================================================================
// DELETE METHODS
//======================================================================  
        public function Delete($idPublic){
            $query = "CALL Publication_Delete(?)";
            $parameters["idPublic"] = $idPublic;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

        // ESTO SIRVE PARA BUSCAR MEDIANTE LA BARRA DE BUSQUEDA UNA PUBLICACION POR MEDIO DEL TITULO O DESCRIPCION 
        public function Search($phrase){
            $publicList = array();    
            $query = "CALL Publication_Search(?)";
            $parameters["phrase"] = $phrase;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $public = new Publication();
                $public->__fromDB($row["idPublic"],$row["openD"]
                                        ,$row["closeD"],$row["title"]
                                        ,$row["description"],$row["popularity"]
                                        ,$row["remuneration"]
                                        ,$this->userDAO->DGet($row["idUser"]));

                array_push($publicList,$public);
            }
            return $publicList;
        }
        ///////////////////////////////////////////

        //ESTO SIRVE PARA VERIFICAR QUE LA FECHA QUE INGRESA EL USUARIO COINCIDA CON LAS DISPONIBLES POR EL KEEPER
        public function ValidateDP($startD, $finishD, $idPublic){
            $rta = NULL;
            $query = "CALL Publication_DateCheck(?,?,?)";
            $parameters["openD"] = $startD;
            $parameters["closeD"] = $finishD;
            $parameters["idPublic"] = $idPublic;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $rta = $row["rta"];

                }
            return $rta;
        }
        //////////////////////////////////////
        //ESTO SIRVE PARA VALIDAR QUE LA FECHA DE RESERVA SEA CON UNA SEMANA DE ANTICIPACION
        public function ValidateOnWeek($startD){
            $rta = 0;
            $limitD = DATE("Y-m-d",STRTOTIME(DATE("Y-m-d") ."+ 7 days"));
            if($limitD<$startD){
                $rta = 1;
            }
            return $rta;
        }
        //////////////////////////////////////
        //ESTO SIRVE PARA VALIDAR QUE LA FECHA DE UNA NUEVA PUBLICACION SEA COMPATIBLE CON EL RESTO DE PUBLICACIONES DEL MISMO KEEPER
        public function ValidateDAllPublications($openD, $closeD, $user){
            $rta = NULL;
            $query = "Call Publication_NIDate(?,?,?)";
            $parameters["openD"] = $openD;
            $parameters["closeD"] = $closeD;
            $parameters["idUser"] = $this->userDAO->DGetByUsername($user->getUsername())->getId();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $rta = $row["rta"];
            }
            return $rta;
        }
        //////////////////////////////////////
    }
?>