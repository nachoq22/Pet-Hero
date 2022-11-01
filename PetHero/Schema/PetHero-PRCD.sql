/*
DROP PROCEDURE IF EXISTS `Location_GetAll`;
DROP PROCEDURE IF EXISTS `Location_GetById`;
DROP PROCEDURE IF EXISTS `Location_Add`;
DROP PROCEDURE IF EXISTS `Location_Delete`;

DROP PROCEDURE IF EXISTS `PersonalData_GetAll`;
DROP PROCEDURE IF EXISTS `PersonalData_GetById`;
DROP PROCEDURE IF EXISTS `PersonalData_Add`;
DROP PROCEDURE IF EXISTS `PersonalData_Delete`;

DROP PROCEDURE IF EXISTS `User_GetAll`;
DROP PROCEDURE IF EXISTS `User_GetById`;
DROP PROCEDURE IF EXISTS `User_Add`;
DROP PROCEDURE IF EXISTS `User_Register`;
DROP PROCEDURE IF EXISTS `User_Login`;
DROP PROCEDURE IF EXISTS `User_Delete`;

DROP PROCEDURE IF EXISTS `Keeper_GetAll`;
DROP PROCEDURE IF EXISTS `Keeper_GetById`;
DROP PROCEDURE IF EXISTS `Keeper_Delete`;
DROP PROCEDURE IF EXISTS `Keeper_Add`;


DROP PROCEDURE IF EXISTS `Owner_GetAll`;
DROP PROCEDURE IF EXISTS `Owner_GetById`;
DROP PROCEDURE IF EXISTS `Owner_Add`;
DROP PROCEDURE IF EXISTS `Owner_Delete`;

DROP PROCEDURE IF EXISTS `Size_GetAll`;
DROP PROCEDURE IF EXISTS `Size_GetById`;
DROP PROCEDURE IF EXISTS `Size_Add`;
DROP PROCEDURE IF EXISTS `Size_Delete`;

DROP PROCEDURE IF EXISTS `PetType_GetAll`;
DROP PROCEDURE IF EXISTS `PetType_GetById`;
DROP PROCEDURE IF EXISTS `PetType_Add`;
DROP PROCEDURE IF EXISTS `PetType_Delete`;

DROP PROCEDURE IF EXISTS `Pet_GetAll`;
DROP PROCEDURE IF EXISTS `Pet_GetById`;
DROP PROCEDURE IF EXISTS `Pet_GetByUser`;
DROP PROCEDURE IF EXISTS `Pet_Add`;
DROP PROCEDURE IF EXISTS `Pet_Delete`;
*/

USE petHero;
/*********************************PROCEDURES LOCATION*******************************************/
DELIMITER $$
CREATE PROCEDURE Location_GetAll()
BEGIN
    SELECT * 
    FROM Location;
END;
$$

DELIMITER $$
CREATE PROCEDURE Location_GetById(IN idLocation INT)
BEGIN
    SELECT * 
    FROM Location
    WHERE (Location.idLocation = idLocation);
END;
$$

DELIMITER $$
CREATE PROCEDURE Location_Add(IN adress VARCHAR(50),IN neighborhood VARCHAR(50),IN city VARCHAR(50),
                              IN province VARCHAR(50),IN country VARCHAR(50))
BEGIN
    INSERT INTO Location
        (Location.adress,Location.neighborhood,Location.city,Location.province,Location.country)
    VALUES
        (adress,neighborhood,city,province,country);
END;
$$

DELIMITER $$
CREATE PROCEDURE Location_Delete(IN idLocation INT)
BEGIN
    DELETE 
    FROM Location
    WHERE (Location.idLocation = idLocation);
END;
$$

/*********************************PROCEDURES PERSONAL DATA*******************************************/
DELIMITER $$
CREATE PROCEDURE PersonalData_GetAll()
BEGIN
    SELECT * 
    FROM PersonalData;
END;
$$

DELIMITER $$
CREATE PROCEDURE PersonalData_GetById(IN idData INT)
BEGIN
    SELECT * 
    FROM PersonalData
    WHERE (PersonalData.idData = idData);
