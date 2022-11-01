<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IPetDAO as IPetDAO;
use \DAO\PetTypeDAO as PetTypeDAO;
use \DAO\SizeDao as SizeDAO;
use \DAO\UserDAO as UserDAO;
use \Model\Pet as Pet;


    class PetDAO implements IPetDAO{
        private $connection;
        private $tableName = 'Pet';

        private $typeDAO;
        private $sizeDAO;
        private $userDAO;

//DAO INJECTION
        public function __construct(){
            $this->typeDAO = new PetTypeDAO();
            $this->sizeDAO = new SizeDao();
            $this->userDAO = new UserDAO();
        }
//TOOLS
        private function imgPPProcess($nameFile,$file,$petName){
        $pathDB= "Views/Img/IMGPet/Profile".$nameFile.$petName.date("YmdHis"); 
        $path =  "../".$pathDB;  
        move_uploaded_file($file,$path);
        return $pathDB;
        }    
        private function imgPVPProcess($nameFile,$file,$petName){
            $pathDB= "Views/Img/IMGPet/VaccinationPlan".$nameFile.$petName.date("YmdHis"); 
            $path =  "../".$pathDB;  
            move_uploaded_file($file,$path);
            return $pathDB;
        }       


//SELECT METHODS
        public function GetAll(){
            $petList = array();

            $query = "CALL Pet_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $pet = new Pet();
/*
                $pet->__fromDB($row["idPet"],$row["name"]
                ,$row["breed"],$row["profileIMG"]
                ,$row["vaccinationPlanIMG"],$row["observation"]
                ,$this->typeDAO->Get($row["idType"])
                ,$this->sizeDAO->Get($row["idSize"])
                ,$this->ownerDAO->Get($row["idOwner"]));
*/
                $pet->setId($row["idPet"]);
                $pet->setName($row["name"]);
                $pet->setBreed($row["breed"]);
                $pet->setProfileIMG($row["profileIMG"]);
                $pet->setVaccinationPlanIMG($row["vaccinationPlanIMG"]);
                $pet->setObservation($row["observation"]);
                array_push($petList,$pet);
            }
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
                ,$this->userDAO->Get($row["idUser"]));

            }
            return $pet;
        }

//INSERT METHODS
        private function Add(Pet $pet,$fileP,$fileNameP,$fileV,$fileNameV){
            $pet->setProfileIMG($this->imgPPProcess($fileNameP,$fileP,$pet->getName()));
            $pet->setVaccinationPlanIMG($this->imgPVPProcess($fileNameV,$fileV,$pet->getName()));

            $query = "CALL Pet_Add(?,?,?,?,?,?,?,?)";
            $parameters["name"] = $pet->getName();
            $parameters["breed"] = $pet->getBreed();
            $parameters["profileIMG"] = $pet->getProfileIMG();
            $parameters["vaccinationPlanIMG"] = $pet->getVaccinationPlanIMG();
            $parameters["observation"] = $pet->getObservation();
            $parameters["idType"] = $pet->getType()->getId();
            $parameters["idSize"] = $pet->getSize()->getId();
            $parameters["idUser"] = $pet->getUser()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function RegisterPet(Pet $pet,$fileP,$fileNameP,$fileV,$fileNameV){
            $pet->setType($this->typeDAO->GetByName($pet->getType()->getName()));
            $pet->setSize($this->sizeDAO->GetByName($pet->getSize()->getName()));
            $pet->setUser($this->userDAO->GetByUsername($pet->getUser()->getUsername()));
            $this->Add($pet,$fileP,$fileNameP,$fileV,$fileNameV);
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