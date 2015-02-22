<?php

class Crontab{
	/**
	 * Location of the crontab executable
	 * @var string
	 */
	var $Crontab = '/usr/bin/crontab';
	
        /**
         * Crontab user for the sudo command
         * @var string
         */
        var $CrontabUser = 'scheduler';

	/**
	 * Location to save the crontab file.
	 * @var string
	 */
	var $Destination = '/tmp/CronManager';
	
	/**
	 * Minute (0 - 59)
	 * @var string
	 */
	var $Minute = '*';
	
	/**
	 * Hour (0 - 23)
	 * @var string
	 */
	var $Hour = '*';
	
	/**
	 * Day of Month (1 - 31)
	 * @var string
	 */
	var $DayOfMonth = '*';
	
	/**
	 * Month (1 - 12) OR jan,feb,mar,apr...
	 * @var string
	 */
	var $Month = '*';
	
	/**
	 * Day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat
	 * @var string
	 */
	var $DayOfWeek = '*';
	
	/**
	 * @var array
	 */
	var $Jobs = array();
	
        /**
         * Constructor - Do nothing for now
         */
	function Crontab(){}
	
	/**
	* Set minute or minutes
	* @param string $Minute required
	* @return object
	*/
	function OnMinute($Minute){
		$this->Minute = $Minute;
		return $this;
	}
	
	/**
	* Set hour or hours
	* @param string $Hour required
	* @return object
	*/
	function OnHour($Hour){
		$this->Hour = $Hour;
		return $this;
	}
	
	/**
	* Set day of month or days of month
	* @param string $DayOfMonth required
	* @return object
	*/
	function OnDayOfMonth($DayOfMonth){
		$this->DayOfMonth = $DayOfMonth;
		return $this;
	}
	
	/**
	* Set month or months
	* @param string $Month required
	* @return object
	*/
	function OnMonth($Month){
		$this->Month = $Month;
		return $this;
	}
	
	/**
	* Set day of week or days of week
	* @param string $Minute required
	* @return object
	*/
	function OnDayOfWeek($DayOfWeek){
		$this->DayOfWeek = $DayOfWeek;
		return $this;
	}
	
	/**
	* Set entire time code with one function. This has to be a complete entry. See http://en.wikipedia.org/wiki/Cron#crontab_syntax
	* @param string $TimeCode required
	* @return object
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
	* Add job to the jobs array. Each time segment should be set before calling this method. The job should include the absolute path to the commands being used.
	* @param string $Job required
	* @return object
	*/
	function DoJob($Job){
		$this->Jobs[] =	$this->Minute.' '.
				$this->Hour.' '.
				$this->DayOfMonth.' '.
				$this->Month.' '.
				$this->DayOfWeek.' '.
				$Job;
		
		return $this;
	}
	
	/**
	* Save the jobs to disk, remove existing cron
	* @param boolean $IncludeOldJobs optional
	* @return boolean
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
	* Deletes all crontab entries.
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
	* Deletes a specific crontab entry.
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
        * Get a specific job
        */
        function GetJob($ID){
                $AllJobs = $this->ListJobs();
                foreach($AllJobs as $Key => $Job){
                        if($Key == $ID) {
                                return $Job;
                        }
                }
        }
	
	/**
	* List current cron jobs
	* @return string
	*/
	function ListJobs(){
		$Result = exec('sudo -u '.$this->CrontabUser.' '.$this->Crontab.' -l;', $Output, $RetVal);
		return $Output;
	}
}

?>
