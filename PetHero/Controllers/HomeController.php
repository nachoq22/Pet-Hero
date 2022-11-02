<?php
namespace Controllers;


use \DAO\LocationDAO as LocationDAO;
use \DAO\SizeDAO as SizeDAO;
use \DAO\PetTypeDAO as PetTypeDAO;
use \DAO\UserDAO as UserDAO;

    class HomeController
    {
        private $locationDAO;
        private $sizeDAO;
        private $typeDAO;
        private $userDAO;

        public function __construct(){
            $this->locationDAO = new LocationDAO();
            $this->sizeDAO = new SizeDao();
            $this->typeDAO = new PetTypeDAO();
            $this->userDAO = new UserDAO();
        }

        public function Index()
        {
            $locationList=$this->locationDAO->GetAll();
            $sizeList=$this->sizeDAO->GetAll();
            $typeList=$this->typeDAO->GetAll();
            $userList =$this->userDAO->DefGetAll();
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

        public function ViewPetList(){

            require_once(VIEWS_PATH."PetList.php");
        }

        public function ViewBeKeeper(){
            require_once(VIEWS_PATH."BeKeeper.php");
        }

        public function ViewAddPublication(){
            require_once(VIEWS_PATH."AddPublication.php");
        }

        public function ViewRequestReservation(){
            require_once(VIEWS_PATH."ReqReservation.php");
        }
    }
?>