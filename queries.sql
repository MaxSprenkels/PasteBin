DROP DATABASE IF EXISTS pastebin;

CREATE DATABASE pastebin;

USE pastebin;

CREATE TABLE `databin` (
	Id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    uniqueId VARCHAR(100) NOT NULL,
    userInput TEXT NOT NULL,
    title VARCHAR(100) NOT NULL,
    datePasted varchar(100) NOT NULL,
    prlanguage VARCHAR(100) NOT NULL,
    post_expo VARCHAR(100) NOT NULL
);