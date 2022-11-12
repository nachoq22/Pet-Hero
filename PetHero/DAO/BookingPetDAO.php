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
            $message = "Successful: Se ha completado la reserva exitosamente";
            try{
                $booking = $this->bookDAO->AddRet($booking);
            }
            catch(exception $e){
                $message = "Error: No se ha podido completar la reserva, intente nuevamente";
            }
            try{
                foreach($petList as $pet){
                    $bp = new BookingPet();
                    $bp->setBooking($booking);
                    $bp->getPet()->setId($pet);
                    $this->NewBP($bp);
                }
            }
            catch(exception $e){
                $message="Error: ha ocurrido un fallo en el guardado de pets, intente nuevamente";
            }
            return $message;
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
                $bp = new BookingPet();
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


        //ESTO HACE FUNCIONAR LA VALIDACION DE TIPOS DE MASCOTAS ANTES DE VALIDAR FECHAS
        public function GetAllPetsbyBooking($idList) {
            $petList = array();
            
            foreach($idList as $obj){
                $pet = new Pet();
                $pet = $this->petDAO->Get($obj);
                array_push($petList, $pet);
            }
            return $petList;

        }

        public function ValidateTypes($idList){
            $petList= $this->GetAllPetsbyBooking($idList);
            $rta=0;
            $type="";
            foreach($petList as $pet){
                if(empty($type)){
                    $type = $pet->getType()->getName();
                }
                if(strcmp($pet->getType()->getName(), $type)!=0){
                    $rta =0;
                    return $rta;
                }else{
                    $rta = 1;
                }
            }
        return $rta;
        }
        /////////////////////

        
        //ESTO SIRVE PARA COMPARAR EL TIPO DE MASCOTAS DE NUESTRO BOOKING CON EL TIPO DE LAS MASCOTAS DE LOS BOOKING QUE COINCIDAN CON NUESTRA FECHA INTRODUCIDA
        public function ValidateTypesOnBookings(Booking $booking, $idList){
            $matches = $this->bookDAO->GetAllMatchingDatesByPublic($booking); 
            $petList = $this->GetAllPetsbyBooking($idList);
            $pet = $petList[0];
            $rta = 1;
            if(!empty($matches)){
                foreach($matches as $book){
                    $bookN = $this->GetByBook($book->getId());
                    $TypeBP = $bookN->getPet()->getType()->getName();
                    if (strcmp($TypeBP, $pet->getType()->getName())!=0){
                        $rta=0;
                        return $rta;
                    }
                }
            }
            return $rta;
        }
        ////////////////////////////

        

    }
?>