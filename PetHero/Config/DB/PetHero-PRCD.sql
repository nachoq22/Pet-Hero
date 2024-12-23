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

CREATE PROCEDURE Location_GetAll()
BEGIN
    SELECT * 
    FROM Location;
END;

CREATE PROCEDURE Location_GetById(IN idLocation INT)
BEGIN
    SELECT * 
    FROM Location
    WHERE (Location.idLocation = idLocation);
END;


CREATE PROCEDURE Location_GetByAll(IN adress VARCHAR(50),IN neighborhood VARCHAR(50),IN city VARCHAR(50),
                              IN province VARCHAR(50),IN country VARCHAR(50))
BEGIN
    SELECT * 
    FROM Location
    WHERE (Location.adress = adress AND Location.neighborhood = neighborhood AND Location.city = city 
		   AND Location.province = province AND Location.country = country);
END;

CREATE PROCEDURE Location_Add(IN adress VARCHAR(50),IN neighborhood VARCHAR(50),IN city VARCHAR(50),
                              IN province VARCHAR(50),IN country VARCHAR(50))
BEGIN
    INSERT INTO Location
        (Location.adress,Location.neighborhood,Location.city,Location.province,Location.country)
    VALUES
        (adress,neighborhood,city,province,country);
END;

CREATE PROCEDURE Location_Delete(IN idLocation INT)
BEGIN
    DELETE 
    FROM Location
    WHERE (Location.idLocation = idLocation);
END;


/*********************************PROCEDURES PERSONAL DATA*******************************************/

CREATE PROCEDURE PersonalData_GetAll()
BEGIN
    SELECT * 
    FROM PersonalData;
END;

CREATE PROCEDURE PersonalData_GetById(IN idData INT)
BEGIN
    SELECT * 
    FROM PersonalData
    WHERE (PersonalData.idData = idData);
END;

CREATE PROCEDURE PersonalData_GetByDni(IN dni VARCHAR(8))
BEGIN
    SELECT * 
    FROM PersonalData
    WHERE (PersonalData.dni = dni);
END;

CREATE PROCEDURE PersonalData_Add(IN name VARCHAR(50),IN surname VARCHAR(50),IN sex VARCHAR(1),
                                    IN dni VARCHAR(8),IN idLocation INT)
BEGIN
    INSERT INTO PersonalData
        (PersonalData.name,PersonalData.surname,PersonalData.sex,PersonalData.dni,PersonalData.idLocation)
    VALUES
        (name,surname,sex,dni,idLocation);
END;

CREATE PROCEDURE PersonalData_Delete(IN idData INT)
BEGIN
    DELETE 
    FROM PersonalData
    WHERE (PersonalData.idData = idData);
END;


/*********************************PROCEDURES USER*******************************************/

CREATE PROCEDURE User_GetAll()
BEGIN
    SELECT * 
    FROM User;
END;

CREATE PROCEDURE User_GetById(IN idUser INT)
BEGIN
    SELECT * 
    FROM User
    WHERE (User.idUser = idUser);
END;

CREATE PROCEDURE User_GetByUsername(IN username VARCHAR(50))
BEGIN
    SELECT * 
    FROM User
    WHERE (User.username = username);
END;

CREATE PROCEDURE User_IsExist(IN username VARCHAR(50), IN email VARCHAR(50))
BEGIN
    SELECT COUNT(idUser) as rta
    FROM User
    WHERE (User.username = username) OR (User.email = email);
END;

CREATE PROCEDURE User_Add(IN username VARCHAR(50),IN password VARCHAR(30),IN email VARCHAR(50))
BEGIN
    INSERT INTO User
        (User.username,User.password,User.email)
    VALUES
        (username,password,email);
END;

CREATE PROCEDURE User_HookData(IN idUser INT,IN idData INT)
BEGIN
    UPDATE User
	SET User.idData = idData
	WHERE User.idUser = idUser;
END;

CREATE PROCEDURE User_Register(IN username VARCHAR(50),IN password VARCHAR(30),IN email VARCHAR(50))
BEGIN
    INSERT INTO User
        (User.username,User.password,User.email)
    VALUES
        (username,password,email);
END;

