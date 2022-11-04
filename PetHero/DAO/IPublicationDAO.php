<?php
namespace DAO;

use \Model\Publication as Publication;

    interface IPublicationDAO{
        public function Add(Publication $public);
        public function GetAll();
        public function Get($idPublic);
        public function Delete($idPublic);
    }
?>