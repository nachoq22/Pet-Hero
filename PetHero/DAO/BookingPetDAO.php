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

//? ======================================================================
//!                           DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this->bookDAO = new BookingDAO();
            $this->petDAO = new PetDAO();
        }

//? ======================================================================
//!                             TOOL METHOD
//? ======================================================================
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

//? ======================================================================
//!                             SELECT METHODS
//? ======================================================================
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

/*
* D: Realiza la llamada del método 'GetAllBooksByUsername' 
*        perteneciente a BookingDAO.
* A: Username del Owner.
* R: El listado de Bookings del username proporcionado.
🐘*/ 
        public function GetAllBooksByUsername($username){
            $bookList = $this->bookDAO->GetAllBooksByUsername($username);
        return $bookList;
        }

/*
* D: Realiza la llamada del método 'GetAllBooksByKeeper' 
*        perteneciente a BookingDAO.
* A: Username del Keeper.
* R: El listado de Bookings del username proporcionado.
🐘*/ 
        public function GetAllBooksByKeeper($username){
            $matches = $this->bookDAO->GetAllBooksByKeeper($username);
        return $matches;    
        }
 
/*
* D: Recupera las Pets asociadas a cada Booking según ID.
*        Realiza llamada a los métodos Get de BookingDAO Y PetDAO
*        como soporte.
* A: ID del Booking
* R: El listado de Pets según ID del Booking
🐘*/     
        public function GetPetsByBook($idBook){
            $bpetList = array();

            $query = "CALL BP_GetByBook(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bp = new BookingPet();
                $bp -> __fromDB($row["idBP"],$this->bookDAO->Get($row["idBook"]),$this->petDAO->Get($row["idPet"]));
                array_push($bpetList,$bp);
            }
        return $bpetList;
        }

/*
* D: Método de uso conjunto donde primero recupera todos los
*        Booking según su username, para posteriormente aprovechar
*        el ID de cada una para recuperar las Pets asociadas.
* A: Username del Owner.
* R: Listado de Pets según los Bookings filtrados por Username.
🐘*/    
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

/*
* D: Método de uso conjunto donde primero recupera todos los
*        Booking donde este asociado el Keeper, para luego usar
*        los ID y recuperar las mascotas asociadas.
* A: Username del Keeper.
* R: Listado de Pets según los Bookings filtrados por Username.
🐘*/    
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
        
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬  MÉTODOS QUE OBTIENEN EL TOTAL DE LOS DÍAS DE ESTANCIA Y LA CANTIDAD DE MASCOTA
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Obtiene el pago correspondientes al NUMERO de Pets
*        que el Keeper deberá cuidar en ESTA Booking.
*        TotalPagoPets = CantidadPets * RemuneraciónPublication
!     Requerido por GetTotally para obtener el total final a pagar.
* A: Booking que aportara el ID para realizar el filtro
*     y recuento de Pets asociados.
* R: Subtotal correspondiente al pago por x cantidad de Pets.
🐘*/    
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

/*
* D: Método compuesto encargado de calcular el total
*       y retornar la mitad de este para finalizar la emisión
*       del checker a pagar por el Owner.
!       Requerido por GetTotally de CheckerDAO para la emisión
!       satisfactoria de un Checker.
* A: Booking que aportara el ID para realizar el filtro
*        y recuento de Pets asociados.
* R: Mitad del pago total.
🐘*/   
        public function GetTotally(Booking $book){
                $book = $this->bookDAO->Get($book->getId());
            $subtotalBook = $this->bookDAO->GetFPBook($book);
            $subtotalPet = $this->GetFPPet($book);
                $total = ($subtotalBook + $subtotalPet);
            $checkPay = $total / 2;
        return $checkPay;
        }

