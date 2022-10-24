<?php
    namespace Controllers;
    use \DAO\PetDAO as PetDAO;
    use \DAO\SizeDAO as SizeDAO;
    use \DAO\PetTypeDAO as PetTypeDAO;
    use \Models\Pet as Pet;
    use \Models\Size as Size;
    use \Models\PetType as PetType;

        class PetController
        {
            private $PetDAO;
            private $SizeDAO;
            private $PetTypeDAO;

        public function __construct()
        {
            $this->PetDAO = new PetDAO();
            $this->SizeDAO = new SizeDAO();
            $this->PetTypaDAO = new PetTypeDAO();
        }

        public function showListView()
        {
            $PetDAO=$this->PetDAO->GetAll();
        }

        public function Add($name, $breed, $profileIMG, $vaccinationPlanIMG, $observation, $type, $size)
        {
            $sizeOBJ = new Size();
            $sizeOBJ->setName($size);
            $typeOBJ = new PetType();
            $typeOBJ->setName($type);
            $pet = new Pet();   
            $pet->__fromRequest($name, $breed, $profileIMG, $vaccinationPlanIMG, $observation, $typeOBJ, $sizeOBJ);
            $this->PetDAO->Add($pet);
            $petList=$this->petDAO->GetAll();
            require_once(VIEWS_PATH."Pets.php");
        } 
        }

?>