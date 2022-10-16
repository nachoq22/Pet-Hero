USE petHero;

/*********************************PROCEDURES*******************************************/
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
CREATE PROCEDURE Location_Add(IN adress VARCHAR(40),IN neighborhood VARCHAR(20), 
                              IN city VARCHAR(20),IN province VARCHAR(30),IN country VARCHAR(20))
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

/*********************************TEST PROCEDURES*******************************************/
CALL Location_GetAll();
/*CALL Location_GetById(ID);*/
CALL Location_GetById(13);
/*CALL Location_Add(adress,neighborhood,city,province,country);*/
CALL Location_Add("Mi calle","Mi Barrio","Mar del plata","Buenos Aires","Argentina");
/*CALL Location_Delete(ID);*/
CALL Location_Delete(12);
	


