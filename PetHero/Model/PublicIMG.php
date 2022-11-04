<?php
    namespace Model;

    class PublicIMG {
        private $id;
        private $url;
        private Publication $publication;

        
        //CONSTRUCTORS
        public function __construct(){}
        public function __fromRequest($url, Publication $publication){
            $this->url = $url;
            $this->publication = $publication;
        }
        public function __fromBD($id, $url, Publication $publication){
            $this->id = $id;
            $this->url = $url;
            $this->publication = $publication;
        }

        //GETTERS
        public function getId(){
            return $this->id;
        }
        public function getUrl(){

        }
        public function getPublication(){
            return $this->publication;
        }

        //SETTERS
        public function setId($id){
            $this->id = $id;
        }
        public function setUrl($url){
            $this->url = $url;
        }
        public function setPublication($publication){
            $this->publication = $publication;
        }

    }

?>