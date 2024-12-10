<?php
namespace Controllers;
use Exception;
use Exceptions\IsKeeperException;
use Exceptions\DataBindingException;
use Exceptions\UserDuplicateException;
use Exceptions\InvalidExtensionException;
use Exceptions\RegisterLocationException;
use Exceptions\RegisterPersonalDataException;

use \DAO\UserDAO as UserDAO;
use \DAO\URoleDAO as URoleDAO;

use \Model\User as User;
use \Model\Location as Location;
use \Model\UserRole as UserRole;
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
            $user -> __fromRegister($username,$password,$email);
            $uRole = new UserRole();
            $uRole -> setUser($user);
            $success = false;
            $message = "Successful: Se ha registrado satisfactoriamente.";

            try{

                $this -> uRoleDAO -> Register($uRole);
                $_SESSION["logUser"] = $user;
                $success = true;
                
            }catch(UserDuplicateException $ude){
                $message = $ude -> getMessage(); 
            }catch(InvalidExtensionException $iee){
                $message = $iee -> getMessage(); 
            }catch(Exception $e){
                $message = "Error: No se ha podido procesar su solicitud, reintente mas tarde."; 
            }   
 
            setcookie('message', $message, time() + 2,'/');
            if($success){
                header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewOwnerPanel');
                exit;
            }else{
                header('Location: http://localhost/Pet-Hero/PetHero/');
                exit;
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
            $user -> __fromLogin($username,$password);

            $rta = $this -> userDAO -> Login($user);
             
            if(!empty($rta)){
                $_SESSION["logUser"] = $user;
                $ur = new UserRole();
                $ur -> setUser($user);
                
                if(!empty($this -> uRoleDAO -> IsKeeper($ur -> getUser() -> getUsername()))){
                    $_SESSION["isKeeper"] = true; 
                }

                setcookie('message', "Successful: Se ha logueado correctamente",time() + 2,'/');
            }else{
                setcookie('message', "Error: Credenciales invalidas, reintente...",time() + 2,'/');
            }

            header('Location: http://localhost/Pet-Hero/PetHero/');
            exit;
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

* A: $address, $neighborhood, $city, 
*    $province, $country, $name,$surname,$sex,$dni: PERSONAL DATA del USER.

* R: No Posee.
🐘 */  
        public function BeKeeper($address, $neighborhood, $city, $province, $country, $name,$surname,$sex,$dni){
            $this->homeController->isLogged();
                
            $location = new Location();
            $location->__fromRequest($address, $neighborhood, $city, $province,$country);
                
            $data = new PersonalData();
            $data->__fromRequest($name,$surname,$sex,$dni,$location);
                
            $user = $_SESSION["logUser"];
            $user->setData($data);
            $uRole = new UserRole();
            $uRole->setUser($user);  
                
            $message = "Sucessful: Ha obtenido el rol de keeper.";
            $success = false;
                
            try{
                    
                $this->uRoleDAO->UtoKeeper($uRole);
                $success = true;
                
            }catch(IsKeeperException $ike){
                $message = $ike -> getMessage();
            }catch(RegisterLocationException $rle){
                $message = $rle -> getMessage();
            }catch(RegisterPersonalDataException $rpde){
                $message = $rpde -> getMessage();
            }catch(DataBindingException $dbe){
                $message = $dbe -> getMessage();
            }
                
            setcookie('message', $message, time() + 2,'/');
            
            if($success){
                $_SESSION["isKeeper"] = 1; 
                header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewKeeperPanel');
                exit;
            }else{
                header('Location: http://localhost/Pet-Hero/PetHero/Home/ViewBeKeeper');
                exit;
            }    
        }
    }
?>