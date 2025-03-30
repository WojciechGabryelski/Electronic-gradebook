CREATE DATABASE dziennik;
USE dziennik;
CREATE TABLE uczen (pesel varchar(11) PRIMARY KEY, imie varchar(30), nazwisko varchar(50), data_urodzenia date, login varchar(20), haslo varchar(500));
CREATE TABLE przedmioty(id int PRIMARY KEY AUTO_INCREMENT, nazwa varchar(30));
CREATE TABLE oceny (id int PRIMARY KEY AUTO_INCREMENT, ocena varchar(2), pesel varchar(11), id_przedmiotu int, data date, FOREIGN KEY (pesel) REFERENCES uczen(pesel) ON DELETE CASCADE, FOREIGN KEY (id_przedmiotu) REFERENCES przedmioty(id) ON DELETE CASCADE);
CREATE TABLE nauczyciel(pesel varchar(11) PRIMARY KEY, imie varchar(30), nazwisko varchar(50), data_urodzenia date, login varchar(20), haslo varchar(500));
CREATE TABLE admin(pesel varchar(11) PRIMARY KEY, imie varchar(30), nazwisko varchar(50), data_urodzenia date, login varchar(20), haslo varchar(500));
CREATE TABLE nauczyciel_przedmiot(id int AUTO_INCREMENT PRIMARY KEY, pesel varchar(11), id_przedmiotu int, FOREIGN KEY (pesel) REFERENCES nauczyciel(pesel) ON DELETE CASCADE, FOREIGN KEY (id_przedmiotu) REFERENCES przedmioty(id) ON DELETE CASCADE);

DELIMITER $$
CREATE TRIGGER adminOnInsert BEFORE INSERT ON admin
FOR EACH ROW
BEGIN
	DECLARE pes varchar(11) DEFAULT NULL;
	SET pes = (SELECT pesel FROM uczen WHERE login = NEW.login);
        IF pes IS NOT NULL THEN
    	    signal sqlstate '45000';
        END IF;
        SET pes = (SELECT pesel FROM nauczyciel WHERE login = NEW.login);
        IF pes IS NOT NULL THEN
    	    signal sqlstate '45000';
        END IF;
	IF CHK_PESEL(NEW.pesel, NEW.data_urodzenia) = 1 THEN
        SET pes = (SELECT pesel FROM uczen WHERE pesel = NEW.pesel);
        IF pes IS NOT NULL THEN
            IF (SELECT imie, nazwisko FROM uczen WHERE pesel = NEW.pesel) != (NEW.imie, NEW.nazwisko) THEN
              	signal sqlstate '45000';
            END IF;
        END IF;
        SET pes = (SELECT pesel FROM nauczyciel WHERE pesel = NEW.pesel);
        IF pes IS NOT NULL THEN
            IF (SELECT imie, nazwisko FROM nauczyciel WHERE pesel = NEW.pesel) != (NEW.imie, NEW.nazwisko) THEN
            	signal sqlstate '45000';
            END IF;
        END IF;
    ELSE
    	signal sqlstate '45000';
	END IF;
END$$
DELIMITER ;

-- Pozostałe triggery są bardzo podobne, więc nie ma sensu wklejać każdego (zmiany są tylko w nazwach tabel i w rodzaju sytuacji, kiedy wykonuje się trigger).

DELIMITER $$
CREATE FUNCTION CHK_PESEL(PESEL char(11), data_urodzenia date) RETURNS int DETERMINISTIC
BEGIN
    DECLARE i int DEFAULT 0;
    DECLARE ctrl int DEFAULT 0;
    DECLARE s char(4) DEFAULT '1379';
    DECLARE y, m, d int;
    IF PESEL LIKE '%[!0-9]%' OR LENGTH(PESEL) < 11 THEN
	RETURN 0;
    END IF;
    WHILE i<10 DO
	SET ctrl = ctrl + (ASCII(RIGHT(PESEL, 11-i))-48)*(ASCII(RIGHT(s, 4-i%4))-48)%10;
        SET i = i + 1;
    END WHILE;
    SET ctrl = (10-ctrl%10)%10;
    IF ASCII(RIGHT(PESEL, 1))-48 = ctrl THEN
	SET y = (ASCII(PESEL)-48)*10+ASCII(RIGHT(PESEL, 10))-48;
        SET m = (ASCII(RIGHT(PESEL, 9))-48)*10+ASCII(RIGHT(PESEL, 8))-48;
        SET d = (ASCII(RIGHT(PESEL, 7))-48)*10+ASCII(RIGHT(PESEL, 6))-48;
        SET y = y + CASE WHEN (m-m%20)/20 = 4 THEN 1800 WHEN (m-m%20)/20 = 0 THEN 1900
        WHEN (m-m%20)/20 = 1 THEN 2000 WHEN (m-m%20)/20 = 2 THEN 2100 ELSE 2200 END;
        SET m = m%20;
        IF YEAR(data_urodzenia) = y AND MONTH(data_urodzenia) = m AND DAY(data_urodzenia) = d THEN
	    RETURN 1;
	END IF;
    END IF;
    RETURN 0;
END$$
DELIMITER ;

INSERT INTO admin VALUES ('64010297933', 'Adam', 'Nowak', '1964-01-02', 'Adam', '$2y$10$mWE19fziIbFVmS2vY3LV1eFKBaXbIDin7JUQqBVLPqH8LQPQv86NW'); -- hasło to nazwisko
