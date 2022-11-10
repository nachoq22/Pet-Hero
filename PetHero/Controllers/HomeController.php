<?php
namespace Controllers;
/*
use \DAO\LocationDAO as LocationDAO;
use \DAO\SizeDAO as SizeDAO;
use \DAO\PetTypeDAO as PetTypeDAO;
*/
use \DAO\UserDAO as UserDAO;
use \DAO\PetDAO as PetDAO;
use \DAO\PublicationDAO as PublicationDAO; 
use \DAO\BookingPetDAO as BookingPetDAO;
use \DAO\ImgPublicDAO as ImgPublicDAO;

    class HomeController{
        /*
        private $locationDAO;
        private $sizeDAO;
        private $typeDAO;
        */
        private $userDAO;
        private $petDAO;
        private $publicDAO;
        private $bpDAO;

        private $imgPublicDAO;

        public function __construct(){
            /*
            $this->locationDAO = new LocationDAO();
            $this->sizeDAO = new SizeDao();
            $this->typeDAO = new PetTypeDAO();
            */
            $this->userDAO = new UserDAO();
            $this->petDAO = new PetDAO();
            $this->publicDAO = new PublicationDAO();
            $this->bpDAO = new BookingPetDAO();
            $this->imgPublicDAO = new ImgPublicDAO();
        }

        public function Index($message = ""){
            $publicList = $this->publicDAO->GetAll();
            require_once(VIEWS_PATH."Home.php");
        }

        public function ViewLogin(){
            require_once(VIEWS_PATH."login.php");
        }
        public function ViewAddTemplates(){
            require_once(VIEWS_PATH."AddForms.php");
        }

        public function ViewPersonalInfo(){
            require_once(VIEWS_PATH."PersonalData.php");
        }

        public function ViewAddPet(){
            require_once(VIEWS_PATH."AddPet.php");
        }

        public function ViewPetList(){
            require_once(VIEWS_PATH."PetList.php");
        }

        public function ViewBeKeeper($message = ""){
            require_once(VIEWS_PATH."BeKeeper.php");
        }

        public function ViewAddPublication(){
            require_once(VIEWS_PATH."AddPublication.php");
        }

        public function ViewRequestReservation(){
            require_once(VIEWS_PATH."ReqReservation.php");
        }

        public function ViewOwnerPanel(){
            //$owner = $this->userDAO->DGet(2);   /*$owner = $this->userDAO->DGetByUsername(2);*/
            $petList = $this->petDAO->GetAllByUsername("venus"); /*$petList = $this->petDAO->GetAllByUsername("sculpordwarf");*/ 
            $bookList = $this->bpDAO->GetBookByUsername("venus"); /*$bookList = $this->bookDAO->GetByOwner(?);*/ 
            $bPetsList = $this->bpDAO->GetAllPetsBooks("venus"); 
            $imgList = $this->imgPublicDAO->GetByBookings($bookList);
            //print_r($imgList);
            require_once(VIEWS_PATH."OwnerPanel.php");
        }       
        
        public function ViewKeeperPanel(){
            //$owner = $this->userDAO->DGet(2);   /*$owner = $this->userDAO->DGetByUsername(2);*/
            $petList = $this->petDAO->GetAllByUsername("sculpordwarf"); /*$petList = $this->petDAO->GetAllByUsername("sculpordwarf");*/ 
            $bookList = $this->bpDAO->GetBookByUsername("sculpordwarf"); /*$bookList = $this->bookDAO->GetByOwner(?);*/ 
            $bPetsList = $this->bpDAO->GetAllPetsBooks("sculpordwarf"); 
            $imgList = $this->imgPublicDAO->GetByBookings($bookList);
            require_once(VIEWS_PATH."KeeperPanel.php");
        }      
    }
?>