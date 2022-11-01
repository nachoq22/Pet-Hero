<?php
    namespace Controllers;
    use \DAO\UserDAO as UserDAO;
    use \DAO\URDAO as URDAO;
    use \Model\User as User;
    use \Model\UserRole as UserRole;
    

    class UserController
    {
        private $userDAO;
        private $homeController;
        private $urDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->homeController = new HomeController();
            $this->urDAO = new URDAO();
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
            //$user = $this->userDAO->AddRet($user);
            //var_dump($user);
            $ur= new UserRole();
            $ur->setUser($user);
            //var_dump($ur);
            $this->urDAO->Register($user);
            $this->homeController->Index();
        } 

        public function Login($username, $password)
        {            
            $user = new User();
            $user->__fromLogin($username,$password);
            $rta = $this->userDAO->Login($user);
            //var_dump($rta);
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