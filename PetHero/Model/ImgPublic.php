<?php
namespace Model;
use \Model\Publication as Publication;

    class ImgPublic{
        private $idIMG;
        private $url;
        private Publication $publication;

        //CONSTRUCTORS
        public function __construct(){}
        public function __fromRequest($url, Publication $publication){
            $this->url = $url;
            $this->publication = $publication;
        }
        public function __fromDB($idIMG, $url, Publication $publication){
            $this->idIMG = $idIMG;
            $this->url = $url;
            $this->publication = $publication;
        }

        //GETTERS
        public function getId(){
            return $this->idIMG;
        }
        public function getUrl(){
            return $this->url;
        }
        public function getPublication(){
            return $this->publication;
        }

        //SETTERS
        public function setId($idIMG){
            $this->idIMG = $idIMG;
        }
        public function setUrl($url){
            $this->url = $url;
        }
        public function setPublication($publication){
            $this->publication = $publication;
        }
    }
?>
