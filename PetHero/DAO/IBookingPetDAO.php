<?php
namespace DAO;

use \Model\BookingPet as BookingPet;

    interface IBookingPetDAO{
        public function Add(BookingPet $bp);
        public function Get($id);
        public function GetAll();
        public function Delete($idBP);
    }
?>