<?php
namespace Controllers;

use \DAO\UserDAO as UserDAO;
use \DAO\PetDAO as PetDAO;
use \DAO\ChatDAO as ChatDAO;
use \DAO\MessageChatDAO as MessageChatDAO;
use \DAO\PublicationDAO as PublicationDAO; 
use \DAO\BookingPetDAO as BookingPetDAO;
use \DAO\ImgPublicDAO as ImgPublicDAO;

use \Model\User as User;
use \Model\Chat as Chat;

    class HomeController{
        private $userDAO;
        private $petDAO;
        private $publicDAO;
        private $bpDAO;
        private $imgPublicDAO;
        private $chatDAO;
        private $messageChatDAO;

        public function __construct(){
            $this -> userDAO = new UserDAO();
            $this -> petDAO = new PetDAO();
            $this -> publicDAO = new PublicationDAO();
            $this -> bpDAO = new BookingPetDAO();
            $this -> imgPublicDAO = new ImgPublicDAO();
            $this -> chatDAO = new ChatDAO();
            $this -> messageChatDAO = new MessageChatDAO();
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                  HOME VIEW CON TODAS LAS PUBLICATION
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function Index($message = ""){  
            $publicList = $this -> publicDAO -> GetAll();
            $imgByPublic =  $this -> imgPublicDAO -> GetAccordingPublic($publicList);

            require_once(VIEWS_PATH."Home.php");
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                                 LOGOUT
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function Logout(){
            session_destroy();
            setcookie('message', "Successful: Te has deslogueado con éxito",time() + 2,'/');
            header('Location: http://localhost/Pet-Hero/PetHero/');
            exit;
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                         FUNCIONALIDAD SEARCHBAR
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function Search($search){
            $publicList = $this -> publicDAO -> Search($search);
            $imgByPublic =  $this -> imgPublicDAO -> GetAccordingPublic($publicList);

            require_once(VIEWS_PATH."Search.php");
        }

//? ======================================================================
//!                          VIEW CONTROLLERS
//? ======================================================================
        public function ViewOwnerPanel($message=""){
            $this -> isLogged();
            $logUser = $_SESSION["logUser"];
            $this -> bpDAO->UpdateAllStates();

            $owner = $this -> userDAO -> DGetByUsername($logUser -> getUsername());
            $petList = $this -> petDAO -> GetAllByUsername($owner -> getUsername()); 
            $bookList = $this -> bpDAO -> GetAllBooksByUsername($owner -> getUsername());
            $bPetsList = $this -> bpDAO -> GetAllPetsBooks($owner -> getUsername()); 
            $imgList = $this -> imgPublicDAO -> GetByBookings($bookList);

            require_once(VIEWS_PATH."OwnerPanel.php");
        }
        
        public function ViewAddPet(){
            $this -> isLogged();

            require_once(VIEWS_PATH."AddPet.php");
        }

        public function ViewRequestReservation(){
            $this -> isLogged();

            require_once(VIEWS_PATH."ReqReservation.php");
        }

        public function ViewBeKeeper($message = ""){
            $this -> isLogged();

            require_once(VIEWS_PATH."BeKeeper.php");
        }

        public function ViewKeeperPanel($message=""){
            $this->isLogged();
            $this->isKeeper();
            $logUser = $_SESSION["logUser"];
            $this->bpDAO->UpdateAllStates();
            
            $keeper = $this -> userDAO -> DGetByUsername($logUser -> getUsername());
            $publicList = $this -> publicDAO -> GetAllByUsername($keeper -> getUsername());
            $imgByPublic = $this -> imgPublicDAO -> GetAccordingPublic($publicList);
            $bookList = $this -> bpDAO -> GetAllBooksByKeeper($keeper -> getUsername()); 
            $bPetsList = $this -> bpDAO -> GetAllPetsByBooks($keeper -> getUsername());
            $imgList = $this -> imgPublicDAO -> GetByBookings($bookList);

            require_once(VIEWS_PATH."KeeperPanel.php");
        }     

        public function ViewAddPublication($message = ""){
            $this -> isLogged();
            $this -> isKeeper();
            $public = null;

            require_once(VIEWS_PATH."AddPublication.php");
        } 

//! CORTAR REDIRECCION Y VOLVER CON UN MENSAJE SI ES QUE POSEE BOOKINGS ACTIVOS ANTES DE SIQUIERA LLEGAR AL FORMULARIO?        
        public function ViewUpdatePublication($idPublic){
            $this -> isLogged();
            $this -> isKeeper();
            $public = $this -> publicDAO -> Get($idPublic);

            require_once(VIEWS_PATH."AddPublication.php");
        } 

        // public function ViewAddReview(){
        //     $this -> isLogged();
        //     $public = $this -> publicDAO -> Get(1);

        //     require_once(VIEWS_PATH."AddReview.php");
        // }

//! ERRORES AL ENVIAR MENSAJE POR PRIMERA VEZ, HEADER SE CUELGA. CREO QUE SERIA MEJOR BORRR EL INTERMEDIO E IR AL PANEL GRAL.        
        public function ViewPanelChat(Chat $chat, $messageList){
            $this -> isLogged();
            $user = new User();
            $user = $_SESSION["logUser"];

            require_once(VIEWS_PATH."ViewChat.php");
        }

        public function ViewPanelChatHome(){
            $this -> isLogged();
            $user = new User();
            $user = $_SESSION["logUser"];
            $chatList = $this -> chatDAO -> ChatsByUser($user -> getUsername());
            $messageAllList = $this -> messageChatDAO -> GetByAllChats($chatList);

            require_once(VIEWS_PATH."ViewChatPanel.php");
        }


//? ======================================================================
//!                           VALIDACIONES DE SESSION
//? ======================================================================
        public function isLogged(){
            if(!isset($_SESSION["logUser"])){
                setcookie('message', "Error: No ha iniciado Session",time() + 2,'/');
                header('Location: http://localhost/Pet-Hero/PetHero/');
                exit;
            }
        }

        public function isKeeper(){
            if(!isset($_SESSION["isKeeper"])){
                setcookie('message', "Error: No posee permisos para ingresar",time() + 2,'/');
                header('Location: http://localhost/Pet-Hero/PetHero/');
                exit;
            }
        }
    }
?>