//? ======================================================================
// !                        INSERT METHODS
//? ======================================================================

        private function Add(BookingPet $bp){
            $query = "CALL BP_Add(?,?)";
            $parameters["idBook"] = $bp->getBooking()->getId();
            $parameters["idPet"] = $bp->getPet()->getId();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                 MÉTODO PARA CREAR UNA RESERVA CON MASCOTAS
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××  
        public function NewBooking(Booking $booking,$petList){
//? 1) GUARDO Y RECUPERO BOOKING COMPLETO CON ID
            $message = "Successful: Se ha completado la reserva exitosamente";
                try{
                    $booking = $this->bookDAO->AddRet($booking);
                }catch(exception $e){
                    $message = "Error: No se ha podido completar la reserva, intente nuevamente";
                }
//? 2) GUARDO EN BUCLE BP USANDO EL BOOKING GUARDADO Y RECUPERADO
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

//? ======================================================================
//!                         UPDATE METHODS
//? ======================================================================
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

/*
* D: Método que se sostiene de UpdateAllStates de
*     BookingDAO para mantener los estados de las 
*     Booking actualizados y en orden.
* A: No posee
* R: No posee.
🐘*/           
        public function UpdateAllStates(){
            $this->bookDAO->UpdateAllStates();
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬    MÉTODOS A CARGO DE LA VALIDACIÓN Y FIJACIÓN DEL CÓDIGO DE PAGO
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Método encargado de comprobar que el paycode suministrado sea
*       correcto.
?       Para poder realizar una simulacion correcta del funcionamiento,
?       Se tiene un listado de 'paycodes generados', ya que estos 
?       deberían ser suministrados por la entidad donde se pago el checker.
!       Requerida por UpdatePayCode como condicion para actualizar el
!       estado del Booking y asentar el paycode en la BDD.
* A: Booking del cual obtenemos el paycode.
* R: 1 si la comprobación es valida, 0 al ser falso.
🐘*/  
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

/*
* D: Método encargado de actualizar el estado del Booking si previamente
*        a este le fue agregado un paycode y a su vez es valido para comprobar
*        el pago del Checker. Finalmente se asienta el paycode en la BDD.
!    Indispensable para funcionamiento de PayCheck() en CheckerDAO 
!    para la actualizacion del checker.
* A: Booking del cual obtenemos el paycode.
* R: Mensaje afirmativo o negativo respecto a si el pago pudo ser comprobado.
🐘*/    
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

//? ======================================================================
// !                        DELETE METHODS
//? ======================================================================       
        public function Delete($idBP){
            $query = "CALL BP_Delete(?)";
            $parameters["idBP"] = $idBP;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }


//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬    MÉTODOS ENCARGADOS DE VALIDACIONES NECESARIAS PARA CREAR BOOKING
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××      
/*
* D: Método que retorna los Pets correspondientes a 
*        determinado Booking según sus ID.
!        Requerido por ValidateTypes, instancia previa a
!        la validación de fecha para crear una Booking.
* A: IDs de Mascotas que serán vinculadas a un Booking.
* R: Lista de Pets recuperados.
🐘*/     
        public function GetAllPetsbyBooking($idList) {
            $petList = array();
    
            foreach($idList as $obj){
                $pet = new Pet();
                $pet = $this->petDAO->Get($obj);
                array_push($petList, $pet);
            }
            return $petList;
        }

/*
* D: Método encargado de validar la siguiente condición:
?    "Solo se podrá tener 1 tipo de Pet por Booking"
*     Recuperamos los Pets con el método GetAllPetsbyBooking
*     Para posteriormente obtener un ancla del primer
*     elemento (su petType).
* A: IDs de Mascotas que serán vinculadas a un Booking.
* R: 1 en caso de cumplir la condición previa, 0 en false.
🐘*/          
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

/*
* D: Método compuesto para validar los tipos de Pets la Booking a registrar
*        con las de otras Bookings que coincidan en cuanto a fecha.
* A: Booking a almacenar.
* A2: IDs de Pets a vincular a la Booking anterior.
* R: 1 en caso de cumplir la condición previa, 0 en false.
🐘 */ 
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