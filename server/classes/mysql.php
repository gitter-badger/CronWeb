<?php
class MySQL{
	var $DB = null;
	var $DB_HOST = null;
	var $DB_USER = null;
	var $DB_UPWD = null;
	var $DB_NAME = null;

	/**
	 * MySQL (Constructor)
	 * @Desc : This method retrieves your database configuration and initializes the PDO object
	 */
	public function MySQL(){
		$this->LoadMySQLSettings();
		$this->DB = new PDO('mysql:host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME . ';charset=utf8', $this->DB_USER, $this->DB_UPWD);
	}

	/**
	 * GetJob
	 * @Desc : This method retrieves the desired jobs $JobID
	 * @Return : Associated array, array columns are the database table columns
	 */
	public function GetJob($JobID){
		$Stmt = $this->DB->prepare('SELECT * FROM JOBS WHERE JOB_ID = ?');
		$Stmt->execute(Array($JobID));
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * GetAllJobs
	 * @Desc : This method retrieves all jobs, ordered by JOB_ID
	 * @Return : Associated array, array columns are the database table columns
	 */
	public function GetAllJobs(){
		$Stmt = $this->DB->query('SELECT * FROM JOBS ORDER BY JOB_ID');
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * GetEnabledJobs
	 * @Desc : This method retrieves all enabled jobs, ordered by JOB_ID
	 * @Return : Associated array, array columns are the database table columns
	 */
	public function GetEnabledJobs(){
		$Stmt = $this->DB->query('SELECT * FROM JOBS WHERE JOB_IS_ENABLED = 1 ORDER BY JOB_ID');
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * AddNewJob
	 * @Desc : This method allows you to create a new job
	 * @Parameter $JobMin : Integer, minute of the job
	 * @Parameter $JobHour : Integer, hour of the job
	 * @Parameter $JobDom : Integer, day of month of the job
	 * @Parameter $JobMon : Integer, month of year of the job
	 * @Parameter $JobDow : Integer, day of week of the job
	 * @Parameter $JobName : Integer, name of the job
	 * @Parameter $JobCmd : Integer, command of the job
	 * @Parameter $JobDirectlyEnabled : String, directly enable the job after creation of the job
	 * @Return : Boolean (True if the request was successfully executed / false if not)
	 */
	public function AddNewJob($JobMin, $JobHour, $JobDom, $JobMon, $JobDow, $JobName, $JobCmd, $JobDirectlyEnabled){
		$JobIsEnabled = 0;
		if($JobDirectlyEnabled == 'Enable'){
			$JobIsEnabled = 1;
		}

		$Stmt = $this->DB->prepare('INSERT INTO JOBS (JOB_MIN, JOB_HOUR, JOB_DOM, JOB_MON, JOB_DOW, JOB_NAME, JOB_CMD, JOB_IS_ENABLED) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
		$Stmt->execute(Array($JobMin, $JobHour, $JobDom, $JobMon, $JobDow, $JobName, $JobCmd, $JobIsEnabled));

		if($this->DB->lastInsertId() > 0){
			return True;
		}
		return False;
	}

	/**
	 * EditJob
	 * @Desc : This method allows you to edit the desired JOB $JobID
	 * @Parameter $JobID : Integer, ID of the job
	 * @Parameter $JobMin : Integer, minute of the job
	 * @Parameter $JobHour : Integer, hour of the job
	 * @Parameter $JobDom : Integer, day of month of the job
	 * @Parameter $JobMon : Integer, month of year of the job
	 * @Parameter $JobDow : Integer, day of week of the job
	 * @Parameter $JobName : Integer, name of the job
	 * @Parameter $JobCmd : Integer, command of the job
	 * @Return : Boolean (True if the request was successfully executed / false if not)
	 */
	public function EditJob($JobID, $JobMin, $JobHour, $JobDom, $JobMon, $JobDow, $JobName, $JobCmd){
		$Stmt = $this->DB->prepare('UPDATE JOBS SET JOB_MIN = ?, JOB_HOUR = ?, JOB_DOM = ?, JOB_MON = ?, JOB_DOW = ?, JOB_NAME = ?, JOB_CMD = ? WHERE JOB_ID = ?');
		if($Stmt->execute(Array($JobMin, $JobHour, $JobDom, $JobMon, $JobDow, $JobName, $JobCmd, $JobID))){
			return True;
		}
		return False;
	}

	/**
	 * EnableCronjob
	 * @Desc : This method enable the desired JOB $JobID
	 * @Parameter $JobID : Integer
	 * @Return : Boolean (True if the request was successfully executed / false if not)
	 */
	public function EnableCronjob($JobID){
		$Stmt = $this->DB->prepare('UPDATE JOBS SET JOB_IS_ENABLED = 1 WHERE JOB_ID = ?');
		if($Stmt->execute(Array($JobID))){
			return True;
		}
		return False;
	}

	/**
	 * DisableCronjob
	 * @Desc : This method disable the desired JOB $JobID (the job is not removed !!)
	 * @Parameter $JobID : Integer
	 * @Return : Boolean (True if the request was successfully executed / false if not)
	 */
	public function DisableCronjob($JobID){
		$Stmt = $this->DB->prepare('UPDATE JOBS SET JOB_IS_ENABLED = 0 WHERE JOB_ID = ?');
		if($Stmt->execute(Array($JobID))){
			return True;
		}
		return False;
	}

	/**
	 * DisableAllCronjobs
	 * @Desc : This method disable all jobs in the JOBS table (jobs are not removed !!)
	 * @Return : Boolean (True if the request was successfully executed / false if not)
	 */
	public function DisableAllCronjobs(){
		$Stmt = $this->DB->prepare('UPDATE JOBS SET JOB_IS_ENABLED = 0');
		if($Stmt->execute()){
			return True;
		}
		return False;
	}

	/**
	 * RemoveCronjob
	 * @Desc : This method remove the desired JOB $JobID
	 * @Parameter $JobID : Integer
	 * @Return : Boolean (True if the request was successfully executed / false if not)
	 */
	public function RemoveCronjob($JobID){
		$Stmt = $this->DB->prepare('DELETE FROM JOBS WHERE JOB_ID = ?');
		if($Stmt->execute(Array($JobID))){
			return True;
		}
		return False;
	}
	
	/**
	 * RemoveAllJobs
	 * @Desc : This method truncate the JOBS table
	 * @Return : Boolean (True if the request was successfully executed / false if not)
	 */
	public function RemoveAllJobs(){
		if($this->DB->query('TRUNCATE TABLE JOBS')){
			return True;
		}
		return False;
	}
	
	/**
	 * GetSettings
	 * @Desc : This method retrieves all settings from the table SETTINGS
	 * @Return : Associated array, array columns are the database table columns
	 */
	public function GetSettings(){
		$Stmt = $this->DB->query('SELECT SETTING_KEY, SETTING_VALUE FROM SETTINGS ORDER BY SETTING_ID');
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * GetSetting
	 * @Desc : This method retrieves a specific setting from the table SETTINGS
	 * @Return : Associated array, array columns are the database table columns
	 */
	public function GetSetting($SettingKey){
		$Stmt = $this->DB->prepare('SELECT SETTING_VALUE FROM SETTINGS WHERE SETTING_KEY = ? LIMIT 1');
		$Stmt->execute(Array($SettingKey));
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * SaveSettings
	 * @Desc : This method saves all settings into the table SETTINGS
	 * @Parameter $Settings : Associated array of settings (each key are the SETTING_KEY)
	 * @Return : Associated array, array columns are the database table columns
	 */
	public function SaveSettings($Settings){
		$Error = false;
		
		foreach ($Settings as $SettingKey => $SettingValue) {
			if (count($this->GetSetting($SettingKey)) == 1) {
				$Stmt = $this->DB->prepare('UPDATE SETTINGS SET SETTING_VALUE = ? WHERE SETTING_KEY = ?');
				if(!$Stmt->execute(Array($SettingValue, $SettingKey))){
					$Error = true;
				}
			} else {
				$Stmt = $this->DB->prepare('INSERT INTO SETTINGS (SETTING_KEY, SETTING_VALUE) VALUES (?, ?)');
				$Stmt->execute(Array($SettingValue, $SettingKey));
		
				if($this->DB->lastInsertId() <= 0){
					$Error = true;
				}
			}
		}
		
		return $Error;
	}
	
	/**
	 * CreateUser
	 * @Desc : Create a new user if the user does not exist
	 * @Parameter $Role : Role number
	 * @Parameter $Username : Name of the user
	 * @Parameter $Login : Login of the new user
	 * @Parameter $Password : Password of the new user
	 * @Return : Boolean
	 */
	public function CreateUser($Role, $Username, $Login, $Password){
		foreach ($this->GetUsers() as $User){
			if (strcmp($Login, $User['USER_LOGIN']) === 0){
				return False;
			}
		}
		
		$Stmt = $this->DB->prepare('INSERT INTO USERS (USER_LOGIN, USER_NAME, USER_PASSWORD, USER_MODIFICATION_DATE, USER_ROLE) VALUES (?, ?, ?, ?, ?)');
		$Stmt->execute(Array($Login, $Username, md5($Password), time(), $Role));

		if($this->DB->lastInsertId() <= 0){
			return True;
		}
		return False;
	}
	
	/**
	 * EditUser
	 * @Desc : Edit a user if the user exists
	 * @Parameter $Role : Role number
	 * @Parameter $Username : Name of the user
	 * @Parameter $Login : Login of the new user
	 * @Parameter $Password : Password of the new user
	 * @Return : Boolean
	 */
	public function EditUser($UserID, $Role, $Username, $Login, $Password){
		$Found = False;
		foreach ($this->GetUsers() as $User){
			if ($UserID === $User['USER_ID']){
				$Found = True;
			}
		}
		
		if (!$Found){
			return False;
		}
		
		if (strlen($Password) > 0){
			$Stmt = $this->DB->prepare('UPDATE USERS SET USER_LOGIN = ?, USER_NAME = ?, USER_PASSWORD = ?, USER_MODIFICATION_DATE = ?, USER_ROLE = ? WHERE USER_ID = ?');
			return !$Stmt->execute(Array($Login, $Username, md5($Password), time(), $Role, $UserID));
		}else{
			$Stmt = $this->DB->prepare('UPDATE USERS SET USER_LOGIN = ?, USER_NAME = ?, USER_MODIFICATION_DATE = ?, USER_ROLE = ? WHERE USER_ID = ?');
			return !$Stmt->execute(Array($Login, $Username, time(), $Role, $UserID));
		}
	}
	
	/**
	 * GetUsers
	 * @Desc : Retrieves all users and role per user
	 * @Return : Array
	 */ 
	public function GetUsers(){
		$Stmt = $this->DB->query('SELECT USER_ID, USER_LOGIN, USER_NAME, USER_MODIFICATION_DATE, ROLE_NAME FROM USERS, ROLES WHERE USER_ROLE = ROLE_ID ORDER BY USER_ID');
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * GetUser
	 * @Desc : Retrieves user UserID
	 * @Parameter $UserID : integer
	 * @Return : Array
	 */ 
	public function GetUser($UserID){
		$Stmt = $this->DB->prepare('SELECT USER_ID, USER_LOGIN, USER_NAME, USER_MODIFICATION_DATE, USER_ROLE FROM USERS WHERE USER_ID = ? LIMIT 1');
		$Stmt->execute(Array($UserID));
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * GetUserPassword
	 * @Desc : Retrieves user login and password
	 * @Return : Array
	 */ 
	public function GetUserPassword($Login){
		$Stmt = $this->DB->prepare('SELECT USER_NAME, USER_LOGIN, USER_PASSWORD FROM USERS WHERE USER_LOGIN = ? LIMIT 1');
		$Stmt->execute(Array($Login));
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * RemoveUser
	 * @Desc : Remove the user $UserID
	 * @Parameter $UserID : integer
	 * @Return : Boolean
	 */
	public function RemoveUser($UserID){
		$Stmt = $this->DB->prepare('DELETE FROM USERS WHERE USER_ID = ?');
		if($Stmt->execute(Array($UserID))){
			return True;
		}
		return False;
	}
	
	/**
	 * GetRoles
	 * @Desc : Retrieves all roles
	 * @Return : Array
	 */
	public function GetRoles(){
		$Stmt = $this->DB->query('SELECT ROLE_ID, ROLE_NAME FROM ROLES ORDER BY ROLE_ID');
		return $Stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//============================================= PRIVATE METHODS =============================================//
	/**
	 * LoadMySQLSettings
	 * @Desc : This private methods retrieves your own database settings in the /includes folder
	 */
	private function LoadMySQLSettings(){
		$XML = simplexml_load_file(dirname(__FILE__) . '/../../includes/db_settings.xml') or die('Error: Cannot create object');
		$this->DB_HOST = $XML->Host;
		$this->DB_USER = $XML->User;
		$this->DB_UPWD = $XML->Password;
		$this->DB_NAME = $XML->DBName;
	}
}
?>
