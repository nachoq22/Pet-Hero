<?php
namespace Controllers;
use \DAO\UserDAO as UserDAO;
use \DAO\PetDAO as PetDAO;
use \DAO\PublicationDAO as PublicationDAO; 
use \DAO\BookingPetDAO as BookingPetDAO;
use \DAO\ImgPublicDAO as ImgPublicDAO;
use \DAO\CheckerDAO as CheckerDAO;
use \Model\User as User;

    class HomeController{
        private $userDAO;
        private $petDAO;
        private $publicDAO;
        private $bpDAO;
        private $imgPublicDAO;
        private $checkerDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->petDAO = new PetDAO();
            $this->publicDAO = new PublicationDAO();
            $this->bpDAO = new BookingPetDAO();
            $this->imgPublicDAO = new ImgPublicDAO();
            $this->checkerDAO = new CheckerDAO();
        }

        public function ViewChecker(){
            //$this->isLogged();
            $checker = $this->checkerDAO->Get(1);
            require_once(VIEWS_PATH."ViewChecker.php");
        }

        public function Index($message = ""){
            $publicList = $this->publicDAO->GetAll();
            $imgByPublic =  $this->imgPublicDAO->GetAccordingPublic($publicList);
            require_once(VIEWS_PATH."Home.php");
        }

        public function Logout(){
            session_destroy();
            $this->Index("Successful: Te has deslogueado con exito");
        }

        public function Search($search){
            $publicList = $this->publicDAO->Search($search);
            require_once(VIEWS_PATH."Search.php");
        }

        public function ViewOwnerPanel($message=""){
        $this->isLogged();
                $this->bpDAO->UpdateAllStates();
                $logUser = $_SESSION["logUser"];
            $owner = $this->userDAO->DGetByUsername($logUser->getUsername());
            $petList = $this->petDAO->GetAllByUsername($owner->getUsername()); 
            $bookList = $this->bpDAO->GetAllBooksByUsername($owner->getUsername());
            $bPetsList = $this->bpDAO->GetAllPetsBooks($owner->getUsername()); 
            $imgList = $this->imgPublicDAO->GetByBookings($bookList);
            require_once(VIEWS_PATH."OwnerPanel.php");
        }

        public function ViewAddPet(){
            $this->isLogged();
            require_once(VIEWS_PATH."AddPet.php");
        }

        public function ViewRequestReservation(){
            $this->isLogged();
            require_once(VIEWS_PATH."ReqReservation.php");
        }

        public function ViewBeKeeper($message = ""){
            $this->isLogged();
            require_once(VIEWS_PATH."BeKeeper.php");
        }

        public function ViewKeeperPanel($message=""){
                $this->isLogged();
                $this->isKeeper();
                $this->bpDAO->UpdateAllStates();
            $logUser = $_SESSION["logUser"];
            $keeper = $this->userDAO->DGetByUsername($logUser->getUsername());
            $publicList = $this->publicDAO->GetAllByUsername($keeper->getUsername());
            $imgByPublic = $this->imgPublicDAO->GetAccordingPublic($publicList);
            $bookList = $this->bpDAO->GetAllBooksByKeeper($keeper->getUsername()); 
            $bPetsList = $this->bpDAO->GetAllPetsByBooks($keeper->getUsername());
            $imgList = $this->imgPublicDAO->GetByBookings($bookList);
            require_once(VIEWS_PATH."KeeperPanel.php");
        }     

        public function ViewAddPublication(){
            $this->isLogged();
            $this->isKeeper();
            require_once(VIEWS_PATH."AddPublication.php");
        } 

        public function ViewAddReview(){
            $this->isLogged();
            $public = $this->publicDAO->Get(1);
            require_once(VIEWS_PATH."AddReview.php");
        }

        public function isLogged(){
            if(!isset($_SESSION["logUser"])){
                $this->Index("Error: No ha iniciado Session");  
            }
        }

        public function isKeeper(){
            if(!isset($_SESSION["isKeeper"])){
                $this->Index("Error: No posee permisos para ingresar");  
            }
        }

//METODOS ANTIGUOS
/*
        public function ViewLogin(){
            require_once(VIEWS_PATH."login.php");
        }

        public function ViewAddTemplates(){
            require_once(VIEWS_PATH."AddForms.php");
        }

        public function ViewPersonalInfo(){
            require_once(VIEWS_PATH."PersonalData.php");
        }

        public function ViewPetList(){
            require_once(VIEWS_PATH."PetList.php");
        }
*/
    }
?>