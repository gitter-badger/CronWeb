<?php
	require_once('../classes/mysql.php');
	$MySQL = new MySQL();
	$Settings = $MySQL->GetSettings();
	if(count($Settings) == 1){
		$ArrSettings = Array('Error' => False);
		for($SettingCounter = 0; $SettingCounter < count($Settings); $SettingCounter++){
			if(!isset($ArrSettings[$Settings[$SettingCounter]['SETTING_KEY']])) {
				$ArrSettings[$Settings[$SettingCounter]['SETTING_KEY']] = null;
			}
			$ArrSettings[$Settings[$SettingCounter]['SETTING_KEY']] = $Settings[$SettingCounter]['SETTING_VALUE'];
		}

		print(json_encode($ArrSettings));
	}else{
		print(json_encode(Array('Error' => True)));
	}
?>