<?php
namespace Controllers;

use \DAO\ReviewDAO as ReviewDAO;
use \Model\Review as Review;
use \Model\Publication as Publication;
use \Model\User as User;
use \Controllers\PublicationController as PublicationController;

    class ReviewController{
        private $reviewDAO;
        private $publicationController;

        public function __construct(){
            $this->reviewDAO = new ReviewDAO();
            $this->publicationController = new PublicationController();
        }

//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
//¬                             AGREGAR REVIEW
//* ××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
/*
* D: Controller que procesa la entrada de datos necesarios para el registro
*    de una nueva reseña. 

?      💠 NewReview
¬          ► Registra una nueva REVIEW, obteniendo un mensaje de la op.
?      💠 ViewPublication
¬          ► Redireccionamos a PublicInd, remitiendo un mensaje a mostrar.

* A: $idPublic: id de la PUBLICATION.
*    $stars: puntuacion por el servicio.
*    $commentary: comentarios sobre el servicio recibido.

* R: No Posee.
🐘 */ 
        public function Add($idPublic,$stars,$commentary){
            $public = new Publication();
                $public->setId($idPublic);
            $user = new User();
                $user->setUsername("venus");
            $review = new Review();
                $review->__fromRequest(DATE("Y-m-d"),$commentary,$stars,$public,$user);
            $message= $this->reviewDAO->NewReview($review);
            $this->publicationController->ViewPublication($idPublic, $message);
        }
    }
?>