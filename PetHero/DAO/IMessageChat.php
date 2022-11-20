<?php
    namespace DAO;

    use \Model\MessageChat as MessageChat;

    interface IMessageChatDAO{
        public function AddMsg(MessageChat $Messagechat);
        public function GetAll();
        public function GetById($id);
        public function Delete($idBooking);
    }
?>