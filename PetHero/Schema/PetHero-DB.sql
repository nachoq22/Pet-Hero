/*
drop database if exists petHero;
drop table if exists Location;
drop table if exists Keeper;
drop table if exists Owner;
drop table if exists Size;
drop table if exists Dog;
*/
DROP DATABASE IF EXISTS petHero;
/*********************************DATABASE*******************************************/

CREATE DATABASE IF NOT EXISTS petHero;
USE petHero;

/*********************************LOCATION*******************************************/
CREATE TABLE IF NOT EXISTS Location(
	idLocation INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    adress VARCHAR(50) NOT NULL,
    neighborhood VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL,
    province VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL
);

INSERT INTO Location VALUES (0,"Rondeau 616","Piedras del sol","Cordoba","Cordoba","Argentina");
INSERT INTO Location VALUES (0,"Av. 3 de Abril 827","Mariano","Corrientes","Corrientes","Argentina");
INSERT INTO Location VALUES (0,"Av San Martín 1143","Arbolito","Ciudad de Mendoza","Mendoza","Argentina");
INSERT INTO Location VALUES (0,"Rondeau 616","Mitre","San Fernando","Buenos Aires","Argentina");
INSERT INTO Location VALUES (0,"San Martín 2365","Termas Saladas","Santa Fe","Santa Fe","Argentina");
INSERT INTO Location VALUES (0,"Pedro Morán 4441","Moron","Ciudad Autonoma de Buenos Aires","Buenos Aires","Argentina");
INSERT INTO Location VALUES (0,"Cerrito 20","Alba Azul","Rosario","Santa Fe","Argentina");
INSERT INTO Location VALUES (0,"12 De Octubre 3179","Puerto Feo","Mar del Plata","Buenos Aires","Argentina");
INSERT INTO Location VALUES (0,"Pio Xii 366","El Floral","Santa Rosa","La Pampa","Argentina");
INSERT INTO Location VALUES (0,"Pigue 1996","Pompeya","Mar del Plata","Buenos Aires","Argentina");

/*********************************PERSONAL DATA*******************************************/
CREATE TABLE IF NOT EXISTS PersonalData(
	idData INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    sex VARCHAR(1) NOT NULL,
    dni VARCHAR(8) UNIQUE NOT NULL CHECK(dni regexp '[0-9]{8}'),
		idLocation INT NOT NULL,
		CONSTRAINT fk_DataLocation FOREIGN KEY (idLocation)
			REFERENCES Location(idLocation)
);

INSERT INTO PersonalData VALUES (0,"Santino","Escobedo","M","28418700",1);
INSERT INTO PersonalData VALUES (0,"Maximiliano","Sanz","M","41844906",2);
INSERT INTO PersonalData VALUES (0,"Josefina","Herrera","F","67154484",3);
INSERT INTO PersonalData VALUES (0,"Ashley","Benitez","F","88403165",4);
INSERT INTO PersonalData VALUES (0,"Alan","Rojas","M","40737343",5);

/*********************************USER*******************************************/
CREATE TABLE IF NOT EXISTS User(
	idUser INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
		idData INT UNIQUE,
		CONSTRAINT fk_UserData FOREIGN KEY (idData)
			REFERENCES PersonalData(idData)
);
/*Keepers*/
INSERT INTO User VALUES (0,"planetar","orylOSad","achternaga@wificon.eu",1);
INSERT INTO User VALUES (0,"marsexpress","eIrCHips","djlucadj@lifestyleunrated.com",2);
INSERT INTO User VALUES (0,"venus","MuncENsu","medennikovadasha@boranora.com",3);
INSERT INTO User VALUES (0,"sculpordwarf","cIShAphe","saschre@hs-gilching.de",4);
INSERT INTO User VALUES (0,"toystory","nShaREDO","ovnoya@emvil.com",5);

