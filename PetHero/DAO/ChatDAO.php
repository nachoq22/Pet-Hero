<?php
    namespace DAO;
    use \Model\Chat as Chat;
    use \DAO\IChatDAO as IChatDAO;
    use \DAO\UserDAO as UserDAO;

    class ChatDAO implements IChatDAO{
        private $connection;
        private $tableName = 'Chat';

        private $userDAO;

        //DAO INJECTION
        public function __construct()
        {
            $this->userDAO = new UserDAO();
        }

        //Add
        public function Add(Chat $chat){
            $query = "CALL Chat_Add(?,?)";
            $parameters["idOwner"] = $chat->getOwner()->getId();
            $parameters["idKeeper"] = $chat->getKeeper()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function GetAll()
        {
            $chatList = array();    

            $query = "CALL Chat_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $chat = new chat();
                $chat->__fromBD($row["idChat"],$this->userDAO->DGet($row["idPublic"]),$this->userDAO->DGet($row["idKeeper"]));

                array_push($chatList,$chat);
            }
            return $chatList;
        }

        public function GetById($idChat){
            $chat = null;
            $query = "CALL Chat_GetById(?)";
            $parameters["idChat"] = $idChat;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $chat = new Chat();

                $chat->__fromBD($row["idChat"],$this->userDAO->DGet($row["idPublic"]),$this->userDAO->DGet($row["idKeeper"]));
            }
            return $chat;
        }

        public function Delete($idChat){
            $query = "CALL Chat_Delete(?)";
            $parameters["idChat"] = $idChat;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>

