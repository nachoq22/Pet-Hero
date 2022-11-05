<?php
namespace Controllers;

    class PublicationController{

        public function __construct(){
        }

        public function Add($title,$description,$openD,$closeD,$remuneration,$images){
            
            var_dump($_FILES['images']['name']);
        }
    }
?>