-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		city.sql		    	 --
-------------------------------------------

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
	
