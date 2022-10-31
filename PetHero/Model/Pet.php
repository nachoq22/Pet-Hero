<?php
namespace Model;
use \Model\Owner as Owner;
use \Model\PetType as PetType;
use \Model\Size as Size;

    class Pet{
        private $idPet;
        private $name;
        private $breed;
        private $profileIMG;
        private $vaccinationPlanIMG;
        private $observation;
        private PetType $type;
        private Size $size;
        private Owner $owner;

//CONSTRUCTORS
        function __fromDB($idPet,$name,$breed,$profileIMG,
                          $vaccinationPlanIMG,$observation,
                          PetType $type,Size $size,Owner $owner){
            $this->idPet = $idPet;
            $this->name = $name;
            $this->breed = $breed;
            $this->profileIMG = $profileIMG;
            $this->vaccinationPlanIMG = $vaccinationPlanIMG;
            $this->observation = $observation;
            $this->type = $type;
            $this->size = $size;
            $this->owner = $owner;
        } 

        function __construct(){} 

        function __fromRequest($name,$breed,$observation,
                               PetType $type,Size $size,Owner $owner){
            $this->name = $name;
            $this->breed = $breed;
            $this->observation = $observation;
            $this->type = $type;
            $this->size = $size;
            $this->owner = $owner;
        } 

//GETTER & SERTTER
        public function getId(){
            return $this->idPet;
        }
        public function setId($idPet){
            $this->idPet = $idPet;
        }

        public function getName(){
            return $this->name;
        }
        public function setName($name){
            $this->name = $name;
        }

        public function getBreed(){
            return $this->breed;
        }
        public function setBreed($breed){
            $this->breed = $breed;
        }

        public function getProfileIMG(){
            return $this->profileIMG;
        }
        public function setProfileIMG($profileIMG){
            $this->profileIMG = $profileIMG;
        }

        public function getVaccinationPlanIMG(){
            return $this->vaccinationPlanIMG;
        }
        public function setVaccinationPlanIMG($vaccinationPlanIMG){
            $this->vaccinationPlanIMG = $vaccinationPlanIMG;
        }

        public function getObservation(){
            return $this->observation;
        }
        public function setObservation($observation){
            $this->observation = $observation;
        }

        public function getType(): PetType{
            return $this->type;
        }
        public function setType(PetType $type){
            $this->type = $type;
        }

        public function getSize(): Size{
            return $this->size;
        }
        public function setSize(Size $size){
                $this->size = $size;
        }

        public function getOwner(): Owner{
            return $this->owner;
        }
        public function setOwner(Owner $owner){
                $this->owner = $owner;
        }
    }
?>