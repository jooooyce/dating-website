-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		status.sql		    	 --
-------------------------------------------

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