CREATE PROCEDURE User_Login(IN username VARCHAR(20),IN password VARCHAR(20))
BEGIN
    SELECT COUNT(idUser) as rta
    FROM User
    WHERE User.username = username AND User.password = password;
END;

CREATE PROCEDURE User_Delete(IN idUser INT)
BEGIN
    DELETE 
    FROM User
    WHERE (User.idUser = idUser);
END;

/*********************************PROCEDURE ROLE*******************************************/

CREATE PROCEDURE Role_GetAll()
BEGIN
    SELECT * 
    FROM Role;
END;

CREATE PROCEDURE Role_GetById(IN idRole INT)
BEGIN
    SELECT * 
    FROM Role
    WHERE (Role.idRole = idRole);
END;

CREATE PROCEDURE Role_GetByName(IN name VARCHAR(30))
BEGIN
    SELECT * 
    FROM Role
    WHERE (Role.name = name);
END;

CREATE PROCEDURE Role_Add(name VARCHAR(30),description VARCHAR(250))
BEGIN
    INSERT INTO Role
        (Role.name,Role.description)
    VALUES
        (name,description);
END;

CREATE PROCEDURE Role_Delete(IN idRole INT)
BEGIN
    DELETE 
    FROM Role
    WHERE (Role.idRole = idRole);
END;


/*********************************PROCEDURE USERROLE*******************************************/
CREATE PROCEDURE UR_GetAll()
BEGIN
    SELECT * 
    FROM UserRole;
END;

CREATE PROCEDURE UR_GetById(IN idUR INT)
BEGIN
    SELECT * 
    FROM UserRole
    WHERE (UserRole.idUR = idUR);
END;

CREATE PROCEDURE UR_IsKeeper(IN idUser INT)
BEGIN
    SELECT COUNT(idUser) as rta 
    FROM UserRole
    WHERE (UserRole.idUser = idUser) AND (UserRole.idRole = 2);
END;

CREATE PROCEDURE UR_Add(IN idUser INT,IN idRole INT)
BEGIN
    INSERT INTO UserRole
        (UserRole.idUser,UserRole.idRole)
    VALUES
        (idUser,idRole);
END;

CREATE PROCEDURE UR_UserToOwner(IN idUser INT)
BEGIN
    INSERT INTO UserRole
        (UserRole.idUser,UserRole.idRole)
    VALUES
        (idUser,1);
END;

CREATE PROCEDURE UR_UserToKeeper(IN idUser INT)
BEGIN
    INSERT INTO UserRole
        (UserRole.idUser,UserRole.idRole)
    VALUES
        (idUser,2);
END;

CREATE PROCEDURE UR_Delete(IN idUR INT)
BEGIN
    DELETE 
    FROM UserRole
    WHERE (UserRole.idUR = idUR);
END;


/*********************************PROCEDURES SIZE*******************************************/
CREATE PROCEDURE Size_GetAll()
BEGIN
    SELECT * 
    FROM Size;
END;

CREATE PROCEDURE Size_GetById(IN idSize INT)
BEGIN
    SELECT * 
    FROM Size
    WHERE (Size.idSize = idSize);
END;

CREATE PROCEDURE Size_GetByName(IN name VARCHAR(30))
BEGIN
    SELECT * 
    FROM Size
    WHERE (Size.name = name);
END;

CREATE PROCEDURE Size_Add(IN name VARCHAR(30))
BEGIN
    INSERT INTO Size
        (Size.name)
    VALUES
        (name);
END;

CREATE PROCEDURE Size_Delete(IN idSize INT)
BEGIN
    DELETE 
    FROM Size
    WHERE (Size.idSize = idSize);
END;


/*********************************PROCEDURES PETTYPE*******************************************/
CREATE PROCEDURE PetType_GetAll()
BEGIN
    SELECT * 
    FROM PetType;
END;

CREATE PROCEDURE PetType_GetById(IN idType INT)
BEGIN
    SELECT * 
    FROM PetType
    WHERE (PetType.idType = idType);
END;

CREATE PROCEDURE PetType_GetByName(IN name VARCHAR(30))
BEGIN
    SELECT * 
    FROM PetType
    WHERE (PetType.name = name);
END;

CREATE PROCEDURE PetType_Add(IN name VARCHAR(30))
BEGIN
    INSERT INTO PetType
        (PetType.name)
    VALUES
        (name);
