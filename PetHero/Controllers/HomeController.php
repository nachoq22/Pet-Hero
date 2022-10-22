<?php
    namespace Controllers;

    use \DAO\UserDAO;
    use \DAO\LocationDAO;
    use \Model\User as User;

    class HomeController
    {
        private $userDAO;
        private $locationDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->locationDAO = new LocationDAO();
        }

        public function Index()
        {
            $locationList=$this->locationDAO->GetAll();
            require_once(VIEWS_PATH."home.php");
        }

        public function ViewRegister()
        {
            require_once(VIEWS_PATH."register.php");
        }

        /*public function Register($userName, $password)
        {
            
            require_once(VIEWS_PATH."agregarlocation.php");
        }*/

        public function ViewLogin()
        {
            require_once(VIEWS_PATH."Login.php");
        }

        public function ViewLocation()
        {
            require_once(VIEWS_PATH."agregarlocation.php");
        }

        public function Login($userName, $password)
        {
            
            $user = new User();
            $user->__fromLogin($userName,$password);
            //$rta = $this->UserDAO->Login($user);
            $userLogin = $this->userDAO->GetByUsername($userName);
            var_dump($userLogin);
            //echo $userLogin->getUsername();
            //echo $userLogin->getPassword();
            /*if($rta=1){
                session_start();
                $loggedUser = new User();
                $loggedUser->setUsername($userName);
                $loggedUser->setPassword($password);
                require_once(VIEWS_PATH."prueba.php");
            }*/

        }

        public function DeleteUser($id)
        {
            echo $id;
            $this->userDAO->Delete($id);
        }

        public function Register($userName, $email, $password)
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
            $user->__fromRegister($userName,$password,$email);
            $this->userDAO->Register($user);
            require_once(VIEWS_PATH."home.php");
        } 
    }
?>