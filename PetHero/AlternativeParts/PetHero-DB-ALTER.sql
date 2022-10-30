/*
drop database if exists petHero;
drop table if exists Location;
drop table if exists Keeper;
drop table if exists Owner;
drop table if exists Size;
drop table if exists Dog;
*/
DROP DATABASE IF EXISTS petHeroAlter;
/*********************************DATABASE*******************************************/

CREATE DATABASE IF NOT EXISTS petHeroAlter;
USE petHeroAlter;

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
	username VARCHAR(20),
    password VARCHAR(20),
    email VARCHAR(30),
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

/*********************************ROLE*******************************************/
CREATE TABLE IF NOT EXISTS Role(
	idRole INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(20) UNIQUE,
	description VARCHAR(250)
);

INSERT INTO Role VALUES (0,"Owner","The owner has permissions to add their corresponding pets, 
									as well as to edit their profile and delete their account. 
									To finish, there is the functionality of making a reservation 
									and loading the corresponding payment receipt.");
INSERT INTO Role VALUES (0,"Keeper","El keeper posee permisos para el agregado publicaciones con las cuales 
									 el owner podra interactuar.Junto con esto, la posibilidad de responder 
									 a reservaciones, consultarlas,etc.");

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
		idUser INT NOT NULL,
		CONSTRAINT fk_PetSize FOREIGN KEY (idSize)
			REFERENCES Size(idSize),
		CONSTRAINT fk_PetType FOREIGN KEY (idPetType)
			REFERENCES PetType(idType),
		CONSTRAINT fk_PetUser FOREIGN KEY (idUser)
			REFERENCES User(idUser)
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