END;

CREATE PROCEDURE PetType_Delete(IN idType INT)
BEGIN
    DELETE 
    FROM PetType
    WHERE (PetType.idType = idType);
END;


/*********************************PROCEDURES PET*******************************************/

CREATE PROCEDURE Pet_GetAll()
BEGIN
    SELECT * 
    FROM Pet;
END;

CREATE PROCEDURE Pet_GetById(IN idPet INT)
BEGIN
    SELECT * 
    FROM Pet
    WHERE (Pet.idPet = idPet);
END;

CREATE PROCEDURE Pet_GetByUser(IN idUser INT)
BEGIN
    SELECT * 
    FROM Pet
    WHERE (Pet.idUser = idUser);
END;

CREATE PROCEDURE Pet_Add(IN name VARCHAR(50), IN breed VARCHAR(50), IN profileIMG VARCHAR(250),
                         IN vaccinationPlanIMG VARCHAR(250), IN observation VARCHAR(200), IN idSize INT,
	                     IN idType INT, IN idUser INT)
BEGIN
    INSERT INTO Pet
        (Pet.name,Pet.breed,Pet.profileIMG,Pet.vaccinationPlanIMG,Pet.observation,Pet.idSize
        ,Pet.idType,Pet.idUser)
    VALUES
        (name,breed,profileIMG,vaccinationPlanIMG,observation,idSize,idType,idUser);
END;

CREATE PROCEDURE Pet_Delete(IN idPet INT)
BEGIN
    DELETE 
    FROM Pet
    WHERE (Pet.idPet = idPet);
END;


/*********************************PROCEDURES SECOND PART*******************************************/
/*********************************PROCEDURES PUBLICATION*******************************************/

CREATE PROCEDURE Publication_GetAll()
BEGIN
    SELECT *
    FROM Publication WHERE Publication.active = 1;
END;


CREATE PROCEDURE Publication_GetAllByRangeDates(IN initD DATE, IN finishD DATE)
BEGIN
    SELECT *
    FROM Publication
    WHERE Publication.openD <= initD AND Publication.closeD >= finishD AND Publication.active = 1;
END;

CREATE PROCEDURE Publication_GetById(IN idPublication INT)
BEGIN
    SELECT * 
    FROM Publication
    WHERE (Publication.idPublic = idPublication) AND Publication.active = 1;
END;

CREATE PROCEDURE Publication_GetByUser(IN idUser INT)
BEGIN
    SELECT * 
    FROM publication
    WHERE (publication.idUser = idUser) AND Publication.active = 1;
END;

CREATE PROCEDURE Publication_Search(IN phrase VARCHAR(50))
BEGIN
     SELECT DISTINCT p.idPublic, p.openD, p.closeD, p.title, p.description, p.popularity, p.remuneration, p.active, p.idUser
     FROM publication AS P
     INNER JOIN User ON P.idUser = User.idUser
     INNER JOIN PersonalData ON PersonalData.idData = User.idData
     INNER JOIN Location ON Location.idLocation = PersonalData.idLocation
     WHERE P.title LIKE CONCAT('%',phrase,'%') 
        OR P.description like CONCAT('%',phrase,'%')
        OR User.username LIKE CONCAT('%',phrase,'%')
        OR PersonalData.name LIKE CONCAT('%',phrase,'%')
        OR PersonalData.surname LIKE CONCAT('%',phrase,'%')
        OR Location.city LIKE CONCAT('%',phrase,'%')
        OR Location.province LIKE CONCAT('%',phrase,'%')
        OR Location.country LIKE CONCAT('%',phrase,'%')
        AND P.active = 1;
END;

CREATE PROCEDURE Publication_DateCheck(IN openD DATE, IN closeD DATE, IN idPublic INT)
BEGIN
    SELECT COUNT(idPublic) as rta 
    FROM publication
    WHERE (publication.idPublic = idPublic) AND (publication.openD < openD) AND (publication.closeD >= closeD) AND Publication.active = 1;
END;

