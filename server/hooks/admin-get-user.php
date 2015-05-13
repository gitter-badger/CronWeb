<?php
	require_once('server/classes/mysql.php');
	$MySQL = new MySQL();
        
    if(isset($_POST['UserID']) && is_numeric($_POST['UserID'])){
        $User = $MySQL->GetUser($_POST['UserID']);
        if(count($User) == 0){
            $User = Array('Error' => True);
        }else{
            $User = Array('Error' => False, 'Item' => $User[0]);
        }
    }else{
        $User = Array('Error' => True);
    }

    print(json_encode($User));
?>
