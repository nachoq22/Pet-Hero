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
CREATE PROCEDURE Location_Add(IN adress VARCHAR(40),IN neighborhood VARCHAR(20),IN city VARCHAR(20),
                              IN province VARCHAR(30),IN country VARCHAR(20))
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
CREATE PROCEDURE PersonalData_Add(IN name VARCHAR(20),IN surname VARCHAR(20),IN sex VARCHAR(1),
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
CREATE PROCEDURE User_GetByUsername(IN username VARCHAR(20))
BEGIN
    SELECT * 
    FROM User
    WHERE (User.username = username);
END;
$$

DELIMITER $$
CREATE PROCEDURE User_Add(IN username VARCHAR(20),IN password VARCHAR(20),IN email VARCHAR(30),IN idData INT)
BEGIN
    INSERT INTO User
        (User.username,User.password,User.email,User.idData)
    VALUES
        (username,password,email,idData);
END;
$$

DELIMITER $$
CREATE PROCEDURE User_Register(IN username VARCHAR(20),IN password VARCHAR(20),IN email VARCHAR(30))
BEGIN
    INSERT INTO User
        (User.username,User.password,User.email)
    VALUES
        (username,password,email);
END;
$$

DELIMITER $$
CREATE PROCEDURE User_Login(IN username VARCHAR(20),IN password VARCHAR(20),OUT rta INT)
BEGIN
    SELECT COUNT(idUser) 
    INTO rta
    FROM User
    WHERE User.username = username AND User.password = password;
    
    SELECT @rta;
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

/*********************************PROCEDURE USERROLE*******************************************/
DELIMITER $$
CREATE PROCEDURE URole_GetAll()
BEGIN
    SELECT * 
    FROM UserRole;
END;
$$

DELIMITER $$
CREATE PROCEDURE URole_GetById(IN idUR INT)
BEGIN
    SELECT * 
    FROM UserRole
    WHERE (UserRole.idUR = idUR);
END;
$$

DELIMITER $$
CREATE PROCEDURE URole_GetByIdRole(IN idUser INT)
BEGIN
    SELECT * 
    FROM UserRole
    WHERE (UserRole.idUser = idUser) AND (UserRole.idRole = idRole);
END;
$$

DELIMITER $$
CREATE PROCEDURE URole_Add(IN idUser INT,IN idRole INT)
BEGIN
    INSERT INTO UserRole
        (UserRole.idUser,UserRole.idRole)
    VALUES
        (idUser,idRole);
END;
$$

DELIMITER $$
CREATE PROCEDURE URole_Delete(IN idUR INT)
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
	                     IN idPetType INT, IN idUser INT)
BEGIN
    INSERT INTO Pet
        (Pet.name,Pet.breed,Pet.profileIMG,Pet.vaccinationPlanIMG,Pet.observation,Pet.idSize
        ,Pet.idPetType,Pet.idUser)
    VALUES
        (name,breed,profileIMG,vaccinationPlanIMG,observation,idSize,idPetType,idUser);
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
CALL User_Login("planetar","orylOSad",@rta);
SELECT @rta;
/*CALL User_Add(username,password,email,idData);*/
Call User_Add("pablitoClavito","ClavitoCrack","pablitoElCrack@gmail.com",5);
/*CALL User_Add(username,password,email);*/
Call User_Register("pablitoClavito","ClavitoCrack","pablitoElCrack@gmail.com");
/*Call User_Delete(6);*/


/*********************************TEST USERROLE*******************************************/
Call URole_GetAll();
Call URole_GetById(2);
/*CALL Owner_Add(idUser,idRole);*/
Call URole_Add(1,2);
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
Call Pet_GetByOwner(2);
/*CALL Size_Add(name,breed,profileIMG,vaccinationPlanIMG,observation,idSize,idPetType,idOwner);*/
Call Pet_Add("Salchichon","Suricatta","C:\xampp\htdocs\Pet-Hero\Pet Hero\PetImg/SurS-181020222211.jpg"
						,"C:\xampp\htdocs\Pet-Hero\Pet Hero\VacImg/SurS-181020222211.jpg"
						,"Tiene 6 dedos",1,5,3);
/*Call Pet_Delete(6);*/


	