<?php
namespace Controllers;

use Exceptions\RegisterChatException;
use Exceptions\RegisterMSGException;

use \Controllers\HomeController as HomeController;

use \DAO\ChatDAO as ChatDAO;
use \DAO\MessageChatDAO as MessageChatDAO;

use \Model\Chat as Chat;
use \Model\MessageChat as MessageChat;
use \Model\User as User;

    class ChatController{
        private $chatDAO;
        private $messageChatDAO;
        private $homeController;

        public function __construct(){
            $this -> chatDAO = new ChatDAO();
            $this -> messageChatDAO = new MessageChatDAO();
            $this -> homeController = new HomeController();
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                               AGREGAR UN CHAT
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el registro
*    de un nuevo CHAT.

?      💠 CheckChatExists
¬          ► Verifica la existencia de un chat entre 2 USERS (Owner/Keeper).
?      💠 ChatByUsers
¬          ► Recupera el CHAT con la información completa desde la BDD.
?      💠 GetAllMsgByChat
¬          ► Recupera los MSG según un idChat.
?      💠 ViewPanelChat
¬          ► Invocación de HomeController para redireccion a "Chat Panel",
¬          donde se visualizan todos los contactos.
?      💠 NewChat
¬          ► Registra un nuevo CHAT en la BDD.

* A: $idKeeper: id del Keeper con el que se establecerá CHAT.

* R: No Posee.
🐘 */        
        public function AddChat($idKeeper){
            $this -> homeController -> isLogged();

            $owner = new User();
            $owner = $_SESSION["logUser"]; //* Verifica si el user actual esta logueado.
            
            $keeper = new User();
            $keeper -> setId($idKeeper);

            $chat = new Chat();
            $chat -> __fromRequest($owner, $keeper);


            $message = "Successful: Se ha creado el CHAT satisfactoriamente.";
            $success = false;
            $messageList = null;

            if($this -> chatDAO -> CheckChatExists($chat) == 1){

                $chat = $this -> chatDAO -> ChatByUsers($chat);
                $messageList = $this -> messageChatDAO -> GetAllMsgByChat($chat->getIdChat());
                $success = true;

            }else{

                try{

                    $chat = $this -> chatDAO -> NewChat($chat);
                    //$messageList = $this -> messageChatDAO -> GetAllMsgByChat($chat -> getIdChat());
                    $success = true;

                }catch(RegisterChatException $rce){
                    $message = $rce -> getMessage();
                }
            }

            setcookie('message', $message, time() + 2,'/');

            if($success){

                require_once(VIEWS_PATH."ViewChat.php");
                //$this->homeController->ViewPanelChat($chat, $messageList);
                exit;

            }else{

                header('Location: http://localhost/Pet-Hero/PetHero/');
                exit;

            }    

            //header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewPanelChat');

            //$this->homeController->ViewPanelChat($chat, $messageList);
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                            AGREGAR UN MSG AL CHAT
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el registro
*    de un nuevo MESSAGE.

?      💠 GetById
¬          ► Recupera la informacion completa del CHAT según ID.
?      💠 NewMsg
¬          ► Registra un nuevo MSG en la BDD asociado a un CHAT.
?      💠 GetAllMsgByChat
¬          ► Recupera los MSG según un idChat.
?      💠 ViewPanelChatHome
¬          ► Invocación de HomeController para redireccion a "Chat Panel",
¬          donde se visualizan todos los contactos.

* A: $message: Mensaje a registrar entre 2 USERs.
*    $chatId: id del CHAT al que se asociara el MSG.
*    $previewPage: ?

* R: No Posee.
🐘 */   
        public function AddMessage($message, $chatId, $previewPage){
            $this -> homeController -> isLogged();

            $messageChat = new MessageChat();
            $user = new User();
            $user = $_SESSION["logUser"];
            
            $chat = new Chat();
            $chat = $this -> chatDAO -> GetById($chatId);
            date_default_timezone_set('America/Argentina/Buenos_Aires');

            $messageChat -> __fromRequest($message, Date("Y-m-d H:i:s"), $chat, $user);
            $message = "Successful: Se ha enviado correctamente el MSG";

            try{

                $this -> messageChatDAO -> NewMsg($messageChat);

            }catch(RegisterMSGException $rme){
                $message = $rme -> getMessage();
            }

            $messageList = $this -> messageChatDAO -> GetAllMsgByChat($chat -> getIdChat());
            

            if(strcmp($previewPage,"chatV") == 0){
                require_once(VIEWS_PATH."ViewChat.php");
                exit;
            }else{
                header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewPanelChatHome');
                exit;
            }
        }
    }
?>