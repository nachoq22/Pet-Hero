USE petHero;

/*********************************PROCEDURES LOCATION*******************************************/
DROP PROCEDURE IF EXISTS `Location_GetAll`;
DELIMITER $$
CREATE PROCEDURE Location_GetAll()
BEGIN
    SELECT * 
    FROM Location;
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Location_GetById`;

DELIMITER $$
CREATE PROCEDURE Location_GetById(IN idLocation INT)
BEGIN
    SELECT * 
    FROM Location
    WHERE (Location.idLocation = idLocation);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Location_Add`;
DELIMITER $$
CREATE PROCEDURE Location_Add(IN adress VARCHAR(40),IN neighborhood VARCHAR(20),IN city VARCHAR(20),
                              IN province VARCHAR(30),IN country VARCHAR(20))
BEGIN
    INSERT INTO Location
        (Location.adress,Location.neighborhood,Location.city,Location.province,Location.country)
    VALUES
        (adress,neighborhood,city,province,country);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Location_Delete`;
DELIMITER $$
CREATE PROCEDURE Location_Delete(IN idLocation INT)
BEGIN
    DELETE 
    FROM Location
    WHERE (Location.idLocation = idLocation);
END;
$$

DELIMITER ;

/*********************************PROCEDURES PERSONAL DATA*******************************************/
DROP PROCEDURE IF EXISTS `PersonalData_GetAll`;
DELIMITER $$
CREATE PROCEDURE PersonalData_GetAll()
BEGIN
    SELECT * 
    FROM PersonalData;
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `PersonalData_GetById`;

DELIMITER $$
CREATE PROCEDURE PersonalData_GetById(IN idData INT)
BEGIN
    SELECT * 
    FROM PersonalData
    WHERE (PersonalData.idData = idData);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `PersonalData_Add`;
DELIMITER $$
CREATE PROCEDURE PersonalData_Add(IN name VARCHAR(20),IN surname VARCHAR(20),IN sex VARCHAR(1),
                                    IN dni VARCHAR(8),IN idLocation INT)
BEGIN
    INSERT INTO PersonalData
        (PersonalData.name,PersonalData.surname,PersonalData.sex,PersonalData.dni,PersonalData.idLocation)
    VALUES
        (name,surname,sex,dni,idLocation);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `PersonalData_Delete`;
DELIMITER $$
CREATE PROCEDURE PersonalData_Delete(IN idData INT)
BEGIN
    DELETE 
    FROM PersonalData
    WHERE (PersonalData.idData = idData);
END;
$$

DELIMITER ;

/*********************************PROCEDURES USER*******************************************/
DROP PROCEDURE IF EXISTS `User_GetAll`;
DELIMITER $$
CREATE PROCEDURE User_GetAll()
BEGIN
    SELECT * 
    FROM User;
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `User_GetById`;

DELIMITER $$
CREATE PROCEDURE User_GetById(IN idUser INT)
BEGIN
    SELECT * 
    FROM User
    WHERE (User.idUser = idUser);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `User_Add`;
DELIMITER $$
CREATE PROCEDURE User_Add(IN username VARCHAR(20),IN password VARCHAR(20),IN email VARCHAR(30),IN idData INT)
BEGIN
    INSERT INTO User
        (User.username,User.password,User.email,User.idData)
    VALUES
        (username,password,email,idData);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `User_Register`;
DELIMITER $$
CREATE PROCEDURE User_Register(IN username VARCHAR(20),IN password VARCHAR(20),IN email VARCHAR(30))
BEGIN
    INSERT INTO User
        (User.username,User.password,User.email)
    VALUES
        (username,password,email);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `User_Delete`;
DELIMITER $$
CREATE PROCEDURE User_Delete(IN idUser INT)
BEGIN
    DELETE 
    FROM User
    WHERE (User.idUser = idUser);
END;
$$

DELIMITER ;

/*********************************PROCEDURES KEEPER*******************************************/
DROP PROCEDURE IF EXISTS `Keeper_GetAll`;
DELIMITER $$
CREATE PROCEDURE Keeper_GetAll()
BEGIN
    SELECT * 
    FROM Keeper;
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Keeper_GetById`;

DELIMITER $$
CREATE PROCEDURE Keeper_GetById(IN idKeeper INT)
BEGIN
    SELECT * 
    FROM Keeper
    WHERE (Keeper.idKeeper = idKeeper);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Keeper_Add`;
DELIMITER $$
CREATE PROCEDURE Keeper_Add(IN idUser INT)
BEGIN
    INSERT INTO Keeper
        (Keeper.idUser)
    VALUES
        (idUser);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Keeper_Delete`;
DELIMITER $$
CREATE PROCEDURE Keeper_Delete(IN idKeeper INT)
BEGIN
    DELETE 
    FROM Keeper
    WHERE (Keeper.idKeeper = idKeeper);
END;
$$

DELIMITER ;

/*********************************PROCEDURES OWNER*******************************************/
DROP PROCEDURE IF EXISTS `Owner_GetAll`;
DELIMITER $$
CREATE PROCEDURE Owner_GetAll()
BEGIN
    SELECT * 
    FROM Owner;
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Owner_GetById`;

DELIMITER $$
CREATE PROCEDURE Owner_GetById(IN idOwner INT)
BEGIN
    SELECT * 
    FROM Owner
    WHERE (Owner.idOwner = idOwner);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Owner_Add`;
