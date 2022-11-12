<?php
namespace DAO;

use \DAO\Connection as Connection;
use \DAO\QueryType as QueryType;

use \DAO\IBookingDAO as IBookingDAO;
use \DAO\PublicationDAO as PublicationDAO;
use \DAO\UserDAO as UserDAO;
use \Model\Booking as Booking;

    class BookingDAO implements IBookingDAO{
        private $connection;
        private $tableName = 'Booking';

        private $publicDAO;
        private $userDAO;
        
//DAO INJECTION
        public function __construct(){
            $this->publicDAO = new PublicationDAO();
            $this->userDAO = new UserDAO();
        }

//CON TODO ESTO SE REGISTRA UN BOOKING
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

            public function AddRet(Booking $booking){
                $public = $this->publicDAO->Get($booking->getPublication()->getId());
                $user = $this->userDAO->DGetByUsername($booking->getUser()->getUsername());
                $booking->setPublication($public);
                $booking->setuser($user);
                try{
                $idNBook = $this->Add($booking);
                $booking = $this->Get($idNBook);
                }
                catch(exception $e){
                return $message="Error: no se ha podido guardar el booking";
                }
                return $booking;
            }     

        public function UpdateST(Booking $booking){
            $query = "CALL Booking_UpdateST(?,?)";
            $parameters["idBook"] = $booking->getStartD();
            $parameters["bookState"] = $booking->getBookState();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function UpdateStSwtich(Booking $book,$stateNum){
            switch($stateNum){
                case 1:
                        $book->setBookState("Awaiting Payment");
                    $this->UpdateST($book);
                    break;
                case 2:
                        $book->setBookState("In Process");
                    $this->UpdateST($book);
                    break;
                case 3:
                        $book->setBookState("Finalized");
                    $this->UpdateST($book);
                    break;
                case 4:
                        $book->setBookState("Rechazed");
                    $this->UpdateST($book);
                    break;
            }
        }

        public function GetAll(){
            $bookingList = array();    

            $query = "CALL Booking_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);

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
                                  ,$this->userDAO->Get($row["idUser"]));

                array_push($bookList,$booking);
            }
            return $bookList;
        }

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
                                  ,$this->userDAO->Get($row["idUser"]));
            }
            return $booking;
        }

        public function GetByUsername($username){
            $user = $this->userDAO->DGetByUsername($username);
            $bookList = $this->GetAllByUser($user->getId());
        return $bookList;
        }

        public function Get($id){
            $booking = null;
            $query = "CALL Booking_GetById(?)";
            $parameters["idBooking"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $booking = new Booking();

                $booking->__fromDBWithoutPC($row["idBook"],$row["startD"]
                                  ,$row["finishD"],$row["bookState"]
                                  ,$this->publicDAO->Get($row["idPublic"])
                                  ,$this->userDAO->Get($row["idUser"]));
                }
            return $booking;
        }

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

        public function GetFPBook(Booking $book){
            $bookPay = $this->GetBookPay($book);
        return $bookPay;    
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

        public function Delete($idBooking){
            $query = "CALL booking_Delete(?)";
            $parameters["idbooking"] = $idBooking;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }

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
        //////////////////////////


}
?>