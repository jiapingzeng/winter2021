DROP TABLE IF EXISTS Person;
DROP TABLE IF EXISTS Organization;
DROP TABLE IF EXISTS Affiliation;
DROP TABLE IF EXISTS NobelPrize;
DROP TABLE IF EXISTS Place;
DROP TABLE IF EXISTS Laureate;

CREATE TABLE Laureate(id INT, type VARCHAR(20), PRIMARY KEY(id));
CREATE TABLE Place(id INT, city VARCHAR(50), country VARCHAR(50), PRIMARY KEY(id));
CREATE TABLE Person(lid INT, givenName VARCHAR(50), familyName VARCHAR(50), gender VARCHAR(20), birth DATE, pid int, FOREIGN KEY(lid) REFERENCES Laureate(id), FOREIGN KEY(pid) REFERENCES Place(id));
CREATE TABLE Organization(lid INT, orgName VARCHAR(50), founded DATE, pid INT, FOREIGN KEY(lid) REFERENCES Laureate(id), FOREIGN KEY(pid) REFERENCES Place(id));
CREATE TABLE Affiliation(lid INT, name VARCHAR(50), pid INT, FOREIGN KEY(lid) REFERENCES Laureate(id), FOREIGN KEY(pid) REFERENCES Place(id));
CREATE TABLE NobelPrize(lid INT, awardYear INT, category VARCHAR(50), sortOrder INT, portion VARCHAR(10), prizeStatus VARCHAR(20), dateAwarded DATE, motivation VARCHAR(500), prizeAmount INT, FOREIGN KEY(lid) REFERENCES Laureate(id));

LOAD DATA LOCAL INFILE "/home/cs143/shared/p3/data/laureate.del" INTO TABLE Laureate FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE "/home/cs143/shared/p3/data/place.del" INTO TABLE Place FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE "/home/cs143/shared/p3/data/person.del" INTO TABLE Person FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE "/home/cs143/shared/p3/data/organization.del" INTO TABLE Organization FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE "/home/cs143/shared/p3/data/affiliation.del" INTO TABLE Affiliation FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
LOAD DATA LOCAL INFILE "/home/cs143/shared/p3/data/nobel-prize.del" INTO TABLE NobelPrize FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"';
