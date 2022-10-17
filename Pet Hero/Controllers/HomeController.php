<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User as User;

    class HomeController
    {
        public function Index();
        public function Buscar();
        public function Login();
        public function ShowProfile();
        public function Register();
        public function Logout();
        public function BeKeeper();

    }

?>