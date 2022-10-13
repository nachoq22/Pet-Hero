<?php
    namespace Models;

    class Keeper
    {
        private $id;
        private $name;
        private $surname;
        private $sex;
        private $dni;

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function getSurname()
        {
            return $this->surname;
        }

        public function setSurname($surname)
        {
            $this->surname = $surname;
        }

        public function getSex()
        {
            return $this->sex;
        }

        public function setSex($sex)
        {
            $this->sex = $sex;
        }

        public function getDni()
        {
            return $this->dni;
        }

        public function setDni($dni)
        {
            $this->dni = $dni;
        }
        
    }

?>