<?php
namespace DAO;

use Exceptions\RegisterPetException;
use PDOException;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IPetDAO as IPetDAO;
use \DAO\PetTypeDAO as PetTypeDAO;
use \DAO\SizeDAO as SizeDAO;
use \DAO\UserDAO as UserDAO;

use \Model\Pet as Pet;

    class PetDAO implements IPetDAO{
        private $connection;
        private $tableName = 'Pet';

        private $typeDAO;
        private $sizeDAO;
        private $userDAO;

//? ======================================================================
//!                           DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this -> typeDAO = new PetTypeDAO();
            $this -> sizeDAO = new SizeDAO();
            $this -> userDAO = new UserDAO();
        }

//? ======================================================================
//!                             TOOL METHOD
//? ======================================================================
        private function imgPPProcess($nameFile,$file,$petName){
            $path = "Views\Img\IMGPet\Profile\\".$petName.date("YmdHis").".jpg"; 
            $path = str_replace(' ', '-', $path); 
            $pathDB =  "..\\".$path; 

            move_uploaded_file($file,$path);
        return $pathDB;
        }    

        private function imgPVPProcess($nameFile,$file,$petName){
            $path = "Views\Img\IMGPet\VaccinationPlan\\".$petName.date("YmdHis").".jpg"; 
            $path = str_replace(' ', '-', $path); 
            $pathDB =  "..\\".$path;  
            
            move_uploaded_file($file,$path);
        return $pathDB;
        }       

//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================
        public function GetAll(){
            $petList = array();

            $query = "CALL Pet_GetAll()";
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $pet = new Pet();
                $pet -> __fromDB($row["idPet"], $row["name"]
                               , $row["breed"], $row["profileIMG"]
                               , $row["vaccinationPlanIMG"], $row["observation"]
                               , $this -> typeDAO -> Get($row["idType"])
                               , $this -> sizeDAO -> Get($row["idSize"])
                               , $this -> userDAO -> dGet($row["idUser"]));

                array_push($petList, $pet);
            }
        return $petList;
        }

        public function GetAllByUser($idUser){
            $petList = array();

            $query = "CALL Pet_GetByUser(?)";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $pet = new Pet();
                $pet -> __fromDB($row["idPet"], $row["name"]
                               , $row["breed"], $row["profileIMG"]
                               , $row["vaccinationPlanIMG"], $row["observation"]
                               , $this -> typeDAO -> Get($row["idType"])
                               , $this -> sizeDAO -> Get($row["idSize"])
                               , $this -> userDAO -> DGet($row["idUser"]));
                
                array_push($petList,$pet);
            }
        return $petList;
        }

        public function GetAllByUsername($username){
            $user = $this -> userDAO -> DGetByUsername($username);
            $petList = $this -> GetAllByUser($user -> getId());
        return $petList;
        }

        public function GetAllByIds($petsIDList){
            $petList = array();
    
            foreach($petsIDList as $id){
                $pet = new Pet();
                $pet = $this -> Get($id);
                array_push($petList, $pet);
            }
        return $petList;
        }

/*
* 🐘 D: Recupera un Pet según ID.
!     Requerido por el método GetPetsByBook de BookingPetDAO.
* 🐘 A: ID del Pet a filtrar.
* 🐘 R: Pet filtrado.
*/     
        public function Get($id){
            $pet = null;
            $query = "CALL Pet_GetById(?)";
            $parameters["idPet"] = $id;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $pet = new Pet();
                $pet -> __fromDB($row["idPet"], $row["name"]
                               , $row["breed"], $row["profileIMG"]
                               , $row["vaccinationPlanIMG"], $row["observation"]
                               , $this -> typeDAO -> Get($row["idType"])
                               , $this -> sizeDAO -> Get($row["idSize"])
                               , $this -> userDAO -> DGet($row["idUser"]));
            }
        return $pet;
        }

//? ======================================================================
// !                          INSERT METHODS
//? ======================================================================
        private function Add(Pet $pet){
            $query = "CALL Pet_Add(?,?,?,?,?,?,?,?)";
            $parameters["name"] = $pet->getName();
            $parameters["breed"] = $pet->getBreed();
            $parameters["profileIMG"] = $pet->getProfileIMG();
            $parameters["vaccinationPlanIMG"] = $pet->getVaccinationPlanIMG();
            $parameters["observation"] = $pet->getObservation();
            $parameters["idSize"] = $pet->getSize()->getId();
            $parameters["idType"] = $pet->getType()->getId();
            $parameters["idUser"] = $pet->getUser()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××
//¬         MÉTODO PARA REGISTRAR UNA MASCOTA
//* ×××××××××××××××××××××××××××××××××××××××××××××××××
        public function RegisterPet(Pet $pet, $fileP, $fileNameP, $fileV, $fileNameV){
            try{

                $pet -> setType($this -> typeDAO -> GetByName($pet -> getType() -> getName()));
                $pet -> setSize($this -> sizeDAO -> GetByName($pet -> getSize() -> getName()));
                $pet -> setUser($this -> userDAO -> DGetByUsername($pet -> getUser() -> getUsername()));
                $pet -> setProfileIMG($this -> imgPPProcess($fileNameP, $fileP, $pet -> getName()));
                $pet -> setVaccinationPlanIMG($this -> imgPVPProcess($fileNameV, $fileV, $pet -> getName()));

                $this -> Add($pet,$fileP,$fileNameP,$fileV,$fileNameV);

            }
            catch(PDOException $pdoe){
                throw new RegisterPetException("Error:No se pudo registrar su PET".$pdoe -> getMessage());
            }
        }
        
//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================
        public function Delete($id){
            $query = "CALL Pet_Delete(?)";
            $parameters["idPet"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>