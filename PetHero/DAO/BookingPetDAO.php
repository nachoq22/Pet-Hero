<?php
namespace DAO;

use \DAO\QueryType as QueryType;
use \DAO\Connection as Connection;

use \Exception as Exception;
use Exceptions\CancelBookingException;
use Exceptions\RegisterBookingException;
use Exceptions\UpdateBookingException;
use Exceptions\UpdateCheckerException;
use PDOException;

use \DAO\IBookingPetDAO as IBookingPetDAO;
use \DAO\BookingDAO as BookingDAO;
use \DAO\PetDAO as PetDAO;
use \DAO\CheckerDAO as CheckerDAO;

use \Model\BookingPet as BookingPet;
use \Model\Booking as Booking;
use \Model\Checker;


    class BookingPetDAO implements IBookingPetDAO{
        private $connection;
        //private $tableName = 'BookingPet';

        private $bookDAO;
        private $petDAO;
        private $checkDAO;

//? ======================================================================
//!                           DAOs INJECTION
//? ======================================================================
        public function __construct(){
            $this -> bookDAO = new BookingDAO();
            $this -> petDAO = new PetDAO();
            $this -> checkDAO = new CheckerDAO();
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
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bp = new bookingPet();
                $bp -> __fromDB($row["idBP"], $this -> bookDAO -> Get($row["idBook"])
                                            , $this -> petDAO -> Get($row["idPet"]));
                array_push($bpList,$bp);
            }
        return $bpList;
        }

/*
* D: Recupera los BP que son parte del mismo BOOKING.
* A: ID del Booking
* R: El listado de registros BOOKINGPET filtrados.
🐘*/     
        public function GetPetsByBook($idBook){
            $bpList = array();

            $query = "CALL BP_GetByBook(?)";
            $parameters["idBook"] = $idBook;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bp = new BookingPet();
                $bp -> __fromDB($row["idBP"], $this -> bookDAO -> Get($row["idBook"])
                                            , $this -> petDAO -> Get($row["idPet"]));
                array_push($bpList,$bp);
            }
        return $bpList;
        }

        public function Get($idBP){
            $bookingPet = null;

            $query = "CALL BP_GetById(?)";
            $parameters["idBP"] = $idBP;
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bp = new bookingPet();
                $bp -> __fromDB($row["idBP"], $this -> bookDAO -> Get($row["idBook"])
                                            , $this -> petDAO -> Get($row["idPet"]));
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
                $bp -> __fromDB($row["idBP"], $this -> bookDAO -> Get($row["idBook"])
                                            , $this -> petDAO -> Get($row["idPet"]));
            }
        return $bp;
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


//? ======================================================================
// !                        DELETE METHODS
//? ======================================================================       
        public function Delete($idBP){
            $query = "CALL BP_Delete(?)";
            $parameters["idBP"] = $idBP;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }


//? ======================================================================
//!                            ESPECIAL METHODS
//? ======================================================================        
/*
* D: Realiza la llamada del método 'GetAllByUsername' 
*        perteneciente a BookingDAO.
* A: Username del Owner.
* R: El listado de Bookings del username proporcionado.
🐘*/ 
        public function GetAllBooksByUsername($username){
            $bookList = $this -> bookDAO -> GetAllByUsername($username);
        return $bookList;
        }

/*
* D: Realiza la llamada del método 'GetAllBooksByKeeper' 
*        perteneciente a BookingDAO.
* A: Username del Keeper.
* R: El listado de Bookings del username proporcionado.
🐘*/ 
        public function GetAllBooksByKeeper($username){
            $matches = $this -> bookDAO -> GetAllByKeeper($username);
        return $matches;    
        }

