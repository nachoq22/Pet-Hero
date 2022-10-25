<?php
namespace Controllers;

use \DAO\UserDAO as UserDAO;
use \DAO\LocationDAO as LocationDAO;
use \DAO\SizeDAO as SizeDAO;
use \DAO\PetTypeDAO as PetTypeDAO;
use \Model\User as User;
use \Model\PetType as PetType;

    class HomeController
    {
        private $userDAO;
        private $locationDAO;
        private $sizeDAO;
        private $typeDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->locationDAO = new LocationDAO();
            $this->sizeDAO = new SizeDao();
            $this->typeDAO = new PetTypeDAO();
        }

        public function Index()
        {
            $locationList=$this->locationDAO->GetAll();
            $sizeList=$this->sizeDAO->GetAll();
            $typeList=$this->typeDAO->GetAll();
            $userList =$this->userDAO->GetAll();
            $userIs=$this->userDAO->Get(2);

            require_once(VIEWS_PATH."Home.php");
        }

        public function ViewLogin()
        {
            require_once(VIEWS_PATH."login.php");
        }
        public function ViewAddTemplates()
        {
            require_once(VIEWS_PATH."AddForms.php");
        }

        public function ViewPersonalInfo()
        {
            require_once(VIEWS_PATH."PersonalData.php");
        }

        public function Register($username, $email, $password)
        {
            /*$user = $this->userDAO->GetByUserName($userName);

            if($user == null){
                $user = $this->userDAO->GetByEmail($email);
                if ($user == null){
                    $user = new User();
                    $user->__fromRequest($username,$password,$email);
                    $this->UserDAO->Add($user);
                    require_once(VIEWS_PATH."Prueba.php");
                }else{
                    //El email ya esta en uso
                }
            
            }else{
                //El usuario ya esta en uso
            }*/
            $user = new User();
            $user->__fromRegister($username,$password,$email);
/*            echo "AQUI ESTA EL USUARIO \n" . var_dump($user);*/
            $this->userDAO->Register($user);
            $this->Index();
        } 

        public function Login($username, $password)
        {            
            $user = new User();
            $user->__fromLogin($username,$password);
            $rta = $this->userDAO->Login($user);
            if($rta=1){
                session_start();
                $loggedUser = new User();
                $loggedUser->setUsername($username);
                $loggedUser->setPassword($password);
                $_SESSION["loggedUser"]= $loggedUser;
                $this->Index();
                var_dump($_SESSION["loggedUser"]);
            }
        }

        public function DeleteUser($id)
        {
            echo $id;
            $this->userDAO->Delete($id);
        }

        public function AddPetType($name){
            $petType = new PetType();
            $petType->setName($name);
            $this->typeDAO->Add($petType);
            $typelist =$this->typeDAO->GetAll();
            require_once(VIEWS_PATH."Home.php");
        }
    }
?>