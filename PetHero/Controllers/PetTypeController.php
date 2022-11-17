<?php
namespace Controllers;
use \DAO\PetTypeDAO as PetTypeDAO;
use \Model\PetType as PetType;

class PetTypeController{
    private $typeDAO;

    public function __construct(){
        $this->typeDAO = new petTypeDAO();
    }

    public function AddPetType($name){
            $petType = new PetType();
            $petType->setName($name);
            $this->typeDAO->Add($petType);
            $typelist=$this->typeDAO->GetAll();
            require_once(VIEWS_PATH."home.php");
    }
}
?>