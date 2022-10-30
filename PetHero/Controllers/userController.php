<?php
    use \DAO\UserDAO as UserDAO;
    use \Model\User as User;

    class UserController
    {
        private $userDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
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