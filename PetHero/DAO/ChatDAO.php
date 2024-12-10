<?php
namespace DAO;

use \DAO\IChatDAO as IChatDAO;
use \DAO\UserDAO as UserDAO;

use PDOException;
use Exceptions\RegisterChatException;

use \Model\Chat as Chat;


    class ChatDAO implements IChatDAO{
        private $connection;
        //private $tableName = 'Chat';
        private $userDAO;

//? ======================================================================
//!                           DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this -> userDAO = new UserDAO();
        }


//? ======================================================================
// !                          INSERT METHODS
//? ======================================================================
        public function Add(Chat $chat){
            $idLastP = 0;
            $query = "CALL Chat_Add(?,?)";
            $parameters["idOwner"] = $chat -> getOwner() -> getId();
            $parameters["idKeeper"] = $chat -> getKeeper() -> getId();

            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $idLastP = $row["LastID"];
            }
        return $idLastP;
        }

        public function NewChat(Chat $chat){
            try{
                $owner = $this -> userDAO -> DGetByUsername($chat -> getOwner() -> getUsername());
                $chat -> setOwner($owner);
                $idLastChat = $this -> Add($chat);
                $chat = $this->GetById($idLastChat);
            }catch(PDOException $pdoe){
               throw new RegisterChatException("Error: no se pudo establecer conexion con el keeper\n" . $pdoe -> getMessage());
            }
        return $chat;
        }


//? ======================================================================
//!                           SELECT METHODS
//? ======================================================================
        public function GetAll(){
            $chatList = array();    

            $query = "CALL Chat_GetAll()";
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $chat = new chat();
                $chat -> __fromBD($row["idChat"], $this -> userDAO -> DGet($row["idOwner"])
                                , $this -> userDAO -> DGet($row["idKeeper"]));
                array_push($chatList,$chat);
            }
        return $chatList;
        }

        public function GetAllByUser($idUser){
            $chatList = array();

            $query = "CALL Chat_GetByUser(?)";
            $parameters["idUser"] = $idUser;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $chatN = new Chat();

                $chatN -> __fromBD($row["idChat"], $this -> userDAO -> DGet($row["idOwner"])
                                 , $this -> userDAO -> DGet($row["idKeeper"]));
                array_push($chatList, $chatN);
            }
        return $chatList;
        }

        public function GetById($idChat){
            $query = "CALL Chat_GetById(?)";
            $parameters["idChat"] = $idChat;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $chat = new Chat();
                $chat -> __fromBD($row["idChat"], $this -> userDAO -> DGet($row["idOwner"])
                                , $this -> userDAO -> DGet($row["idKeeper"]));
            }
        return $chat;
        }

/*
* D: Su principal función es obtener un chat coincidiente entre 2 USERs.
* A1: Chat que provee los usuarios para recuperar el chat completo.
* R: Chat con informacion completa.
🐘*/
        private function GetByUsers(Chat $chat){
            $chatGet = null;

            $owner = $this -> userDAO -> DGetByUsername($chat -> getOwner() -> getUsername());
            $keeper = $chat -> getKeeper();

            $query = "CALL Chat_GetByUsers(?,?)";
            $parameters["idUser1"] = $owner -> getId();
            $parameters["idUser2"] = $keeper -> getId();
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $chatGet = new Chat();
                $chatGet -> __fromBD($row["idChat"], $this -> userDAO -> DGet($row["idOwner"])
                                   , $this -> userDAO -> DGet($row["idKeeper"]));
            }
        return $chatGet;
        }

//? ======================================================================
//!                           DELETE METHODS
//? ======================================================================
        public function Delete($idChat){
            $query = "CALL Chat_Delete(?)";
            $parameters["idChat"] = $idChat;

            $this -> connection = Connection::GetInstance();
            $this -> connection -> ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

//? ======================================================================
//!                           ESPECIAL METHODS
//? ======================================================================
        public function ChatsByUser($userName){
            $user = $this -> userDAO -> DGetByUsername($userName);
            $chats = $this -> GetAllByUser($user -> getId());
        return $chats;
        }

        public function ChatByUsers(Chat $chat){
            $owner = $this -> userDAO -> DGetByUsername($chat -> getOwner() -> getUsername());
            $chat -> setOwner($owner);
            $chatGet = $this -> GetByUsers($chat);
        return $chatGet;
        }

/*
* D: Su principal función es comprobar la existencia de un chat previo
*    entre 2 USERS (Owner y Keeper).
!    Indispensable para el registro de un NUEVO CHAT, validación fundamental.
!    Solicitado por ChatController a traves de ChatDAO.
* A1: Chat que provee los usuarios a recuperar para comparar y validar.
* R: INTEGER 1 en caso positivo de verificación, 0 caso contrario.
🐘*/
        public function CheckChatExists(Chat $chat){
            $chatExists = 0;

            $chatList = $this -> GetAll();
            $owner = $this -> userDAO -> DGetByUsername($chat -> getOwner() -> getUsername());

            foreach($chatList as $chatf){
                if($chatf -> getOwner() -> getId() == $owner -> getId() && 
                   $chatf -> getKeeper() -> getId() == $chat -> GetKeeper() -> getId()){

                    $chatExists = 1;

                return $chatExists;
                }
                if($chatf -> getKeeper() -> getId() == $owner -> getId() && 
                   $chatf -> getOwner() -> getId() == $chat -> GetKeeper() -> getId()){
                    
                    $chatExists = 1;
                    
                return $chatExists;
                }
            }
            
        return $chatExists;
        }
    } 
?>