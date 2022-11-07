<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IBookingPetDAO as IBookingPetDAO;
use \DAO\BookingDAO as BookingDAO;
use \DAO\PetDAO as PetDAO;
use \Model\BookingPet as BookingPet;
use \Model\Booking as Booking;

    class BookingPetDAO implements IBookingPetDAO{
        private $connection;
        private $tableName = 'bookingbookingPet';

        private $bookDAO;
        private $petDAO;

        public function __construct(){
            $this->bookDAO = new BookingDAO();
            $this->petDAO = new PetDAO();
        }

//CON ESTO SE GUARDAN LOS PETS CORRESPONDIENTES A UNA BOOKING
        private function Add(BookingPet $bp){
            $query = "CALL BP_Add(?,?)";
            $parameters["idBook"] = $bp->getBooking()->getId();
            $parameters["idPet"] = $bp->getPet()->getId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        private function NewBP(BookingPet $bp){
                $pet = $this->petDAO->Get($bp->getPet()->getId());
            $bp->setPet($pet);
            $this->Add($bp);
        }

        public function NewBooking(Booking $booking,$petList){
            $booking = $this->bookDAO->AddRet($booking);
            foreach($petList as $pet){
                $bp = new BookingPet();
                    $bp->setBooking($booking);
                    $bp->getPet()->setId($pet);
                $this->NewBP($bp);
            }
        }

        public function NewState(Booking $book,$stateNum){
            $this->bookDAO->UpdateStSwtich($book,$stateNum);
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

        public function GetPetsByBook($idBook){
            $petList = array();
            $query = "CALL BP_GetByBook(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
            foreach($resultBD as $row){
                $bp = new bookingPet();
                $bp->__fromDB($row["idBP"],$this->bookDAO->Get($row["idBook"]),$this->petDAO->Get($row["idPet"]));

            array_push($petList,$bp->getPet());
            }
        return $petList;
        }

///ACA RECUPERO PETS SEGUN LA LISTA DE BOOKINGS A FILTRAR
        public function GetAllPetsBooks($username){
                $booklist = $this->GetBookByUsername($username);
            $psBsList = array();
            foreach($booklist as $booking){
                $petlist = array();
                $petlist = $this->GetPetsByBook($booking->getid());

                $psBsList = array_merge($psBsList,$petlist);
            }
        return $psBsList;    
        }

///ACA RECUPERO BOOKINGS
        public function GetBookByUsername($username){
           $bookList = $this->bookDAO->GetByUsername($username);
        return $bookList;
        }

        
//PARA FUNCIONAMIENTO DE CHECKER        
        private function GetFPPet(Booking $book){
            $petPay = 0;
            $query = "CALL BP_GetPetPay(?)";
            $parameters["remuneration"] = $book->getPublication()->getRemuneration();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                 $petPay = $row["petPay"];
            }
            return $petPay;
        }

        public function GetTotally(Booking $book){
                $book = $this->bookDAO->Get($book->getId());
            $subtotalBook = $this->bookDAO->GetFPBook($book);
            $subtotalPet = $this->GetFPPet($book);
            $total = ($subtotalBook + $subtotalPet) * 0.5;
            return $total;
        }
///

        public function GetByBook($idBook){
            $bp = null;
            $query = "CALL BP_GetByBook(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bp = new bookingPet();
                $bp->__fromDB($row["idBP"],$this->bookDAO->Get($row["idBook"]),$this->petDAO->Get($row["idPet"]));
            }
            return $bp;
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