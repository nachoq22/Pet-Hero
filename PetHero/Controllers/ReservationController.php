<?php
namespace Controllers;

    class ReservationController{

        public function __construct(){
        }

        public function Add($startD,$finishD,$petsId){
            echo "START".$startD;
            echo "\nEND".$finishD;
            var_dump($petsId);
        }
    }
?>