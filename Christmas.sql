DROP DATABASE IF EXISTS Christmas;
CREATE DATABASE Christmas;
USE Christmas;

#Represents a person filling out a form
CREATE TABLE PersonOrdering
(
id INT NOT NULL AUTO_INCREMENT,
firstName VARCHAR(20),
lastName VARCHAR(20),
email VARCHAR(40),
PRIMARY KEY(id)
);

#Will insert a default person to just add addresses without having a  head of household
INSERT INTO PersonOrdering (firstName, lastName, email) VALUES ("No", "Name", "ddd");
INSERT INTO PersonOrdering (firstName, lastName, email) VALUES ("Other", "Name", "ff");

#Every house will have an address, and a head of household (default is no one)
CREATE TABLE House
(
id INT NOT NULL AUTO_INCREMENT,
address VARCHAR(40),
headOfHouseholdId INT DEFAULT 1,
PRIMARY KEY (id),
FOREIGN KEY(headOfHouseholdId) REFERENCES PersonOrdering(id)
);

#Not sure if primaryGaurdianId should not be added for flexibility by admins, will have today as birthday by default
CREATE TABLE Childeren
(
cid INT NOT NULL AUTO_INCREMENT,
firstName VARCHAR(20),
lastName VARCHAR(20),
dateOfBirth DATE NOT NULL,
primaryGaurdianId INT DEFAULT 1,
PRIMARY KEY(cid),
FOREIGN KEY(primaryGaurdianId) REFERENCES PersonOrdering(id) 
);

#Default child name
INSERT INTO Childeren (firstName, lastName, dateOfBirth) VALUES ("No", "Name", CURDATE());

#Need to see if can combine ordered by and ordered for ino primary key
#Need to add structure to add info
CREATE TABLE ClothingOrders
(
coid INT NOT NULL AUTO_INCREMENT,
orderedById INT,
orderedForId INT,
PRIMARY KEY(coid),
FOREIGN KEY(orderedById) REFERENCES PersonOrdering(id),
FOREIGN KEY(orderedForId) REFERENCES Childeren(cid)
);