<?php
namespace Model;
use \Model\User as User;

    class Publication {
        private $idPublic;
        private $openD;
        private $closeD;
        private $title;
        private $description;
        private $popularity;
        private $remuneration;
        private User $user;

        //CONSTRUCTORS
        public function __construct() {}

        public function __fromRequest($openD, $closeD, $title, $description, $popularity, $remuneration,User $user) {
            $this->openD = $openD;
            $this->closeD = $closeD;
            $this->title = $title;
            $this->description = $description;
            $this->popularity = $popularity;
            $this->remuneration = $remuneration;
            $this->user = $user;
        }

        public function __fromDB($idPublic,$openD, $closeD, $title, $description, $popularity, $remuneration,User $user){
            $this->idPublic = $idPublic;
            $this->openD = $openD;
            $this->closeD = $closeD;
            $this->title = $title;
            $this->description = $description;
            $this->popularity = $popularity;
            $this->remuneration = $remuneration;
            $this->user = $user;
        }

        //GETTER & SERTTER

        public function getid() {
            return $this->idPublic;
        }
        public function getOpenDate() {
            return $this->openD;
        }
        public function getCloseDate() {
            return $this->closeD;
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

        public function getUser(): User{
            return $this->user;
        }

        //SETTERS
        public function setid($idPublic) {
            $this->idPublic = $idPublic;
        }
        public function setOpenDate($openDate) {
            $this->openD = $openDate;
        }
        public function setCloseDate($closeD) {
            $this->closeD = $closeD;
        }
        public function setTitle($title) {
            $this->title = $title;
        }
        public function setDescription($description) {
            $this->description = $description;
        }
        public function setPopularity($popularity) {
            $this->popularity = $popularity;
        }
        public function setRemuneration($remuneration) {
            $this->remuneration = $remuneration;
        }
        public function setUser(User $user){
                $this->user = $user;
        }
    }
?>