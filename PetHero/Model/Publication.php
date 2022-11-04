<?php
    namespace Model;

    class Publication {
        public $idPublication;
        public $openDate;
        public $closeDate;
        public $title;
        public $description;
        public $popularity;
        public $remuneration;
        public $image;

        //CONSTRUCTORS
        public function __construct() {}

        public function __fromRequest($openDate, $closeDate, $title, $description, $popularity, $remuneration, $image) {
            $this->openDate = $openDate;
            $this->closeDate = $closeDate;
            $this->title = $title;
            $this->description = $description;
            $this->popularity = $popularity;
            $this->remuneration = $remuneration;
            $this->image = $image;
        }

        public function __fromDB(){
            $this->idPublication = $idPublication;
            $this->openDate = $openDate;
            $this->closeDate = $closeDate;
            $this->title = $title;
            $this->description = $description;
            $this->popularity = $popularity;
            $this->remuneration = $remuneration;
            $this->image = $image;

        }

        //GETTER & SERTTER

        public function getidPublication() {
            return $this->idPublication;
        }
        public function getOpenDate() {
            return $this->openDate;
        }
        public function getCloseDate() {
            return $this->closeDate;
        }
        public function getTitle() {
            return $this->title;
        }
        public function getDescription() {
            return $this->description;
        }
        public function getPopularity() {
            return $this->popularity;
        }
        public function getRemuneration() {
            return $this->remuneration;
        }
        public function getImage() {
            return $this->image;
        }

        //SETTERS
        public function setidPublication($idPublication) {
            $this->idPublication = $idPublication;
            return $this;
        }
        public function setOpenDate($openDate) {
            $this->openDate = $openDate;
            return $this;
        }
        public function setCloseDate($closeDate) {
            $this->closeDate = $closeDate;
            return $this;
        }
        public function setTitle($title) {
            $this->title = $title;
            return $this;
        }
        public function setDescription($description) {
            $this->description = $description;
            return $this;
        }
        public function setPopularity($popularity) {
            $this->popularity = $popularity;
            return $this;
        }
        public function setRemuneration($remuneration) {
            $this->remuneration = $remuneration;
            return $this;
        }
        public function setImage($image) {
            $this->image = $image;
            return $this;   
        }







}

?>