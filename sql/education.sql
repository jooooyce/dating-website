-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2030			     --
--  File:		education.sql		     --
-------------------------------------------

DROP TABLE IF EXISTS education;
CREATE TABLE education(
	value SMALLINT PRIMARY KEY,
	property VARCHAR(30) NOT NULL
);

INSERT INTO education(value, property) VALUES(
	0,
	'Prefer not to say');
INSERT INTO education(value, property) VALUES(
	1,
	'High School');
INSERT INTO education(value, property) VALUES(
	2,
	'College Diploma');
INSERT INTO education(value, property) VALUES(
	4,
	'Bachelor''s Degree');
INSERT INTO education(value, property) VALUES(
	8,
	'Master''s Degree');
INSERT INTO education(value, property) VALUES(
	16,
	'Doctorate');
