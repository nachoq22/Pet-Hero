<?php
    namespace Controllers;

    use \DAO\UserDAO;
    use \Model\User as User;
    use \Model\PersonalData as PersonalData;

    class HomeController
    {
        private $userDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
        }

        public function Index()
        {
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
/*            echo "AQUI ESTA EL USUARIO \n" . var_dump($user);*/
            $this->userDAO->Register($user);
            require_once(VIEWS_PATH."Home.php");
        } 
    }
?>