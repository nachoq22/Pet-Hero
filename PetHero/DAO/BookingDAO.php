<?php
namespace DAO;
use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;
use \Exception as Exception;

use \DAO\IBookingDAO as IBookingDAO;
use \DAO\PublicationDAO as PublicationDAO;
use \DAO\UserDAO as UserDAO;
use \Model\Booking as Booking;

    class BookingDAO implements IBookingDAO{
        private $connection;
        private $tableName = 'Booking';

        private $publicDAO;
        private $userDAO;
        
//======================================================================
// DAOs INJECTION.
//======================================================================
        public function __construct(){
            $this->publicDAO = new PublicationDAO();
            $this->userDAO = new UserDAO();
        }

//======================================================================
// SELECT METHODS.
//======================================================================
        public function GetAll(){
            $bookList = array();    

            $query = "CALL Booking_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();
                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                           ,$row["finishD"],$row["bookState"]
                                           ,$this->publicDAO->Get($row["idPublic"])
                                           ,$this->userDAO->DGet($row["idUser"]));
                array_push($bookList,$booking);
            }
        return $bookList;
        }

#TODAS LAS BOOKINGS DE UN USUARIO.
        public function GetAllByUser($idUser){
            $bookList = array();

            $query = "CALL Booking_GetByUser(?);";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                           ,$row["finishD"],$row["bookState"]
                                           ,$this->publicDAO->Get($row["idPublic"])
                                           ,$this->userDAO->DGet($row["idUser"]));
                array_push($bookList,$booking);
            }
        return $bookList;
        }

#TODAS LAS BOOKINGS DE UN OWNER SEGUN USERNAME.
        public function GetAllBooksByUsername($username){
            $user = $this->userDAO->DGetByUsername($username);
            $bookList = $this->GetAllByUser($user->getId());
        return $bookList;
        }

#TODAS LAS BOOKINGS DE UN KEEPER SEGUN USERNAME.
        public function GetAllBooksByKeeper($username){
            $matches = array();
                $bookings = $this->GetAll();
            foreach($bookings as $book){
                if($book->getPublication()->getUser()->getUsername() == $username){
                    array_push($matches,$book);
                }
            }
        return $matches;
        }

        public function Get($idBook){
            $booking = null;

            $query = "CALL Booking_GetById(?)";
            $parameters["idBook"] = $idBook;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                ,$row["finishD"],$row["bookState"]
                                ,$this->publicDAO->Get($row["idPublic"])
                                ,$this->userDAO->DGet($row["idUser"]));
                }
            return $booking;
        }

#UNA BOOKING SEGUN USUARIO.
        public function GetByUser($idUser){
            $booking = NULL;

            $query = "CALL Booking_GetByUser(?);";
            $parameters["idUser"] = $idUser;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                ,$row["finishD"],$row["bookState"]
                                ,$this->publicDAO->Get($row["idPublic"])
                                ,$this->userDAO->DGet($row["idUser"]));
            }
            return $booking;
        }

//-----------------------------------------------------
// METHODS THAT OBTAIN TOTAL FROM THE DAYS.
//----------------------------------------------------- 
        private function GetBookPay(Booking $book){
            $bookPay = 0;

            $query = "CALL Booking_GetBookigPay(?,?,?)";
            $parameters["starD"] = $book->getStartD();
            $parameters["finishD"] = $book->getFinishD();
            $parameters["remuneration"] = $book->getPublication()->getRemuneration();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $bookPay = $row["bookingPay"];
            }
        return $bookPay;
        }

#OBTENGO EL TOTAL POR DIAS DE HOSPEDAJE. 
        public function GetFPBook(Booking $book){
            $bookPay = $this->GetBookPay($book);
        return $bookPay;    
        }
//-----------------------------------------------------
//----------------------------------------------------- 
        
//======================================================================
// INSERT METHODS.
//======================================================================
        private function Add(Booking $booking){
            $idLastP = 0;

            $query = "CALL Booking_Add(?,?,?,?,?)";
            $parameters["startD"] = $booking->getStartD();
            $parameters["finishD"] = $booking->getFinishD();
            $parameters["bookState"] = $booking->getBookState();
            $parameters["idPublic"] = $booking->getPublication()->getid();
            $parameters["idUser"] = $booking->getUser()->getId();  
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
    
            foreach($resultBD as $row){
                $idLastP = $row["LastID"];
            }
        return $idLastP; 
        }
#PARTE IMPORTANTE PARA EL FUNCIONAMIENTO DEL REGISTRO DE UN BOOKING.
        public function AddRet(Booking $booking){
                $public = $this->publicDAO->Get($booking->getPublication()->getId());
                $user = $this->userDAO->DGetByUsername($booking->getUser()->getUsername());
                $booking->setPublication($public);
                $booking->setuser($user);
            $idNBook = $this->Add($booking);
            $booking = $this->Get($idNBook);
        return $booking;    
        }      

