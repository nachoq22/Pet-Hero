<?php
    namespace DAO;

    use \Model\Publication as Publication;

    interface IPublicationDAO
    {
        public function Add(Publication $publication);
        public function GetAll();
        public function Get($id);
        public function Delete($id);
    }
        


?>