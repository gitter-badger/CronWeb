<?php
    $Resp = Array();

    require_once('server/classes/mysql.php');
    $MySQL = new MySQL();
    $Resp['MySQL'] = $MySQL->DisableAllCronjobs();

    require_once('server/classes/crontab.php');
    $Cron = new Crontab();
    $Resp['Crontab'] = $Cron->DeleteAllJobs();

    print(json_encode($Resp));
?>

