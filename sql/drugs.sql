-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		drugs.sql		    	 --
-------------------------------------------

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