END;
$$

DELIMITER $$
CREATE PROCEDURE PersonalData_Add(IN name VARCHAR(50),IN surname VARCHAR(50),IN sex VARCHAR(1),
                                    IN dni VARCHAR(8),IN idLocation INT)
BEGIN
    INSERT INTO PersonalData
        (PersonalData.name,PersonalData.surname,PersonalData.sex,PersonalData.dni,PersonalData.idLocation)
    VALUES
        (name,surname,sex,dni,idLocation);
END;
$$

DELIMITER $$
CREATE PROCEDURE PersonalData_Delete(IN idData INT)
BEGIN
    DELETE 
    FROM PersonalData
    WHERE (PersonalData.idData = idData);
END;
$$

/*********************************PROCEDURES USER*******************************************/
DELIMITER $$
CREATE PROCEDURE User_GetAll()
BEGIN
    SELECT * 
    FROM User;
END;
$$

DELIMITER $$
CREATE PROCEDURE User_GetById(IN idUser INT)
BEGIN
    SELECT * 
    FROM User
    WHERE (User.idUser = idUser);
END;
$$

DELIMITER $$
CREATE PROCEDURE User_GetByUsername(IN username VARCHAR(50))
BEGIN
    SELECT * 
    FROM User
    WHERE (User.username = username);
END;
$$

DELIMITER $$
CREATE PROCEDURE User_Add(IN username VARCHAR(50),IN password VARCHAR(30),IN email VARCHAR(50))
BEGIN
    INSERT INTO User
        (User.username,User.password,User.email)
    VALUES
        (username,password,email);
END;
$$

DELIMITER $$
CREATE PROCEDURE User_HookData(IN idUser INT,IN idData INT)
BEGIN
    UPDATE User
	SET User.idData = idData
	WHERE User.idUser = idUser;
END;
$$

DELIMITER $$
CREATE PROCEDURE User_Register(IN username VARCHAR(50),IN password VARCHAR(30),IN email VARCHAR(50))
BEGIN
    INSERT INTO User
        (User.username,User.password,User.email)
    VALUES
        (username,password,email);
END;
$$

DELIMITER $$
CREATE PROCEDURE User_Login(IN username VARCHAR(20),IN password VARCHAR(20))
BEGIN
    SELECT COUNT(idUser) as rta
    FROM User
    WHERE User.username = username AND User.password = password;
END;
$$

DELIMITER $$
CREATE PROCEDURE User_Delete(IN idUser INT)
BEGIN
    DELETE 
    FROM User
    WHERE (User.idUser = idUser);
END;
$$
/*********************************PROCEDURE ROLE*******************************************/
DELIMITER $$
CREATE PROCEDURE Role_GetAll()
BEGIN
    SELECT * 
    FROM Role;
END;
$$

DELIMITER $$
CREATE PROCEDURE Role_GetById(IN idRole INT)
BEGIN
    SELECT * 
    FROM Role
    WHERE (Role.idRole = idRole);
END;
$$

DELIMITER $$
CREATE PROCEDURE Role_GetByName(IN name VARCHAR(30))
BEGIN
    SELECT * 
    FROM Role
    WHERE (Role.name = name);
END;
$$

DELIMITER $$
CREATE PROCEDURE Role_Add(name VARCHAR(30),description VARCHAR(250))
BEGIN
    INSERT INTO Role
        (Role.name,Role.description)
    VALUES
        (name,description);
END;
$$

DELIMITER $$
CREATE PROCEDURE Role_Delete(IN idRole INT)
BEGIN
    DELETE 
    FROM Role
    WHERE (Role.idRole = idRole);
END;
$$

/*********************************PROCEDURE USERROLE*******************************************/
DELIMITER $$
CREATE PROCEDURE UR_GetAll()
BEGIN
    SELECT * 
    FROM UserRole;
END;
$$

DELIMITER $$
CREATE PROCEDURE UR_GetById(IN idUR INT)
BEGIN
    SELECT * 
    FROM UserRole
    WHERE (UserRole.idUR = idUR);
END;
$$



