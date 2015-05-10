<?php
class FileSystem{
	/**
	 * $CrontabUserHomeDirectory
	 * @Desc : Home directory of the crontab user
	 * @Type : String
	 */
	var $CrontabUserHomeDirectory = null;
	
	/**
	 * FileSystem (Constructor)
	 * @Desc : This method retrieves your filesystem configuration
	 */
	public function FileSystem(){
		$XML = simplexml_load_file(dirname(__FILE__) . '/../../includes/system_settings.xml') or die('Error: Cannot create object');
		$this->CrontabUserHomeDirectory = $XML->CrontabUserHomeDirectory;
	}
	
	/**
	 * GetScripts
	 * @Desc : List scripts in the local folder "Scripts" in the scheduler user home directory
	 * @Return : Array of Scripts
	 */
	public function GetScripts(){
		$Scripts = Array();
		
		if ($Handle = opendir($this->CrontabUserHomeDirectory . '/Scripts')){
		    while (false !== ($Entry = readdir($Handle))){
				if ($Entry != '.' && $Entry != '..' && $Entry[0] != '.'){
					$Scripts[] = Array(
						'NAME' => $Entry,
						'INFO' => $this->CheckScripts($this->CrontabUserHomeDirectory . '/Scripts/' . $Entry)
					);
				}
		    }
		
		    closedir($Handle);
		}
		
		return $Scripts;
	}
	
	//============================================= PRIVATE METHODS =============================================//
	/**
	 * CheckScripts
	 * @Desc : This private methods checks scripts in the local folder "Scripts" in the scheduler user home directory
	 * @Parameter $ScriptFolder : Folder of the script to analyze
	 * @Return : Script analyze result
	 */
	private function CheckScripts($ScriptFolder){
		$Message = 'Script structure Ok';
		
		if (false === is_dir($ScriptFolder . '/Logs')){ // Check if the Log folder exists
			$Message = 'Missing Log folder';
		}elseif(false === file_exists($ScriptFolder . '/Configuration.xml')){ // Check if configuration file exists
			$Message = 'Missing Configuration.xml file';
		}else{
			if (false === ($XML = simplexml_load_file($ScriptFolder . '/Configuration.xml'))){
				$Message = 'Error while loading Configuration.xml file';
			}elseif (false === property_exists($XML, 'ScriptName')){ // Check if the configuration file contains the ScriptName node
				$Message = 'Configuration.xml file does not contain the ScriptName node';
			}elseif(false === file_exists($ScriptFolder . '/'. $XML->ScriptName)){ // Check if the script exists
				$Message = $XML->ScriptName . ' does not exist';
			}
		}
		
		return $Message;
	}
}
?>