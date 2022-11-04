<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;

    use \DAO\IBookingDAO as IBookingDAO;
    use \Model\Booking as Booking;
    use \Model\User as User;
    use \Model\Publication as Publication;

    class BookingDAO extends IBookingDAO
    {
        private $connection;
        private $tableName = 'booking';



        private function Add(Booking $booking)
        {
            $query = "CALL booking_Add(?,?,?,?,?,?)";
            $parameters["openDate"] = $booking->getOpenDate();
            $parameters["closeDate"] = $booking->getCloseDate();
            $parameters["payState"] = $booking->getPayState();
            $parameters["payCode"] = $booking->getPayCode();
            $parameters["publication"] = $booking->getPublication();
            $parameters["user"] = $booking->getUser();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
        private function GetAll()
        {
            $bookingList = array();    

            $query = "CALL booking_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new booking();
                $booking->__fromDB($row["idBooking"],$row["openDate"]
                ,$row["closeDate"],$row["payState"],$row["payCode"]
                ,$row["publication"],$row["user"]);

                array_push($bookingList,$booking);
            }
            return $bookingList;

        }
        public function Get($id){
            $booking = null;
            $query = "CALL booking_GetById(?)";
            $parameters["idBooking"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDB($row["idBooking"],$row["openDate"]
                ,$row["closeDate"],$row["payState"]
                ,$row["payCode"],$row["publication"]
                ,$this->typeDAO->Get($row["user"]));
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