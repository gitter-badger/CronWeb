<?php
    require_once('server/classes/mysql.php');
    $MySQL = new MySQL();
    $Job = $MySQL->GetJob($_POST['JobID']);
    if(count($Job) == 0){
        die(json_encode(Array('Error' => True)));
    }
    if(!$MySQL->EnableCronjob($Job[0]['JOB_ID'])){
        die(json_encode(Array('Error' => True)));
    }
    $Jobs = $MySQL->GetEnabledJobs();

	require_once('server/classes/crontab.php');
    $Cron = new Crontab();
    $Cron->DeleteAllJobs();

    $Error = False;
    foreach($Jobs as $Job){
    	$Cron = new Crontab();
        $Cron->OnMinute($Job['JOB_MIN']);
    	$Cron->OnHour($Job['JOB_HOUR']);
        $Cron->OnDayOfMonth($Job['JOB_DOM']);
    	$Cron->OnMonth($Job['JOB_MON']);
        $Cron->OnDayOfWeek($Job['JOB_DOW']);
    	$Cron->DoJob($Job['JOB_CMD']);

        if(!$Cron->Activate()){
                $Error = True;
        }
    }

	if(!$Error) {
		print(json_encode(Array('Error' => False)));
	} else {
		print(json_encode(Array('Error' => True)));
	}
?>
