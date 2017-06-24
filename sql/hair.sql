-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		hair.sql		    	 --
-------------------------------------------

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
