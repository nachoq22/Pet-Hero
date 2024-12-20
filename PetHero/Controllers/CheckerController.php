<?php
namespace Controllers;

use \Controllers\HomeController as HomeController;

use \DAO\CheckerDAO as CheckerDAO;

    class CheckerController{
        private $checkDAO;
        private $homeC;

        public function __construct(){
            $this->checkDAO = new CheckerDAO();
            $this->homeC = new HomeController();
        }

//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                         VISTA PREVIA CHECKER PDF
//* ×××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function ViewChecker($idBook){
        $this -> homeC -> isLogged();
        $checker = $this -> checkDAO -> GetByBook($idBook);
        require_once(VIEWS_PATH."ViewChecker.php");
        }
    }
?>