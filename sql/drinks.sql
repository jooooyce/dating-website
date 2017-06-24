-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		drinks.sql		    	 --
-------------------------------------------

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