//======================================================================
// UPDATE METHODS.
//======================================================================
#ACTUALIZA ESTADO DE BOOKING.
        public function UpdateST(Booking $booking){
            $query = "CALL Booking_UpdateST(?,?)";
            $parameters["idBook"] = $booking->getId();
            $parameters["bookState"] = $booking->getBookState();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

#ACTUALIZA PAYCODE DE BOOKING.
        public function UpdateCode(Booking $booking){
            $query = "CALL Booking_UpdateCode(?,?)";
            $parameters["idBook"] = $booking->getId();
            $parameters["payCode"] = $booking->getPayCode();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
   
#SWTICH PARA ACTUALIZAR ESTADOS SEGUN UN CODIGO, REUTILIZANDO DE CODIGO.
        public function UpdateStSwtich(Booking $book,$stateNum){
            switch($stateNum){
                case 0:
                    $book->setBookState("Declined");
                    $this->UpdateST($book);
                    break;
                case 1:
                        $book->setBookState("Awaiting Payment");
                    $this->UpdateST($book);
                    break;
                case 2:
                        $book->setBookState("Waiting Start");
                    $this->UpdateST($book);
                    break;
                case 3:
                        $book->setBookState("Canceled");
                    $this->UpdateST($book);
                    break;
                case 4:
                        $book->setBookState("In Progress");
                    $this->UpdateST($book);
                    break;
                case 5:
                        $book->setBookState("Expired");
                    $this->UpdateST($book);
                    break;
                case 6:
                        $book->setBookState("Out of Term");
                    $this->UpdateST($book);
                    break;
                case 7:
                        $book->setBookState("Finalized");
                    $this->UpdateST($book);
                    break;
            }
        }

//----------------------------------------------------------------------------------
// METHODS THAT WILL BE IMPLEMENTED IN EACH OWNER AND KEEPER PANEL FOR THE UPDATING 
// OF AUTOMATIC STATES ACCORDING TO PARTICULAR SITUATIONS.
//----------------------------------------------------------------------------------
#CHEQUEA LAS CONDICIONES ESPECIFICADAS ABAJO.
        public function UpdateAllStates(){
            $bookisList = $this->GetAll();
            if(!EMPTY($bookisList)){
                $this->UpdateToExpired($bookisList);
                $this->UpdateToInP($bookisList);
                $this->UpdateToFinalized($bookisList);
            }
        }

#CHEQUEA SI UN KEEPER NO RESPONDIO A UNA RESERVA EN UN MAXIMO DE 3 DIAS ANTES DE COMENZAR EL BOOKING, 
#PROCEDE A CAMBIAR ESTADO A EXPIRED,MURIENDO EL BOOKING.
        private function UpdateToExpired($bookList){
            foreach($bookList as $book){
                if(STRCMP($book->getBookState(),"In Review") == 0){
                    $cutD = DATE("Y-m-d",STRTOTIME($book->getStartD()."- 3 days"));
                    if($cutD == DATE("Y-m-d")){
                        $this->UpdateStSwtich($book,5);
                    }
                }   
            }
        }

#CHEQUEA SI UN BOOKING COINCIDE SU FECHA DE INICIO CON LA ACTUAL,PROCEDE A CAMBIAR ESTADO A IN PROGRESS.
        private function UpdateToInP($bookList){
            foreach($bookList as $book){
                if(STRCMP($book->getBookState(),"Waiting Start") == 0){
                    if($book->getStartD() == DATE("Y-m-d")){
                        $this->UpdateStSwtich($book,4);
                    }
                }   
            }
        }

#CHEQUEA SI UN BOOKING COINCIDE SU FECHA DE FIN CON LA ACTUAL,PROCEDE A CAMBIAR ESTADO A FINALIZED, MURIENDO EL BOOKING.   
        private function UpdateToFinalized($bookList){
            foreach($bookList as $book){
                if(STRCMP($book->getBookState(),"In Progress") == 0){
                    $cutD = DATE("Y-m-d",STRTOTIME($book->getFinishD()."+ 1 days"));
                    if($cutD == DATE("Y-m-d")){
                        $this->UpdateStSwtich($book,7);
                    }
                }  
            }
        }

//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
        
//======================================================================
// DELETE METHODS
//====================================================================== 
    public function Delete($idBooking){
        $query = "CALL booking_Delete(?)";
        $parameters["idbooking"] = $idBooking;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
    }

/*funcion para retornar diff de dias
        public function countDays($initD,$finishD){
            $days = 0;
            For($i=$initD;$i<$finishD;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
                $days +=1;
            }
        return $days;    
        }
*/

        //ESTO SIRVE PARA ENCONTRAR TODOS LOS BOOKING EN LOS QUE COINCIDA LAS FECHAS CON LA NUESTRA (FUNCION LLAMADA DESDE BOOKINGPETDAO)
        public function GetAllMatchingDatesByPublic(Booking $booking){
            $bookingList = array();    
            $query = "CALL Booking_CheckRange(?,?,?)";
            $parameters["starD"] = $booking->getStartD();
            $parameters["finishD"] = $booking->getFinishD();
            $parameters["idPublic"] = $booking->getPublication()->getid();
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);
            foreach($resultBD as $row){
                $booking = new Booking();
                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                  ,$row["finishD"],$row["bookState"]
                                  ,$this->publicDAO->Get($row["idPublic"])
                                  ,$this->userDAO->Get($row["idUser"]));
                array_push($bookingList,$booking);
            }
            return $bookingList;
        }
        ////////
        
        //ESTO COMPROBARA SI EL USUARIO HA COMPLETADO UN BOOKING CON LA PUBLICACION
        public function CheckBookDone($idUser, $idPublic){
            $canReview = 0;
            $bookingList = $this->GetAllByUser($idUser);
            foreach($bookingList as $book){
                if($book->getPublication()->getId()==$idPublic){
                    if(strcmp($book->getBookState(),"Finalized")==0){
                        $canReview = 1;
                        return $canReview;
                    }
                }
            
            }
            return $canReview;
        }
    }
        //////////////////////////

?>