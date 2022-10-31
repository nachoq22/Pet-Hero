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
    adress VARCHAR(40),
    neighborhood VARCHAR(20),
    city VARCHAR(40),
    province VARCHAR(30),
    country VARCHAR(20)
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
	name VARCHAR(20),
    surname VARCHAR(20),
    sex VARCHAR(1),
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
	username VARCHAR(20) UNIQUE,
    password VARCHAR(20),
    email VARCHAR(30) UNIQUE,
		idData INT,
		CONSTRAINT fk_UserData FOREIGN KEY (idData)
			REFERENCES PersonalData(idData)
);
/*PARA PRUEBA SE LES LINKEO ID, EN GENERAL NO VA XK EL REGISTRO QUEDA EXCENTO,HABILITA LUEGO DE QUERERER SER KEEPER*/
INSERT INTO User(User.username,User.password,User.email,User.idData) VALUES ("planetar","orylOSad","achternaga@wificon.eu",1);
INSERT INTO User(User.username,User.password,User.email,User.idData) VALUES ("marsexpress","eIrCHips","djlucadj@lifestyleunrated.com",2);
INSERT INTO User(User.username,User.password,User.email,User.idData) VALUES ("venus","MuncENsu","medennikovadasha@boranora.com",3);
INSERT INTO User(User.username,User.password,User.email,User.idData) VALUES ("sculpordwarf","cIShAphe","saschre@hs-gilching.de",4);
INSERT INTO User(User.username,User.password,User.email,User.idData) VALUES ("toystory","nShaREDO","ovnoya@emvil.com",5);

/*********************************KEEPER*******************************************/
CREATE TABLE IF NOT EXISTS Keeper(
	idKeeper INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
		idUser INT,
		CONSTRAINT fk_KeeperUser FOREIGN KEY (idUser)
			REFERENCES User(idUser)
);

INSERT INTO Keeper VALUES (0,1);
INSERT INTO Keeper VALUES (0,2);
INSERT INTO Keeper VALUES (0,3);
INSERT INTO Keeper VALUES (0,4);
INSERT INTO Keeper VALUES (0,5);

/*********************************OWNER*******************************************/
CREATE TABLE IF NOT EXISTS Owner(
	idOwner INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
		idUser INT,
		CONSTRAINT fk_OwnerUser FOREIGN KEY (idUser)
			REFERENCES User(idUser)
);

INSERT INTO Owner VALUES (0,1);
INSERT INTO Owner VALUES (0,2);
INSERT INTO Owner VALUES (0,3);
INSERT INTO Owner VALUES (0,4);
INSERT INTO Owner VALUES (0,5);

/*********************************SIZE*******************************************/
CREATE TABLE IF NOT EXISTS Size(
	idSize INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30)
);

INSERT INTO Size VALUES (0,"Little");
INSERT INTO Size VALUES (0,"Little-Medium");
INSERT INTO Size VALUES (0,"Medium");
INSERT INTO Size VALUES (0,"Medium-Big");
INSERT INTO Size VALUES (0,"Big");

/*********************************PET TYPE*******************************************/
CREATE TABLE IF NOT EXISTS PetType(
	idType INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30)
);

INSERT INTO PetType VALUES (0,"Dog");
INSERT INTO PetType VALUES (0,"Cat");
INSERT INTO PetType VALUES (0,"Hedgehog");
INSERT INTO PetType VALUES (0,"Groundhog");
INSERT INTO PetType VALUES (0,"Meerkat");

/*********************************PET*******************************************/
CREATE TABLE IF NOT EXISTS Pet(
	idPet INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20),
    breed VARCHAR(20),
	profileIMG VARCHAR(60),
	vaccinationPlanIMG VARCHAR(60),
    observation VARCHAR(60),
		idSize INT NOT NULL,
		idPetType INT NOT NULL,
		idOwner INT NOT NULL,
		CONSTRAINT fk_PetSize FOREIGN KEY (idSize)
			REFERENCES Size(idSize),
		CONSTRAINT fk_PetType FOREIGN KEY (idPetType)
			REFERENCES PetType(idType),
		CONSTRAINT fk_PetOwner FOREIGN KEY (idOwner)
			REFERENCES Owner(idOwner)
);

INSERT INTO Pet VALUES (0,"Coco","Mestizo","C:\xampp\htdocs\Pet-Hero\Pet Hero\PetImg/MezC-131020221731.jpg"
						,"C:\xampp\htdocs\Pet-Hero\Pet Hero\VacImg/MezCM-131020221731.jpg"
						,"Esta re duro",1,1,1);
INSERT INTO Pet VALUES (0,"Thor","Lykoi","C:\xampp\htdocs\Pet-Hero\Pet Hero\PetImg/LykT-131020221732.jpg"
						,"C:\xampp\htdocs\Pet-Hero\Pet Hero\VacImg/LykT-131020221731.jpg"
						,"Rompe todo",2,2,2);
