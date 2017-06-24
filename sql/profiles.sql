-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		6/10/2015			     --
--  File:		profiles.sql			 --
-------------------------------------------

DROP TABLE IF EXISTS profiles;
CREATE TABLE profiles(
	user_id VARCHAR(20) PRIMARY KEY,
	FOREIGN KEY (user_id) REFERENCES users(user_id),
	gender SMALLINT NOT NULL,
	gender_sought SMALLINT NOT NULL,
	city INTEGER NOT NULL, 
	images SMALLINT NOT NULL DEFAULT '0', 
	headline VARCHAR(100) NOT NULL,
	self_description VARCHAR(1000) NOT NULL,
	match_description VARCHAR(1000) NOT NULL,
    minimum_age SMALLINT NOT NULL,
    maximum_age SMALLINT NOT NULL,
	interests VARCHAR(1000) NOT NULL,
	height DECIMAL(6) NOT NULL,
	body_type INTEGER NOT NULL DEFAULT '0',
	education INTEGER NOT NULL DEFAULT '0',
	smokes INTEGER NOT NULL DEFAULT '0',
	drinks INTEGER NOT NULL DEFAULT '0',
	drugs INTEGER NOT NULL DEFAULT '0',
	status INTEGER NOT NULL DEFAULT '0',
	hair INTEGER NOT NULL DEFAULT '0',
	children INTEGER NOT NULL DEFAULT '0',
	seeking INTEGER NOT NULL DEFAULT '0'
);