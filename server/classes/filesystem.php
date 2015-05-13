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
	public function GetScripts($Admin = true){
		$Scripts = Array();
		
		if ($Handle = opendir($this->CrontabUserHomeDirectory . '/Scripts')){
		    while (false !== ($Entry = readdir($Handle))){
				if ($Entry != '.' && $Entry != '..' && $Entry[0] != '.'){
					$ScriptInfo = $this->CheckScripts($this->CrontabUserHomeDirectory . '/Scripts/' . $Entry);
					
					if ($Admin){
						$Scripts[] = Array(
							'NAME' => $Entry,
							'INFO' => $ScriptInfo
						);
					}else{
						if (strcmp($ScriptInfo, 'Script structure Ok') === 0){
							$Scripts[] = Array(
								'NAME' => $Entry,
								'PATH' => $this->GetScriptPath($this->CrontabUserHomeDirectory . '/Scripts/' . $Entry)
							);
						}
					}
				}
		    }
		
		    closedir($Handle);
		}
		
		return $Scripts;
	}
	
	public function TailCustom($FilePath, $Lines = 1, $Adaptive = true) {
		// Open file
		$Handle = @fopen($FilePath, "rb");
		if ($Handle === false) return false;

		// Sets buffer size
		if (!$Adaptive) $buffer = 4096;
		else $buffer = ($Lines < 2 ? 64 : ($Lines < 10 ? 512 : 4096));

		// Jump to last character
		fseek($Handle, -1, SEEK_END);

		// Read it and adjust line number if necessary
		// (Otherwise the result would be wrong if file doesn't end with a blank line)
		if (fread($Handle, 1) != "\n") $Lines -= 1;
		
		// Start reading
		$Output = '';
		$Chunk = '';

		// While we would like more
		while (ftell($Handle) > 0 && $Lines >= 0) {
			// Figure out how far back we should jump
			$seek = min(ftell($Handle), $buffer);
			// Do the jump (backwards, relative to where we are)
			fseek($Handle, -$seek, SEEK_CUR);
			// Read a chunk and prepend it to our output
			$Output = ($Chunk = fread($Handle, $seek)) . $Output;
			// Jump back to where we started reading
			fseek($Handle, -mb_strlen($Chunk, '8bit'), SEEK_CUR);
			// Decrease our line counter
			$Lines -= substr_count($Chunk, "\n");
		}

		// While we have too many lines
		// (Because of buffer size we might have read too many)
		while ($Lines++ < 0) {
			// Find first newline and remove all text before that
			$Output = substr($Output, strpos($Output, "\n") + 1);
		}

		// Close file and return
		fclose($Handle);
		return trim($Output);
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
	
	/**
	 * GetScriptPath
	 * @Desc : Retrieves the script path
	 * @Parameter $ScriptFolder : Folder of the script
	 * @Return : Script path
	 */
	private function GetScriptPath($ScriptFolder){
		$XML = simplexml_load_file($ScriptFolder . '/Configuration.xml');
		return $ScriptFolder . '/' . $XML->ScriptName;
	}
}
?>