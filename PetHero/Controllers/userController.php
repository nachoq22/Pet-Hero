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
            $this->uRoleDAO = new URoleDAO();
            $this->homeController = new HomeController();
        }

        public function Register($username, $email, $password){
                $user = new User();
                $user->__fromRegister($username,$password,$email);
                $uRole= new UserRole();
                $uRole->setUser($user);
            $message = $this->uRoleDAO->Register($uRole);
                if(strpos($message,"Error")!==false){
                    $this->homeController->Index($message); 
                }else{
                    $_SESSION["logUser"] = $user;
                    $this->homeController->ViewOwnerPanel($message); 
                }           
        } 

        public function Login($username, $password){            
                $user = new User();
                $user->__fromLogin($username,$password);
            $rta = $this->userDAO->Login($user);
            if(!empty($rta)){
                $_SESSION["logUser"] = $user;
                $ur = new UserRole();
                $ur->setUser($user);
                if(!empty($this->uRoleDAO->IsKeeper($ur->getUser()->getUsername()))){
                    $_SESSION["isKeeper"] = true; 
                }
                
                $this->homeController->Index("Successful: Se ha logueado correctamente");
            }else{
                $this->homeController->Index("Error: Credenciales invalidas, reintente...");
            }
        }

        public function BeKeeper($adress, $neighborhood, $city, $province, $country, $name,$surname,$sex,$dni){
                $this->homeController->isLogged();
                $location = new Location();
                $location->__fromRequest($adress, $neighborhood, $city, $province,$country);
                $data = new PersonalData();
                $data->__fromRequest($name,$surname,$sex,$dni,$location);  
    /*SETTING DE DATOS A UNA INSTANCIA USER DESDE LA SESSION*/
                $user = $_SESSION["logUser"];
                $user->setData($data);
                $uRole = new UserRole();
                $uRole->setUser($user);     

                $message = $this->uRoleDAO->UtoKeeper($uRole);
                    if((strpos($message, "Error") !== false)){
                        
                        $this->homeController->ViewBeKeeper($message);  
                    }else{
                        $_SESSION["isKeeper"] = 1; 
                        $this->homeController->ViewKeeperPanel($message); 
                    }
        }

        public function DeleteUser($id){
            echo $id;
            $this->userDAO->Delete($id);
        }
    }
?>