/*
* D: Método de uso conjunto donde primero recupera todos los
*        Booking según su username, para posteriormente aprovechar
*        el ID de cada una para recuperar las Pets asociadas.
* A: Username del Owner.
* R: Listado de Pets según los Bookings filtrados por Username.
! A REVISION
🐘*/    
        public function GetAllPetsBooks($username){
            $bookList = $this -> GetAllBooksByUsername($username);
            $psBsList = array();

            foreach($bookList as $booking){
                    $bpetList = array();
                    $bpetList = $this -> GetPetsByBook($booking -> getId());
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
! A REVISION
🐘*/    
        public function GetAllPetsByBooks($username){
            $bookList = $this -> GetAllBooksByKeeper($username);
            $psBsList = array();

        foreach($bookList as $booking){
                $bpetList = array();
                $bpetList = $this -> GetPetsByBook($booking -> getId());
            $psBsList = array_merge($psBsList, $bpetList);
        }
        return $psBsList;    
        }


//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬  MÉTODOS QUE CALCULAN EL TOTAL DE LOS DÍAS DE ESTANCIA Y LA CANTIDAD DE MASCOTA
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
        private function TotalPetPay(Booking $book){
            $petPay = 0;

            $query = "CALL BP_GetPetPay(?,?)";
            $parameters["remuneration"] = $book -> getPublication() -> getRemuneration();
            $parameters["idBook"] = $book -> getId();
            $this -> connection = Connection::GetInstance();
            $resultBD = $this -> connection -> Execute($query,$parameters,QueryType::StoredProcedure);

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
            $book = $this -> bookDAO -> Get($book -> getId());

            $subtotalBook = $this -> bookDAO -> GetBookPay($book);

            $subtotalPet = $this -> TotalPetPay($book);
            
            $total = ($subtotalBook + $subtotalPet);
            if ($this -> aplicarDescuentoFechasEspeciales()){
                $total = $total - ($total * 0.25);
            }

            $checkerAmount = $total / 2;

        return $checkerAmount;
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
        // public function GetAllPetsbyBooking($idList) {
        //     $petList = array();
    
        //     foreach($idList as $obj){
        //         $pet = new Pet();
        //         $pet = $this->petDAO->Get($obj);
        //         array_push($petList, $pet);
        //     }
        //     return $petList;
        // }

        // public function GetAllPetsbyBooking($petsIDList) {
        //     $petlist = array();
        //     $petlist = $this -> petDAO -> GetAllByIds($petsIDList);
        // return $petlist;    
        // }

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
            $petList = $this -> petDAO -> GetAllByIds($idList);
            $rta = 0;
            $type = "";

            foreach($petList as $pet){

                if(empty($type)){
                    $type = $pet->getType()->getName();
                }

                if(strcmp($pet -> getType() -> getName(),  $type) != 0){
                    $rta = 0;
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
            $matches = $this -> bookDAO -> GetAllMatchingDatesByPublic($booking); 
            //$petList = $this->GetAllPetsbyBooking($idList);
            $petList = $this -> petDAO -> GetAllByIds($idList);

            $pet = $petList[0];
            $rta = 1;

            if(!empty($matches)){
                foreach($matches as $book){
                    $bookN = $this -> GetByBook($book -> getId());
                    $TypeBP = $bookN -> getPet() -> getType() -> getName();
                    if (strcmp($TypeBP, $pet -> getType() -> getName()) != 0){
                        $rta = 0;
                        return $rta;
                    }
                }
            }
        return $rta;
        }


//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                 MÉTODO PARA CREAR UNA RESERVA CON MASCOTAS
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××  
/*
* D: Método encargado de la ejecución de validaciones y métodos necesarios
*    para la creación de una nueva reserva.

?      💠 ValidateTypes
¬          ► Verifica que las mascotas entrantes son del mismo tipo.
?      💠 ValidateTypesOnBookings
¬          ► Verifica que las mascotas entrantes son compatible con cualquier 
¬            otro booking en la misma fecha con la que haga intersección.
?      💠 AddRet
¬          ► Registra el Booking y lo retorna completo de la BDD.
?      💠 Add
¬          ► Registra un OBJ de tipo BookingPet, asociando la Booking creada
¬            previamente con la mascota del Owner.

!      ❌ RegisterBookingException
¬          ► Excepción que contempla varios errores que puedan surgir a lo
¬            de toda la ejecución del Registro del Booking.

* A: $booking: BOOKING a registrar y relacionar con los petsID.
*    $petsID: IDs de las PETS del OWNER que participan en la BOOKING.

* R: No Posee.
🐘 */
//         public function NewBooking(Booking $booking,$petList){
// //? 1) GUARDO Y RECUPERO BOOKING COMPLETO CON ID
//             $message = "Successful: Se ha completado la reserva exitosamente";
//                 try{
//                     $booking = $this->bookDAO->AddRet($booking);
//                 }catch(exception $e){
//                     $message = "Error: No se ha podido completar la reserva, intente nuevamente";
//                 }
// //? 2) GUARDO EN BUCLE BP USANDO EL BOOKING GUARDADO Y RECUPERADO
//                 try{
//                     foreach($petList as $pet){
//                         $bp = new BookingPet();
//                         $bp->setBooking($booking);
//                         $bp->getPet()->setId($pet);
//                         $pet = $this->petDAO->Get($bp->getPet()->getId());
//                         $bp->setPet($pet);
//                         $this->Add($bp);
//                     }
//                 }
//                 catch(exception $e){
//                     $message="Error: ha ocurrido un fallo en el guardado de pets, intente nuevamente";
//                 }
//             return $message;
//             }

public function NewBooking(Booking $booking,$petsID){
    if($this -> ValidateTypes($petsID) == 1){
        
        if($this -> ValidateTypesOnBookings($booking, $petsID) == 1){

            try{

                $booking = $this->bookDAO->AddRet($booking);
            
            }catch(PDOException $e){
                new RegisterBookingException("Error: No se ha podido completar la reserva, intente nuevamente");
            }

            try{
                foreach($petsID as $pet){
                    $bp = new BookingPet();
                    $bp -> setBooking($booking);
                    $bp -> getPet() -> setId($pet);
                    $pet = $this -> petDAO -> Get($bp -> getPet() -> getId());
                    $bp -> setPet($pet);
                    $this -> Add($bp);
                }
            }catch(PDOException $e){
                throw new RegisterBookingException("Error: ha ocurrido un fallo en el guardado de pets, intente nuevamente");
            }

        }else{
            throw new RegisterBookingException("Error: Sus mascotas son incompatibles con las que cuidara el keeper en ese momento");
        }

    }else{
        throw new RegisterBookingException("Error: Todas sus mascotas deben ser del mismo tipo");
    }
}

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬             MÉTODOS A CARGO DE LA ACTUALIZACIÓN DE ESTADOS
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        public function NewState(Booking $book,$stateNum){
            $this -> bookDAO -> UpdateStSwtich($book,$stateNum);
        }

// public function CancelBook(Booking $booking){
//     $message = "";
//     try{

//         $this -> NewState($booking,3);
//         //$this->bookDAO->UpdateStSwtich($booking,3);
//         $message = "Successful: Reserva cancelada satisfactoriamente";

//     }catch(Exception $e){

//         $message = "Error: No se pudo cancelar la reserva, reintente mas tarde.";
//     }
//     return $message;
// }

        public function CancelBook(Booking $booking){
            try{

                $this -> NewState($booking,3);

            }catch(PDOException $e){
                throw new CancelBookingException("Error: No se pudo cancelar la reserva, reintente mas tarde.");
            }
        }

/*
* D: Método que se sostiene de UpdateAllStates de
*     BookingDAO para mantener los estados de las 
*     Booking actualizados y en orden.
* A: No posee
* R: No posee.
🐘*/           
        public function UpdateAllStates(){
            $this -> bookDAO -> UpdateAllStates();
        }


//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬           MÉTODOS PARA EL PROCESO DE LA RESPUESTA DEL KEEPER
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
        private function OverlappingDates(Booking $bookingA, Booking $bookingB){
            $rta = false;
            if($bookingA -> getStartD() <= $bookingB -> getFinishD() && $bookingB -> getStartD() <= $bookingA -> getFinishD()){
                $rta = true;
            }
        return $rta;    
        }


        private function RejectOtherBookingRequest(Booking $booking){
            $petType = $this -> GetByBook($booking -> getId()) -> getPet() -> getType() -> getName();
            $bookList = $this -> bookDAO -> GetAllByPublication($booking -> getPublication() -> getId());

            foreach($bookList AS $bookF){

                if((STRCMP($bookF -> getBookState(),"In Review") == 0) && $this -> OverlappingDates($booking, $bookF) == true){

                    $petTypeF = $this -> GetByBook($bookF -> getId()) -> getPet() -> getType() -> getName();
                    if(STRCMP($petType, $petTypeF) != 0){
                        $this -> NewState($bookF, 0);
                    }
                }
            }
        }


        public function ProcessBookingRequest(Booking $booking, $rta){
            $bookingPetList = $this -> GetPetsByBook($booking -> getId());
            $petsIDList = array_map(function ($bookingPet){return $bookingPet -> getPet() -> getId();},$bookingPetList);

            $bookingGet = $this -> bookDAO -> Get($booking -> getId());

            if($rta == 1){
                if($this -> ValidateTypesOnBookings($bookingGet, $petsIDList) == 1){
                    //¬ SE OBTIENE EL 50% DEL MONTO TOTAL A PAGAR
                    //¬ REVISAR SI TRAIGO LISTA O UNO SOLO
                    $totally = $this -> GetTotally($bookingGet);

                    $this -> checkDAO -> NewChecker($bookingGet,$totally);

                    $this -> NewState($bookingGet, $rta);

                    $this -> RejectOtherBookingRequest($bookingGet);
            
                }else{
                    $this -> NewState($bookingGet,0);
                    throw new RegisterBookingException("Error: Sus mascotas son incompatibles con las que cuidara el keeper en ese momento");
                }
            }else{
                $this -> NewState($bookingGet, $rta);
            }
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
!       Requerida por UpdatePayCode como condición para actualizar el
!       estado del Booking y asentar el paycode en la BDD.
* A: Booking del cual obtenemos el paycode.
* R: 1 si la comprobación es valida, 0 al ser falso.
🐘*/  
        public function CheckPayCode(Booking $book){
            $rta = 0;
            $bookA = $this -> bookDAO -> Get($book -> getId());

            if((STRCMP($bookA -> getBookState(),"Awaiting Payment") == 0)){
                foreach($this -> GenPayCodes() as $code){
                    if($book -> getPayCode() == $code){
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
!    para la actualización del checker.
* A: Booking del cual obtenemos el paycode.
* R: Mensaje afirmativo o negativo respecto a si el pago pudo ser comprobado.
🐘*/    
// public function UpdatePayCode(Booking $book){
//     $message = "Error: El numero de pago ingresado no es valido";
//     $rta = $this->CheckPayCode($book);
//     if($rta ==1){
//         try{
//             $this->bookDAO->UpdateCode($book);
//             //$this->bookDAO->UpdateStSwtich($book,2);
//             $this->NewState($book,2);
//             $message = "Successful: Su comprobante ha sido aceptado";
//         }catch(Exception $e){
//             $message = "Error: No se pudo actualizar el estado de su reserva, reintente mas tarde";
//             return $message;
//         }
//     }
//     return $message;
// }

        public function UpdatePayCode(Booking $book){
            if($this -> CheckPayCode($book) == 1){
                try{
                    
                    $this -> bookDAO -> UpdateCode($book);
                    $this -> NewState($book, 2);

                }catch(PDOException $pdoe){
                    throw new UpdateBookingException("Error: No se pudo actualizar el estado de su reserva, " . $pdoe -> getMessage());
                }
            }else{
                throw new UpdateBookingException("Error: El numero de pago ingresado no es valido");
            }
        }

        public function PayBooking(Booking $booking){
            $this -> UpdatePayCode($booking);

            $checker = new Checker();
            $checker -> setBooking($booking);
            $checker -> setPayD(DATE("Y-m-d"));

            try{
                $this -> checkDAO -> SetPayDChecker($checker);
            }catch (PDOException $pdoe) {
                throw new UpdateCheckerException("El checker no ha sido actualizado," . $pdoe -> getMessage());
            }
        }

        public function PayBookingCC(Booking $booking, $cc){
            $checker = new Checker();
            $checker -> setBooking($booking);
            $checker -> setPayD(DATE("Y-m-d"));

            if($this -> validateCC($cc)){
                try{
                    $this -> checkDAO -> SetPayDChecker($checker);
                    $this -> UpdatePayCode($booking);
                }catch (PDOException $pdoe) {
                    throw new UpdateCheckerException("El checker no ha sido actualizado," . $pdoe -> getMessage());
                }
            }else{
                throw new UpdateCheckerException("Pago Rechazado, reintente");
            }
        }

        private function validateCC($creditCard){
            $response = false;
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://random-fake-credit-card-details-and-validator.p.rapidapi.com/?ccvalidate=". $creditCard['carNum'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: random-fake-credit-card-details-and-validator.p.rapidapi.com",
                    "x-rapidapi-key: 3461aac04fmsh4c595f383655f5fp170ef8jsnb5b197c8a5f0"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
        return $response;
        }

        public function GetKeeperStats($username){
            return $this -> bookDAO -> GetKeeperStats($username);
        }

        public function CheckBookDone($username, $idPublic){
            return $this -> bookDAO -> CheckBookDone($username, $idPublic);
        }

        public function OnlineBookingsByPublication($idPublic){
            return $this -> bookDAO -> OnlineBookingsByPublication($idPublic);
        }

        public function GetVarietyPetStats($username){
            $bookList = $this -> GetAllBooksByKeeper($username);
            $markedTypes = array();

            foreach($bookList as $book){
                if(strcmp($book -> getBookState(), "Finalized") == 0){
                    $type = $this -> GetByBook($book -> getId()) -> getPet() -> getType() -> getName();

                    if(! in_array($type,$markedTypes)){
                        array_push($markedTypes,$type);
                    }
                }
            }

            $varietyPts = count($markedTypes) * 10;

            // Asignamos un alias según el puntaje
            $alias = match(true) {
                $varietyPts === 10 => "Zoonogamo", // Ajusta según tu lógica
                $varietyPts === 20 => "Dúo zoonamico",
                $varietyPts >= 30 && $varietyPts <= 50 => "Arca de Noé",
                $varietyPts > 50 => "Zookeeper aficionado",
                default => "Invernando",
            };
        
        return $alias;
        }

        public function GetBestPetStats($username){
            $bookList = $this -> GetAllBooksByKeeper($username);
            $petCounts = [];

            foreach($bookList as $book){
                if($book -> getBookState() === "Finalized"){
                    $type = $this -> GetByBook($book -> getId()) -> getPet() -> getType() -> getName();

                    if (!isset($petCounts[$type])) {
                        $petCounts[$type] = 1;
                    } else {
                        $petCounts[$type]++;
                    }
                }
            }

            // Encontrar el tipo de mascota con el mayor conteo
            arsort($petCounts);
        return key($petCounts);
        }
        
        public function aplicarDescuentoFechasEspeciales(){
            // Fechas especiales (ajusta meses y días según sea necesario)
            $anioActual = date('Y');
            $fechasEspeciales = [
                'Navidad' => [$anioActual . '-12-24', $anioActual . '-12-25', $anioActual . '-12-26'],
                'AñoNuevo' => [$anioActual . '-12-29', ($anioActual + 1) . '-12-30', ($anioActual + 1) . '-12-31'],
                'Reyes' => [$anioActual . '-01-04', ($anioActual + 1) . '-01-05', ($anioActual + 1) . '-01-06'], // Ajustado al 6 de enero
                'BlackFriday' => [$anioActual . '-11-22', ($anioActual + 1) . '-11-23', ($anioActual + 1) . '-11-24']
            ];

            // Obtener el día actual
            $diaActual = date('Y-m-d');

            foreach ($fechasEspeciales as $evento => $fechas) {
                if (in_array($diaActual, $fechas)) {
                    return true; // Se aplica el descuento
                }
            }

        return false; // No se aplica el descuento
        }
    }
?>