CREATE PROCEDURE Publication_NIDate(IN openD DATE, IN closeD DATE, IN idUser int, IN idPublicIN int)
BEGIN
    SELECT COUNT(*) > 0 AS rta FROM publication
        WHERE publication.idUser = idUser
        AND publication.active = 1
        AND publication.idPublic != idPublicIN
        AND (
            (publication.openD BETWEEN openD AND closeD) 
            OR 
            (publication.closeD BETWEEN openD AND closeD) 
            OR 
            (publication.openD <= openD AND publication.closeD >= closeD));
END;
   

CREATE PROCEDURE Publication_Add(IN openD DATE, IN closeD DATE, IN title VARCHAR(50),
                         IN description VARCHAR(1000), IN popularity DEC(2,1), IN remuneration DEC(10,2),
	                     IN idUser INT)
BEGIN
    INSERT INTO Publication
        (Publication.openD,Publication.closeD,Publication.title,Publication.description,Publication.popularity
        ,Publication.remuneration,Publication.active,Publication.idUser)
    VALUES
        (openD,closeD,title,description,popularity,remuneration,1,idUser);

	SELECT LAST_INSERT_ID() as LastID;
END;



CREATE PROCEDURE Publication_UpdatePopularity(IN idPublic INT, IN score DEC(2,1))
BEGIN
    UPDATE publication
        SET publication.popularity = score
    WHERE publication.idPublic = idPublic;
END;


CREATE PROCEDURE Publication_Update (IN idPublicIn INT,
                                 IN openDIn DATE, IN closeDIn DATE, IN titleIn VARCHAR(50),
                                 IN descriptionIn VARCHAR(1000), 
                                 IN remunerationIn DEC(10,2))
BEGIN
UPDATE Publication p SET openD =  openDIn, closeD = closeDIn, title = titleIn
                       , description = descriptionIn , remuneration = remunerationIn
                    WHERE idPublic = idPublicIn AND p.active = 1;
END;                                                            


CREATE PROCEDURE Publication_Delete(IN idPublic INT)
BEGIN
    UPDATE Publication SET active = 0 WHERE Publication.`idPublic` = idPublic;
END;


/*********************************PROCEDURES IMAGES*******************************************/

CREATE PROCEDURE ImgPublic_GetAll()
BEGIN
    SELECT *
    FROM ImgPublic;
END;


CREATE PROCEDURE ImgPublic_GetById(IN idImg INT)
BEGIN
    SELECT * 
    FROM ImgPublic
    WHERE (ImgPublic.idImg = idImg);
END;

CREATE PROCEDURE ImgPublic_GetByPublic(IN idPublic INT)
BEGIN
    SELECT * 
    FROM ImgPublic
    WHERE (ImgPublic.idPublic = idPublic);
END;

CREATE PROCEDURE ImgPublic_Add(IN uri varchar(250), IN idPublic INT)
BEGIN
    INSERT INTO ImgPublic
        (ImgPublic.uri,ImgPublic.idPublic)
    VALUES
        (uri,idPublic);
END;

CREATE PROCEDURE ImgPublic_Delete(IN idImg INT)
BEGIN
    DELETE 
    FROM ImgPublic
    WHERE (ImgPublic.idImg = idImg);
END;



/*********************************PROCEDURES BOOKING*******************************************/
CREATE PROCEDURE Booking_GetAll()
BEGIN
    SELECT * 
    FROM Booking;
END;

CREATE PROCEDURE Booking_GetAllByPublication(IN idPublic INT)
BEGIN
    SELECT * FROM Booking
    WHERE (Booking.idPublic = idPublic);
END;

CREATE PROCEDURE Booking_GetById(IN idBook INT)
BEGIN
    SELECT * 
    FROM Booking
    WHERE (Booking.idBook = idBook);
END;

CREATE PROCEDURE Booking_GetByUser(IN idUser INT)
BEGIN
    SELECT * 
    FROM booking
    WHERE (booking.idUser = idUser);
END;

CREATE PROCEDURE Booking_GetBookigDayDiff(IN startD DATE, IN finishD DATE)
BEGIN
    SELECT TIMESTAMPDIFF(DAY, startD, finishD) AS bookingDayDiff;
END;

CALL Booking_GetBookigDayDiff("2024-12-28","2024-12-30");
CALL Booking_GetBookigDayDiff("2024-12-1","2024-12-5");

