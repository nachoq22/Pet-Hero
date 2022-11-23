<?php
    namespace DAO;
    use \Model\MessageChat as MessageChat;
    use \DAO\IMessageChatDAO as IMessageChatDAO;
    use \DAO\UserDAO as UserDAO;
    use \DAO\ChatDAO as ChatDAO;
    use Exception as Exception;

    class MessageChatDAO implements IMessageChatDAO{
        private $connection;
        private $tableName = 'MessageChat';

        private $userDAO;
        private $chatDAO;

        //DAO INJECTION
        public function __construct()
        {
            $this->userDAO = new UserDAO();
            $this->chatDAO = new ChatDAO();
        }

        //Add
        public function AddMsg(MessageChat $messagechat){
            $query = "CALL MessageChat_Add(?,?,?,?)";
            $parameters["message"] = $messagechat->getMessage();
            $parameters["dateTime"] = $messagechat->getDateTime();
            $parameters["idChat"] = $messagechat->getChat()->getIdChat();
            $parameters["idSender"] = $messagechat->getSender()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function NewMsg(MessageChat $messagechat){
            try{
                $sender = $this->userDAO->DGetByUsername($messagechat->getSender()->getUsername());               
            $messagechat->setSender($sender);
            $this->AddMsg($messagechat);
            }catch(Exception $e){
                return "Error: No se pudo enviar el mensaje";
            }
        }

        public function GetAll()
        {
            $messageChatList = array();    

            $query = "CALL MessageChat_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $messageChat = new MessageChat();
                $messageChat->__fromDB($row["idMessageChat"],$row["message"],$row["dateTime"],$this->chatDAO->GetById($row["idChat"]),$this->userDAO->DGet($row["idSender"]));

                array_push($chatList,$messageChat);
            }
            return $chatList;
        }

        public function GetAllMsgByChat($idChat){
            $messageChatList = array();

            $query = "CALL MessageChat_GetAllMsgByChat(?)";
            $parameters["idChat"] = $idChat;

            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $messageChat = new MessageChat();
                $messageChat->__fromDB($row["idMessageChat"], $row["message"]
                                        ,$row["dateTime"],$this->chatDAO->GetById($row["idChat"]),
                                        $this->userDAO->DGet($row["idSender"]));
                array_push($messageChatList, $messageChat);
            }
            return $messageChatList;
        }

        public function GetByAllChats($chatList){
            $allMsg = array();
            foreach($chatList as $chat){
                $msgByChat = array();
                $msgByChat = $this->GetAllMsgByChat($chat->getIdChat());
                array_push($allMsg, $msgByChat);
            }
            return $allMsg;
        }

        public function GetLastMsgByChat($idChat){
            $query = "CALL MessageChat_GetLastMsgByChat(?)";
            $parameters["idChat"] = $idChat;

            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $messageChat = new MessageChat();
                $messageChat->__fromDB($row["idMessageChat"], $row["message"]
                                        ,$row["dateTime"],$this->chatDAO->GetById($row["idChat"]),
                                        $this->userDAO->DGet($row["idSender"]));
            }
            return $messageChat;
        }



        public function GetById($idChat){
            $chat = null;
            $query = "CALL MessageChat_GetById(?)";
            $parameters["idMessageChat"] = $idChat;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $messageChat = new MessageChat();

                $messageChat->__fromDB($row["idMessageChat"],$row["message"],$row["dateTime"],$this->chatDAO->GetById($row["idChat"]),$this->userDAO->DGet($row["idSender"]));
            }
            return $chat;
        }

        public function Delete($idMessageChat){
            $query = "CALL MessageChat_GetById(?)";
            $parameters["idMessageChat"] = $idMessageChat;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
        ///////////////////////////////

        


    }
?>
