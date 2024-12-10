<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IPublicationDAO as IPublicationDAO;
use \DAO\UserDAO as UserDAO;

use \Model\Publication as Publication;

    class PublicationDAO implements IPublicationDAO{
        private $connection;
        //private $tableName = 'Publication';

        private $userDAO;

//? ======================================================================
//!                           DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this -> userDAO = new UserDAO();
        }


//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================
        public function GetAll(){
            $publicList = array();    

            $query = "CALL Publication_GetAll()";
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $public = new Publication();
                $public -> __fromDB($row["idPublic"], $row["openD"]
                                  , $row["closeD"],$row["title"]
                                  , $row["description"],$row["popularity"]
                                  , $row["remuneration"]
                                  , $this -> userDAO -> DGet($row["idUser"]));
                array_push($publicList,$public);
            }
        return $publicList;
        }
    
/*
*  D: Método que busca todas las publicaciones por medio del ID de un usuario
!     Metodo fundamental utilizado en GetAllByUsername()
*  A: el ID del usuario en cuestion
*  R: Retorna una lista de publicaciones pertenencientes al usuario ingresado
🐘*/    
        public function GetAllByUser($idUser){
            $publicList = array();

            $query = "CALL Publication_GetByUser(?)";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $public = new Publication();
                $public -> __fromDB($row["idPublic"], $row["openD"]
                                  , $row["closeD"], $row["title"]
                                  , $row["description"], $row["popularity"]
                                  , $row["remuneration"]
                                  , $this -> userDAO -> DGet($row["idUser"]));
                array_push($publicList,$public);                        
            }
        return $publicList;
        }

/*
*  D: Método que retorna todas las publicaciones por medio de un username
!     Utiliza la funcion DGetByUsername() y por medio de GetAllByUser() recupera la lista
*  A: un string con el nombre de usuario a buscar
*  R: Retorna una lista de publicaciones pertenencientes al usuario ingresado
🐘*/                
        public function GetAllByUsername($username){
            $user = $this -> userDAO -> DGetByUsername($username);
            $publicList = $this -> GetAllByUser($user -> getId());
        return $publicList;
        }

        public function Get($idPublic){
            $public = null;

            $query = "CALL Publication_GetById(?)";
            $parameters["idPublic"] = $idPublic;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $public = new Publication();
                $public -> __fromDB($row["idPublic"], $row["openD"]
                                  , $row["closeD"], $row["title"]
                                  , $row["description"], $row["popularity"]
                                  , $row["remuneration"]
                                  , $this -> userDAO -> DGet($row["idUser"]));
            }
        return $public;
        }

        public function GetByUser($idUser){
            $public = NULL;

            $query = "CALL Publication_GetByUser(?)";
            $parameters["idUser"] = $idUser;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $public = new Publication();
                $public -> __fromDB($row["idPublic"], $row["openD"]
                                  , $row["closeD"], $row["title"]
                                  , $row["description"], $row["popularity"]
                                  , $row["remuneration"]
                                  , $this -> userDAO -> DGet($row["idUser"]));
            }
        return $public;
        }

        public function GetByUsername($username){
            $user = $this -> userDAO -> DGetByUsername($username);
            $public = $this -> GetByUser($user -> getId());
        return $public;
        }


//? ======================================================================
// !                          INSERT METHODS
//? ======================================================================
        public function Add(Publication $public){
            $idLastPublication = 0;

            $query = "CALL publication_Add(?,?,?,?,?,?,?)";
            $parameters["openD"] = $public -> getOpenDate();
            $parameters["closeD"] = $public -> getCloseDate();
            $parameters["title"] = $public -> getTitle();
            $parameters["description"] = $public -> getDescription();
            $parameters["popularity"] = $public -> getPopularity();
            $parameters["remuneration"] = $public -> getRemuneration();
            $parameters["idUser"] = $public -> getUser() -> getId();
    
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $idLastPublication = $row["LastID"];
            }
        return $idLastPublication;
        }

        
