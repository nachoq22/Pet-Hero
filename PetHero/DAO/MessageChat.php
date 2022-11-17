<?php
    namespace DAO;
    use \Model\MessageChat as MessageChat;
    use \DAO\IMessageChatDAO as IMessageChatDAO;
    use \DAO\UserDAO as UserDAO;
    use \DAO\ChatDAO as ChatDAO;

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
        public function AddMsg(MessageChat $Messagechat){
            $query = "CALL Chat_Add(?,?,?,?)";
            $parameters["message"] = $Messagechat->getMessage()->getId();
            $parameters["dateTime"] = $Messagechat->getDateTime();
            $parameters["idChat"] = $Messagechat->getChat()->getIdChat();
            $parameters["idSender"] = $Messagechat->getSender()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function GetAll()
        {
            $messageChatList = array();    

            $query = "CALL MessageChat_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $messageChat = new MessageChat();
                $messageChat->__fromDB($row["idMessageChat"],$row["message"],$row["dateTime"],$this->chatDAO->GetById($row["idChat"]),$this->userDAO->Get($row["idSender"]));

                array_push($chatList,$messageChat);
            }
            return $chatList;
        }

        public function GetById($idChat){
            $chat = null;
            $query = "CALL Chat_GetById(?)";
            $parameters["idMessageChat"] = $idChat;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $messageChat = new MessageChat();

                $messageChat->__fromDB($row["idMessageChat"],$row["message"],$row["dateTime"],$this->chatDAO->GetById($row["idChat"]),$this->userDAO->Get($row["idSender"]));
            }
            return $chat;
        }

        public function Delete($idMessageChat){
            $query = "CALL Chat_Delete(?)";
            $parameters["idMessageChat"] = $idMessageChat;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>