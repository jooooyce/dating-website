-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		body_type.sql		   	 --
-------------------------------------------

DROP TABLE IF EXISTS body_type;
CREATE TABLE body_type(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO body_type(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO body_type(value, property) VALUES(
	1,
	'Thin');
INSERT INTO body_type(value, property) VALUES(
	2,
	'Athletic');
INSERT INTO body_type(value, property) VALUES(
	4,
	'Curvy');
INSERT INTO body_type(value, property) VALUES(
	8,
	'More to Love');
INSERT INTO body_type(value, property) VALUES(
	16,
	'Obese');
