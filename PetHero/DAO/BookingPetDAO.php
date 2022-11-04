<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;

    use \DAO\IBookingbookingPetDAO;
    use \Model\BookingbookingPet as BookingbookingPet;
    use \Model\Booking as Booking;
    use \Model\Pet as Pet;

    class BookingbookingPetDAO extends IBookingbookingPetDAO
    {
        private $connection;
        private $tableName = 'bookingbookingPet';



        private function Add(bookingbookingPet $bookingbookingPet)
        {
            $query = "CALL bookingbookingPet_Add(?,?)";
            $parameters["booking"] = $bookingbookingPet->getBooking();
            $parameters["Pet"] = $bookingbookingPet->getPet();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
        public function Get($id){
            $bookingPet = null;
            $query = "CALL bookingPet_GetById(?)";
            $parameters["idBookingPet"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bookingPet = new bookingPet();

                $bookingPet->__fromDB($row["idBookingPet"],$row["booking"]
                ,$row["pet"]);

            }
            return $bookingPet;
        }
        private function GetAll()
        {
            $bookingbookingPetList = array();    

            $query = "CALL bookingbookingPet_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bookingbookingPet = new bookingbookingPet();
                $bookingbookingPet->__fromDB($row["booking"],$row["bookingPet"]);

                array_push($bookingbookingPetList,$bookingbookingPet);
            }
            return $bookingbookingPetList;

        }
        
        public function Delete($idBookingbookingPet){
            $query = "CALL bookingbookingPet_Delete(?)";
            $parameters["idBookingbookingPet"] = $idBookingbookingPet;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

    
    }

?>