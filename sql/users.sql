-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		9/28/2015			     --
--  File:		users.sql				 --
-------------------------------------------

DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users(
	user_id VARCHAR(20) PRIMARY KEY,
	password VARCHAR(32) NOT NULL,
	user_type CHAR(1),
	first_name VARCHAR(128),
	last_name VARCHAR(128),
	email_address VARCHAR(256),
	birth_date DATE,
	enrol_date DATE,
	last_access DATE
);