DELIMITER $$
CREATE PROCEDURE Owner_Add(IN idUser INT)
BEGIN
    INSERT INTO Owner
        (Owner.idUser)
    VALUES
        (idUser);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Owner_Delete`;
DELIMITER $$
CREATE PROCEDURE Owner_Delete(IN idOwner INT)
BEGIN
    DELETE 
    FROM Owner
    WHERE (Owner.idOwner = idOwner);
END;
$$

DELIMITER ;

/*********************************PROCEDURES SIZE*******************************************/
DROP PROCEDURE IF EXISTS `Size_GetAll`;
DELIMITER $$
CREATE PROCEDURE Size_GetAll()
BEGIN
    SELECT * 
    FROM Size;
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Size_GetById`;

DELIMITER $$
CREATE PROCEDURE Size_GetById(IN idSize INT)
BEGIN
    SELECT * 
    FROM Size
    WHERE (Size.idSize = idSize);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Size_Add`;
DELIMITER $$
CREATE PROCEDURE Size_Add(IN name VARCHAR(30))
BEGIN
    INSERT INTO Size
        (Size.name)
    VALUES
        (name);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Size_Delete`;
DELIMITER $$
CREATE PROCEDURE Size_Delete(IN idSize INT)
BEGIN
    DELETE 
    FROM Size
    WHERE (Size.idSize = idSize);
END;
$$

DELIMITER ;

/*********************************PROCEDURES PETTYPE*******************************************/
DROP PROCEDURE IF EXISTS `PetType_GetAll`;
DELIMITER $$
CREATE PROCEDURE PetType_GetAll()
BEGIN
    SELECT * 
    FROM PetType;
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `PetType_GetById`;

DELIMITER $$
CREATE PROCEDURE PetType_GetById(IN idType INT)
BEGIN
    SELECT * 
    FROM PetType
    WHERE (PetType.idType = idType);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `PetType_Add`;
DELIMITER $$
CREATE PROCEDURE PetType_Add(IN name VARCHAR(30))
BEGIN
    INSERT INTO PetType
        (PetType.name)
    VALUES
        (name);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `PetType_Delete`;
DELIMITER $$
CREATE PROCEDURE PetType_Delete(IN idType INT)
BEGIN
    DELETE 
    FROM PetType
    WHERE (PetType.idType = idType);
END;
$$

DELIMITER ;

/*********************************PROCEDURES PET*******************************************/
DROP PROCEDURE IF EXISTS `Pet_GetAll`;
DELIMITER $$
CREATE PROCEDURE Pet_GetAll()
BEGIN
    SELECT * 
    FROM Pet;
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Pet_GetById`;

DELIMITER $$
CREATE PROCEDURE Pet_GetById(IN idPet INT)
BEGIN
    SELECT * 
    FROM Pet
    WHERE (Pet.idPet = idPet);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Pet_Add`;
DELIMITER $$
CREATE PROCEDURE Pet_Add(IN name VARCHAR(20), IN breed VARCHAR(20), IN profileIMG VARCHAR(60),
                         IN vaccinationPlanIMG VARCHAR(60), IN observation VARCHAR(60), IN idSize INT,
	                     IN idPetType INT, IN idOwner INT)
BEGIN
    INSERT INTO Pet
        (Pet.name,Pet.breed,Pet.profileIMG,Pet.vaccinationPlanIMG,Pet.observation,Pet.idSize
        ,Pet.idPetType,Pet.idOwner)
    VALUES
        (name,breed,profileIMG,vaccinationPlanIMG,observation,idSize,idPetType,idOwner);
END;
$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Pet_Delete`;
DELIMITER $$
CREATE PROCEDURE Pet_Delete(IN idPet INT)
BEGIN
    DELETE 
    FROM Pet
    WHERE (Pet.idPet = idPet);
END;
$$

DELIMITER ;

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
/*CALL User_Add(username,password,email,idData);*/
Call User_Add("pablitoClavito","ClavitoCrack","pablitoElCrack@gmail.com",5);
/*Call User_Delete(6);*/

/*********************************TEST KEEPER*******************************************/
Call Keeper_GetAll();
Call Keeper_GetById(2);
/*CALL Keeper_Add(idUser);*/
Call Keeper_Add(2);
/*Call Keeper_Delete(6);*/

/*********************************TEST OWNER*******************************************/
Call Owner_GetAll();
Call Owner_GetById(2);
/*CALL Owner_Add(idUser);*/
Call Owner_Add(2);
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
/*CALL Size_Add(name,breed,profileIMG,vaccinationPlanIMG,observation,idSize,idPetType,idOwner);*/
Call Pet_Add("Salchichon","Suricatta","C:\xampp\htdocs\Pet-Hero\Pet Hero\PetImg/SurS-181020222211.jpg"
						,"C:\xampp\htdocs\Pet-Hero\Pet Hero\VacImg/SurS-181020222211.jpg"
						,"Tiene 6 dedos",1,5,3);
/*Call Pet_Delete(6);*/


	