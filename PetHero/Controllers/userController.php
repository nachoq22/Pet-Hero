<?php
    namespace Controllers;
    use \DAO\UserDAO as UserDAO;
    use \DAO\OwnerDAO as OwnerDAO;
    use \Model\User as User;
    use \Model\Owner as Owner;

    class UserController
    {
        private $userDAO;
        private $homeController;
        private $ownerDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->homeController = new HomeController();
            $this->ownerDAO = new OwnerDAO();
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
            $owner = new Owner();
            $owner->__fromRequest($user);
           //echo "AQUI ESTA EL USUARIO \n" . var_dump($Owner);
            $this->ownerDAO->Register($owner);
            $this->homeController->Index();
        } 

        public function Login($username, $password)
        {            
            $user = new User();
            $user->__fromLogin($username,$password);
            $rta = $this->userDAO->Login($user);
            var_dump($rta);
            if($rta!=0){
                /*session_start();
                $loggedUser = new User();
                $loggedUser->setUsername($username);
                $loggedUser->setPassword($password);
                $_SESSION["loggedUser"]= $loggedUser;*/
                //var_dump($user);
                //$this->Index();
                //var_dump($_SESSION["loggedUser"]);
                $this->homeController->Index();
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