/*Owners*/
INSERT INTO User (idUser,username,password,email) VALUES (0,"bluckiz","12345678","bluckiz@gmail.com");
INSERT INTO User (idUser,username,password,email) VALUES (0,"nacho","12345678","nacho@gmail.com");
INSERT INTO User (idUser,username,password,email) VALUES (0,"misa","12345678","misa@gmail.com");
INSERT INTO User (idUser,username,password,email) VALUES (0,"ignacio","12345678","ignacio@gmail.com");

/*********************************ROLE*******************************************/
CREATE TABLE IF NOT EXISTS Role(
	idRole INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) UNIQUE,
	description VARCHAR(300)
);

INSERT INTO Role VALUES (0,"Owner","The owner has permissions to add their corresponding pets, 
									as well as to edit their profile and delete their account. 
									To finish, there is the functionality of making a reservation 
									and loading the corresponding payment receipt.");
INSERT INTO Role VALUES (0,"Keeper","The keeper has permissions to add publications with which the owner 
									can interact. Along with this, the possibility of responding to 
									reservations, consulting them, etc.");

/*********************************USERROLE*******************************************/
CREATE TABLE IF NOT EXISTS UserRole(
	idUR INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
		idUser INT,
		idRole INT,
		CONSTRAINT fk_UserRole FOREIGN KEY (idUser)
			REFERENCES User(idUser),
		CONSTRAINT fk_Role FOREIGN KEY (idRole)
			REFERENCES Role(idRole)	
);
/*Keepers*/
INSERT INTO UserRole VALUES(0,1,1);
INSERT INTO UserRole VALUES(0,1,2);
INSERT INTO UserRole VALUES(0,2,1);
INSERT INTO UserRole VALUES(0,2,2);
INSERT INTO UserRole VALUES(0,3,1);
INSERT INTO UserRole VALUES(0,3,2);
INSERT INTO UserRole VALUES(0,4,1);
INSERT INTO UserRole VALUES(0,4,2);
INSERT INTO UserRole VALUES(0,5,1);
INSERT INTO UserRole VALUES(0,5,2);

/*Owners*/
INSERT INTO UserRole VALUES(0,6,1);
INSERT INTO UserRole VALUES(0,7,1);
INSERT INTO UserRole VALUES(0,8,1);
INSERT INTO UserRole VALUES(0,9,1);

/*********************************SIZE*******************************************/
CREATE TABLE IF NOT EXISTS Size(
	idSize INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL UNIQUE
);

INSERT INTO Size VALUES (0,"Little");
INSERT INTO Size VALUES (0,"Little-Medium");
INSERT INTO Size VALUES (0,"Medium");
INSERT INTO Size VALUES (0,"Medium-Big");
INSERT INTO Size VALUES (0,"Big");

/*********************************PET TYPE*******************************************/
CREATE TABLE IF NOT EXISTS PetType(
	idType INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO PetType VALUES (0,"Dog");
INSERT INTO PetType VALUES (0,"Cat");
INSERT INTO PetType VALUES (0,"Hedgehog");
INSERT INTO PetType VALUES (0,"Groundhog");
INSERT INTO PetType VALUES (0,"Meerkat");

/*********************************PET*******************************************/
CREATE TABLE IF NOT EXISTS Pet(
	idPet INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    breed VARCHAR(50) NOT NULL,
	profileIMG VARCHAR(250) NOT NULL UNIQUE,
	vaccinationPlanIMG VARCHAR(250) NOT NULL UNIQUE,
    observation VARCHAR(200) NOT NULL,
		idSize INT NOT NULL,
		idType INT NOT NULL,
		idUser INT NOT NULL,
		CONSTRAINT fk_PetSize FOREIGN KEY (idSize)
			REFERENCES Size(idSize),
		CONSTRAINT fk_PetType FOREIGN KEY (idType)
			REFERENCES PetType(idType),
		CONSTRAINT fk_PetUser FOREIGN KEY (idUser)
			REFERENCES User(idUser)
);

/* INSERTS PARA GENERAR DE LA MISMA FORMA EN QUE LO HACE PHP, SIN HARDCODEO
INSERT INTO Pet VALUES (0,"Coco","Mestizo",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Coco",(NOW() + 0),".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Coco",(NOW() + 0),".jpg")
						,"Esta re duro",1,1,1);
INSERT INTO Pet VALUES (0,"Thor","Lykoi",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Thor",(NOW() + 0),".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Thor",(NOW() + 0),".jpg")
						,"Rompe todo",2,2,2);
INSERT INTO Pet VALUES (0,"Faraon","Pigmeo africano",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Faraon",(NOW() + 0),".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Faraon",(NOW() + 0),".jpg")
						,"Come mucho",3,3,3);
INSERT INTO Pet VALUES (0,"Laila","Ariray",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Laila",(NOW() + 0),".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Laila",(NOW() + 0),".jpg")
						,"No tiene baño propio",4,4,4);
INSERT INTO Pet VALUES (0,"Willow","Suricatta",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Willow",(NOW() + 0),".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Willow",(NOW() + 0),".jpg")
						,"Se escapa constantemente",5,5,5);
*/
INSERT INTO Pet VALUES (0,"Coco","Mestizo",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Coco","202211151843",".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Coco","202211151843",".jpg")
						,"Esta re duro",1,1,1);
INSERT INTO Pet VALUES (0,"Thor","Lykoi",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Thor","202211151843",".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Thor","202211151843",".jpg")
						,"Rompe todo",2,2,2);
INSERT INTO Pet VALUES (0,"Faraon","Pigmeo africano",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Faraon","202211151843",".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Faraon","202211151843",".jpg")
						,"Come mucho",3,3,3);
INSERT INTO Pet VALUES (0,"Laila","Ariray",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Laila","202211151843",".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Laila","202211151843",".jpg")
						,"No tiene baño propio",4,4,6);
INSERT INTO Pet VALUES (0,"Willow","Suricatta",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Willow","202211151843",".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Willow","202211151843",".jpg")
						,"Se escapa constantemente",5,5,7);


/*SEGUNDA PARTE, ADMINISTRACION DE PUBLICACIONES, RESERVAS Y RESENIAS*/

/*********************************PUBLICATION*******************************************/
		/*AGREGA LOS CHECK PELOTUDO*/
CREATE TABLE IF NOT EXISTS Publication(
	idPublic INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	openD DATE NOT NULL,
	closeD DATE NOT NULL,
	title VARCHAR(50) NOT NULL,
	description VARCHAR(500) NOT NULL,
	popularity DEC(2,1) CHECK (popularity >= 0 AND popularity <=5),
	remuneration DEC(10,2) NOT NULL,
		idUser INT NOT NULL,
		CONSTRAINT fk_publicUser FOREIGN KEY(idUser)
			REFERENCES User(idUser)
);

INSERT INTO Publication VALUES (0,"2022-12-02","2022-12-30","De Gran comodidad"," ¡No permitas que tu mascota se quede atrás! 
								Las mejores actividades para el, ¡Unas vacaciones para los miembros peludos de la familia! 
								A tu mascota le encantará investigar un nuevo lugar, y tú te sentirás mejor sabiendo que 
								esta haciendo algo nuevo y seguro.",0.0,3500,1);
INSERT INTO Publication VALUES (0,"2022-12-10","2022-12-30","Calidez para tu mascota","Este verano, reserva su lugar en el sol. 
								Nosotros lo llevaremos a las mejores playas, donde podrá relajarse y divertirte. 
								No te quedes en casa, ¡ven a disfrutar del sol con nosotros!",0.0,5000,2);
INSERT INTO Publication VALUES (0,"2023-01-05","2023-02-20","Tranquilidad para ahora y despues","Reservar ahora 
								y asegurar su lugar en la lista de espera para el próximo año. Si reserva con nosotros, 
								podrá estar tranquilo sabiendo que su lugar estará a salvo.",0.0,4200,3);
INSERT INTO Publication VALUES (0,"2022-11-28","2023-01-20","La perfeccion es nuestra filosofia","Al hacer tu reserva, 
								nos aseguramos de que tu estancia sea perfecta. Tenemos una variedad de opciones para que elijas, 
								y todas las comodidades que necesita tu mascota.",0.0,7500,4);
INSERT INTO Publication VALUES (0,"2022-12-22","2023-01-10","Sera como estar en casa","Haz una reserva para tu mascota y 
								asegúrate de recibir el mejor servicio. Nuestro equipo de profesionales se asegurará de que 
								tu mascota esté segura y cómoda durante su estadía. están aquí. 
								Estamos a tu disposición para hacer de tu estancia una experiencia inolvidable.",0.0,9300,5);


/*********************************PUBLICATION IMAGES*******************************************/
CREATE TABLE IF NOT EXISTS ImgPublic(
	idImg INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	uri VARCHAR(60) NOT NULL UNIQUE,
		idPublic INT NOT NULL,
		CONSTRAINT fk_imgPublication FOREIGN KEY(idPublic)
			REFERENCES Publication(idPublic)
);

INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\11223344-IMGPublic20221115213311.jpg",1);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\55667788-IMGPublic20221115213311.jpg",1);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\11447788-IMGPublic20221115213311.jpg",1);

INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\44776633-IMGPublic20221115213322.jpg",2);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\11774499-IMGPublic20221115213322.jpg",2);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\33556688-IMGPublic20221115213322.jpg",2);

INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\2321547139-IMGPublic202211152133.jpg",3);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\8189340865-IMGPublic202211152133.jpg",3);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\6327715270-IMGPublic202211152133.jpg",3);

INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\6745476559-IMGPublic202211152144.jpg",4);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\5300927809-IMGPublic202211152144.jpg",4);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\9858419706-IMGPublic202211152144.jpg",4);

INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\2284550973-IMGPublic202211152155.jpg",5);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\3551448123-IMGPublic202211152155.jpg",5);
INSERT INTO ImgPublic VALUES (0,"Views\\Img\\IMGPublic\\3256367687-IMGPublic202211152155.jpg",5);



/*********************************BOOKING*******************************************/
CREATE TABLE IF NOT EXISTS Booking(
	idBook INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	startD DATE NOT NULL,
	finishD DATE NOT NULL,
	bookState VARCHAR(50) NOT NULL, /*CHECK(bookState = "Awaiting Reply")*/
	payCode VARCHAR(14),
		idPublic INT NOT NULL,
		idUser INT NOT NULL,
			CONSTRAINT fk_bookPublic FOREIGN KEY(idPublic)
				REFERENCES Publication(idPublic),
			CONSTRAINT fk_bookUser FOREIGN KEY(idUser)
				REFERENCES User(idUser)
);

/* INSERT CON FECHA ACTUAL CADA VEZ QUE SE LEVANTA LA BDD
INSERT INTO Booking VALUES (0,DATE(NOW()),
								  DATE_ADD(DATE(NOW()),INTERVAL 15 DAY)
							     ,"Finalized"
								 ,"AT1048235672BY"
								 ,1,4);
*/

INSERT INTO Booking VALUES (0,"2022-12-12","2022-12-17","Waiting Start","65667469864268",1,6);
INSERT INTO Booking VALUES (0,"2023-01-10","2023-01-20","Waiting Start","79624905898821",2,7);
INSERT INTO Booking VALUES (0,"2021-11-10","2021-12-12","Finalized","79624905898821",3,1);


/*********************************BOOKING PET*******************************************/
CREATE TABLE IF NOT EXISTS BookingPet(
	idBP INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
		idBook INT NOT NULL,
		idPet INT NOT NULL,
		CONSTRAINT fk_bpBook FOREIGN KEY(idBook)
				REFERENCES Booking(idBook),
		CONSTRAINT fk_bpPet FOREIGN KEY(idPet)
				REFERENCES Pet(idPet)		
);

INSERT INTO BookingPet VALUES (0,1,4); 
INSERT INTO BookingPet VALUES (0,2,5); 

/*********************************CHECKER*******************************************/
CREATE TABLE IF NOT EXISTS Checker(
    idChecker INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    refCode VARCHAR(20) UNIQUE,
    emisionD DATE NOT NULL,
    closeD DATE NOT NULL,
    payD DATE,
    finalPrice DEC(10,2) NOT NULL,
        idBook INT NOT NULL,
            CONSTRAINT fk_checkerBook FOREIGN KEY(idBook)
                REFERENCES Booking(idBook)
);

INSERT INTO Checker VALUES (0,"111999a17a98w2364er","2022-10-15","2022-10-18","2022-10-16",21000,1);
INSERT INTO Checker VALUES (0,"22a8x7a21a98w1289ra","2022-10-28","2022-10-31","2022-10-29",55000,2);

/*********************************REVIEW*******************************************/
CREATE TABLE IF NOT EXISTS Review(
	idReview INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	createD DATE NOT NULL,
	commentary VARCHAR(200) NOT NULL,
	stars DEC(2,1) NOT NULL CHECK (stars >= 0 AND stars <=5),
		idPublic INT NOT NULL,
		idUser INT NOT NULL,
			CONSTRAINT fk_reviewPublic FOREIGN KEY(idPublic)
				REFERENCES Publication(idPublic),
			CONSTRAINT fk_reviewUser FOREIGN KEY(idUser)
				REFERENCES User(idUser)
);


/*********************************CHAT*******************************************/
CREATE TABLE IF NOT EXISTS Chat(
	idChat INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
		idOwner INT NOT NULL,
		idKeeper INT NOT NULL,
	CONSTRAINT fk_chatOwner FOREIGN KEY (idOwner)
		REFERENCES User(idUser),
	CONSTRAINT fk_chatKeeper FOREIGN KEY (idKeeper) 
		REFERENCES User(idUser)
);

INSERT INTO Chat VALUES (1,1,3); 
INSERT INTO Chat VALUES (2,4,2); 
INSERT INTO Chat VALUES (3,5,2); 
INSERT INTO Chat VALUES (4,2,7); 



/*********************************MESSAGE*******************************************/
CREATE TABLE IF NOT EXISTS MessageChat(
	idMessageChat INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	message VARCHAR(500),
	dateTime DATE NOT NULL,
		idChat INT NOT NULL,
		idSender INT NOT NULL,
	CONSTRAINT fk_messageChat FOREIGN KEY (idChat)
		REFERENCES Chat(idChat),
	CONSTRAINT fk_messageSender FOREIGN KEY (idSender)
		REFERENCES User(idUser)
);

INSERT INTO MessageChat VALUES (1,"Buenas tardes","2022-12-12 22:55:40",4,1); 
INSERT INTO MessageChat VALUES (2,"Buenas!!","2022-12-12 22:56:40",4,2); 
INSERT INTO MessageChat VALUES (3,"Tengo una consulta","2022-12-12 22:57:40",4,1); 
INSERT INTO MessageChat VALUES (4,"Si, digame","2022-12-12 22:57:48",4,2); 
INSERT INTO MessageChat VALUES (5,"podria ir llevarle el perro a las 8:00 de la mañana?","2022-12-12 22:58:05",4,1); 
INSERT INTO MessageChat VALUES (6,"No hay problema, a cualquier hora me viene bien","2022-12-12 22:58:25",4,2); 
INSERT INTO MessageChat VALUES (7,"Perfecto! ya mismo hago la reserva","2022-12-12 22:58:40",4,1); 