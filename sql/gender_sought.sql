-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		gender_sought.sql		 --
-------------------------------------------

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
	