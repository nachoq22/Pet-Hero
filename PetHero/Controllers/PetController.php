<?php
    namespace Controllers;
    use \DAO\PetDAO as PetDAO;
    use \DAO\SizeDAO as SizeDAO;
    use \DAO\PetTypeDAO as PetTypeDAO;
    use \DAO\OwnerDAO as OwnerDAO;
    use \Model\Pet as Pet;
    use \Model\Size as Size;
    use \Model\PetType as PetType;
    use \Model\Owner as Owner;

        class PetController
        {
            private $PetDAO;
            private $SizeDAO;
            private $PetTypeDAO;

        public function __construct()
        {
            //$this->PetDAO = new PetDAO();
            $this->SizeDAO = new SizeDAO();
            $this->PetTypeDAO = new PetTypeDAO();
        }

        public function showListView()
        {
            $petDAO=$this->PetDAO->GetAll();
        }

        public function Add($name, $breed, $profileIMG, $vaccinationPlanIMG, $observation, $type, $size)
        {
            $sizeOBJ = new Size();
            $sizeOBJ->setName($size);
            $typeOBJ = new PetType();
            $typeOBJ->setName($type);
            $owner = $this->ownerDAO->Get(rand(1,6));
            
            $pet = new Pet();   
            $pet->__fromRequest($name, $breed, $profileIMG, $vaccinationPlanIMG, $observation, $typeOBJ, $sizeOBJ,$owner);
            $this->petDAO->Add($pet);
            //$petList=$this->petDAO->GetAll();
            //require_once(VIEWS_PATH."Pets.php");
        } 

        

    }
?>