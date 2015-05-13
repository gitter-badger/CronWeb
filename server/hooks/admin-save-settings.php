<?php
    $Error = False;
	if(!isset($_POST['ActiveRefreshTime']) || $_POST['ActiveRefreshTime'] == '' || !is_numeric($_POST['ActiveRefreshTime']) || $_POST['ActiveRefreshTime'] < 1 || $_POST['ActiveRefreshTime'] > 99) $Error = True;
	
	if(!$Error){
		require_once('server/classes/mysql.php');
        $MySQL = new MySQL();
        $Result = Array('Updated' => $MySQL->SaveSettings(Array(
			'active_refresh_time' => $_POST['ActiveRefreshTime']
		)));
	} else {
		$Result = Array('Updated' => False);
	}

    print(json_encode($Result));
?>