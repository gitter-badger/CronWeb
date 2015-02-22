<?php
	require_once('../classes/crontab.php');
	$Cron = new Crontab();
	if($Cron->DeleteAllJobs()){
                require_once('../classes/mysql.php');
                $MySQL = new MySQL();
                if($MySQL->RemoveAllJobs()){
                        print(json_encode(Array('Error' => False)));
                }else{
                        print(json_encode(Array('Error' => True)));
                }
        }else{
                print(json_encode(Array('Error' => True)));
        }
?>
