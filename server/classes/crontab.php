<?php
class Crontab{
	/**
	 * $Crontab
	 * @Desc : Location of the crontab executable
	 * @Type : String
	 */
	var $Crontab = null;
	
	/**
	 * $CrontabUser
	 * @Desc : Crontab user for the sudo command
	 * @Type : String
	 */
	var $CrontabUser = null;

	/**
	 * $Destination
	 * @Desc : Location to save the crontab file.
	 * @Type : String
	 */
	var $Destination = null;
	
	/**
	 * $Minute
	 * @Desc : Minute (0 - 59)
	 * @Type : String
	 */
	var $Minute = '*';
	
	/**
	 * $Hour
	 * @Desc : Hour (0 - 23)
	 * @Type : String
	 */
	var $Hour = '*';
	
	/**
	 * $DayOfMonth
	 * @Desc : Day of Month (1 - 31)
	 * @Type : String
	 */
	var $DayOfMonth = '*';
	
	/**
	 * $Month
	 * @Desc : Month (1 - 12) OR jan,feb,mar,apr...
	 * @Type : String
	 */
	var $Month = '*';
	
	/**
	 * $DayOfWeek
	 * @Desc : Day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat
	 * @Type : String
	 */
	var $DayOfWeek = '*';
	
	/**
	 * $Jobs
	 * @Desc : Structure for cronjobs
	 * @Type : Array
	 */
	var $Jobs = Array();
	
	/**
	 * Crontab (Constructor)
	 * @Desc : Load system settings
	 */
	function Crontab(){
		$XML = simplexml_load_file(dirname(__FILE__) . '/../../includes/system_settings.xml') or die('Error: Cannot create object');
		$this->Crontab = $XML->CrontabBinary;
		$this->CrontabUser = $XML->CrontabUser;
		$this->Destination = $XML->TmpCrontabFile;
	}
	
	/**
	 * GetCrontabUser
	 * @Desc : Retrieve crontab user
	 * @Return : String
	 */
	function GetCrontabUser(){
		return $this->CrontabUser;
	}
	
	/**
	 * OnMinute
	 * @Desc : Set minute or minutes
	 * @Parameter : String $Minute required
	 * @Return : Object
	 */
	function OnMinute($Minute){
		$this->Minute = $Minute;
		return $this;
	}
	
	/**
	 * OnHour
	 * @Desc : Set hour or hours
	 * @Parameter : String $Hour required
	 * @Return : Object
	 */
	function OnHour($Hour){
		$this->Hour = $Hour;
		return $this;
	}
	
	/**
	 * OnDayOfMonth
	 * @Desc : Set day of month or days of month
	 * @Parameter : String $DayOfMonth required
	 * @Return : Object
	 */
	function OnDayOfMonth($DayOfMonth){
		$this->DayOfMonth = $DayOfMonth;
		return $this;
	}
	
	/**
	 * OnMonth
	 * @Desc : Set month or months
	 * @Parameter : String $Month required
	 * @Return : Object
	 */
	function OnMonth($Month){
		$this->Month = $Month;
		return $this;
	}
	
	/**
	 * OnDayOfWeek
	 * @Desc : Set day of week or days of week
	 * @Parameter : String $Minute required
	 * @Return : Object
	 */
	function OnDayOfWeek($DayOfWeek){
		$this->DayOfWeek = $DayOfWeek;
		return $this;
	}
	
	/**
	 * On
	 * @Desc : Set entire time code with one function. This has to be a complete entry. See http://en.wikipedia.org/wiki/Cron#crontab_syntax
	 * @Parameter : String $TimeCode required
	 * @Return : Object
	 */
	function On($TimeCode){
		list(
			$this->Minute, 
			$this->Hour, 
			$this->DayOfMonth, 
			$this->Month, 
			$this->DayOfWeek
		) = explode(' ', $TimeCode);
		
		return $this;
	}
	
	/**
	 * DoJob
	 * @Desc : Add job to the jobs array. Each time segment should be set before calling this method. The job should include the absolute path to the commands being used.
	 * @Parameter : String $Job required
	 * @Return : Object
	 */
	function DoJob($Job){
		$this->Jobs[] =	$this->Minute . ' ' . $this->Hour . ' ' . $this->DayOfMonth . ' ' . $this->Month . ' ' . $this->DayOfWeek . ' ' . $Job;
		return $this;
	}
	
	/**
	 * Activate
	 * @Desc : Save the jobs to disk, remove existing cron
	 * @Parameter : Boolean $IncludeOldJobs optional
	 * @Return : Boolean
	 */
	function Activate($IncludeOldJobs = True){
		$Contents = '';
		
		if($IncludeOldJobs){
			$OldJobs = $this->listJobs();
			foreach($OldJobs as $Job){
				$Contents .= $Job;
				$Contents .= "\n";
			}
		}
		$Contents .= implode("\n", $this->Jobs);
		$Contents .= "\n";
		
		if(is_writable($this->Destination) || !file_exists($this->Destination)){
			exec('sudo -u '.$this->CrontabUser.' '.$this->Crontab.' -r;');
			file_put_contents($this->Destination, $Contents, LOCK_EX);
			exec('sudo -u '.$this->CrontabUser.' '.$this->Crontab.' '.$this->Destination.';');
			return True;
		}
		return False;
	}

	/**
	 * DeleteAllJobs
	 * @Desc : Deletes all crontab entries.
	 * @Return : Boolean
	 */
	function DeleteAllJobs(){
		if(is_writable($this->Destination) || !file_exists($this->Destination)){
			exec('sudo -u '.$this->CrontabUser.' '.$this->Crontab.' -r;');
			file_put_contents($this->Destination, '', LOCK_EX);
			exec('sudo -u '.$this->CrontabUser.' '.$this->Crontab.' '.$this->Destination.';');
			return True;
		}
		return False;
	}

	/**
	 * DeleteJob
	 * @Desc : Deletes a specific crontab entry.
	 * @Return : Boolean
	 */
	function DeleteJob($ID){
		$AllJobs = $this->ListJobs();
		foreach($AllJobs as $Key => $Job){
			if($Key == $ID){
				unset($AllJobs[$Key]);
			}
		}

		// Update the crontab
		if($this->DeleteAllJobs()){
			$Contents = '';
			foreach($AllJobs as $Job){
				$Contents .= $Job;
				$Contents .= "\n";
			}
	
			if(is_writable($this->Destination) || !file_exists($this->Destination)){
				exec('sudo -u '.$this->CrontabUser.' '.$this->Crontab.' -r;');
				file_put_contents($this->Destination, $Contents, LOCK_EX);
				exec('sudo -u '.$this->CrontabUser.' '.$this->Crontab.' '.$this->Destination.';');
				return True;
			}
		}
		return False;
	}

	/**
	 * GetJob
	 * @Desc : Retrieves a specific job
	 * @Return : Job
	 */
	function GetJob($ID){
		$AllJobs = $this->ListJobs();
		foreach($AllJobs as $Key => $Job){
			if($Key == $ID){
				return $Job;
			}
		}
		return null;
	}
	
	/**
	 * ListJobs
	 * @Desc : List current crontab jobs
	 * @Return : String
	 */
	function ListJobs(){
		$Result = exec('sudo -u '.$this->CrontabUser.' '.$this->Crontab.' -l;', $Output, $RetVal);
		return $Output;
	}
}
?>
