# CronWeb
Just a webUI for your local cron

# Install/Requirements
1. Create a directory under your document root folder (ex: /var/www/cronweb)
2. Download files (or clone this repository) in the newly created folder
3. The CronWeb application needs some specific apache configuration : mod_rewrite, php5 module
4. Your virtualhost should be configured with "AllowOverride AuthConfig FileInfo Limit" in your "<Directory /var/www/CronWeb/>" node
5. The application works under PHP 5.1 min (tested under PHP 5.4.4).

# DB Install
- Create the MySQL database
```
CREATE DATABASE scheduler
```
- Create the MySQL databse user
```
CREATE USER 'scheduler'@'localhost' IDENTIFIED BY 'schedulerpassword';
```
- Grant privileges for the new user to the new database
```
GRANT ALL PRIVILEGES ON scheduler.* TO 'scheduler'@'localhost' WITH GRANT OPTION;
```
- Connect to the database to create the table
```
mysql -hDB_HOST -uscheduler -pschedulerpassword scheduler
```
- Create the following table JOBS
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
Edit the file <CronWeb Folder>/includes/db_settings.xml
Just change values with your MySQL host and user connection settings :
```
<?xml version="1.0" encoding="UTF-8"?>
<DBSettings>
	<Host><![CDATA[localhost]]></Host>
	<User><![CDATA[freyr]]></User>
	<Password><![CDATA[freyr]]></Password>
	<DBName><![CDATA[scheduler]]></DBName>
</DBSettings>
```

# System configuration
CronWeb uses a specific user to create the crontab. User settings could be found in the file <CronWeb Folder>/includes/system_settings.xml
```
<?xml version="1.0" encoding="UTF-8"?>
<SystemSettings>
	<!-- This is the result of the which command ($ which crontab) -->
	<CrontabBinary><![CDATA[/usr/bin/crontab]]></CrontabBinary>
	<!-- The local user who performs system commands -->
	<CrontabUser><![CDATA[scheduler]]></CrontabUser>
	<!-- This is need to build the user crontab file -->
	<TmpCrontabFile><![CDATA[/tmp/CronManager]]></TmpCrontabFile>
</SystemSettings>
```
Just create a local user, under Debian :
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
Xavier Beurois
- Twitter : [@djazzlab](https://twitter.com/djazzlab)
- Blog : [Visit SGC-Univ.Net blog!](https://www.sgc-univ.net)
