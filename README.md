# CronWeb

[![Join the chat at https://gitter.im/DjazzLab/CronWeb](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/DjazzLab/CronWeb?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
Just a webUI for your local cron

# Install/Requirements
1. Create a directory under your document root folder (ex: /var/www/cronweb)
2. Download files (or clone this repository) in the newly created folder
3. The CronWeb application needs some specific apache configuration : mod_rewrite, php5 module
4. Your virtualhost should be configured with "AllowOverride AuthConfig FileInfo Limit" in your &lt;Directory /var/www/cronweb/&gt; node
5. The application works under PHP 5.1 min (tested under PHP 5.4.4).

# DB Install
If you want to customize database name, username, user password, then edit the SQL script <strong>db.sql</strong> in the <strong>install</strong> folder of the application :
```
CREATE DATABASE scheduler;
CREATE USER 'scheduler'@'localhost' IDENTIFIED BY 'scheduler';
GRANT ALL PRIVILEGES ON scheduler.* TO 'scheduler'@'localhost' WITH GRANT OPTION;
use scheduler;
```
Please, note the changes you made !! You will need them below in the DB configuration part.

Just run the SQL script installer in the application <strong>install</strong> folder.
<br/>
This should do the job :
```
cd <ApplicationFolder>/install
mysql -uroot -prootpassword < db.sql
```
Feel free to execute this command with your proper user ! You just need to have the permission to create a user and a database, and to make grant requests.

<strong>Note : The application uses PHP PDO driver to build and execute SQL requests. PHP PDO driver is included with the php5-mysql module.</strong>

# DB configuration
Edit the file <CronWeb Folder>/includes/db_settings.xml
Just change values with your MySQL host and user connection settings :
```
<?xml version="1.0" encoding="UTF-8"?>
<DBSettings>
	<Host><![CDATA[localhost]]></Host>
	<User><![CDATA[scheduler]]></User>
	<Password><![CDATA[scheduler]]></Password>
	<DBName><![CDATA[scheduler]]></DBName>
</DBSettings>
```
These settings should be the same as those you wrote earlier in the database SQL script installer.

# System configuration
CronWeb uses a specific user to create the crontab. So just create a local user, under Debian :
```
adduser scheduler
```
User settings could be found in the file <CronWeb Folder>/includes/system_settings.xml
```
<?xml version="1.0" encoding="UTF-8"?>
<SystemSettings>
	<!-- This is the result of the which command ($ which crontab) -->
	<CrontabBinary><![CDATA[/usr/bin/crontab]]></CrontabBinary>
	<!-- The local user who executes scripts -->
	<CrontabUser><![CDATA[scheduler]]></CrontabUser>
	<!-- The local user home directory -->
	<CrontabUserHomeDirectory><![CDATA[/home/scheduler]]></CrontabUserHomeDirectory>
	<!-- This is needed to build the user crontab file -->
	<TmpCrontabFile><![CDATA[/tmp/CronManager]]></TmpCrontabFile>
</SystemSettings>
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
<br/>
If you change the application folder name, or if your document root in your virtualhost is not "cronweb", don't forget to change the <strong>RewriteBase</strong> in the .htaccess file
```
RewriteBase /cronweb
```
For example, if your document root is the application folder, your RewriteBase will be :
```
RewriteBase /
```
This is very importante, otherwise none of the application URLs will work.

# Author
Xavier Beurois
- Twitter : [@djazzlab](https://twitter.com/djazzlab)
- Blog : [Visit SGC-Univ.Net blog!](https://www.sgc-univ.net)
