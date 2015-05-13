<?php
	$Error = False;
	if(!isset($_POST['SettingKey']) || $_POST['SettingKey'] == '') $Error = True;
	
	if(!$Error) {
        require_once('server/classes/mysql.php');
		$MySQL = new MySQL();
		$Setting = $MySQL->GetSetting($_POST['SettingKey']);
		if(count($Setting) == 1){
			$SettingValue = Array(
				'Error' => False,
				'SettingValue' => $Setting[0]['SETTING_VALUE']
			);
	
			print(json_encode($SettingValue));
		} else {
			$Result = Array('Error' => True);
		}
    } else {
        $Result = Array('Error' => True);
    }
?>