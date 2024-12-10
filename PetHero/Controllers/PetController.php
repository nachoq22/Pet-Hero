<?php
namespace Controllers;

use Exceptions\RegisterPetException;

use \Controllers\HomeController as HomeController;

use \DAO\PetDAO as PetDAO;

use \Model\Pet as Pet;
use \Model\Size as Size;
use \Model\PetType as PetType;

    class PetController{
        private $petDAO;
        private $homeController;

        public function __construct(){
            $this -> petDAO = new PetDAO();
            $this -> homeController = new HomeController();
        }    

//? ======================================================================
//!                          VIEW CONTROLLERS
//? ======================================================================
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                        VISTA PESTAÑA DE MASCOTAS
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        // public function ViewPetList(){
        //     $petList = $this -> petDAO -> GetAll();
        //     require_once(VIEWS_PATH."PetList.php");
        // }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                        VISTA PANEL DE MASCOTA
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××        
        public function ViewPetProfile($idPet){
            $this -> homeController -> isLogged();
            $petaux = $this -> petDAO -> Get($idPet);
            require_once(VIEWS_PATH."PetProfile.php");
        }

        // public function showListView(){
        //     $petDAO=$this->petDAO->GetAll();
        // }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                           REGISTRAR MASCOTA
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el registro
*    de una nueva PET.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 RegisterPet
¬          ► Registra una nueva mascota.
?      💠 ViewOwnerPanel
¬          ► Invocación de HomeController para redireccion a "Owner Panel".

* A: $name: nombre de la PET.
*    $breed: raza de la PET.
*    $type: tipo de PET.
*    $size: tamaño de la PET.
*    $observation: detalles adicionales de la PET.
*    $ImagenP: imagen de perfil de la PET.
*    $ImagenV: imagen del plan de vacunacion de la PET.

* R: No Posee.
🐘 */ 
        public function Add($name, $breed, $type, $size, $observation,$ImagenP,$ImagenV){
            $this->homeController->isLogged();

            $sizeOBJ = new Size();
            $sizeOBJ -> setName($size);

            $typeOBJ = new PetType();
            $typeOBJ -> setName($type);

            $logUser = $_SESSION["logUser"];

            $pet = new Pet();
            $pet -> __fromRequest($name, $breed, $observation, $typeOBJ, $sizeOBJ, $logUser); 

            $fileNameP = $_FILES['ImagenP']['name'];
            $fileP = $_FILES['ImagenP']['tmp_name'];
            $fileNameV = $_FILES['ImagenV']['name'];
            $fileV = $_FILES['ImagenV']['tmp_name'];

            $message = "Successful: Se ha registrado correctamente su mascota";
            
            try{

                $this -> petDAO -> RegisterPet($pet, $fileP, $fileNameP, $fileV, $fileNameV);

            }catch(RegisterPetException $rpe){
                $message = $rpe -> getMessage();
            }

            setcookie('message', $message, time() + 2,'/');
            header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewOwnerPanel');
            exit;   
        } 

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                   RECUPERA MASCOTAS PARA RESERVACIÓN
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que obtendrá las mascotas para mostrar en el apartado de
*    formulario para una nueva BOOKING.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 GetAllByUsername
¬          ► Obtiene una Lista de PETs segun el username de un USER.
?      💠 ViewOwnerPanel
¬          ► Invocación de HomeController para redireccion a "Owner Panel".

* A: $idPublic: id de la PUBLICATION. 
*    $$startD: fecha de inicio de la BOOKING.
*    $finishD: fecha de fin de la BOOKING.
*    $message: mensaje a enviar en caso de no poseer mascotas registradas.

* R: No Posee.
🐘 */ 
        public function GetPetsByReservation($idPublic, $startD, $finishD, $message=""){
            $this -> homeController -> isLogged();
            $logUser = $_SESSION["logUser"];
            $petList = $this -> petDAO -> GetAllByUsername($logUser -> getUsername());

            if(!empty($petList)){

                require_once(VIEWS_PATH."AddBooking.php");

            }else{

                setcookie('message', "Error: Debe tener al menos 1 mascota registrada para proceder con la reservación", time() + 2,'/');
                header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewOwnerPanel');
            
            }
        }
    }
?>