CREATE PROCEDURE Booking_CheckRange(IN startD DATE, IN finishD DATE, IN idPublic INT)
BEGIN
    SELECT *
    FROM booking
     WHERE (booking.idPublic=idPublic) AND (booking.bookState ="Waiting Start" OR booking.bookState="In Progress" OR booking.bookState="Awaiting Payment") AND ((booking.startD >= startD AND booking.startD <= finishD) 
            OR (booking.startD <= startD AND booking.finishD >= startD));
END;

CREATE PROCEDURE Booking_Add(IN startD DATE, IN finishD DATE, IN bookState VARCHAR(25),
                         IN idPublic INT, IN idUser INT)
BEGIN
    INSERT INTO Booking
        (Booking.startD, Booking.finishD, Booking.bookState, Booking.idPublic, Booking.idUser)
    VALUES
        (startD, finishD, bookState, idPublic, idUser);
	SELECT LAST_INSERT_ID() as LastID;
END;

CREATE PROCEDURE Booking_UpdateST(IN idBook INT, IN bookState VARCHAR(50))
BEGIN
    UPDATE Booking
        SET Booking.bookState = bookState
    WHERE Booking.idBook = idBook;
END;

CREATE PROCEDURE Booking_UpdateCode(IN idBook INT, IN payCode VARCHAR(14))
BEGIN
    UPDATE Booking
        SET Booking.payCode = payCode
    WHERE Booking.idBook = idBook;
END;

CREATE PROCEDURE Booking_Delete(IN idBook INT)
BEGIN
    DELETE 
    FROM Booking
    WHERE (Booking.idBook = idBook);
END;


/*********************************PROCEDURES BOOKING PET*******************************************/


CREATE PROCEDURE BP_GetAll()
BEGIN
    SELECT * 
    FROM BookingPet;
END;

CREATE PROCEDURE BP_GetById(IN idBP INT)
BEGIN
    SELECT * 
    FROM BookingPet
    WHERE (BookingPet.idBP = idBP);
END;

CREATE PROCEDURE BP_GetByBook(IN idBook INT)
BEGIN
    SELECT * 
    FROM BookingPet
    WHERE (BookingPet.idBook = idBook);
END;

CREATE PROCEDURE BP_GetPetPay(IN remuneration DEC(10,2),IN idBook INT)
BEGIN
    SELECT (COUNT(idPet) * remuneration) AS petPay
    FROM BookingPet
    WHERE (BookingPet.idBook = idBook);
END;

CALL BP_GetPetPay(5000.00,11)

CALL BP_GetPetPay(7500.00,10)

CREATE PROCEDURE BP_Add(IN idBook INT, IN idPet INT)
BEGIN
    INSERT INTO BookingPet
        (BookingPet.idBook, BookingPet.idPet)
    VALUES
        (idBook, idPet);
END;
CREATE PROCEDURE BP_Delete(IN idBP INT)
BEGIN
    DELETE 
    FROM BookingPet
    WHERE (BookingPet.idBP = idBP);
END;

/*********************************PROCEDURES CHECKER*******************************************/


CREATE PROCEDURE Checker_GetAll()
BEGIN
    SELECT * 
    FROM Checker;
END;

CREATE PROCEDURE Checker_GetById(IN idChecker INT)
BEGIN
    SELECT * 
    FROM Checker
    WHERE (Checker.idChecker= idChecker);
END;

CREATE PROCEDURE Checker_GetByBooking(IN idBook INT)
BEGIN
    SELECT * 
    FROM Checker
    WHERE (Checker.idBook = idBook);
END;

CREATE PROCEDURE Checker_GetByRef(IN refCode VARCHAR(20))
BEGIN
    SELECT * 
    FROM Checker
    WHERE (Checker.refCode = refCode);
END;

CREATE PROCEDURE Checker_Add(IN refCode VARCHAR(20),IN emisionD DATE, IN closeD DATE, IN finalPrice INT, IN idBook INT)
BEGIN
    INSERT INTO Checker
        (Checker.refCode,Checker.emisionD, Checker.closeD, Checker.finalPrice, Checker.idBook)
    VALUES
        (refCode,emisionD, closeD, finalPrice, idBook);
END;

CREATE PROCEDURE Checker_SetPayD(IN idChecker INT, IN payD DATE)
BEGIN
	UPDATE Checker
    SET Checker.payD = payD
    WHERE Checker.idChecker = idChecker;
