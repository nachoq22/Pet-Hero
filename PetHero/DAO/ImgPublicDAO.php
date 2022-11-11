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

        private function imgPuProcess($tmp_name){
            $idR = random_int(1,1000000000);
            $path= "Views\Img\IMGPublic\\".$idR."-IMGPublic".date("YmdHis").".jpg"; 
            $path = str_replace(' ', '-', $path); 
            $pathDB =  "..\\".$path; 
            move_uploaded_file($tmp_name,$path);
        return $pathDB;
        }


        public function Add(ImgPublic $imgPublic){
            $query = "CALL ImgPublic_Add(?,?)";
            $parameters["uri"] = $imgPublic->getUrl();
            $parameters["idPublic"] = $imgPublic->getPublication()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }


        public function NewPublication(ImgPublic $public,$images){
///ACA SE GUARDA LA PUBLICACION Y SE ACTUALIZA LA QUE VINO POR LA NUEVA CON ID NUEVO, PARA ASIGNAR A LAS IMG
            $publicN = $this->publicDAO->NewPublication($public->getPublication());
            $public->setPublication($publicN);
//PARA OBTENER LOS VALORES DE TMP_NAME                
            foreach($images as $k1=> $v1){
                foreach($v1 as $k2 => $v2){
                    if(strcmp($k1,"tmp_name") == 0){
                        $path = $this->imgPuProcess($images[$k1][$k2]);
                    $public->setUrl($path);
                    $this->Add($public);
                   }
                }
            }
        }

        public function Get($idImg){
            $publicIMG = null;
            $query = "CALL ImgPublic_GetById(?)";
            $parameters["idImg"] = $idImg;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $imgPublic = new ImgPublic();

                $imgPublic->__fromDB($row["idImg"],$row["uri"],$this->publicDAO->Get($row["idPublic"]));
            }
            return $publicIMG;
        }

        public function GetByPublic($idPublic){
            $publicIMG = null;
            $query = "CALL ImgPublic_GetByPublic(?)";
            $parameters["idPublic"] = $idPublic;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $publicIMG = new ImgPublic();

                $publicIMG->__fromDB($row["idImg"],$row["uri"],$this->publicDAO->Get($row["idPublic"]));
            }
            return $publicIMG;
        }

        public function GetAllByPublic($idPublic){
            $imgPublicList = array();
            $query = "CALL ImgPublic_GetByPublic(?)";
            $parameters["idPublic"] = $idPublic;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $imgPublic = new ImgPublic();
                $imgPublic->__fromDB($row["idImg"],$row["uri"],$this->publicDAO->Get($row["idPublic"]));

                array_push($imgPublicList,$imgPublic);
            }
            return $imgPublicList;
        }

        public function GetByBookings($bookList){
            $imgByBooks = array();
            $limitedPub = array();
            foreach($bookList as $book){
                if(IN_ARRAY($book->getPublication()->getid(),$limitedPub) == false){
                        ARRAY_PUSH($limitedPub,$book->getPublication()->getid());
                    $imgByP = new ImgPublic();
                    $imgByP = $this->GetByPublic($book->getPublication()->getId());
                    ARRAY_PUSH($imgByBooks,$imgByP);
                }
            }
        return $imgByBooks;
        }

        public function GetPublication(ImgPublic $public){
            return $this->publicDAO->Get($public->getPublication()->getId());
        }


        public function GetAll(){
            $imgPublicList = array();    

            $query = "CALL ImgPublic_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $imgPublic = new ImgPublic();
                $imgPublic->__fromDB($row["idImg"],$row["uri"],$this->publicDAO->Get($row["idPublic"]));

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

        public function ValidateDP($startD, $finishD, $idPublic){
            return $this->publicDAO->ValidateDP($startD, $finishD, $idPublic);
        }
    }
?>