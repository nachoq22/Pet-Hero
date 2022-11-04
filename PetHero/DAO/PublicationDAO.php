<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;

    use \DAO\IPublicationDAO as IPublicationDAO;
    use \Model\Publication as Publication;

    class PublicationDAO implements IPublicationDAO
    {
        private $connection;
        private $tableName = 'Publication';

        private function imgPPProcess($nameFile,$file,$publicationName){
            $path= "Views\Img\IMGpublication\Profile\\".$publicationName.date("YmdHis").".jpg"; 
            $path = str_replace(' ', '-', $path); 
            $pathDB =  "..\\".$path; 
            move_uploaded_file($file,$path);
            return $pathDB;
        } 

        public function Add(Publication $publication)
            {
                $query = "CALL publication_Add(?,?,?,?,?,?)";
                $parameters["openDate"] = $publication->getOpenDate();
                $parameters["closeDate"] = $publication->getCloseDate();
                $parameters["title"] = $publication->getTitle();
                $parameters["description"] = $publication->getDescription();
                $parameters["popularity"] = $publication->getPopularity();
                $parameters["remuneration"] = $publication->getRemuneration();
                $parameters["image"] = $publication->getImage();
    
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
            }
            public function Get($id){
                $publication = null;
                $query = "CALL publication_GetById(?)";
                $parameters["idPublication"] = $id;
                $this->connection = Connection::GetInstance();
                $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
    
                foreach($resultBD as $row){
                    $publication = new Publication();
    
                    $publication->__fromDB($row["idPublication"],$row["openDate"]
                    ,$row["closeDate"],$row["title"]
                    ,$row["description"],$row["popularity"]
                    ,$this->typeDAO->Get($row["remuneration"])
                    ,$this->sizeDAO->Get($row["image"]));
    
                }
                return $publication;
            }
        public function GetAll()
        {
            $publicationList = array();    

            $query = "CALL publication_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $publication = new Publication();
                $publication->__fromDB($row["idPublication"],$row["openDate"]
                ,$row["closeDate"],$row["title"],$row["description"]
                ,$row["popularity"],$row["remuneration"],$row["image"]);

                array_push($publicationList,$publication);
            }
            return $publicationList;

        }
        public function Delete($idPublication){
            $query = "CALL Publication_Delete(?)";
            $parameters["idPublication"] = $idPublication;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>