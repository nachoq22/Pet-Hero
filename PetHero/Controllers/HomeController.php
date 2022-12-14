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
            $this->userDAO = new UserDAO();
            $this->petDAO = new PetDAO();
            $this->publicDAO = new PublicationDAO();
            $this->bpDAO = new BookingPetDAO();
            $this->imgPublicDAO = new ImgPublicDAO();
            $this->chatDAO = new ChatDAO();
            $this->messageChatDAO = new MessageChatDAO();
        }

        //METODO QUE LLEVA AL HOME, SE MUESTRAN TODAS LAS PUBLICACIONES//
        public function Index($message = ""){  
            $publicList = $this->publicDAO->GetAll();
            $imgByPublic =  $this->imgPublicDAO->GetAccordingPublic($publicList);
            require_once(VIEWS_PATH."Home.php");
        }

        //METODO PARA DESLOGEARSE DE LA PAGINA//
        public function Logout(){
            session_destroy();
            $this->Index("Successful: Te has deslogueado con exito");
        }

        //METODO PARA BUSCAR DETERMINADAS PUBLICACIONES CON PALABRAS ESPECIFICAS//
        public function Search($search){
            $publicList = $this->publicDAO->Search($search);
            $imgByPublic =  $this->imgPublicDAO->GetAccordingPublic($publicList);
            require_once(VIEWS_PATH."Search.php");
        }

        //METODO PARA IR AL OWNER PANEL, DONDE SE MOSTRARAN MASCOTAS Y RESERVAS//
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

        //======================================================================
        // VIEWS METHODS
        //======================================================================
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

        public function ViewAddPublication($message = ""){
            $this->isLogged();
            $this->isKeeper();
            require_once(VIEWS_PATH."AddPublication.php");
        } 

        public function ViewAddReview(){
            $this->isLogged();
            $public = $this->publicDAO->Get(1);
            require_once(VIEWS_PATH."AddReview.php");
        }

        public function ViewPanelChat(Chat $chat, $messageList){
            $this->isLogged();
            $user=new User();
            $user=$_SESSION["logUser"];
            require_once(VIEWS_PATH."ViewChat.php");
        }

        public function ViewPanelChatHome(){
            $this->isLogged();
            $user=new User();
            $user=$_SESSION["logUser"];
            $chatList = $this->chatDAO->ChatByUser($user->getUsername());
            $messageAllList = $this->messageChatDAO->GetByAllChats($chatList);

            require_once(VIEWS_PATH."ViewChatPanel.php");
        }


        //======================================================================
        // METODOS PARA COMPROBAR SESIONES
        //======================================================================
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
    }
?>