//? ======================================================================
//!                           UPDATE METHODS
//? ======================================================================     
        public function UpdatePublication(Publication $public){
            $query = "CALL Publication_Update(?,?,?,?,?,?);";
            $parameters["idPublicIn"] = $public -> getId();
            $parameters["openDIn"] = $public -> getOpenDate();
            $parameters["closeDIn"] = $public -> getCloseDate();
            $parameters["titleIn"] = $public -> getTitle();
            $parameters["descriptionIn"] = $public -> getDescription();
            $parameters["remunerationIn"] = $public -> getRemuneration();

            $this -> connection = Connection::GetInstance();
            $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);
        }
        

//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================
        public function Delete($idPublic){
            $query = "CALL Publication_Delete(?)";
            $parameters["idPublic"] = $idPublic;

            $this -> connection = Connection::GetInstance();
            $this -> connection -> ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        

//? ======================================================================
//!                           ESPECIAL METHODS
//? ======================================================================
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××  
//¬         MÉTODO PARA REGISTRAR UNA PUBLICACIÓN
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function NewPublication(Publication $public){

            $user = $this -> userDAO -> DGetByUsername($public -> getUser() -> getUsername());
            $public -> setUser($user);
            $idLastPublication = $this -> Add($public);
            $newPublication = $this -> Get($idLastPublication);

        return $newPublication;
        }


//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××  
//¬   BUSCAR PUBLICACIÓN POR TITULO O DESCRIPCIÓN A TRAVES DE SEARCHBAR
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function Search($phrase){
            $publicList = array();    
            $query = "CALL Publication_Search(?)";
            $parameters["phrase"] = $phrase;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $public = new Publication();
                $public -> __fromDB($row["idPublic"], $row["openD"]
                                  , $row["closeD"], $row["title"]
                                  , $row["description"], $row["popularity"]
                                  , $row["remuneration"]
                                  , $this -> userDAO -> DGet($row["idUser"]));
                array_push($publicList,$public);
            }
        return $publicList;
        }


//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬   VERIFICA QUE LAS FECHAS DEL RANGO DE LA RESERVA ESTEN DENTRO DE LAS DE LA PUBLICATION
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function ValidateDP($startD, $finishD, $idPublic){
            $rta = NULL;
            $query = "CALL Publication_DateCheck(?,?,?)";
            $parameters["openD"] = $startD;
            $parameters["closeD"] = $finishD;
            $parameters["idPublic"] = $idPublic;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $rta = $row["rta"];
            }
        return $rta;
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬   VERIFICACIÓN FECHA DE RESERVA = UNA SEMANA DE ANTICIPACION.
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function ValidateOnWeek($startD){
            $rta = 0;
            $limitD = DATE("Y-m-d",STRTOTIME(DATE("Y-m-d") ."+ 7 days"));
            if($limitD < $startD){
                $rta = 1;
            }
            return $rta;
        }



//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬   VERIFICA QUE LAS FECHA DE UNA NUEVA PUBLICACIÓN NO INTERCALE CON EL RESTO.
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
    //     public function ValidateDAllPublications($openD, $closeD, $user){
    //         $rta = NULL;
    //         $query = "Call Publication_NIDate(?,?,?)";
    //         $parameters["openD"] = $openD;
    //         $parameters["closeD"] = $closeD;
    //         $parameters["idUser"] = $this->userDAO->DGetByUsername($user->getUsername())->getId();
    //         $this->connection = Connection::GetInstance();
    //         $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

    //         foreach($resultBD as $row){
    //             $rta = $row["rta"];
    //         }
    //         return $rta;
    //     }
    // }

    public function ValidateDAllPublications(Publication $public){
        $rta = NULL;
        $query = "Call Publication_NIDate(?,?,?)";
        $parameters["openD"] = $public -> getOpenDate();
        $parameters["closeD"] = $public -> getCloseDate();
        $parameters["idUser"] = $this->userDAO->DGetByUsername($public->getUser()->getUsername())->getId();
        $this->connection = Connection::GetInstance();
        $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

        foreach($resultBD as $row){
            $rta = $row["rta"];
        }
        return $rta;
    }
}
?>