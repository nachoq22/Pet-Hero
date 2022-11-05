<?php
namespace Controllers;
use \DAO\PublicationDAO as PublicationDAO;
use \Model\Publication as Publication;
use \Model\User as User;

    class PublicationController{
        private $publicDAO;

        public function __construct(){
            $this->publicDAO = new PublicationDAO();
        }

        public function Add($title,$description,$openD,$closeD,$remuneration,$images){
            $public = new Publication();
            $user = new User();
            $user->setUsername("marsexpress");
            $public->__fromRequest($openD, $closeD, $title, $description,0, $remuneration,$user);
            $this->publicDAO->NewPublication($public);

        }
    }
?>