DELIMITER $$
CREATE PROCEDURE UR_IsKeeper(IN idUser INT)
BEGIN
    SELECT COUNT(idUser) as rta 
    FROM UserRole
    WHERE (UserRole.idUser = idUser) AND (UserRole.idRole = 2);
END;
$$

DELIMITER $$
CREATE PROCEDURE UR_Add(IN idUser INT,IN idRole INT)
BEGIN
    INSERT INTO UserRole
        (UserRole.idUser,UserRole.idRole)
    VALUES
        (idUser,idRole);
END;
$$

DELIMITER $$
CREATE PROCEDURE UR_UserToOwner(IN idUser INT)
BEGIN
    INSERT INTO UserRole
        (UserRole.idUser,UserRole.idRole)
    VALUES
        (idUser,1);
END;
$$

DELIMITER $$
CREATE PROCEDURE UR_UserToKeeper(IN idUser INT)
BEGIN
    INSERT INTO UserRole
        (UserRole.idUser,UserRole.idRole)
    VALUES
        (idUser,2);
END;
$$

DELIMITER $$
CREATE PROCEDURE UR_Delete(IN idUR INT)
BEGIN
    DELETE 
    FROM UserRole
    WHERE (UserRole.idUR = idUR);
END;
$$

/*********************************PROCEDURES SIZE*******************************************/
DELIMITER $$
CREATE PROCEDURE Size_GetAll()
BEGIN
    SELECT * 
    FROM Size;
END;
$$

DELIMITER $$
CREATE PROCEDURE Size_GetById(IN idSize INT)
BEGIN
    SELECT * 
    FROM Size
    WHERE (Size.idSize = idSize);
END;
$$

DELIMITER $$
CREATE PROCEDURE Size_GetByName(IN name VARCHAR(30))
BEGIN
    SELECT * 
    FROM Size
    WHERE (Size.name = name);
END;
$$


DELIMITER $$
CREATE PROCEDURE Size_Add(IN name VARCHAR(30))
BEGIN
    INSERT INTO Size
        (Size.name)
    VALUES
        (name);
END;
$$

DELIMITER $$
CREATE PROCEDURE Size_Delete(IN idSize INT)
BEGIN
    DELETE 
    FROM Size
    WHERE (Size.idSize = idSize);
END;
$$

/*********************************PROCEDURES PETTYPE*******************************************/
DELIMITER $$
CREATE PROCEDURE PetType_GetAll()
BEGIN
    SELECT * 
    FROM PetType;
END;
$$

DELIMITER $$
CREATE PROCEDURE PetType_GetById(IN idType INT)
BEGIN
    SELECT * 
    FROM PetType
    WHERE (PetType.idType = idType);
END;
$$

DELIMITER $$
CREATE PROCEDURE PetType_GetByName(IN name VARCHAR(30))
BEGIN
    SELECT * 
    FROM PetType
    WHERE (PetType.name = name);
END;
$$

DELIMITER $$
CREATE PROCEDURE PetType_Add(IN name VARCHAR(30))
BEGIN
    INSERT INTO PetType
        (PetType.name)
    VALUES
        (name);
END;
$$

DELIMITER $$
CREATE PROCEDURE PetType_Delete(IN idType INT)
BEGIN
    DELETE 
    FROM PetType
    WHERE (PetType.idType = idType);
END;
$$

/*********************************PROCEDURES PET*******************************************/
DELIMITER $$
CREATE PROCEDURE Pet_GetAll()
BEGIN
    SELECT * 
    FROM Pet;
END;
$$

DELIMITER $$
CREATE PROCEDURE Pet_GetById(IN idPet INT)
BEGIN
    SELECT * 
    FROM Pet
    WHERE (Pet.idPet = idPet);
END;
$$


DELIMITER $$
CREATE PROCEDURE Pet_GetByUser(IN idUser INT)
BEGIN
    SELECT * 
    FROM Pet
    WHERE (Pet.idUser = idUser);
END;
$$

