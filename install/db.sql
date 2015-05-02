-- Create the database for the application
CREATE DATABASE scheduler;
-- Create the database user which will be used by the application
CREATE USER 'scheduler'@'localhost' IDENTIFIED BY 'scheduler';
-- Give some privileges to the new user
GRANT ALL PRIVILEGES ON scheduler.* TO 'scheduler'@'localhost' WITH GRANT OPTION;

-- Use newly created database
use scheduler;

-------------------------------------------
-- DON'T CHANGE ANYTHING BELOW THIS LINE --
-------------------------------------------

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
INSERT INTO SETTINGS (SETTING_KEY, SETTING_VALUE) VALUES ("active_refresh_time", "30");

-- Create SCRIPTS table
CREATE TABLE `SCRIPTS` (
	`SCRIPT_ID` tinyint(4) NOT NULL AUTO_INCREMENT,
	`SCRIPT_NAME` varchar(100) NOT NULL,
	`SCRIPT_PATH_CMD` varchar(255) NOT NULL,
	PRIMARY KEY (`SCRIPT_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;