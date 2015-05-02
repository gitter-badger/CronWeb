<?php
        require_once('../classes/mysql.php');
        $MySQL = new MySQL();
        $Enabled_BDD = $MySQL->GetEnabledJobs();

        require_once('../classes/crontab.php');
        $Cron = new Crontab();
        $Enabled_Sys = $Cron->ListJobs();

        if(count($Enabled_BDD) == count($Enabled_Sys) && isset($_POST['JobPos']) && is_numeric($_POST['JobPos'])){
                $JobBDD = $Enabled_BDD[$_POST['JobPos']];
                $JobSys = $Enabled_Sys[$_POST['JobPos']];

                $JobBDD = Array($JobBDD['JOB_MIN'], $JobBDD['JOB_HOUR'], $JobBDD['JOB_DOM'], $JobBDD['JOB_MON'], $JobBDD['JOB_DOW'], $JobBDD['JOB_CMD']);

                $JobSys = explode(' ', $JobSys);
                $Tmp = implode(' ', array_splice($JobSys, 5));
                $JobSys[5] = $Tmp;

                if(count(array_diff($JobBDD, $JobSys)) == 0){
                        print(json_encode(Array('Error' => False, 'Output' => shell_exec('sudo -u ' . $Cron->GetCrontabUser() . ' ' . $Enabled_BDD[$_POST['JobPos']]['JOB_CMD']))));
                }else{
                        print(json_encode(Array('Error' => True)));
                }
        }else{
                print(json_encode(Array('Error' => True)));
        }
?>
