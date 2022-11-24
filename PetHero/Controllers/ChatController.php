<?php
    namespace Controllers;

    use \DAO\ChatDAO as ChatDAO;
    use \DAO\MessageChatDAO as MessageChatDAO;
    use \DAO\UserDAO as UserDAO;
    use \Model\Chat as Chat;
    use \Model\MessageChat as MessageChat;
    use \Model\User as User;
    use \Controllers\HomeController as HomeController;

    class ChatController{
        private $chatDAO;
        private $messageChatDAO;
        private $userDAO;
        private $homeController;

        public function __construct(){
            $this->chatDAO = new ChatDAO();
            $this->messageChatDAO = new MessageChatDAO();
            $this->homeController = new HomeController();
            $this->userDAO = new UserDAO();
        }

        //METODO PARA AGREGAR UN CHAT//
        public function AddChat($idKeeper){
            $owner = new User();
            $owner = $_SESSION["logUser"]; //comprobar si esta logeado o no
            $keeper = new User();
            $keeper->setId($idKeeper);

            $chat = new Chat();
            $chat->__fromRequest($owner, $keeper);
            if($this->chatDAO->CheckChatExists($chat)==1){
                $chat = $this->chatDAO->ChatByUsers($chat);
                $messageList = $this->messageChatDAO->GetAllMsgByChat($chat->getIdChat());
                $this->homeController->ViewPanelChat($chat, $messageList);
            }else{
                $chat = $this->chatDAO->NewChat($chat);
                $messageList = $this->messageChatDAO->GetAllMsgByChat($chat->getIdChat());
                $this->homeController->ViewPanelChat($chat, $messageList);
            }
        }

        //METODO PARA ENVIAR UN MENSAJE//
        public function AddMessage($message, $chatId, $previewPage){
            $messageChat = new MessageChat();
            $user = new User();
            $user = $_SESSION["logUser"];
            
            $chat = new Chat();
            $chat =$this->chatDAO->GetById($chatId);
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $messageChat->__fromRequest($message, Date("Y-m-d H:i:s"), $chat, $user);
            $this->messageChatDAO->NewMsg($messageChat);
            $messageList = $this->messageChatDAO->GetAllMsgByChat($chat->getIdChat());
            if(strcmp($previewPage,"chatV")==0){
                require_once(VIEWS_PATH."ViewChat.php");
            }else{
                $this->homeController->ViewPanelChatHome();
            }
            
        }


    }

?>