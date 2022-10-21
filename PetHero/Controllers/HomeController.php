<?php
    namespace Controllers;

    class HomeController
    {
        public function Index()
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function ViewRegister()
        {
            require_once(VIEWS_PATH."register.php");
        }

        public function Register($userName, $password)
        {
            
            require_once(VIEWS_PATH."agregarlocation.php");
        }
    }

    

?>