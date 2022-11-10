<?php
    namespace Controllers;
    use \DAO\PetDAO as PetDAO;
    use \DAO\UserDAO as UserDAO;

    use \Model\Pet as Pet;
    use \Model\Size as Size;
    use \Model\PetType as PetType;
    use \Model\User as User;

    use \Controllers\HomeController as HomeController;

        class PetController{
            private $petDAO;
            private $userDAO;
            private $homeController;

        public function __construct(){
            $this->petDAO = new PetDAO();
            $this->userDAO = new UserDAO();
            $this->homeController = new HomeController();
        }

        public function ViewPetList(){
            //$petList = $this->petDAO->GetAllByUser($_SESSION["loggedUser"]->getName());
            $petList = $this->petDAO->GetAll();
            require_once(VIEWS_PATH."PetList.php");
        }

        public function ViewPetProfile($idPet){
            //var_dump($idPet);
            $petaux = $this->petDAO->Get($idPet);
            require_once(VIEWS_PATH."PetProfile.php");
        }

        public function showListView(){
            $petDAO=$this->petDAO->GetAll();
        }

        public function Add($name, $breed, $type, $size, $observation,$ImagenP,$ImagenV){
            //var_dump($this->ownerDAO->Get(1));
            //var_dump($observation);
            $sizeOBJ = new Size();
            $sizeOBJ->setName($size);
            $typeOBJ = new PetType();
            $typeOBJ->setName($type);
            $user = new User();
            $user = $this->userDAO->Get(1);
            $pet = new Pet();
            $pet->__fromRequest($name, $breed, $observation, $typeOBJ, $sizeOBJ, $user);   
            //var_dump($pet);
            //var_dump($_FILES['ImagenP']);
            //var_dump($_FILES['ImagenV']);
            $fileNameP = $_FILES['ImagenP']['name'];
            $fileP = $_FILES['ImagenP']['tmp_name'];
            $fileNameV = $_FILES['ImagenV']['name'];
            $fileV = $_FILES['ImagenV']['tmp_name'];
            
            
            $this->petDAO->RegisterPet($pet, $fileP, $fileNameP, $fileV, $fileNameV);
            $petList=$this->petDAO->GetAll();
            require_once(VIEWS_PATH."PetList.php");
        } 

        public function GetPetsByReservation($idPublic, $startD, $finishD){
            //$petList = $this->petDAO->GetAllByUser(1);
            var_dump($idPublic);
            $petList = $this->petDAO->GetAll();
            require_once(VIEWS_PATH."AddBooking.php");
        }
    }
?>