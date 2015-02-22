<?php
        require_once('../classes/mysql.php');
        $MySQL = new MySQL();
        $Enabled_BDD = $MySQL->GetEnabledJobs();

        require_once('../classes/crontab.php');
        $Cron = new Crontab();
        $Enabled_Sys = $Cron->ListJobs();

        $Actives = Array();
        if(count($Enabled_BDD) == count($Enabled_Sys)){
                foreach($Enabled_Sys as $Pos => $Job){
                        $JobBDD = $Enabled_BDD[$Pos];
                        $JobSys = $Enabled_Sys[$Pos];

                        $JobBDD = Array($JobBDD['JOB_MIN'], $JobBDD['JOB_HOUR'], $JobBDD['JOB_DOM'], $JobBDD['JOB_MON'], $JobBDD['JOB_DOW'], $JobBDD['JOB_CMD']);

                        $JobSys = explode(' ', $JobSys);
                        $Tmp = implode(' ', array_splice($JobSys, 5));
                        $JobSys[5] = $Tmp;

                        if(count(array_diff($JobBDD, $JobSys)) == 0){
                                $Name = substr($Enabled_BDD[$Pos]['JOB_NAME'], 6);
                                $InProgress = '/home/scheduler/check_mk/.in_progress/'.$Name.'.run';
                                
                                if(!file_exists($InProgress)){
                                        $File = '/home/scheduler/check_mk/'.$Name.'/'.$Name.'.cmk';
                                        $Content = '';
                                        if(file_exists($File)){
                                                $Handle = fopen($File, 'r');
                                                $Content = fgets($Handle);
                                                fclose($Handle);
                                        };
        
                                        if(!empty($Content)){
                                                if($Content[0] == '0'){
                                                        $LastState = 0;
                                                }elseif($Content[0] == '1'){
                                                        $LastState = 1;
                                                }else{
                                                        $LastState = 2;
                                                }
                                        }else{
                                                $LastState = 3;
                                        }
                                }else{
                                        $LastState = 4;
                                }
                        }else{
                                $LastState = 3;
                        }
                        $Actives[] = Array($LastState, $Job);
                }
        }
 
        print(json_encode(Array('NBItems' => count($Actives), 'Items' => $Actives)));
?>
