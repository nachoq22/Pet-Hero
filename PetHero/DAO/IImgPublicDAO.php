<?php
namespace DAO;

use \Model\ImgPublic as ImgPublic;

    interface IImgPublicDAO{
        public function Add(ImgPublic $imgPublic);
        public function Get($idImg);
        public function GetAll();
        public function Delete($idImg);
    }
?>