END;

CREATE PROCEDURE Checker_Delete(IN idChecker INT)
BEGIN
    DELETE 
    FROM Checker
    WHERE (Checker.idChecker = idChecker);
END;


/*********************************PROCEDURES REVIEW*******************************************/
CREATE PROCEDURE Review_GetAll()
BEGIN
    SELECT * 
    FROM Review;
END;

CREATE PROCEDURE Review_GetById(IN idReview INT)
BEGIN
    SELECT * 
    FROM Review
    WHERE (Review.idReview = idReview);
END;

CREATE PROCEDURE Review_GetByPublic(IN idPublic INT)
BEGIN
    SELECT * 
    FROM Review
    WHERE (Review.idPublic = idPublic);
END;

CREATE PROCEDURE Review_Add(IN createD DATE, IN commentary VARCHAR(500), IN stars INT,
                            IN idUser INT, IN idPublic INT)
BEGIN
    INSERT INTO Review
        (Review.createD, Review.commentary, Review.stars, Review.idUser,Review.idPublic)
    VALUES
        (createD, commentary, stars, idUser, idPublic);
END;

CREATE PROCEDURE Review_Delete(IN idReview INT)
BEGIN
    DELETE 
    FROM Review
    WHERE (Review.idReview = idReview);
END;


/*********************************PROCEDURES CHAT*******************************************/

CREATE PROCEDURE Chat_GetAll()
BEGIN
    SELECT * 
    FROM Chat;
END;

CREATE PROCEDURE Chat_GetById(IN idChat INT)
BEGIN
    SELECT * 
    FROM Chat
    WHERE (Chat.idChat = idChat);
END;

CREATE PROCEDURE Chat_GetByUsers(IN idUser1 INT, IN idUser2 INT)
BEGIN
	SELECT * 
    FROM Chat
    WHERE (Chat.idOwner = idUser1 AND Chat.idKeeper = idUser2) OR (Chat.idOwner = idUser2 AND chat.idKeeper = idUser1);
END;

CREATE PROCEDURE Chat_GetByUser(IN idUser INT)
BEGIN
	SELECT * 
    FROM Chat
	WHERE (Chat.idOwner = idUser XOR Chat.idKeeper=idUser);
END;

CREATE PROCEDURE Chat_Add(IN idOwner INT, IN idKeeper INT)
BEGIN
    INSERT INTO Chat
        (Chat.idOwner, Chat.idKeeper)
    VALUES
        (idOwner, idKeeper);
	SELECT LAST_INSERT_ID() as LastID;
END;

CREATE PROCEDURE Chat_Delete(IN idChat INT)
BEGIN
    DELETE 
    FROM Chat
    WHERE (Chat.idReview = idReview);
END;



/*********************************PROCEDURES MESSAGECHAT*******************************************/


CREATE PROCEDURE MessageChat_GetAll()
BEGIN
    SELECT * 
    FROM MessageChat;
END;

CREATE PROCEDURE MessageChat_GetById(IN idMessageChat INT)
BEGIN
    SELECT * 
    FROM MessageChat
    WHERE (MessageChat.idMessageChat = idMessageChat);
END;

CREATE PROCEDURE MessageChat_Add(IN message VARCHAR(500), IN dateTime DATETIME, IN idChat INT, IN idSender INT)
BEGIN
    INSERT INTO MessageChat
        (MessageChat.message, MessageChat.dateTime, MessageChat.idChat, MessageChat.idSender)
    VALUES
        (message, dateTime, idChat, idSender);
END;

CREATE PROCEDURE MessageChat_GetAllMsgByChat(IN idChat INT)
BEGIN
	SELECT *
    FROM MessageChat
    WHERE (MessageChat.idChat = idChat);
END;

CREATE PROCEDURE MessageChat_GetLastMsgByChat(IN idChat INT)
BEGIN
	SELECT * 
    FROM MessageChat
    WHERE MessageChat.idChat = idChat ORDER BY MessageChat.dateTime DESC LIMIT 1;
END; 

CREATE PROCEDURE MessageChat_Delete(IN idMessageChat INT)
BEGIN
    DELETE 
    FROM MessageChat
    WHERE (MessageChat.idMessageChat = idMessageChat);
