<?php
	require_once('server/classes/mysql.php');

	$MySQL = new MySQL();

        $Results = $MySQL->GetAllJobs();
        if(count($Results) == 0){
                $Results = Array('NBItems' => 0);
        }else{
                $Results = Array('NBItems' => count($Results), 'Items' => $Results);
        }

        print(json_encode($Results));
?>
