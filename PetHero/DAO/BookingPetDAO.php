<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IBookingPetDAO as IBookingPetDAO;
use \DAO\BookingDAO as BookingDAO;
use \DAO\PetDAO as PetDAO;
use \Model\BookingPet as BookingPet;
use \Model\Booking as Booking;
use \Model\Pet as Pet;

    class BookingPetDAO implements IBookingPetDAO{
        private $connection;
        private $tableName = 'bookingbookingPet';

        private $bookDAO;
        private $petDAO;

        public function __construct(){
            $this->bookDAO = new BookingDAO();
            $this->petDAO = new PetDAO();
        }


        public function Add(BookingPet $bp){
            $query = "CALL BP_Add(?,?)";
            $parameters["idBook"] = $bp->getBooking()->getId();
            $parameters["idPet"] = $bp->getPet()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function Get($id){
            $bookingPet = null;
            $query = "CALL BP_GetById(?)";
            $parameters["idBP"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bp = new bookingPet();
                $bp->__fromDB($row["idBP"],$this->bookDAO->Get($row["idBook"]),$this->petDAO->Get($row["idPet"]));
            }
            return $bookingPet;
        }

        public function GetAll(){
            $bpList = array();    

            $query = "CALL BP_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bp = new bookingPet();
                $bp->__fromDB($row["idBP"],$this->bookDAO->Get($row["idBook"]),$this->petDAO->Get($row["idPet"]));

                array_push($bpList,$bp);
            }
            return $bpList;
        }
        
        public function Delete($idBP){
            $query = "CALL BP_Delete(?)";
            $parameters["idBP"] = $idBP;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>