END;




                /*********************************TEST PROCEDURES*******************************************/

/*********************************TEST LOCATION*******************************************/
#CALL Location_GetAll();
/*CALL Location_GetById(ID);*/
#CALL Location_GetById(2);
/*CALL Location_Add(adress,neighborhood,city,province,country);*/
#CALL Location_Add("Mi calle","Mi Barrio","Mar del plata","Buenos Aires","Argentina");
/*CALL Location_Delete(ID);*/
/*CALL Location_Delete(6);*/

/*********************************TEST PERSONAL DATA*******************************************/
#CALL PersonalData_GetAll(); 
#CALL PersonalData_GetById(2);
/*CALL PersonalData_Add(name,surname,sex,dni,idLocation);*/
#Call PersonalData_Add("Bryan","Heads","M","44886655",6);
/*Call PersonalData_Delete(6);*/

/*********************************TEST USER*******************************************/
#Call User_GetAll();
#Call User_GetById(2);
#Call User_GetByUsername("planetar");
/*CALL User_Add(username,password,varResp);*/
#CALL User_IsExist("planetar","achternaga@wificon.eu");
#CALL User_Login("planetar","orylOSad");

/*CALL User_Add(username,password,email,idData);*/
#Call User_Add("Pablo","Tringuin","triguillo@gmail.com");
#Call User_Add("Pablito","Caño","triiiguillo@gmail.com");
/*CALL User_Add(username,password,email);*/
#Call User_Register("Eduardo","Manitas","manitasDeManteca@gmail.com");
/*Call User_Delete(6);*/

/*********************************TEST USERROLE*******************************************/
#Call UR_GetAll();
#Call UR_GetById(2);
/*CALL Owner_Add(idUser,idRole);*/
/*Call URole_Add(6,2);*/
#Call UR_IsKeeper(3);
#Call UR_UserToKeeper(6);
/*Call Owner_Delete(6);*/

/*********************************TEST SIZE*******************************************/
#Call Size_GetAll();
#Call Size_GetById(2);
/*CALL Size_Add(name);*/
#Call Size_Add("Big-Extra");
/*Call Size_Delete(6);*/

/*********************************TEST PETTYPE*******************************************/
#Call PetType_GetAll();
#Call PetType_GetById(2);
#Call PetType_GetByName("Dog");
/*CALL PetType_Add(name);*/
#Call PetType_Add("Cacatuos");
/*Call PetType_Delete(6);*/

/*********************************TEST PET*******************************************/
#Call Pet_GetAll();
#Call Pet_GetById(2);
#Call Pet_GetByUser(2);
/*CALL Size_Add(name,breed,profileIMG,vaccinationPlanIMG,observation,idSize,idPetType,idUser);*/
/*Call Pet_Add("Salchichon","Suricatta",CONCAT("..\\Views\\Img\\IMGPet\\Profile\\Salchichon",(NOW() + 0),".jpg")
						,CONCAT("..\\Views\\Img\\IMGPet\\VaccinationPlan\\Salchichon",(NOW() + 0),".jpg")
						,"Tiene 6 dedos",1,5,3);*/
/*Call Pet_Delete(6);*/

/*********************************TEST PUBLICATION*******************************************/
#CALL Publication_GetAll();
#CALL Publication_GetById(1);
#CALL Publication_GetByUser(1);
#CALL Publication_Search("playa");
/*CALL Publication_Add(openD,closeD,title,description,popularity,remuneration,idUser);*/
-- CALL Publication_Add("2022-10-30","2022-11-08", "El mejor cuidador de toda Mar Del Plata",
--                      "Mascota correr, mascota feliz", 0,4000,2);
-- CALL Publication_Delete(6);
#CALL Publication_DateCheck("2022-10-31", "2022-11-10", 1);
#CALL Publication_UpdatePopularity(1, 3);
#CALL Publication_NIDate("2022-12-15","2023-01-12" ,1);


/*********************************TEST IMAGES*******************************************/
#CALL ImgPublic_GetAll();
#CALL ImgPublic_GetById(1);
#CALL ImgPublic_GetByPublic(1);
/*CALL ImgPublic_Add(IN url varchar(250), IN idPublication INT)*/
#CALL ImgPublic_Add("www.holaSoyUnaURL.com", 1);
/*CALL ImgPublic_Delete(1);*/

