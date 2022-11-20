<?php
    namespace Model;

    class MessageChat{
        private $idMsg;
        private $message;
        private $dateTime;
        private Chat $chat;
        private User $sender;

        //CONSTRUCTORS
        public function __construct(){}

        public function __fromRequest($message, $dateTime, Chat $chat, User $sender){
            $this->message = $message;
            $this->dateTime = $dateTime;
            $this->chat = $chat;
            $this->sender = $sender;
        }

        public function __fromDB($idMsg, $message, $dateTime, Chat $chat, User $sender){
            $this->idMsg = $idMsg;
            $this->message = $message;
            $this->dateTime = $dateTime;
            $this->chat = $chat;
            $this->sender = $sender;
        }

        //GETTERS & SETTERS
        public function getIdMsg()
        {
            return $this->idMsg;
        }

        public function setIdMsg($idMsg)
        {
            $this->idMsg = $idMsg;
        }

        public function getMessage()
        {
            return $this->message;
        }

        public function setMessage($message)
        {
            $this->message = $message;
        }

        public function getDateTime()
        {
            return $this->dateTime;
        }

        public function setDateTime($dateTime)
        {
            $this->dateTime = $dateTime;
        }

        public function getChat()
        {
            return $this->chat;
        }

        public function setChat(Chat $chat)
        {
            $this->chat = $chat;
        }

        public function getSender()
        {
            return $this->sender;
        }

        public function setSender(User $sender)
        {
            $this->sender = $sender;

        }
    }
?>