<?php
namespace Model;

use \Model\User;

    class Chat{

        private $idChat;
        private User $owner;
        private User $keeper;

//? CONSTRUCTORS
        public function __construct(){}

        public function __fromRequest(User $owner, User $keeper){
            $this->owner = $owner;
            $this->keeper = $keeper;
        }

        public function __fromBD($idChat, User $owner, User $keeper){
            $this->idChat = $idChat;
            $this->owner = $owner;
            $this->keeper = $keeper;
        }

//? GETTERS & SETTERS
        public function getIdChat(){
            return $this->idChat;
        }

        public function getOwner(){
            return $this->owner;
        }

        public function getKeeper(){
            return $this->keeper;
        }

        public function setIdChat($idChat){
            $this->idChat = $idChat;
        }

        public function setOwner($owner){
            $this->owner = $owner;
        }

        public function setKeeper($keeper){
            $this->keeper = $keeper;
        }
    }
?>