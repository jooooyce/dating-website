-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		children.sql		    	 --
-------------------------------------------

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