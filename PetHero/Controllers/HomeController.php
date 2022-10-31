<?php
namespace Controllers;


use \DAO\LocationDAO as LocationDAO;
use \DAO\SizeDAO as SizeDAO;
use \DAO\PetTypeDAO as PetTypeDAO;
use \Model\PetType as PetType;

    class HomeController
    {
        private $locationDAO;
        private $sizeDAO;
        private $typeDAO;

        public function __construct(){

            $this->locationDAO = new LocationDAO();
            $this->sizeDAO = new SizeDao();
            $this->typeDAO = new PetTypeDAO();
        }

        public function Index()
        {
            $locationList=$this->locationDAO->GetAll();
            $sizeList=$this->sizeDAO->GetAll();
            $typeList=$this->typeDAO->GetAll();
            //$userList =$this->userDAO->GetAll();
            //$userIs=$this->userDAO->Get(2);
            //require_once(VIEWS_PATH."PetList.php");
            require_once(VIEWS_PATH."Home.php");
        }

        public function ViewLogin()
        {
            require_once(VIEWS_PATH."login.php");
        }
        public function ViewAddTemplates()
        {
            require_once(VIEWS_PATH."AddForms.php");
        }

        public function ViewPersonalInfo()
        {
            require_once(VIEWS_PATH."PersonalData.php");
        }

        public function ViewAddPet()
        {
            require_once(VIEWS_PATH."AddPet.php");
        }

        public function ViewPetList()
        {
            require_once(VIEWS_PATH."PetList.php");
        }

        

        
    }
?>