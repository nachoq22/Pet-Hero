<?php
namespace Controllers;
use \DAO\ImgPublicDAO as ImgPublicDAO;
use \DAO\ReviewDAO as ReviewDAO;
use \DAO\BookingDAO as BookingDAO;
use \Model\ImgPublic as ImgPublic;
use \Model\Publication as Publication;
use \Model\User as User;
use \Model\Review as Review;
use \Controllers\HomeController as HomeController;
use \Controllers\PetController as PetController;

    class PublicationController{
        private $publicDAO;
        private $reviewDAO;
        private $homeController;
        private $petController;
        private $bookingDAO;

        public function __construct(){
            $this->publicDAO = new ImgPublicDAO();
            $this->reviewDAO = new ReviewDAO();
            $this->homeController = new HomeController();
            $this->petController = new PetController();
            $this->bookingDAO = new BookingDAO();
        }

        //FUNCION PARA CREAR UNA NUEVA PUBLICACION//
        public function Add($title,$description,$openD,$closeD,$remuneration,$images){
            $this->homeController->isLogged();
            $this->homeController->isKeeper();

                $public = new Publication();
                $logUser = $_SESSION["logUser"];

                if(($this->publicDAO->ValidateDAllPublications($openD, $closeD, $logUser))==0 &&     //VALIDA QUE LAS FECHAS NO COINCIDAN CON LAS DE OTRAS PUBLICACIONES SUYAS//
                ($closeD>DATE("Y-m-d") && $openD>DATE("Y-m-d") && $closeD>$openD)){                  //VALIDA QUE LAS FECHAS SEAN DESPUES DE LA FECHA ACTUAL Y VAIDA QUE LA FECHA   
                $public->__fromRequest($openD, $closeD, $title, $description,0, $remuneration,$logUser);  //DE FINALIZACION SEA DESPUES QUE LA DE INICIO//
                $imgPublic = new ImgPublic();
                $imgPublic->setPublication($public);

            $message = $this->publicDAO->NewPublication($imgPublic,$images);
            $this->homeController->ViewKeeperPanel($message);
        }else{
            $this->homeController->ViewAddPublication("Error: Las fechas ingresadas coinciden con otra publicacion suya o son invalidas");
        }
        }

        //FUNCION PARA VER UNA PUBLICACION INDIVIDUAL//
        public function ViewPublication($idPublic, $message=""){     
                $public = new Publication();
                $public->setId($idPublic);
                $imgPublic = new ImgPublic();
                $imgPublic->setPublication($public);
            $public = $this->publicDAO->GetPublication($imgPublic);
            $reviewList = $this->reviewDAO->GetAllByPublic($public->getid()); 
            $canReview = 0;
                if(isset($_SESSION["logUser"])){
                $logUser = $_SESSION["logUser"];
                $canReview = $this->bookingDAO->CheckBookDone($logUser->getUsername(), $idPublic);
                }
            
            $ImgList = $this->publicDAO->GetAllByPublic($public->getid());
            require_once(VIEWS_PATH."PublicInd.php");
        }

        //FUNCION PARA VALIDAR DIFERENTES REQUISITOS DE FECHAS//
        public function ValidateDateFP($idPublic, $startD, $finishD){
            $this->homeController->isLogged();
                if($startD<$finishD){                                                             //QUE LA FECHA DE INICIO SEA ANTES QUE LA DE FINALIZACION      
                    if($this->publicDAO->ValidateOnWeek($startD)==1){                                    //QUE LA FECHA DE INICIO TENGA UNA SEMANA DE ANTICIPACION
                        if($this->publicDAO->ValidateDP($startD, $finishD, $idPublic) == 1){                       //QUE LAS FECHAS COINCIDAN CON LAS ESTABLECIDAS POR EL KEEPER
                            $this->petController->GetPetsByReservation($idPublic, $startD, $finishD);
                        }else{
                            $this->ViewPublication($idPublic, "Error: Las fechas ingresadas no entran en el rango de establecidas por el Keeper");
                        }
                    }else{
                        $this->ViewPublication($idPublic, "Error: Las reservas deben tener 1 semana de aniticipacion");
                    }
                }else{
                    $this->ViewPublication($idPublic, "Error: La fecha de finalizacion debe ser despues de la de inicio");}
            }
    }
?>