INSERT INTO Pet VALUES (0,"Faraon","Pigmeo africano","C:\xampp\htdocs\Pet-Hero\Pet Hero\PetImg/PigF-131020221732.jpg"
						,"C:\xampp\htdocs\Pet-Hero\Pet Hero\VacImg/PigF-131020221731.jpg"
						,"Come mucho",3,3,3);
INSERT INTO Pet VALUES (0,"Laila","Ariray","C:\xampp\htdocs\Pet-Hero\Pet Hero\PetImg/AriL-131020221733.jpg"
						,"C:\xampp\htdocs\Pet-Hero\Pet Hero\VacImg/AriL-131020221731.jpg"
						,"No tiene baño propio",4,4,4);
INSERT INTO Pet VALUES (0,"Willow","Suricatta","C:\xampp\htdocs\Pet-Hero\Pet Hero\PetImg/SurW-131020221734.jpg"
						,"C:\xampp\htdocs\Pet-Hero\Pet Hero\VacImg/SurW-131020221731.jpg"
						,"Se escapa constantemente",5,5,5);



/*SEGUNDA PARTE, ADMINISTRACION DE PUBLICACIONES, RESERVAS Y RESENIAS*/

/*********************************PUBLICATION*******************************************/
		/*AGREGA LOS CHECK PELOTUDO*/
CREATE TABLE IF NOT EXISTS Publication(
	idPublic INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	openD DATE,
	closeD DATE,
	title VARCHAR(50),
	description VARCHAR(200),
	popularity DEC(2,1),
	remuneration DEC(10,2),
		idKeeper INT NOT NULL,
		CONSTRAINT fk_publicKeeper FOREIGN KEY(idKeeper)
			REFERENCES Keeper(idKeeper)
);

INSERT INTO Publication VALUES (0,"2022-10-30","2022-11-02"
							     ,"De Gran comodidad"
								 ,"Casa doble planta con patio trasero, casucha con acolchado para mascotas grandes que lo requieran"
								 ,4.8,3500.10,1)
/*								 
INSERT INTO Publication VALUES (0,"","","","",0.0,0.0,2)
INSERT INTO Publication VALUES (0,"","","","",0.0,0.0,3)
INSERT INTO Publication VALUES (0,"","","","",0.0,0.0,4)
INSERT INTO Publication VALUES (0,"","","","",0.0,0.0,5)
*/

/*********************************PUBLICATION IMAGES*******************************************/
CREATE TABLE IF NOT EXISTS ImgPublic(
	idImg INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	uri VARCHAR(60) NOT NULL UNIQUE,
		idPublic INT NOT NULL,
		CONSTRAINT fk_imgPublic FOREIGN KEY(idPublic)
			REFERENCES Publication(idPublic)
);

INSERT INTO ImgPublic VALUES (0,"IMG/Public/30102022153601.jpg",1);
INSERT INTO ImgPublic VALUES (0,"IMG/Public/30102022153602.jpg",1);
INSERT INTO ImgPublic VALUES (0,"IMG/Public/30102022153604.jpg",1);

/*********************************BOOKING*******************************************/
CREATE TABLE IF NOT EXISTS Booking(
	idBook INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	openD DATE,
	closeD DATE,
	payState VARCHAR(20),
	payCode VARCHAR(14), /*HACER CHECK DE QUE TENGA 4 LETRAS Y DEMAS NUMS*/
		idPublic INT NOT NULL,
		idOwner INT NOT NULL,
		idPet INT NOT NULL,
			CONSTRAINT fk_bookPublic FOREIGN KEY(idPublic)
				REFERENCES Publication(idPublic),
			CONSTRAINT fk_bookOwner FOREIGN KEY(idOwner)
				REFERENCES Owner(idOwner),
			CONSTRAINT fk_bookPet FOREIGN KEY(idPet)
				REFERENCES Pet(idPet)
);

INSERT INTO Booking VALUES (0,"2022-10-30","2022-11-30"
							     ,"PAID"
								 ,"AT1048235672BY"
								 ,1,3,4)

/*********************************CHECKER*******************************************/

CREATE TABLE IF NOT EXISTS Checker(
	idChecker INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	emisionD DATE,
	closeD DATE,
	finalPrice DEC(10,2),
		idBook INT NOT NULL,
			CONSTRAINT fk_checkerBook FOREIGN KEY(idBook)
				REFERENCES Booking(idBook)
);

INSERT INTO Checker VALUES (0,"2022-10-30","2022-11-30",13500.30,1);

/*********************************REVIEW*******************************************/
CREATE TABLE IF NOT EXISTS Review(
	idReview INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	createD DATE,
	commentary VARCHAR(200),
	stars DEC(2,1),
		idPublic INT NOT NULL,
		idOwner INT NOT NULL,
			CONSTRAINT fk_reeviewPublic FOREIGN KEY(idPublic)
				REFERENCES Publication(idPublic),
			CONSTRAINT fk_reviewOwner FOREIGN KEY(idOwner)
				REFERENCES Owner(idOwner),
);


