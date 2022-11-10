<?php
    namespace Controllers;
    use \DAO\UserDAO as UserDAO;
    use \DAO\URoleDAO as URoleDAO;
    
    use \Model\User as User;
    use \Model\UserRole as UserRole;
    use \Model\Location as Location;
    use \Model\PersonalData as PersonalData;
    

    class UserController{
        private $userDAO;
        private $homeController;
        private $uRoleDAO;

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->homeController = new HomeController();
            $this->uRoleDAO = new URoleDAO();
        }

        public function Register($username, $email, $password){
            $user = new User();
            $user->__fromRegister($username,$password,$email);
            $uRole= new UserRole();
            $uRole->setUser($user);
            var_dump($uRole);
            $this->uRoleDAO->Register($uRole);
            $this->homeController->ViewOwnerPanel("El registro ha sido exitoso!");//levantar sesion si es satifactorio           
        } 

        public function Login($username, $password){            
            $user = new User();
            $user->__fromLogin($username,$password);
            $rta = $this->userDAO->Login($user);
            if($rta!=0){
                $loggedUser = new User();
                $loggedUser->setUsername($username);
                $loggedUser->setPassword($password);
                $_SESSION["loggedUser"] = $loggedUser;
                $_SESSION["var"] = 1; 
                $this->homeController->Index();
            }
        }

        public function BeKeeper($adress, $neighborhood, $city, $province, $country,
                                 $name,$surname,$sex,$dni){
            $location = new Location();
                $location->__fromRequest($adress, $neighborhood, $city, $province,$country);
            $data = new PersonalData();
                $data->__fromRequest($name,$surname,$sex,$dni,$location);
            
            /*SETTING DE DATOS A UNA INSTANCIA USER DESDE LA SESSION*/
            $user = new User();
                $user->__fromRequest("Elcucarachin","Carlos1245","elcuca@gmail.com",$data);
            $uRole = new UserRole();
                $uRole->setUser($user);
            //var_dump($uRole);    
            $this->uRoleDAO->UtoKeeper($uRole);
            $this->homeController->Index();
        }

        public function DeleteUser($id){
            echo $id;
            $this->userDAO->Delete($id);
        }
    }
?>