<?php
    namespace Controllers;

    use \DAO\UserDAO;
    use \DAO\LocationDAO;
    use \DAO\SizeDAO;
    use \DAO\PetTypeDAO;
    use \Model\User as User;

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
            $this->Index();
        } 
    }
?>