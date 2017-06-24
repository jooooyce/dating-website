-------------------------------------------
--	Author:		Andrew Daigneault		 --
--  Group: 		10						 --	
--	Date:		3/12/2015			     --
--  File:		reports.sql			 --
-------------------------------------------

DROP TABLE IF EXISTS reports;
CREATE TABLE reports(
	user_id VARCHAR(20) NOT NULL,
	user_reported VARCHAR(20) NOT NULL, 
	time TIMESTAMP NOT NULL,
    time_handled TIMESTAMP,
	status CHAR(1) NOT NULL,
	PRIMARY KEY (user_id, user_reported),
	FOREIGN KEY (user_id) REFERENCES users(user_id),
	FOREIGN KEY (user_reported) REFERENCES users(user_id)
);