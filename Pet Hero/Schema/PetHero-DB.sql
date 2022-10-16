/*
drop database if exists petHero;
drop table if exists Location;
drop table if exists Keeper;
drop table if exists Owner;
drop table if exists Size;
drop table if exists Dog;
*/
/*********************************DATABASE*******************************************/

CREATE DATABASE IF NOT EXISTS petHero;
USE petHero;

/*********************************LOCATION*******************************************/
CREATE TABLE IF NOT EXISTS Location(
	idLocation INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    adress VARCHAR(40),
    neighborhood VARCHAR(20),
    city VARCHAR(20),
    province VARCHAR(30),
    country VARCHAR(20)
);

INSERT INTO Location VALUES (0,"Rondeau 616","Piedras del sol","Cordoba","Cordoba","Argentina");
INSERT INTO Location VALUES (0,"Av. 3 de Abril 827","Mariano","Corrientes","Corrientes","Argentina");
INSERT INTO Location VALUES (0,"Av San Martín 1143","Arbolito","Ciudad de Mendoza","Mendoza","Argentina");
INSERT INTO Location VALUES (0,"Rondeau 616","Mitre","San Fernando","Buenos Aires","Argentina");
INSERT INTO Location VALUES (0,"San Martín 2365","Termas Saladas","Santa Fe","Santa Fe","Argentina");
INSERT INTO Location VALUES (0,"Pedro Morán 4441","Moron","Ciudad Autónoma de Buenos Aires","Buenos Aires","Argentina");
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

INSERT INTO User(User.username,User.password,User.email) VALUES ("planetar","orylOSad","achternaga@wificon.eu");
INSERT INTO User(User.username,User.password,User.email) VALUES ("marsexpress","eIrCHips","djlucadj@lifestyleunrated.com");
INSERT INTO User(User.username,User.password,User.email) VALUES ("venus","MuncENsu","medennikovadasha@boranora.com");
INSERT INTO User(User.username,User.password,User.email) VALUES ("sculpordwarf","cIShAphe","saschre@hs-gilching.de");
INSERT INTO User(User.username,User.password,User.email) VALUES ("toystory","nShaREDO","ovnoya@emvil.com");

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

/********************************************************************************************/
CREATE TABLE IF NOT EXISTS Pet(
	idPet INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20),
    breed VARCHAR(20),
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

INSERT INTO Pet VALUES (0,"Coco","Mestizo","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogCM-131020221731.jpg","Esta re duro",1,1,1);
INSERT INTO Pet VALUES (0,"Thor","Lykoi","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogTG-131020221732.jpg","Rompe todo",2,2,2);
INSERT INTO Pet VALUES (0,"Faraon","Pigmeo africano","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogFL-131020221732.jpg","Come mucho",3,3,3);
INSERT INTO Pet VALUES (0,"Laila","Ariray","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogLO-131020221733.jpg","No tiene baño propio",4,4,4);
INSERT INTO Pet VALUES (0,"Willow","Suricatta","C:\xampp\htdocs\Pet-Hero\Pet Hero\DogImg/dogWC-131020221734.jpg","Se escapa constantemente",5,5,5);
