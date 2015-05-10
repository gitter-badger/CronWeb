<?php
    $Error = False;
	if(!isset($_POST['Minute']) || $_POST['Minute'] == '') $Error = True;
	if(!isset($_POST['Hour']) || $_POST['Hour'] == '') $Error = True;
	if(!isset($_POST['Month']) || $_POST['Month'] == '') $Error = True;
	if(!isset($_POST['DayWeek']) || $_POST['DayWeek'] == '') $Error = True;
	if(!isset($_POST['DayMonth']) || $_POST['DayMonth'] == '') $Error = True;
    if(!isset($_POST['Name']) || $_POST['Name'] == '') $Error = True;
	if(!isset($_POST['Command']) || $_POST['Command'] == '') $Error = True;
    if(!isset($_POST['DirectlyEnabled']) || $_POST['DirectlyEnabled'] == '') $Error = True;

	if(!$Error){
                require_once('../classes/mysql.php');
                $MySQL = new MySQL();
                $Result = Array('Inserted' => $MySQL->AddNewJob($_POST['Minute'], $_POST['Hour'], $_POST['DayMonth'], $_POST['Month'], $_POST['DayWeek'], $_POST['Name'], $_POST['Command'], $_POST['DirectlyEnabled']));

                $Jobs = $MySQL->GetEnabledJobs();

                require_once('../classes/crontab.php');
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

                if(!$Error){
                        $Result = Array('Inserted' => True);
                }else{
                        $Result = Array('Inserted' => False);
                }
	} else {
		$Result = Array('Inserted' => False);
	}

        print(json_encode($Result));
?>