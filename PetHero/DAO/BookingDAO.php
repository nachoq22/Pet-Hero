<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IBookingDAO as IBookingDAO;
use \DAO\PublicationDAO as PublicationDAO;
use \DAO\UserDAO as UserDAO;
use \Model\Booking as Booking;

    class BookingDAO implements IBookingDAO{
        private $connection;
        private $tableName = 'Booking';

        private $publicDAO;
        private $userDAO;
        
//DAO INJECTION
        public function __construct(){
            $this->publicDAO = new PublicationDAO();
            $this->userDAO = new UserDAO();
        }

        public function Add(Booking $booking){
            $query = "CALL Booking_Add(?,?,?,?,?,?)";
            $parameters["openDate"] = $booking->getStartD();
            $parameters["closeDate"] = $booking->getFinishD();
            $parameters["bookState"] = $booking->getBookState();
            $parameters["payCode"] = $booking->getPayCode();
            $parameters["idPublic"] = $booking->getPublication()->getid();
            $parameters["idUser"] = $booking->getUser()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function GetAll(){
            $bookingList = array();    

            $query = "CALL Booking_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();
                $booking->__fromBD($row["idBooking"],$row["openDate"]
                                  ,$row["closeDate"],$row["payState"],$row["payCode"]
                                  ,$this->publicDAO->Get($row["idPublic"])
                                  ,$this->userDAO->Get($row["user"]));

                array_push($bookingList,$booking);
            }
            return $bookingList;

        }

        public function Get($id){
            $booking = null;
            $query = "CALL Booking_GetById(?)";
            $parameters["idBooking"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromBD($row["idBooking"],$row["openDate"]
                                  ,$row["closeDate"],$row["payState"],$row["payCode"]
                                  ,$this->publicDAO->Get($row["idPublic"])
                                  ,$this->userDAO->Get($row["user"]));
            }
            return $booking;
        }

        public function Delete($idBooking){
            $query = "CALL booking_Delete(?)";
            $parameters["idbooking"] = $idBooking;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>