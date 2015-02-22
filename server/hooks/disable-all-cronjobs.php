<?php
        $Resp = Array();

        require_once('../classes/mysql.php');
        $MySQL = new MySQL();
        $Resp['MySQL'] = $MySQL->DisableAllCronjobs();

        require_once('../classes/crontab.php');
        $Cron = new Crontab();
        $Resp['Crontab'] = $Cron->DeleteAllJobs();

        print(json_encode($Resp));
?>

