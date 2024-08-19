<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;
use Exception as Exception;

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

//======================================================================
// DAOs INJECTION
//======================================================================
        public function __construct(){
            $this->typeDAO = new PetTypeDAO();
            $this->sizeDAO = new SizeDAO();
            $this->userDAO = new UserDAO();
        }

//======================================================================
// METHODS TOOLS
//======================================================================
        private function imgPPProcess($nameFile,$file,$petName){
            $path= "Views\Img\IMGPet\Profile\\".$petName.date("YmdHis").".jpg"; 
            $path = str_replace(' ', '-', $path); 
            $pathDB =  "..\\".$path; 

            move_uploaded_file($file,$path);
        return $pathDB;
        }    

        private function imgPVPProcess($nameFile,$file,$petName){
            $path= "Views\Img\IMGPet\VaccinationPlan\\".$petName.date("YmdHis").".jpg"; 
            $path = str_replace(' ', '-', $path); 
            $pathDB =  "..\\".$path;  
            
            move_uploaded_file($file,$path);
        return $pathDB;
        }       

//======================================================================
// SELECT METHODS
//======================================================================
        public function GetAll(){
            $petList = array();

            $query = "CALL Pet_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $pet = new Pet();
                $pet->__fromDB($row["idPet"],$row["name"]
                              ,$row["breed"],$row["profileIMG"]
                              ,$row["vaccinationPlanIMG"],$row["observation"]
                              ,$this->typeDAO->Get($row["idType"])
                              ,$this->sizeDAO->Get($row["idSize"])
                              ,$this->userDAO->dGet($row["idUser"]));
                array_push($petList,$pet);
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
                $pet->__fromDB($row["idPet"],$row["name"]
                              ,$row["breed"],$row["profileIMG"]
                              ,$row["vaccinationPlanIMG"],$row["observation"]
                              ,$this->typeDAO->Get($row["idType"])
                              ,$this->sizeDAO->Get($row["idSize"])
                              ,$this->userDAO->DGet($row["idUser"]));
                array_push($petList,$pet);
            }
        return $petList;
        }

        public function GetAllByUsername($username){
            $user = $this->userDAO->DGetByUsername($username);
            $petList = $this->GetAllByUser($user->getId());
        return $petList;
        }

        public function Get($id){
            $pet = null;
            $query = "CALL Pet_GetById(?)";
            $parameters["idPet"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $pet = new Pet();
                $pet->__fromDB($row["idPet"],$row["name"]
                              ,$row["breed"],$row["profileIMG"]
                              ,$row["vaccinationPlanIMG"],$row["observation"]
                              ,$this->typeDAO->Get($row["idType"])
                              ,$this->sizeDAO->Get($row["idSize"])
                              ,$this->userDAO->DGet($row["idUser"]));
            }
        return $pet;
        }

//======================================================================
// INSERT METHODS
//======================================================================
        private function Add(Pet $pet,$fileP,$fileNameP,$fileV,$fileNameV){
                $pet->setProfileIMG($this->imgPPProcess($fileNameP,$fileP,$pet->getName()));
                $pet->setVaccinationPlanIMG($this->imgPVPProcess($fileNameV,$fileV,$pet->getName()));
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

//-----------------------------------------------------
// METHOD DEDICATED TO REGISTER A PET
//-----------------------------------------------------
        public function RegisterPet(Pet $pet,$fileP,$fileNameP,$fileV,$fileNameV){
            $message = "Successful: Se ha registrado correctamente su mascota";
            try{
                $pet->setType($this->typeDAO->GetByName($pet->getType()->getName()));
                $pet->setSize($this->sizeDAO->GetByName($pet->getSize()->getName()));
                $pet->setUser($this->userDAO->DGetByUsername($pet->getUser()->getUsername()));
                $this->Add($pet,$fileP,$fileNameP,$fileV,$fileNameV);
            }
            catch(Exception $e){
                $message = "Error: Se han cargado archivos invalidos, intente mas tarde";
                return $message;
            }
            return $message;
        }

        
//DELETE METHODS
        public function Delete($id){
            $query = "CALL Pet_Delete(?)";
            $parameters["idPet"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>