<?php
    require_once('server/classes/mysql.php');
    $MySQL = new MySQL();
    if(isset($_POST['JobID']) && is_numeric($_POST['JobID'])){
        $CronJob = $MySQL->GetJob($_POST['JobID']);
        if(count($CronJob) == 1){
            print(json_encode(Array('Error' => False, 'JobName' => $CronJob[0]['JOB_NAME'], 'CmdDetails' => $CronJob[0]['JOB_CMD'])));
        }else{
            print(json_encode(Array('Error' => True)));
        }
    }else{
        print(json_encode(Array('Error' => True)));
    }
?>
