<?php
    namespace DAO;

    use \Model\Chat as Chat;

    interface IChatDAO{
        public function Add(Chat $chat);
        public function GetAll();
        public function GetById($id);
        public function Delete($idBooking);
    }

?>