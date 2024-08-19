<?php
namespace DAO;
use \DAO\QueryType as QueryType;
use \DAO\Connection as Connection;
use \Exception as Exception;

use \DAO\IBookingPetDAO as IBookingPetDAO;
use \DAO\BookingDAO as BookingDAO;
use \DAO\PetDAO as PetDAO;
use \Model\BookingPet as BookingPet;
use \Model\Booking as Booking;
use \Model\Pet as Pet;

    class BookingPetDAO implements IBookingPetDAO{
        private $connection;
        private $tableName = 'BookingPet';

        private $bookDAO;
        private $petDAO;

//======================================================================
// DAOs INJECTION
//======================================================================
        public function __construct(){
            $this->bookDAO = new BookingDAO();
            $this->petDAO = new PetDAO();
        }

//======================================================================
// TOOL METHOD
//======================================================================
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

//======================================================================
// SELECT METHODS
//======================================================================
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

#1.1.TRAIGO BOOKINGS SEGUN USERNAME OWNER
        public function GetAllBooksByUsername($username){
            $bookList = $this->bookDAO->GetAllBooksByUsername($username);
        return $bookList;
        }


#2.1.TRAIGO BOOKINGS SEGUN USERNAME KEEPER
        public function GetAllBooksByKeeper($username){
            $matches = $this->bookDAO->GetAllBooksByKeeper($username);
        return $matches;    
        }

#1||2.TRAIGO LOS PETS CORRESPONDIENTES A UNA BOOKING        
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

#1.2.TRAIGO TODOS LOS PETS SEGUN UN USERNAME DE OWNER
        public function GetAllPetsBooks($username){
                $booklist = $this->GetAllBooksByUsername($username);
                $psBsList = array();
            foreach($booklist as $booking){
                    $bpetList = array();
                    $bpetList = $this->GetPetsByBook($booking->getid());
                $psBsList = array_merge($psBsList,$bpetList);
            }
        return $psBsList;    
        }


#2.2.TRAIGO TODOS LOS PETS SEGUN UN USERNAME DE KEEPER
        public function GetAllPetsByBooks($username){
                $booklist = $this->GetAllBooksByKeeper($username);
                $psBsList = array();
            foreach($booklist as $booking){
                    $bpetList = array();
                    $bpetList = $this->GetPetsByBook($booking->getid());
                $psBsList = array_merge($psBsList,$bpetList);
            }
        return $psBsList;    
        }

        public function Get($idBP){
            $bookingPet = null;

            $query = "CALL BP_GetById(?)";
            $parameters["idBP"] = $idBP;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bp = new bookingPet();
                $bp->__fromDB($row["idBP"],$this->bookDAO->Get($row["idBook"]),$this->petDAO->Get($row["idPet"]));
            }
        return $bookingPet;
        }

#UN BP SEGUN BOOKING
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
        
//-----------------------------------------------------
// METHODS THAT OBTAIN TOTAL FROM THE DAYS OF STAY AND THE AMOUNT OF PET
//-----------------------------------------------------  
#SUBTOTAL POR MASCOTA     
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

#MITAD DEL TOTAL CORRESPONDIENTE AL PAGO/VALOR DEL CHECKER
        public function GetTotally(Booking $book){
                $book = $this->bookDAO->Get($book->getId());
            $subtotalBook = $this->bookDAO->GetFPBook($book);
            $subtotalPet = $this->GetFPPet($book);
                $total = ($subtotalBook + $subtotalPet);
            $checkPay = $total / 2;
        return $checkPay;
        }
//-----------------------------------------------------
//-----------------------------------------------------  

//======================================================================
// INSERT METHODS
//======================================================================

        private function Add(BookingPet $bp){
            $query = "CALL BP_Add(?,?)";
            $parameters["idBook"] = $bp->getBooking()->getId();
            $parameters["idPet"] = $bp->getPet()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//-----------------------------------------------------
// METHOD TO CREATE A BOOKING WITH PETS
//-----------------------------------------------------     
        public function NewBooking(Booking $booking,$petList){
#GUARDO Y RECUPERO BOOKING COMPLETO CON ID
            $message = "Successful: Se ha completado la reserva exitosamente";
                try{
                    $booking = $this->bookDAO->AddRet($booking);
                }catch(exception $e){
                    $message = "Error: No se ha podido completar la reserva, intente nuevamente";
                }
#GUARDO EN BUCLE BP USANDO EL BOOKING GUARDADO Y RECUPERADO
                try{
                    foreach($petList as $pet){
                        $bp = new BookingPet();
                        $bp->setBooking($booking);
                        $bp->getPet()->setId($pet);
                        $pet = $this->petDAO->Get($bp->getPet()->getId());
                        $bp->setPet($pet);
                        $this->Add($bp);
                    }
                }
                catch(exception $e){
                    $message="Error: ha ocurrido un fallo en el guardado de pets, intente nuevamente";
                }
            return $message;
            }
//-----------------------------------------------------
//-----------------------------------------------------  

//======================================================================
// UPDATE METHODS
//======================================================================
        public function NewState(Booking $book,$stateNum){
            $this->bookDAO->UpdateStSwtich($book,$stateNum);
        }

        public function CancelBook(Booking $booking){
            $message = "";
            try{
                $this->NewState($booking,3);
                //$this->bookDAO->UpdateStSwtich($booking,3);
                $message = "Successful: Reserva cancelada satisfactoriamente";
            }catch(Exception $e){
                $message = "Error: No se pudo cancelar la reserva, reintente mas tarde.";
            }
            return $message;
        }

        public function UpdateAllStates(){
            $this->bookDAO->UpdateAllStates();
        }

//-----------------------------------------------------
// METHODS IN CHARGE OF THE PAYMENT CODE VALIDATION AND SETTING
//-----------------------------------------------------   
#CHEQUEAMOS QUE EL PAYCODE SEA VALIDO
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

#ACTUALIZAMOS VALOR DE PAYCODE EN LA BOOKING Y EL ESTADO EN EL QUE SE ENCUENTRA
        public function UpdatePayCode(Booking $book){
            $message = "Error: El numero de pago ingresado no es valido";
            $rta = $this->CheckPayCode($book);
            if($rta ==1){
                try{
                    $this->bookDAO->UpdateCode($book);
                    //$this->bookDAO->UpdateStSwtich($book,2);
                    $this->NewState($book,2);
                    $message = "Successful: Su comprobante ha sido aceptado";
                }catch(Exception $e){
                    $message = "Error: No se pudo actualizar el estado de su reserva, reintente mas tarde";
                    return $message;
                }
            }
            return $message;
        }

//======================================================================
// DELETE METHODS
//======================================================================       
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

        
//ESTO SIRVE PARA COMPARAR EL TIPO DE MASCOTAS DE NUESTRO BOOKING CON EL TIPO DE LAS MASCOTAS DE LOS BOOKING QUE COINCIDAN CON NUESTRA FECHA INTRODUCIDA//
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

    }
?>