/*********************************TEST BOOKING*******************************************/
#CALL Booking_GetAll();
#CALL Booking_GetById(1);
#CALL Booking_GetByUser(4);
/*CREATE PROCEDURE Booking_GetBookigPay(IN startD DATE,IN finishD DATE, IN remuneration DEC(10,2))*/
#CALL Booking_GetBookigPay('2022-11-06','2022-11-10',50);
/*CALL Booking_Add(IN openDate DATE, IN closeDate DATE, IN payState VARCHAR(25), IN payCode VARCHAR(10),
                         IN idPublication INT, IN idUser INT)*/
#CALL Booking_Add("2022-10-15","2022-11-15","In Review",1, 1);
#CALL Booking_CheckRange("2022-09-17", "2022-09-22", 1); /*ARRANCA ANTES TERMINA ANTES ANDA BIEN */
#CALL Booking_CheckRange("2022-09-17", "2022-11-13", 1); #ARRANCA ANTES TERMINA EN EL MEDIO -CONTEMPLA
#CALL Booking_CheckRange("2022-08-17", "2022-12-19", 1); #ARRANCA ANTES TERMINA DESPUES -CONTEMPLA
#CALL Booking_CheckRange("2022-10-17", "2022-11-12", 1); #ARRANCA EN EL MEDIO TERMINA EN EL MEDIO -CONTEMPLA
#CALL Booking_CheckRange("2022-10-17", "2022-12-28", 1); #ARRANCA EN EL MEDIO TERMINA DESPUES -CONTEMPLA 
#CALL Booking_CheckRange("2022-11-21", "2022-12-14", 1); #ARRANCA DESPUES TERMINA DESPUES -CONTEMPLA
/*CALL Booking_UpdateST(IN idBook DATE, IN bookState VARCHAR(25))*/
#CALL Booking_UpdateST(2,"Awaiting Payment");
#CALL Booking_GetAllByPublication(8);
/*CALL Booking_Delete(2);*/

/*********************************TEST BOOKING PET*******************************************/
#CALL BP_GetAll();
#CALL BP_GetById(1);
#CALL BP_GetByBook(4);
/*CALL BookingPet_Add(IN idBooking INT, IN idPet INT);*/
/*CALL BP_GetPetPay(remuneration,idBooking);*/
#CALL BP_GetPetPay(500,2);
#CALL BP_Add(1,1);
/*CALL BookingPet_Delete(1);*/

/*********************************TEST CHECKER*******************************************/
#CALL Checker_GetAll();
#CALL Checker_GetById(1);
#CALL Checker_GetByBooking(1);
/*CALL Checker_AddChecker_Add(IN emisionD DATE, IN closeD DATE, IN finalPrice INT, IN idBook INT);*/
#CALL Checker_Add("2022-11-05", "2022-12-05", 2000, 1);
/*CALL Checker_Delete(1);*/

/*********************************TEST REVIEW*******************************************/
#CALL Review_GetAll();
#CALL Review_GetById(1);
#CALL Review_GetByPublic(3);
/*CALL Review_Add(IN createD DATE, IN commentary VARCHAR(500), IN stars INT,
                            IN idUser INT, IN idPublication INT)*/
#CALL Review_Add("2022-11-01", "Muy bueno, excelente servicio", 5, 4, 2);
/*CALL Review_Delete(1);*/


/*********************************TEST CHAT*******************************************/
#CALL Chat_GetAll();
#CALL Chat_GetById(1);
#CALL Chat_GetByUsers(6,1);
#CALL Chat_GetByUser(4);
#CALL Chat_Add(1,6);
/*CALL Chat_Delete(1);*/


/*********************************TEST MESSAGECHAT*******************************************/
#CALL MessageChat_GetAll();
#CALL MessageChat_GetById(1);
#CALL MessageChat_Add("Te agradezco por todo, un saludo enorme", "2023-12-12 23:55:40", 7, 8);
#CALL MessageChat_GetAllMsgByChat(2);
/*CALL MessageChat_Delete(1);*/
#CALL MessageChat_GetLastMsgByChat(7);

