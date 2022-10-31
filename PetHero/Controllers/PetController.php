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
            private $petDAO;
            private $sizeDAO;
            private $petTypeDAO;
            private $ownerDAO;

        public function __construct()
        {
            $this->petDAO = new PetDAO();
            $this->sizeDAO = new SizeDAO();
            $this->petTypeDAO = new PetTypeDAO();
            $this->ownerDAO = new OwnerDAO();
        }

        public function ViewPetProfile()
        {
            $pet = $this->petDAO->Get(8);
            require_once(VIEWS_PATH."PetProfile.php");
        }

        public function showListView()
        {
            $petDAO=$this->petDAO->GetAll();
        }

        public function Add($name, $type, $breed, $size, $observation, $ImagenP, $ImagenV)
        {
            //var_dump($this->ownerDAO->Get(1));
            //var_dump($observation);
            $sizeOBJ = new Size();
            $sizeOBJ->setName($size);
            $typeOBJ = new PetType();
            $typeOBJ->setName($type);
            $owner = new Owner();
            $owner = $this->ownerDAO->Get(1);
            $pet = new Pet();
            $pet->__fromRequest($name, $breed, $observation, $typeOBJ, $sizeOBJ, $owner);   
            var_dump($pet);
            $fileNameP = $_FILES['ImagenP']['name'];
            $fileP = $_FILES['ImagenP']['tmp_name'];
            $fileNameV = $_FILES['ImagenV']['name'];
            $fileV = $_FILES['ImagenV']['tmp_name'];
            
            
            $this->petDAO->RegisterPet($pet, $fileP, $fileNameP, $fileV, $fileNameV);
            //$petList=$this->petDAO->GetAll();
            //require_once(VIEWS_PATH."Pets.php");
        } 

        //(Pet $pet,$fileP,$fileNameP,$fileV,$fileNameV)

        

    }
?>