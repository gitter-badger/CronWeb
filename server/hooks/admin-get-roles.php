<?php
    require_once('../classes/mysql.php');
	$MySQL = new MySQL();
    
    $Results = $MySQL->GetRoles();
    if(count($Results) == 0){
        $Results = Array('Error' => True);
    }else{
        $Results = Array('Error' => False, 'Items' => $Results);
    }
	
	print(json_encode($Results));
?>