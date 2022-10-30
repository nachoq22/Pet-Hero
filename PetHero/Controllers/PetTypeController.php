<?php
namespace Controllers;
use \DAO\PetDAO as PetDAO;
use \DAO\PetTypeDAO as PetTypeDAO;
use \Models\Pet as Pet;
use \Models\PetType as PetType;

class PetTypeController
{
    private $PetDAO;
    private $PetTypeDAO;

    public function __construct()
    {
        $this->PetDAO = new petDAO();
        $this->PetTypeDAO = new petTypeDAO();
    }

    public function AddPetType($name)
        {
            $petType = new PetType();
            $petType->setName($name);
            $this->petTypeDAO->Add($petType);
            $typelist=$this->petTypeDAO->GetAll();
            require_once(VIEWS_PATH."home.php");

        }





}

?>