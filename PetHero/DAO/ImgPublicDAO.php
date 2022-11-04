<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;

    use \DAO\IImgPublicDAO as IImgPublicDAO;
    use \DAO\PublicationDAO as PublicationDAO;
    use \Model\ImgPublic as ImgPublic;


    class ImgPublicDAO implements IImgPublicDAO{
        private $connection;
        private $tableName = 'ImgPublic';
        private $publicDAO;

        public function __construct(){
            $this->publicDAO = new PublicationDAO();
        }

        public function Add(ImgPublic $imgPublic){
            $query = "CALL ImgPublic_Add(?,?)";
            $parameters["url"] = $imgPublic->getUrl();
            $parameters["idPublic"] = $imgPublic->getPublication()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function Get($idImg){
            $publicIMG = null;
            $query = "CALL ImgPublic_GetById(?)";
            $parameters["idImg"] = $idImg;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $imgPublic = new ImgPublic();

                $imgPublic->__fromDB($row["idImg"],$row["url"],$this->publicDAO->Get($row["idPublic"]));
            }
            return $publicIMG;
        }

        public function GetAll(){
            $imgPublicList = array();    

            $query = "CALL ImgPublic_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $imgPublic = new ImgPublic();
                $imgPublic->__fromDB($row["idImg"],$row["url"],$this->publicDAO->Get($row["idPublic"]));

                array_push($imgPublicList,$imgPublic);
            }
            return $imgPublicList;

        }

        public function Delete($idImg){
            $query = "CALL ImgPublic_Delete(?)";
            $parameters["idImg"] = $idImg;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }  
    }
?>