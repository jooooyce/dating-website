-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		smokes.sql		    	 --
-------------------------------------------

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
