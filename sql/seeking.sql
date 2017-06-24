-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		seeking.sql		    	 --
-------------------------------------------

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
