<?php
namespace DAO;

use \Model\Booking as Booking;

    interface IBookingDAO{
        public function AddRet(Booking $booking);
        public function GetAll();
        public function GetByUser($idUser);
        public function Get($id);
        public function Delete($idBooking);
    }
?>