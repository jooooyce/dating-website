-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		gender.sql		    	 --
-------------------------------------------

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
	