DELIMITER $$
CREATE PROCEDURE Pet_Add(IN name VARCHAR(20), IN breed VARCHAR(20), IN profileIMG VARCHAR(60),
                         IN vaccinationPlanIMG VARCHAR(60), IN observation VARCHAR(60), IN idSize INT,
	                     IN idType INT, IN idUser INT)
BEGIN
    INSERT INTO Pet
        (Pet.name,Pet.breed,Pet.profileIMG,Pet.vaccinationPlanIMG,Pet.observation,Pet.idSize
        ,Pet.idType,Pet.idUser)
    VALUES
        (name,breed,profileIMG,vaccinationPlanIMG,observation,idSize,idType,idUser);
END;
$$

DELIMITER $$
CREATE PROCEDURE Pet_Delete(IN idPet INT)
BEGIN
    DELETE 
    FROM Pet
    WHERE (Pet.idPet = idPet);
END;
$$

/*********************************PROCEDURES PUBLICATION*******************************************/

DELIMITER $$

CREATE PROCEDURE Publication_GetAll()
BEGIN
    SELECT *
    FROM Publication;
END;

$$

DELIMITER $$ 

CREATE PROCEDURE Publication_GetById(IN idPublication INT)
BEGIN
    SELECT * 
    FROM Publication
    WHERE (Publication.idPublication = idPublication);
END;

$$





/*********************************TEST PROCEDURES*******************************************/
/*********************************TEST LOCATION*******************************************/
CALL Location_GetAll();
/*CALL Location_GetById(ID);*/
CALL Location_GetById(2);
/*CALL Location_Add(adress,neighborhood,city,province,country);*/
CALL Location_Add("Mi calle","Mi Barrio","Mar del plata","Buenos Aires","Argentina");
/*CALL Location_Delete(ID);*/
/*CALL Location_Delete(6);*/

/*********************************TEST PERSONAL DATA*******************************************/
CALL PersonalData_GetAll();
CALL PersonalData_GetById(2);
/*CALL PersonalData_Add(name,surname,sex,dni,idLocation);*/
Call PersonalData_Add("Ramiro","Talangana","M","44886655",2);
/*Call PersonalData_Delete(6);*/

/*********************************TEST USER*******************************************/
Call User_GetAll();
Call User_GetById(2);
Call User_GetByUsername("planetar");
/*CALL User_Add(username,password,varResp);*/
CALL User_Login("planetar","orylOSad");
/*CALL User_Add(username,password,email,idData);*/
Call User_Add("pablitoClavito","ClavitoCrack","pablitoElCrack@gmail.com");
/*CALL User_Add(username,password,email);*/
Call User_Register("Elcucarachin","Carlos1245","elcuca@gmail.com");
/*Call User_Delete(6);*/

/*********************************TEST USERROLE*******************************************/
Call UR_GetAll();
Call UR_GetById(2);
/*CALL Owner_Add(idUser,idRole);*/
/*Call URole_Add(6,2);*/
Call UR_IsKeeper(3);
Call UR_UserToKeeper(6);
/*Call Owner_Delete(6);*/

/*********************************TEST SIZE*******************************************/
Call Size_GetAll();
Call Size_GetById(2);
/*CALL Size_Add(name);*/
Call Size_Add("ExtraBig");
/*Call Size_Delete(6);*/

/*********************************TEST PETTYPE*******************************************/
Call PetType_GetAll();
Call PetType_GetById(2);
/*CALL PetType_Add(name);*/
Call PetType_Add("Cacatuos");
/*Call PetType_Delete(6);*/

/*********************************TEST PET*******************************************/
Call Pet_GetAll();
Call Pet_GetById(2);
Call Pet_GetByUser(2);
/*CALL Size_Add(name,breed,profileIMG,vaccinationPlanIMG,observation,idSize,idPetType,idOwner);*/
Call Pet_Add("Salchichon","Suricatta","C:\xampp\htdocs\Pet-Hero\Pet Hero\PetImg/SurS-181020222211.jpg"
						,"C:\xampp\htdocs\Pet-Hero\Pet Hero\VacImg/SurS-181020222211.jpg"
						,"Tiene 6 dedos",1,5,3);
/*Call Pet_Delete(6);*/


	