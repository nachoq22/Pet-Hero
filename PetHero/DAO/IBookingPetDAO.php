<?php
namespace DAO;

use \Model\Booking as Booking;

    interface IBookingPetDAO{
        public function NewBooking(Booking $booking,$petList);
        public function Get($id);
        public function GetAll();
        public function Delete($idBP);
    }
?>