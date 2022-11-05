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

        public function __construct(){
            $this->userDAO = new UserDAO();
        }

        private function imgPPProcess($nameFile,$file,$publicationName){
            $path= "Views\Img\IMGpublication\Profile\\".$publicationName.date("YmdHis").".jpg"; 
            $path = str_replace(' ', '-', $path); 
            $pathDB =  "..\\".$path; 
            move_uploaded_file($file,$path);
            return $pathDB;
        } 

        public function Add(Publication $public){
            $query = "CALL publication_Add(?,?,?,?,?,?)";
            $parameters["openD"] = $public->getOpenDate();
            $parameters["closeD"] = $public->getCloseDate();
            $parameters["title"] = $public->getTitle();
            $parameters["description"] = $public->getDescription();
            $parameters["popularity"] = $public->getPopularity();
            $parameters["remuneration"] = $public->getRemuneration();
            $parameters["idUser"] = $public->getUser()->getId();
    
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
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
                                        ,$this->userDAO->Get($row["idUser"]));
                }
            return $public;
        }

        public function GetByUser($idUser){
            $query = "CALL Publication_GetByUser(?)";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            $publication = new Publication();
            $book->__fromDB($row["idPublic"],$row["openD"]
            ,$row["closeD"],$row["title"]
            ,$row["description"],$row["popularity"],$row["remuneration"]
            ,$this->sizeDAO->Get($row["idUser"]));
            return $public;
        }

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
                                        ,$this->userDAO->Get($row["idUser"]));

                array_push($publicList,$public);
            }
            return $publicList;

        }

        public function Delete($idPublic){
            $query = "CALL Publication_Delete(?)";
            $parameters["idPublic"] = $idPublic;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>