-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		9/28/2015			     --
--  File:		master.sql				 --
-------------------------------------------

DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users(
	user_id VARCHAR(20) PRIMARY KEY,
	password VARCHAR(32) NOT NULL,
	user_type CHAR(1),
	first_name VARCHAR(128),
	last_name VARCHAR(128),
	email_address VARCHAR(256),
	birth_date DATE,
	enrol_date DATE,
	last_access DATE
);

DROP TABLE IF EXISTS profiles;
CREATE TABLE profiles(
	user_id VARCHAR(20) PRIMARY KEY,
	FOREIGN KEY (user_id) REFERENCES users(user_id),
	gender SMALLINT NOT NULL,
	gender_sought SMALLINT NOT NULL,
	city INTEGER NOT NULL, 
	images SMALLINT NOT NULL DEFAULT '0', 
	headline VARCHAR(100) NOT NULL,
	self_description VARCHAR(1000) NOT NULL,
	match_description VARCHAR(1000) NOT NULL,
    minimum_age SMALLINT NOT NULL,
    maximum_age SMALLINT NOT NULL,
	interests VARCHAR(1000) NOT NULL,
	height DECIMAL(6) NOT NULL,
	body_type INTEGER NOT NULL DEFAULT '0',
	education INTEGER NOT NULL DEFAULT '0',
	smokes INTEGER NOT NULL DEFAULT '0',
	drinks INTEGER NOT NULL DEFAULT '0',
	drugs INTEGER NOT NULL DEFAULT '0',
	status INTEGER NOT NULL DEFAULT '0',
	hair INTEGER NOT NULL DEFAULT '0',
	children INTEGER NOT NULL DEFAULT '0',
	seeking INTEGER NOT NULL DEFAULT '0'
);

DROP TABLE IF EXISTS status;
CREATE TABLE status(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO status(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO status(value, property) VALUES(
	1,
	'Single');
INSERT INTO status(value, property) VALUES(
	2,
	'In a Relationship');
INSERT INTO status(value, property) VALUES(
	4,
	'Married');
INSERT INTO status(value, property) VALUES(
	8,
	'Widowed');
INSERT INTO status(value, property) VALUES(
	16,
	'It''s complicated');
	
DROP TABLE IF EXISTS smokes;
CREATE TABLE smokes(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO smokes(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO smokes(value, property) VALUES(
	1,
	'Never');
INSERT INTO smokes(value, property) VALUES(
	2,
	'Rarely');
INSERT INTO smokes(value, property) VALUES(
	4,
	'Socially');
INSERT INTO smokes(value, property) VALUES(
	8,
	'Often');
	
DROP TABLE IF EXISTS seeking;
CREATE TABLE seeking(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO seeking(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO seeking(value, property) VALUES(
	1,
	'Relationship');
INSERT INTO seeking(value, property) VALUES(
	2,
	'Marriage');
INSERT INTO seeking(value, property) VALUES(
	4,
	'Something Casual');
INSERT INTO seeking(value, property) VALUES(
	8,
	'Not sure');
	
DROP TABLE IF EXISTS hair;
CREATE TABLE hair(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO hair(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO hair(value, property) VALUES(
	1,
	'Blonde');
INSERT INTO hair(value, property) VALUES(
	2,
	'Brown');
INSERT INTO hair(value, property) VALUES(
	4,
	'Black');
INSERT INTO hair(value, property) VALUES(
	8,
	'Red');
INSERT INTO hair(value, property) VALUES(
	16,
	'Other');
	
DROP TABLE IF EXISTS gender_sought;
CREATE TABLE gender_sought(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO gender_sought(value, property) VALUES(
	1,
	'Male');
INSERT INTO gender_sought(value, property) VALUES(
	2,
	'Female');
INSERT INTO gender_sought(value, property) VALUES(
	4,
	'Male and Female');

DROP TABLE IF EXISTS gender;
CREATE TABLE gender(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO gender(value, property) VALUES(
	1,
	'Male');
INSERT INTO gender(value, property) VALUES(
	2,
	'Female');

DROP TABLE IF EXISTS drugs;
CREATE TABLE drugs(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO drugs(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO drugs(value, property) VALUES(
	1,
	'Never');
INSERT INTO drugs(value, property) VALUES(
	2,
	'Rarely');
INSERT INTO drugs(value, property) VALUES(
	4,
	'Socially');
INSERT INTO drugs(value, property) VALUES(
	8,
	'Often');

DROP TABLE IF EXISTS education;
CREATE TABLE education(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO education(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO education(value, property) VALUES(
	1,
	'High School');
INSERT INTO education(value, property) VALUES(
	2,
	'College Diploma');
INSERT INTO education(value, property) VALUES(
	4,
	'Bachelor''s Degree');
INSERT INTO education(value, property) VALUES(
	8,
	'Master''s Degree');
INSERT INTO education(value, property) VALUES(
	16,
	'Doctorate');

DROP TABLE IF EXISTS drinks;
CREATE TABLE drinks(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO drinks(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO drinks(value, property) VALUES(
	1,
	'Never');
INSERT INTO drinks(value, property) VALUES(
	2,
	'Rarely');
INSERT INTO drinks(value, property) VALUES(
	4,
	'Socially');
INSERT INTO drinks(value, property) VALUES(
	8,
	'Often');

DROP TABLE IF EXISTS city;
CREATE TABLE city(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO city(value, property) VALUES(
	1,
	'Ajax');
INSERT INTO city(value, property) VALUES(
	2,
	'Brock');
INSERT INTO city(value, property) VALUES(
	4,
	'Clarington');
INSERT INTO city(value, property) VALUES(
	8,
	'Oshawa');
INSERT INTO city(value, property) VALUES(
	16,
	'Pickering');
INSERT INTO city(value, property) VALUES(
	32,
	'Scugog');
INSERT INTO city(value, property) VALUES(
	64,
	'Uxbridge');
INSERT INTO city(value, property) VALUES(
	128,
	'Whitby');
	
DROP TABLE IF EXISTS children;
CREATE TABLE children(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO children(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO children(value, property) VALUES(
	1,
	'Have Children');
INSERT INTO children(value, property) VALUES(
	2,
	'Want Children');
INSERT INTO children(value, property) VALUES(
	4,
	'Not interested');
INSERT INTO children(value, property) VALUES(
	8,
	'Not sure');
	
DROP TABLE IF EXISTS body_type;
CREATE TABLE body_type(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO body_type(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO body_type(value, property) VALUES(
	1,
	'Thin');
INSERT INTO body_type(value, property) VALUES(
	2,
	'Athletic');
INSERT INTO body_type(value, property) VALUES(
	4,
	'Curvy');
INSERT INTO body_type(value, property) VALUES(
	8,
	'More to Love');
INSERT INTO body_type(value, property) VALUES(
	16,
	'Obese');
	
