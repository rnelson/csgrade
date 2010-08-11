# Creates the database for csgrade, deleting an old one if available
# Version 1.1

DROP DATABASE IF EXISTS csgrade;
CREATE DATABASE csgrade;
USE csgrade;

CREATE TABLE assignment (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255) NOT NULL,
	totalPoints			INTEGER NOT NULL,
	weight				DECIMAL(7, 4) NOT NULL,
	classAverage		DECIMAL(7, 4) NOT NULL,
	classId				INTEGER NOT NULL, # -> singleClass(id)
	
	PRIMARY KEY (id)
);

CREATE TABLE assignmentPart (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255) NOT NULL,
	totalPoints			INTEGER NOT NULL,
	weight				DECIMAL(7, 4) NOT NULL,
	classAverage		DECIMAL(7, 4) NOT NULL,
	assignmentId		INTEGER NOT NULL, # -> assignment(id)
	filePath			VARCHAR(255),
	
	PRIMARY KEY (id)
);

CREATE TABLE comment (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	gradeId				INTEGER DEFAULT 0, # -> grade(id)
	assignmentPartId	INTEGER DEFAULT 0, # -> assignmentPart(id)
	userId				INTEGER NOT NULL, # -> user(id)
	replyId				INTEGER, # -> comment(id)
	commentText			TEXT NOT NULL,
	
	PRIMARY KEY (id)
);

CREATE TABLE grade (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	assignmentPartId	INTEGER NOT NULL, # -> assignmentPart(id)
	studentId			INTEGER NOT NULL, # -> user(id)
	points				INTEGER NOT NULL,
	percentage			DECIMAL(7, 4) NOT NULL,
	commentId			INTEGER,
	
	PRIMARY KEY (id)
);

CREATE TABLE instructorType (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255),
	
	PRIMARY KEY (id)
);

CREATE TABLE instructorClassXref (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	instructorId		INTEGER NOT NULL, # -> user(id)
	classId				INTEGER NOT NULL, # -> singleClass(id)
	instructorTypeId	INTEGER NOT NULL, # -> instructorType(id)
	
	PRIMARY KEY (id)
);

CREATE TABLE priv (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255) NOT NULL,
	bitvalue			BIGINT UNSIGNED NOT NULL,
	
	PRIMARY KEY (id)
);

CREATE TABLE semester (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255) NOT NULL,
	startDate			INTEGER NOT NULL,
	endDate				INTEGER NOT NULL,
	description			TEXT,
	
	PRIMARY KEY (id)
);

CREATE TABLE singleClass (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255) NOT NULL,
	semesterId			INTEGER NOT NULL, # -> semester(id)
	hidden				TINYINT(1),
	
	PRIMARY KEY (id)
);

CREATE TABLE studentClassXref (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	studentId			INTEGER NOT NULL, # -> user(id)
	classId				INTEGER NOT NULL, # -> singleClass(id)
	
	PRIMARY KEY (id)
);

CREATE TABLE user (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	userTypeId			INTEGER NOT NULL, # -> userType(id)
	username			VARCHAR(255) NOT NULL,
	passwd				VARCHAR(255) NOT NULL, # password hash
	firstName			VARCHAR(255),
	lastName			VARCHAR(255),
	email				VARCHAR(255),
	theme				VARCHAR(255) DEFAULT 'default',
	
	PRIMARY KEY (id)
);

CREATE TABLE userType (
	id					INTEGER NOT NULL AUTO_INCREMENT,
	name				VARCHAR(255) NOT NULL,
	privs				INTEGER NOT NULL,
	
	PRIMARY KEY (id)
);

# Insert default values
INSERT INTO priv(name, bitvalue) VALUES ('Guest', 1);
INSERT INTO priv(name, bitvalue) VALUES ('User', 2);
INSERT INTO priv(name, bitvalue) VALUES ('Administrator', 4);

INSERT INTO userType(name, privs) VALUES ('Guest', 1);
INSERT INTO userType(name, privs) VALUES ('User', 3);
INSERT INTO userType(name, privs) VALUES ('Administrator', 7);

INSERT INTO instructorType(name) VALUES ('Instructor');
INSERT INTO instructorType(name) VALUES ('Teaching Assistant');


# TODO: replace these with web config
INSERT INTO user(userTypeId, username, passwd, firstName, lastName, email) VALUES (3, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Local', 'Administrator', 'admin@example.com'); # pass = 'password'


# Add some test data, development-only
INSERT INTO semester(name, startDate, endDate, description) VALUES ('Semester 1', 1266472800, 1275541200, 'Some description here.');
INSERT INTO semester(name, startDate, endDate, description) VALUES ('Semester 2', 1265004000, 1275541200, 'Hi there!');
INSERT INTO singleClass(name, semesterId) VALUES ('Class', 1);
INSERT INTO singleClass(name, semesterId) VALUES ('Class 2', 2);
INSERT INTO userType(name, privs) VALUES ('Test', 3);