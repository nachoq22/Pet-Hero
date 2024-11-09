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

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                             AGREGAR USER
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el registro
*    de un nuevo usuario. 

?      💠 Register
¬          ► Registra un nuevo USER.
?      💠 Index
¬          ► Redirecciona a la pagina principal,Index, con un mensaje.
?      💠 ViewOwnerPanel
¬          ► Redirecciona a OwnerPanel luego de un registro satisfactorio.

* A: $username: nombre del USER.
*    $email: email del USER.
*    $password: contraseña del USER.

* R: No Posee.
🐘 */       
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

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                                 LOGIN
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el login
*    de un usuario. 

?      💠 Login
¬          ► Verifica la data del USER para loguearlo.
?      💠 IsKeeper
¬          ► Verifica que el USER Logueado sea KEEPER (habilita funciones).
?      💠 Index
¬          ► Redirecciona a la pagina principal,Index, con un mensaje.

* A: $username: nombre del USER.
*    $password: contraseña del USER.

* R: No Posee.
🐘 */ 
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

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                          ASIGNACIÓN ROL KEEPER
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios actualizar los
* roles que dispone el USER logueado.

?      💠 isLogged
¬          ► Verifica si un usuario ha iniciado sesión en una aplicación.
?      💠 UtoKeeper
¬          ► Actualiza el ROLE del USER si cumple las condiciones.
?      💠 ViewBeKeeper
¬          ► Redirecciona a la pagina BeKeeper, con un mensaje de error.
?      💠 ViewKeeperPanel
¬          ► Redirecciona a la pagina KeeperPanel, con un satisfactorio.

* A: $adress, $neighborhood, $city, 
*    $province, $country, $name,$surname,$sex,$dni: PERSONAL DATA del USER.

* R: No Posee.
🐘 */  
        //FUNCION PARA ASIGNARLE A UN USUARIO EL ROL KEEPER//
        public function BeKeeper($adress, $neighborhood, $city, $province, $country, $name,$surname,$sex,$dni){
                $this->homeController->isLogged();
                $location = new Location();
                $location->__fromRequest($adress, $neighborhood, $city, $province,$country);
                $data = new PersonalData();
                $data->__fromRequest($name,$surname,$sex,$dni,$location);  
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
    }
?>