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

//CON TODO ESTO SE REGISTRA UN BOOKING
        private function Add(Booking $booking){
            $query = "CALL Booking_Add(?,?,?,?,?)";
            $parameters["startD"] = $booking->getStartD();
            $parameters["finishD"] = $booking->getFinishD();
            $parameters["bookState"] = $booking->getBookState();
            $parameters["idPublic"] = $booking->getPublication()->getid();
            $parameters["idUser"] = $booking->getUser()->getId();

            $idNBook = 0;

            $this->connection = Connection::GetInstance();
            $idNBook = $this->connection->ExecuteLastId($query,$parameters,$idNBook,QueryType::StoredProcedure);
        return $idNBook;    
        }

        public function AddRet(Booking $booking){
                $public = $this->publicDAO->Get($booking->getPublication()->getId());
                $user = $this->userDAO->DGetByUsername($booking->getUser()->getUsername());
            $booking->setPublication($public);
            $booking->setuser($user);
            $idNBook = $this->Add($booking);
            $booking = $this->Get($idNBook);
        return $booking;    
        }      
///

        public function GetAll(){
            $bookingList = array();    

            $query = "CALL Booking_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();
                $booking->__fromDB($row["idBooking"],$row["openDate"]
                                  ,$row["closeDate"],$row["payState"],$row["payCode"]
                                  ,$this->publicDAO->Get($row["idPublic"])
                                  ,$this->userDAO->Get($row["user"]));

                array_push($bookingList,$booking);
            }
            return $bookingList;

        }

        public function GetByUser($idUser){
            $query = "CALL Booking_GetByUser(?);";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            $book = new Booking();
            $book->__fromDB($resultBD["idBook"],$resultBD["startD"]
            ,$resultBD["finishD"],$resultBD["bookState"]
            ,$resultBD["payCode"]
            ,$this->publicDAO->Get($resultBD["idPublic"])
            ,$this->userDAO->Get($resultBD["idUser"]));
            return $book;
        }

        public function Get($id){
            $booking = null;
            $query = "CALL Booking_GetById(?)";
            $parameters["idBooking"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                  ,$row["finishD"],$row["bookState"]
                                  ,$this->publicDAO->Get($row["idPublic"])
                                  ,$this->userDAO->Get($row["idUser"]));
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