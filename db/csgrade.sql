# Creates the database for csgrade; assumes database does not exist
# Version 1

DROP DATABASE IF EXISTS `csgrade`;
CREATE DATABASE `csgrade`;
USE `csgrade`;

CREATE TABLE `config` (
	`dbVersion`			INTEGER NOT NULL DEFAULT 1,
	`adminName`			VARCHAR(255) NOT NULL,
	`adminEmail`		VARCHAR(255),
	`adminUrl`			VARCHAR(255),
	`defaultFilePath`	VARCHAR(255),
	
	PRIMARY KEY (`dbVersion`)
);

CREATE TABLE `assignment` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`name`				VARCHAR(255) NOT NULL,
	`totalPoints`		INTEGER NOT NULL,
	`weight`			DECIMAL(7, 4) NOT NULL,
	`classAverage`		DECIMAL(7, 4) NOT NULL,
	`classId`			INTEGER NOT NULL, # -> singleClass(id)
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `assignmentPart` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`name`				VARCHAR(255) NOT NULL,
	`totalPoints`		INTEGER NOT NULL,
	`weight`			DECIMAL(7, 4) NOT NULL,
	`classAverage`		DECIMAL(7, 4) NOT NULL,
	`assignmentId`		INTEGER NOT NULL, # -> assignment(id)
	`filePath`			VARCHAR(255),
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `comment` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`gradeId`			INTEGER DEFAULT 0, # -> grade(id)
	`assignmentPartId`	INTEGER DEFAULT 0, # -> assignmentPart(id)
	`userId`			INTEGER NOT NULL, # -> user(id)
	`replyId`			INTEGER, # -> comment(id)
	`commentText`		TEXT NOT NULL,
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `grade` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`assignmentPartId`	INTEGER NOT NULL, # -> assignmentPart(id)
	`studentId`			INTEGER NOT NULL, # -> user(id)
	`points`			INTEGER NOT NULL,
	`percentage`		DECIMAL(7, 4) NOT NULL,
	`commentId`			INTEGER,
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `instructorType` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`name`				VARCHAR(255),
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `instructorClassXref` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`instructorId`		INTEGER NOT NULL, # -> user(id)
	`classId`			INTEGER NOT NULL, # -> singleClass(id)
	`instructorTypeId`	INTEGER NOT NULL, # -> instructorType(id)
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `priv` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`name`				VARCHAR(255) NOT NULL,
	`bitvalue`			INTEGER NOT NULL,
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `semester` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`name`				VARCHAR(255) NOT NULL,
	`startDate`			DATE NOT NULL,
	`endData`			DATE NOT NULL,
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `singleClass` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`name`				VARCHAR(255) NOT NULL,
	`semesterId`		INTEGER NOT NULL, # -> semester(id)
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `studentClassXref` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`studentId`			INTEGER NOT NULL, # -> user(id)
	`classId`			INTEGER NOT NULL, # -> singleClass(id)
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`userTypeId`		INTEGER NOT NULL, # -> userType(id)
	`username`			VARCHAR(255) NOT NULL,
	`passwd`			VARCHAR(255) NOT NULL, # password hash
	`firstName`			VARCHAR(255),
	`lastName`			VARCHAR(255),
	`email`				VARCHAR(255),
	
	PRIMARY KEY (`id`)
);

CREATE TABLE `userType` (
	`id`				INTEGER NOT NULL AUTO_INCREMENT,
	`name`				VARCHAR(255) NOT NULL,
	`privs`				INTEGER NOT NULL,
	
	PRIMARY KEY (`id`)
);
