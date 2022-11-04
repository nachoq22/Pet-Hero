<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;

    use \DAO\IPublicIMGDAO as IPublicIMGDAO;
    use \Model\PublicIMG as PublicIMG;
    use \Model\Publication as Publication;

    class PublicIMGDAO implements IPublicIMGDAO
    {
        private $connection;
        private $tableName = 'PublicIMG';

        private $id;
        private $url;
        private Publication $publication;

        private function Add(PublicIMG $publicIMG)
        {
            $query = "CALL publicIMG_Add(?,?)";
            $parameters["url"] = $publicIMG->getUrl();
            $parameters["publication"] = $publicIMG->getPublication();


            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
        public function Get($id){
            $publicIMG = null;
            $query = "CALL publicIMG_GetById(?)";
            $parameters["idPublicIMG"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $publicIMG = new PublicIMG();

                $publicIMG->__fromDB($row["idPublicIMG"],$row["url"]
                ,$row["publication"]);
            }
            return $publicIMG;
        }

        private function GetAll()
        {
            $publicIMGList = array();    

            $query = "CALL publicIMG_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $publicIMG = new publicIMG();
                $publicIMG->__fromDB($row["idpublicIMG"],$row["url"]
                ,$row["publication"]);

                array_push($publicIMGList,$publicIMG);
            }
            return $publicIMGList;

        }
        public function Delete($idPublicIMG){
            $query = "CALL publicIMG_Delete(?)";
            $parameters["idPublicIMG"] = $idPublicIMG;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        
    }


?>