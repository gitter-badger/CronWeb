<?php
	require_once('server/classes/mysql.php');
	$MySQL = new MySQL();
        
    if(isset($_POST['JobID']) && is_numeric($_POST['JobID'])){
        $Result = $MySQL->GetJob($_POST['JobID']);
        if(count($Result) == 0){
            $Result = Array('Error' => True);
        }else{
            $Result = Array('Error' => False, 'Item' => $Result);
        }
    }else{
        $Result = Array('Error' => True);
    }

    print(json_encode($Result));
?>
