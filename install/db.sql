-- Create the database for the application
CREATE DATABASE scheduler;
-- Create the database user which will be used by the application
CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
-- Give some privileges to the new user
GRANT ALL PRIVILEGES ON scheduler.* TO 'scheduler'@'localhost' WITH GRANT OPTION;

-- Use newly created database
use scheduler;

--
-- DON'T CHANGE ANYTHING BELOW THIS LINE --
--

-- Create JOBS table
CREATE TABLE `JOBS` (
  	`JOB_ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  	`JOB_NAME` varchar(100) NOT NULL,
  	`JOB_MIN` varchar(50) NOT NULL,
  	`JOB_HOUR` varchar(50) NOT NULL,
  	`JOB_DOM` varchar(50) NOT NULL,
  	`JOB_MON` varchar(50) NOT NULL,
  	`JOB_DOW` varchar(50) NOT NULL,
  	`JOB_CMD` text NOT NULL,
  	`JOB_IS_ENABLED` tinyint(1) NOT NULL,
  	PRIMARY KEY (`JOB_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- Create SETTINGS table
CREATE TABLE `SETTINGS` (
	`SETTING_ID` tinyint(4) NOT NULL AUTO_INCREMENT,
  	`SETTING_KEY` varchar(100) NOT NULL,
  	`SETTING_VALUE` varchar(255) NOT NULL,
  	PRIMARY KEY (`SETTING_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
-- Initialize SETTINGS table with default settings
INSERT INTO SETTINGS (`SETTING_KEY`, `SETTING_VALUE`) VALUES ("active_refresh_time", "30");

-- Create SCRIPTS table
CREATE TABLE `SCRIPTS` (
	`SCRIPT_ID` tinyint(4) NOT NULL AUTO_INCREMENT,
	`SCRIPT_NAME` varchar(100) NOT NULL,
	`SCRIPT_PATH_CMD` varchar(255) NOT NULL,
	PRIMARY KEY (`SCRIPT_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- Create ROLES table
CREATE TABLE `ROLES` (
	`ROLE_ID` tinyint(4) NOT NULL AUTO_INCREMENT,
	`ROLE_NAME` varchar(100) NOT NULL,
	PRIMARY KEY (`ROLE_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
-- Initialize ROLES table with default roles
INSERT INTO ROLES (`ROLE_ID`, `ROLE_NAME`) VALUES (1, "ADMIN");

-- Create USERS table
CREATE TABLE `USERS` (
	`USER_ID` tinyint(4) NOT NULL AUTO_INCREMENT,
	`USER_LOGIN` varchar(100) NOT NULL,
	`USER_NAME` varchar(255) NOT NULL,
	`USER_PASSWORD` varchar(50) NOT NULL,
	`USER_MODIFICATION_DATE` int(11) NOT NULL,
	`USER_ROLE` tinyint(4) NOT NULL,
	PRIMARY KEY (`USER_ID`),
	FOREIGN KEY (`USER_ROLE`) REFERENCES `ROLES` (`ROLE_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
-- Initialize USERS table with the default user
INSERT INTO USERS (`USER_LOGIN`, `USER_NAME`, `USER_PASSWORD`, `USER_MODIFICATION_DATE`, `USER_ROLE`) VALUES ("admin", "Administrator", MD5("admin"), UNIX_TIMESTAMP(), 1);