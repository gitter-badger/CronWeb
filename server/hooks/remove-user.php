<?php
	require_once('../classes/mysql.php');
	$MySQL = new MySQL();
	
	if(isset($_POST['UserID']) && is_numeric($_POST['UserID'])){
		if($MySQL->RemoveUser($_POST['UserID'])){
			print(json_encode(Array('Error' => False)));
		}else{
			print(json_encode(Array('Error' => True)));
		}
	}else{
		print(json_encode(Array('Error' => True)));
	}
?>
