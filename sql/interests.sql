-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		3/12/2015			     --
--  File:		interests.sql			 --
-------------------------------------------

DROP TABLE IF EXISTS interests;
CREATE TABLE interests(
	user_id VARCHAR(20) NOT NULL,
	user_interest VARCHAR(20) NOT NULL, 
	time TIMESTAMP NOT NULL,
	PRIMARY KEY (user_id, user_interest),
	FOREIGN KEY (user_id) REFERENCES users(user_id),
	FOREIGN KEY (user_interest) REFERENCES users(user_id)
);