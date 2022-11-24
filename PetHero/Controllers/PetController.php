<?php
namespace Controllers;
use \DAO\PetDAO as PetDAO;
use \DAO\UserDAO as UserDAO;

use \Model\Pet as Pet;
use \Model\Size as Size;
use \Model\PetType as PetType;
use \Model\User as User;

use \Controllers\HomeController as HomeController;

        class PetController{
            private $petDAO;
            private $userDAO;
            private $homeController;

        public function __construct(){
            $this->petDAO = new PetDAO();
            $this->userDAO = new UserDAO();
            $this->homeController = new HomeController();
        }

        //======================================================================
        // FUNCIONES DE VIEWS
        //======================================================================
        public function ViewPetList(){
            //$petList = $this->petDAO->GetAllByUser($_SESSION["loggedUser"]->getName());
            $petList = $this->petDAO->GetAll();
            require_once(VIEWS_PATH."PetList.php");
        }

        public function ViewPetProfile($idPet){
            $this->homeController->isLogged();
            $petaux = $this->petDAO->Get($idPet);
            require_once(VIEWS_PATH."PetProfile.php");
        }

        public function showListView(){
            $petDAO=$this->petDAO->GetAll();
        }

        //FUNCION PARA AGREGAR UNA NUEVA MASCOTA//
        public function Add($name, $breed, $type, $size, $observation,$ImagenP,$ImagenV){
            $this->homeController->isLogged();
            $sizeOBJ = new Size();
            $sizeOBJ->setName($size);
            $typeOBJ = new PetType();
            $typeOBJ->setName($type);
            $logUser = $_SESSION["logUser"];
            $pet = new Pet();
            $pet->__fromRequest($name, $breed, $observation, $typeOBJ, $sizeOBJ, $logUser);   
            $fileNameP = $_FILES['ImagenP']['name'];
            $fileP = $_FILES['ImagenP']['tmp_name'];
            $fileNameV = $_FILES['ImagenV']['name'];
            $fileV = $_FILES['ImagenV']['tmp_name'];
            $message = $this->petDAO->RegisterPet($pet, $fileP, $fileNameP, $fileV, $fileNameV);
            $this->homeController->ViewOwnerPanel($message);      
        } 

        //RECUPERAR LOS PETS MEDIANTE UNA RESERVACION//
        public function GetPetsByReservation($idPublic, $startD, $finishD, $message=""){
            $this->homeController->isLogged();
            $logUser = $_SESSION["logUser"];
            $petList = $this->petDAO->GetAllByUsername($logUser->getUsername());
            if(!empty($petList)){
            require_once(VIEWS_PATH."AddBooking.php");
            }else{
                $this->homeController->ViewOwnerPanel("Error: antes de hacer una reserva debe tener al menos una mascota registrada");
            }
        }
    }
?>