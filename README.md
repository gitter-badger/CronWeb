# CronWeb
Just a webUI for your local cron

# Install
1. Create a directory under your document root folder (ex: /var/www/cronweb)
2. Download files (or clone this repository) in the newly created folder

# DB Install
1. Create the MySQL database
```
CREATE DATABASE scheduler
```
2. Create the MySQL databse user
```
CREATE USER 'scheduler'@'localhost' IDENTIFIED BY 'schedulerpassword';
```
3. Grant privileges for the new user to the new database
```
GRANT ALL PRIVILEGES ON scheduler.* TO 'scheduler'@'localhost' WITH GRANT OPTION;
```
4. Connect to the database to create the table
```
mysql -hDB_HOST -uscheduler -pschedulerpassword scheduler
```
5. Create the following table JOBS
```
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
```

# DB configuration
Edit the file <CronWeb Folder>/server/classes/mysql.php
At the beginning of the file, juste change variables values with your MySQL host and user connection settings :
```
var $DB_HOST = '<DB HOST>';
var $DB_USER = '<DB USER>';
var $DB_UPWD = '<DB USER PASSWORD>';
var $DB_NAME = '<DB NAME>';
```

# System configuration
CronWeb uses a specific user to create the crontab. User settings could be found in the file <CronWeb Folder>/server/classes/crontab.php. So just create a local user, under Debian :
```
adduser scheduler
```
Then install the package sudo, under Debian :
```
apt-get install sudo
```
and edit the sudoers file with the command :
```
visudo
```
Here, you should allow the web server user (generaly www-data) to run the crontab command for the user "scheduler" :
```
www-data        ALL=(scheduler) NOPASSWD: /usr/bin/crontab
```
You should also add here, every commands/scripts/anything you want the web server user launch as the "scheduler" user :
```
www-data        ALL=(scheduler) NOPASSWD: /home/scheduler/scripts/vms/backup_vm.bash
```
Finally the HTACCESS configuration
Just create the authfile /var/www/.cronweb :
```
htpasswd -c /var/www/.cronweb the_user_you_want_to_use
```
If you want to change the location of this file, do not forget to change the authfile path in the .htaccess file !

# Author
Xavier Beurois [@djazzlab](twitter.com/djazzlab)
[Visit SGC-Univ.Net blog!](www.sgc-univ.net)
