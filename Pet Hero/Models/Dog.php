<?php
    namespace Modes;

    class Dog
    {
        private $id;
        private $profileIMG;
        private $breed;
        private $size;
        private $vaccinationPlanIMG;
        private $observation;
        private $ownerID;

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getProfileIMG()
        {
            return $this->profileIMG;
        }

        public function setProfileIMG($profileIMG)
        {
            $this->profileIMG = $profileIMG;
        }

        public function getBreed()
        {
            return $this->breed;
        }

        public function setBreed($breed)
        {
            $this->breed = $breed;
        }

        public function getSize()
        {
            return $this->size;
        }

        public function setSize($size)
        {
            $this->size = $size;
        }
        
        public function getVaccinationPlanIMG()
        {
            return $this->vaccinationPlanIMG;
        }

        public function setVaccinationPlanIMG($vaccinationPlanIMG)
        {
            $this->vaccinationPlanIMG;
        }

        public function getObservation()
        {
            return $this->observation;
        }

        public function setObservation($observation)
        {
            $this->observation = $observation;
        }

        public function getOwnerId()
        {
            return $this->ownerID;
        }

        public function setOwnerId($ownerID)
        {
            $this->ownerID = $ownerID;
        }
    }

    


?>