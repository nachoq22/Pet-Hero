<?php
namespace DAO;

use \Exception as Exception;
use \DAO\PetDAO as PetDAO;

use \Model\Booking as Booking;
use \DAO\QueryType as QueryType;
use \DAO\BookingDAO as BookingDAO;
use \DAO\Connection as Connection;
use \Model\BookingPet as BookingPet;
use \DAO\IBookingPetDAO as IBookingPetDAO;

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
            $bpetList = array();
            $query = "CALL BP_GetByBook(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
            foreach($resultBD as $row){
                $bp = new bookingPet();
                $bp->__fromDB($row["idBP"],$this->bookDAO->Get($row["idBook"]),$this->petDAO->Get($row["idPet"]));

            array_push($bpetList,$bp);
            }
        return $bpetList;
        }

///ACA RECUPERO PETS SEGUN LA LISTA DE BOOKINGS A FILTRAR
        public function GetAllPetsBooks($username){
                $booklist = $this->GetBookByUsername($username);
            $psBsList = array();
            foreach($booklist as $booking){
                $bpetList = array();
                $bpetList = $this->GetPetsByBook($booking->getid());

                $psBsList = array_merge($psBsList,$bpetList);
            }
        return $psBsList;    
        }

///ACA RECUPERO BOOKINGS
        public function GetBookByUsername($username){
           $bookList = $this->bookDAO->GetByUsername($username);
        return $bookList;
        }


        public function GetAllPetsByBooks($username){
            $booklist = $this->GetBookByKeeper($username);
        $psBsList = array();
        foreach($booklist as $booking){
            $bpetList = array();
            $bpetList = $this->GetPetsByBook($booking->getid());

            $psBsList = array_merge($psBsList,$bpetList);
        }
    return $psBsList;    
    }
        
//PARA FUNCIONAMIENTO DE CHECKER        
        private function GetFPPet(Booking $book){
            $petPay = 0;
            $query = "CALL BP_GetPetPay(?,?)";
            $parameters["remuneration"] = $book->getPublication()->getRemuneration();
            $parameters["idBook"] = $book->getId();
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

//RECUPERO BOOKINGS POR KEEPER
        public function GetBookByKeeper($username){
            $matches = $this->bookDAO->GetBookByKeeper($username);
        return $matches;    
        }
//

        public function CheckPayCode(Booking $book){
            $rta = 0;
            $bookA = $this->bookDAO->Get($book->getId());
            if((STRCMP($bookA->getBookState(),"Awaiting Payment") == 0)){
                foreach($this->GenPayCodes() as $code){
                    if($book->getPayCode() == $code){
                        $rta = 1;
                        return $rta;
                    }
                }
            }
            return $rta;
        }

        public function UpdatePayCode(Booking $book){
            $message = "Error: El numero de pago ingresado no es valido";
            $rta = $this->CheckPayCode($book);
            if($rta ==1){
                try{
                    $this->bookDAO->UpdateCode($book);
                    $this->bookDAO->UpdateStSwtich($book,2);
                    $message = "Successful: Su comprobante ha sido aceptado";
                }catch(Exception $e){
                    $message = "Error: No se pudo actualizar el estado de su reserva, reintente mas tarde";
                    return $message;
                }
            }
            return $message;
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

        private function GenPayCodes(){
            $payCodeList = array();
            array_push($payCodeList,"2356942225");
            array_push($payCodeList,"2953479394");
            array_push($payCodeList,"4436675246");
            array_push($payCodeList,"5878746552");
            array_push($payCodeList,"2436977836");
            array_push($payCodeList,"5553434269");
            array_push($payCodeList,"8793569575");
            array_push($payCodeList,"7439386563");
            array_push($payCodeList,"5647789525");
            array_push($payCodeList,"3934865252");
            array_push($payCodeList,"9483284459");
        return $payCodeList;    
        }
    }
?>